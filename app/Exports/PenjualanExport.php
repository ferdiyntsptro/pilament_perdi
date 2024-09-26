<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenjualanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Mengambil data penjualan dengan nama pelanggan (menggunakan relasi)
        return Penjualan::with('pelanggan')
            ->get()
            ->map(function ($penjualan) {
                return [
                    'id' => $penjualan->id,
                    'nama_pelanggan' => $penjualan->pelanggan->nama, // Menampilkan nama pelanggan
                    'tanggal_penjualan' => $penjualan->tanggal_penjualan,
                    'total_harga' => $penjualan->total_harga,
                    'dibuat_oleh' => $penjualan->dibuat_oleh,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID Penjualan',
            'Nama Pelanggan', // Menggunakan nama pelanggan di header
            'Tanggal Penjualan',
            'Total Harga',
            'Dibuat Oleh',
        ];
    }
}
