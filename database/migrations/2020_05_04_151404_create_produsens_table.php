<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdusensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produsen', function (Blueprint $table) {
            $table->id();
            $table->string('nama',50)->nullable();
            $table->string('no_hp',13)->nullable();
            $table->string('email',30)->nullable();
            $table->string('bank',30)->nullable();
            $table->string('no_rekening',30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produsen');
    }
}
