<?php

namespace App\Exports;

use App\Models\Fakultas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FakultasExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Fakultas::select('id_fakultas', 'nama_fakultas')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id fakultas',
            'nama fakultas',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        // Apply bold style to the header row
        $sheet->getStyle('1:1')->getFont()->setBold(true);
    }
}
