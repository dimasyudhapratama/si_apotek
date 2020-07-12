<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukKonversiStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_konversi_stok', function (Blueprint $table) {
            $table->id();
            $table->string('produk_id',30)->nullable()->foreign('produk_id')->references('id')->on('produk');
            $table->enum('status_aktif',["0","1"]);
            $table->enum('level',['1','2','3','4']);
            $table->string('satuan',15);
            $table->integer('nilai_konversi', false, true)->length(5);
            $table->float('laba_harga_biasa', 11, 2);
            $table->float('harga_biasa', 11, 2);
            $table->float('laba_harga_resep', 11, 2);
            $table->float('harga_resep', 11, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk_konversi_stok');
    }
}
