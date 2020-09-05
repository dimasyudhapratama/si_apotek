<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReturnPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_return_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('return_penjualan_id',30);
            $table->foreign('return_penjualan_id')->references('id')->on('return_penjualan');
            $table->foreignId('produk_konversi_stok_id')->nullable()->references('id')->on('produk_konversi_stok')->onUpdate('cascade');
            $table->date('produk_stok_detail_exp_date');
            $table->integer('harga',false,true)->length(11);
            $table->integer('qty',false,true)->length(11);
            $table->integer('subtotal',false,true)->length(11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_return_penjualan');
    }
}
