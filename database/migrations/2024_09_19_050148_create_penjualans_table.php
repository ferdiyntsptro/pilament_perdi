<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    // database/migrations/xxxx_xx_xx_create_penjualans_table.php
// database/migrations/xxxx_xx_xx_create_penjualans_table.php
public function up()
{
    Schema::create('penjualans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pelanggan_id')->nullable(); // Mengizinkan NULL
        $table->date('tanggal_penjualan');
        $table->decimal('total_harga', 10, 2);
        $table->string('dibuat_oleh');
        $table->timestamps();
        $table->softDeletes();
    });
}


    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
