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
        Schema::create('cutplan_master', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('no_transaksi', 50);
            $table->unsignedBigInteger('id_iki'); 
            $table->foreign('id_iki')->references('id_iki')->on('master_project')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutplan_master');
    }
};
