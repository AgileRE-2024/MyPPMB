<?php

namespace App\Http\Controllers;
use App\Models\Host;
use App\Models\Peserta;
use App\Models\peserta_gelombang;
use App\Models\Pewawancara;
use App\Models\DetailWawancara;
use App\Models\Gelombang;
use App\Models\Ruang;
use App\Models\ruang_gelombang;
use App\Models\ruang_host;
use App\Models\ruang_pewawancara;
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
        $filePeserta = Excel::toArray([], filePath: $request->file('file1'));
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
                $nipHost = trim($host[$i % $host->count()][1]); // Assuming NIP HOST is in the second column of file3
            
                foreach ($chunk as $j => $peserta) {
                    $noPeserta = $peserta[1] ?? null;
                    $namaPeserta = $peserta[2] ?? null;
            
                    if ($noPeserta === null || $namaPeserta === null) {
                        return redirect()->back()->with('error', 'Data peserta tidak lengkap.');
                    }
            
                    $pewawancaraIndex = intval(($j / $max_participants_per_pewawancara) % count($pewawancaraProdi));
                    $assignedPewawancara = $pewawancaraProdi[$pewawancaraIndex]['PEWAWANCARA'];
                    $nip = $pewawancaraProdi[$pewawancaraIndex]['NIP'];
            
                    $final_data[] = [
                        'PRODI' => $prodi,
                        'NO PESERTA' => $noPeserta,
                        'PESERTA' => $namaPeserta,
                        'NIP PEWAWANCARA'=> $nip,
                        'PEWAWANCARA' => $assignedPewawancara,
                        'MEETING ID'=> '',
                        'MEETING PASS'=> '',
                        'NIP HOST'=> $nipHost,  
                        'HOST' => $assignedHost,
                        'HOST USERNAME' => '',  
                        'HOST PASSWORD' => '',  
                        'MEETING LINK' => '', 
                    ];
                }
            }
            
        }

        \Log::info('Data merging completed successfully');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([ 
        'PRODI',
        'NO PESERTA',
        'PESERTA',
        'NIP PEWAWANCARA',
        'PEWAWANCARA',
        'MEETING ID',
        'MEETING PASS',
        'NIP HOST',
        'HOST',  
        'HOST USERNAME',
        'HOST PASS',  
        'MEETING LINK'
        ], null, 'A1');
        
        $sheet->fromArray($final_data, null, 'A2');

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
    public function importFiles(Request $request, $id_gelombang){
        
        $request->validate([
            'file4' => 'required|file|mimes:xlsx,xls',
        ]);

        $fileMaster = Excel::toArray(import: [], filePath: $request->file('file4'));

        $file = $request->file('file4');
        $filePath = $file->storeAs('gelombang_files', "gelombang_{$id_gelombang}_" . $file->getClientOriginalName());

        $gelombang = Gelombang::find($id_gelombang);
        if ($gelombang) {
            $gelombang->file_path = $filePath;
            $gelombang->save();
        }

        \Log::info('Files read successfully');

        $masterdata = array_slice($fileMaster[0], 1);
        $master = collect($masterdata);

        foreach ($master as $data) {
            Ruang::firstOrCreate([
                'id_ruang'=> $data[5],
                'link_ruang'=> $data[11],
            ]);

            Peserta::firstOrCreate([
                'prodi' => $data[0],
                'no_peserta' => $data[1],
                'peserta' => $data[2],
            ]);

            Pewawancara::firstOrCreate([
                'id_pewawancara'=>$data[3],
                'pewawancara_name'=> $data[4],
            ]);

            Host::firstOrCreate([
                 'id_host'=> $data[7],
                 'nama_host'=> $data[8],
                 'username_zoom'=> $data[9],
                 'pass_zoom'=> $data[10],
            ]);

            DetailWawancara::firstOrCreate([
                'no_peserta'=> $data[1],
                'id_pewawancara'=>$data[3],
                'id_gelombang'=> $id_gelombang,
                'q1'=> '0',
                'q2'=> '0',
                'q3'=> '0',
                'q4'=> '',
                'q5'=> '',
            ]);

            ruang_pewawancara::firstOrCreate([
                'id_ruang'=> $data[5],
                'id_pewawancara'=> $data[3],
                'id_gelombang'=> $id_gelombang,
            ]);

            ruang_host::firstOrCreate([
                'id_ruang'=> $data[5],
                'id_host'=> $data[7],
                'id_gelombang'=> $id_gelombang,
            ]);

            ruang_gelombang::firstOrCreate([
                'id_ruang'=> $data[5],
                'id_gelombang'=> $id_gelombang,
            ]);

            peserta_gelombang::firstOrCreate([
                'no_peserta'=> $data[1],
                'id_gelombang'=> $id_gelombang,
            ]);            

        }

        \Log::info('Data imported successfully');
        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
