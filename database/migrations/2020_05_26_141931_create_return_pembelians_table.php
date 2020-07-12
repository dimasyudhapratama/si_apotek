<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_pembelian', function (Blueprint $table) {
            $table->string('id',30)->primary();
            $table->string('pembelian_id',30)->nullable()->foreign('pembelian_id')->references('id')->on('pembelian');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onUpdate('cascade');
            $table->enum('status_pembayaran',['0','1']);
            $table->integer('total', false, true)->length(15);
            $table->integer('diskon', false, true)->length(15);
            $table->integer('grand_total', false, true)->length(15);
            $table->integer('terbayar', false, true)->length(15);
            $table->integer('sisa_tunggakan', false, true)->length(15)->unsigned(false);

            //Hanya Sebagai Penyimpanan Sementara untuk Struk
            $table->integer('uang_pembayaran', false, true)->length(15)->unsigned(false);
            $table->integer('kembalian_pembayaran', false, true)->length(15)->unsigned(false);
            
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
        Schema::dropIfExists('return_pembelian');
    }
}
