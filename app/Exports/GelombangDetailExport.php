<?php

namespace App\Exports;

use App\Models\DetailWawancara;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class GelombangDetailExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $id_gelombang;

    public function __construct($id_gelombang)
    {
        $this->id_gelombang = $id_gelombang;
    }

    public function collection()
    {
        return DetailWawancara::join('peserta', 'detail_wawancara.no_peserta', '=', 'peserta.no_peserta')
            ->join('pewawancara', 'detail_wawancara.id_pewawancara', '=', 'pewawancara.id_pewawancara')
            ->where('detail_wawancara.id_gelombang', $this->id_gelombang)
            ->select(
                'detail_wawancara.no_peserta',
                'peserta.peserta as nama_peserta',
                'peserta.prodi',
                'detail_wawancara.q1',
                'detail_wawancara.q2',
                'detail_wawancara.q3',
                'detail_wawancara.q4',
                'detail_wawancara.q5',
                'pewawancara.pewawancara_name as pewawancara',
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'No Peserta',
            'Nama Peserta',
            'Program Studi',
            'Motivasi',
            'Kualitas Pra Proposal',
            'Kemampuan Bidang Ilmu',
            'Perlu Matrikulasi',
            'Catatan Wawancara',
            'Nama Pewawancara',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the worksheet
        return [
            // Bold the first row (headings)
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Apply border style to all cells
                $sheet->getStyle($sheet->calculateWorksheetDimension())
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Wrap text for all cells
                $sheet->getStyle($sheet->calculateWorksheetDimension())
                    ->getAlignment()
                    ->setWrapText(true);

                // Auto-size columns
                foreach (range('A', $sheet->getHighestColumn()) as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
