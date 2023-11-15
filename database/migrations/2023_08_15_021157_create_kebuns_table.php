<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kebuns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_tanaman')->unsigned();
            $table->string('jenis_kebun');
            $table->string('nama_kebun');
            $table->string('nama_pemilik');
            $table->bigInteger('id_perangkat')->unsigned();
            $table->text('alamat');
            $table->float('luas');
            $table->string('satuan');
            $table->text('foto')->nullable();
            $table->date('tgl_dibuat')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('altitude')->nullable();
            $table->timestamps();
        });

        Schema::table('kebuns', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_tanaman')->references('id')->on('tanamen')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_perangkat')->references('id')->on('perangkats')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebuns');
    }
};
