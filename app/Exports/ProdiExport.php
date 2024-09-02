<?php

namespace App\Exports;

use App\Models\Prodi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProdiExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('prodi')
            ->join('fakultas', 'prodi.fakultas_id', '=', 'fakultas.id_fakultas')
            ->select('prodi.id_prodi', 'prodi.nama_prodi', 'prodi.fakultas_id', 'fakultas.nama_fakultas')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id prodi',
            'nama prodi',
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
