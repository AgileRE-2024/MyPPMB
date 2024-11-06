<?php

namespace App\Http\Controllers;
use App\Models\Peserta;
use App\Models\Pewawancara;
use App\Models\DetailWawancara;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExcelMergeController extends Controller
{
    public function mergeFiles(Request $request)
    {

        \Log::info('mergeFiles function called');

        $request->validate([
            'file1' => 'required|file|mimes:xlsx,xls',
            'file2' => 'required|file|mimes:xlsx,xls',
            'file3' => 'required|file|mimes:xlsx,xls',
        ]);

        $gel_id = $request->input('id_gelombang');

        \Log::info('File validation passed');

        $filePeserta = Excel::toArray([], $request->file('file1'));
        $filePewawancara = Excel::toArray([], $request->file('file2'));
        $fileHost = Excel::toArray([], $request->file('file3'));

        \Log::info('Files read successfully');

        $pesertaData = array_slice($filePeserta[0], 1);
        $peserta = collect($pesertaData);

        $hostData = array_slice($fileHost[0], 1);
        $host = collect($hostData);

        $max_participants_per_host = 25;
        $max_participants_per_pewawancara = 10;
        $final_data = [];

        $pesertaByProdi = $peserta->groupBy(0);

        // Extract Pewawancara and NIP information
        $pewawancaraWithNIP = collect($filePewawancara[0])
            ->map(function($item) {
                if (is_array($item) && isset($item[0], $item[1], $item[2])) { // Assume column order: PRODI, PEWAWANCARA, NIP
                    return [
                        'PRODI' => trim(strtoupper($item[0])),
                        'PEWAWANCARA' => $item[1],
                        'NIP' => $item[2],
                    ];
                } else {
                    return null; 
                }
            })
            ->filter()
            ->groupBy('PRODI');

        foreach ($pesertaByProdi as $prodi => $pesertaGroup) {
            $normalizedProdi = trim(strtoupper($prodi));

            $pewawancaraProdi = $pewawancaraWithNIP->get($normalizedProdi, collect())->toArray();

            if (count($pewawancaraProdi) === 0) {
                return redirect()->back()->with('error', 'Tidak ada pewawancara untuk prodi ' . $prodi);
            }

            $chunks = $pesertaGroup->chunk($max_participants_per_host);
            foreach ($chunks as $i => $chunk) {
                $assignedHost = trim($host[$i % $host->count()][0]);

                foreach ($chunk as $j => $peserta) {
                    $noPeserta = $peserta[1] ?? null;
                    $namaPeserta = $peserta[2] ?? null;

                    if ($noPeserta === null || $namaPeserta === null) {
                        return redirect()->back()->with('error', 'Data peserta tidak lengkap.');
                    }

                    // Determine the assigned interviewer and NIP
                    $pewawancaraIndex = ($j / $max_participants_per_pewawancara) % count($pewawancaraProdi);
                    $assignedPewawancara = $pewawancaraProdi[$pewawancaraIndex]['PEWAWANCARA'];
                    $nip = $pewawancaraProdi[$pewawancaraIndex]['NIP'];

                    $final_data[] = [
                        'NO PESERTA' => $noPeserta,
                        'PESERTA' => $namaPeserta,
                        'PRODI' => $prodi,
                        'HOST' => $assignedHost,
                        'PEWAWANCARA' => $assignedPewawancara,
                        'ZOOM LINK' => '', 
                        'ZOOM ID' => '',   
                        'HOST ID' => '',
                        'NIP' => $nip,
                    ];
                }
            }
        }

        foreach ($final_data as $data) {
            Peserta::firstOrCreate([
                'no_peserta' => $data['NO PESERTA'],
                'peserta' => $data['PESERTA'],
                'prodi' => $data['PRODI'],
            ]);

            Pewawancara::firstOrCreate([
                'pewawancara_name' => $data['PEWAWANCARA'],
                'nip' => $data['NIP'],
            ]);

            DetailWawancara::firstOrCreate([
                'no_peserta' => $data['NO PESERTA'],
                'nip' => $data['NIP'],
            ]);

            
        }

        \Log::info('Data merging completed successfully');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray(['NO PESERTA', 'PESERTA', 'PRODI', 'HOST', 'PEWAWANCARA', 'ZOOM LINK', 'ZOOM ID', 'HOST ID'], null, 'A1');
        $sheet->fromArray(array_map(function($item) {
            unset($item['NIP']);
            return $item;
        }, $final_data), null, 'A2');

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getAlignment()
            ->setWrapText(true);

        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $gelombang = Gelombang::find($gel_id);
        $fileName = $gelombang->gelombang_name . '_Semester_' . $gelombang->semester . '_Tanggal_' . $gelombang->date . '.xlsx';
        $filePath = storage_path('app/' . $fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        \Log::info('File written to: ' . $filePath);
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
