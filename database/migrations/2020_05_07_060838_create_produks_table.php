<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->string('id',30)->primary();
            $table->foreignId('kategori_produk_id')->nullable()->references('id')->on('kategori_produk')->onUpdate('cascade');
            $table->foreignId('produsen_id')->nullable()->references('id')->on('produsen')->onUpdate('cascade');
            $table->foreignId('supplier_id')->nullable()->references('id')->on('supplier')->onUpdate('cascade');
            // $table->foreignId('kategori_produk_id')->constrained('kategori_produk')->nullable();
            // $table->foreignId('produsen_id')->constrained('produsen')->nullable();
            // $table->foreignId('supplier_id')->constrained('supplier')->nullable();
            $table->string('nama_produk',50);
            $table->float('harga_beli',10,2);
            $table->integer('stok_minimal', false, true)->length(7);
            $table->enum('level_satuan',['1','2','3','4']);
            $table->enum('status_pajak_produk',['0','1']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk');
    }
}
