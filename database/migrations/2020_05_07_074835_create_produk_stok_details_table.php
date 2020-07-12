<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukStokDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_stok_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_konversi_stok_id')->nullable()->references('id')->on('produk_konversi_stok')->onUpdate('cascade');
            $table->date('exp_date');
            $table->integer('jumlah', false, true)->length(10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk_stok_detail');
    }
}
