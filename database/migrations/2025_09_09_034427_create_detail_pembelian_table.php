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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelian_id'); // foreign key

            $table->string('nama_barang');
            $table->integer('qty');
            $table->decimal('harga', 15, 2);

            $table->timestamps();

            // foreign key relation
            $table->foreign('pembelian_id')
                  ->references('id')
                  ->on('pembelian')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
