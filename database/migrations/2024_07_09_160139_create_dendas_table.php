<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengembalian_id');
            $table->foreign('pengembalian_id')->references('id')->on('pengembalians')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('jenis_denda',['Kehilangan', 'kerusakan'])->default('Kerusakan');
            $table->enum('jenis_kerusakan', ['ringan', 'sedang', 'total'])->nullable()->default('ringan');
            $table->integer('keterlambatan')->nullable();
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
        Schema::dropIfExists('dendas');
    }
};
