<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl_transaksi');
            $table->date('tgl_kembali');
            $table->string('jml_transaksi');
            $table->string('biaya');
            $table->integer('id_pegawai')->references('id')->on('employees');
            $table->integer('id_mobil')->references('id')->on('cars');
            $table->integer('id_supir')->references('id')->on('drivers');
            $table->integer('id_peminjaman')->references('id')->on('borrowings');
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
        Schema::dropIfExists('transactions');
    }
}
