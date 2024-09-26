<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tanggal_penjualan',
        'total_harga',
        'pelanggan_id',
        'dibuat_oleh',
    ];

    protected $dates = [
        'deleted_at',
    ];

  // app/Models/Penjualan.php
public function pelanggan()
{
    return $this->belongsTo(Pelanggan::class);
}

public function produk()
{
    return $this->belongsToMany(Produk::class, 'penjualan_produks')
                ->withPivot('quantity', 'harga');
}

}
