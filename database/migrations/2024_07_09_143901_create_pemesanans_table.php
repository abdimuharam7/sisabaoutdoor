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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_penyewaan');
            $table->string('kode_transaksi')->unique();
            $table->time('jam_pengambilan');
            $table->integer('durasi');
            $table->enum('jaminan',['KTP', 'SIM', 'KPelajar'])->default('KTP');
            $table->enum('status_penyewaan',['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status_pembayaran',['Menunggu', 'Dibayar','gagal'])->default('Menunggu');
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
        Schema::dropIfExists('pemesanans');
    }
};
