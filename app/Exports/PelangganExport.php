<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelangganExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pelanggan::all(['id', 'nama', 'email', 'telepon', 'alamat']);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Telepon',
            'Alamat',
        ];
    }
}
