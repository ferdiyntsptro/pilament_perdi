<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanProduksTable extends Migration
{
 // database/migrations/xxxx_xx_xx_create_penjualans_table.php
// database/migrations/xxxx_xx_xx_create_penjualan_produks_table.php
public function up()
{
    Schema::create('penjualan_produks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('penjualan_id')->constrained()->onDelete('cascade');
        $table->string('produk_nama');
        $table->integer('quantity');
        $table->decimal('harga', 10, 2);
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('penjualan_produks');
    }
}
