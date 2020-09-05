<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKoreksiStokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_koreksi_stok', function (Blueprint $table) {
            $table->id();
            $table->string('koreksi_stok_id',30);
            $table->foreign('koreksi_stok_id')->references('id')->on('koreksi_stok');
            $table->foreignId('produk_konversi_stok_id')->nullable()->references('id')->on('produk_konversi_stok')->onUpdate('cascade');
            $table->date('produk_stok_detail_exp_date');
            $table->float('qty_awal', 8, 2);
            $table->float('qty_akhir', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_koreksi_stok');
    }
}
