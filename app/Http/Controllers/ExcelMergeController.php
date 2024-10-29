<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelMergeController extends Controller
{
    public function showForm()
    {
        return view('excel.merge');
    }

    public function mergeFiles(Request $request)
    {
        \Log::info('mergeFiles function called'); // Log message for debugging

        $request->validate([
            'file1' => 'required|file|mimes:xlsx,xls',
            'file2' => 'required|file|mimes:xlsx,xls',
            'file3' => 'required|file|mimes:xlsx,xls',
        ]);

        \Log::info('File validation passed'); // Log message for debugging

        $filePeserta = Excel::toArray([], $request->file('file1'));
        $filePewawancara = Excel::toArray([], $request->file('file2'));
        $fileHost = Excel::toArray([], $request->file('file3'));

        \Log::info('Files read successfully'); 

        $pesertaData = array_slice($filePeserta[0], 1); // Skip header secara manual
        $peserta = collect($pesertaData);

        \Log::info('Peserta Data after skipping header:', $peserta->toArray());

        $hostData = array_slice($fileHost[0], 1); // Skip header secara manual
        $host = collect($hostData); // Konversi ke collection untuk memudahkan pengolahan

        \Log::info('Host Data after skipping header:', $host->toArray());

        $max_participants_per_host = 25;
        $max_participants_per_pewawancara = 10;
        $final_data = [];

        $pesertaByProdi = $peserta->groupBy(0);

        foreach ($pesertaByProdi as $prodi => $pesertaGroup) {
            $normalizedProdi = trim(strtoupper($prodi));

            \Log::info('Pewawancara Data Structure:', collect($filePewawancara[0])->toArray());

            $pewawancaraProdi = collect($filePewawancara[0])
                ->map(function($item) {
                    if (is_array($item) && isset($item[0], $item[1])) {
                        $item['PRODI'] = trim(strtoupper($item[0])); // Kolom pertama adalah PRODI
                        $item['PEWAWANCARA'] = $item[1]; // Kolom kedua adalah PEWAWANCARA
                    } else {
                        \Log::error('Kolom PRODI atau PEWAWANCARA tidak ditemukan pada data pewawancara.');
                        return null; 
                    }
                    return $item;
                })
                ->where('PRODI', $normalizedProdi)
                ->pluck('PEWAWANCARA')
                ->toArray();

            if (count($pewawancaraProdi) === 0) {
                \Log::error('Tidak ada pewawancara untuk prodi: ' . $prodi); // Log error
                return redirect()->back()->with('error', 'Tidak ada pewawancara untuk prodi ' . $prodi);
            }

            $chunks = $pesertaGroup->chunk($max_participants_per_host);
            foreach ($chunks as $i => $chunk) {
                if (isset($host[$i % $host->count()]) && isset($host[$i % $host->count()][0])) { 
                    $assignedHost = trim($host[$i % $host->count()][0]); // Mengambil data host dari kolom pertama
                } else {
                    \Log::error('Data host tidak valid atau kolom HOST tidak ditemukan.'); // Error log
                    return redirect()->back()->with('error', 'Data host tidak valid atau kolom HOST tidak ditemukan.');
                }

                foreach ($chunk as $j => $peserta) {
                    // Akses data peserta berdasarkan indeks
                    $noPeserta = isset($peserta[1]) ? $peserta[1] : null;
                    $namaPeserta = isset($peserta[2]) ? $peserta[2] : null;

                    // Pastikan data lengkap
                    if ($noPeserta === null || $namaPeserta === null) {
                        \Log::error('Missing data in peserta: ', $peserta); // Log error jika data peserta tidak lengkap
                        return redirect()->back()->with('error', 'Data peserta tidak lengkap.');
                    }

                    $assignedPewawancara = $pewawancaraProdi[$j / $max_participants_per_pewawancara % count($pewawancaraProdi)];

                    // Tambahkan data final
                    $final_data[] = [
                        'NO PESERTA' => $noPeserta,
                        'PESERTA' => $namaPeserta,
                        'PRODI' => $prodi,
                        'HOST' => $assignedHost,
                        'PEWAWANCARA' => $assignedPewawancara,
                    ];
                }
            }
        }

        foreach ($final_data as $data) {
            MergedParticipant::create([
                'no_peserta' => $data['NO PESERTA'],
                'peserta' => $data['PESERTA'],
                'prodi' => $data['PRODI'],
                'host' => $data['HOST'],
                'pewawancara' => $data['PEWAWANCARA'],
            ]);
        }
        
        Schema::create('merged_participants', function (Blueprint $table) {
            $table->id();
            $table->string('no_peserta');
            $table->string('peserta');
            $table->string('prodi');
            $table->string('host');
            $table->string('pewawancara');
            $table->timestamps();
        });        

        \Log::info('Data merging completed successfully'); // Log message for debugging

        // Buat file Excel hasil penggabungan
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan header ke file Excel
        $sheet->fromArray(['NO PESERTA', 'PESERTA', 'PRODI', 'HOST', 'PEWAWANCARA'], null, 'A1');

        // Tambahkan data ke file Excel
        $sheet->fromArray($final_data, null, 'A2');

        // Simpan file ke dalam storage
        $fileName = 'merged_file.xlsx';
        $filePath = storage_path('app/' . $fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        \Log::info('File written to: ' . $filePath); // Log message for debugging

        // Kirim file untuk diunduh
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
