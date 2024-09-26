<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProdukExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Retrieve the data for the export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Export data dari tabel produk dengan kolom tertentu
        return Produk::select('id', 'nama_produk', 'harga', 'stok')->get();
    }

    /**
     * Define the headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'Harga',
            'Stok',
        ];
    }

    /**
     * Map the data before exporting (optional).
     *
     * @param $produk
     * @return array
     */
    public function map($produk): array
    {
        return [
            $produk->id,
            $produk->nama_produk,
            number_format($produk->harga, 2), // Menampilkan harga dengan 2 desimal
            $produk->stok,
        ];
    }
}
