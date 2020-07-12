<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('id',30)->primary();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onUpdate('cascade');
            $table->foreignId('supplier_id')->nullable()->references('id')->on('supplier')->onUpdate('cascade');
            $table->enum('cara_pembayaran',['Cash','Kredit']);
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->enum('status_pembayaran',['0','1']);
            $table->integer('total', false, true)->length(15)->unsigned(false);
            $table->integer('diskon', false, true)->length(15)->unsigned(false);
            $table->integer('grand_total', false, true)->length(15)->unsigned(false);
            $table->integer('terbayar', false, true)->length(15)->unsigned(false);
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
        Schema::dropIfExists('pembelian');
    }
}
