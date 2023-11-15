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
        Schema::create('perangkats', function (Blueprint $table) {
            $table->id();
            $table->string('no_seri')->unique();
            $table->bigInteger('id_user')->unsigned()->nullable();
            $table->date('tgl_produksi')->nullable();
            $table->date('tgl_aktivasi')->nullable();
            $table->date('tgl_pembelian')->nullable();
            $table->string('versi')->nullable();
            $table->text('foto')->nullable();
            $table->timestamps();
        });

        Schema::table('perangkats', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkats');
    }
};
