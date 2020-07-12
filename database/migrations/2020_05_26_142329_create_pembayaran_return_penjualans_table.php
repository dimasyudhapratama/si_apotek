<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranReturnPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_return_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('return_penjualan_id',30)->nullable()->foreign('return_penjualan_id')->references('id')->on('return_penjualan');
            $table->integer('jumlah',false,true)->length(11);
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_return_penjualan');
    }
}
