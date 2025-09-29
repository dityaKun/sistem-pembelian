// database/migrations/2025_09_08_000001_create_detail_pembelian_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelian_id');
            $table->string('nama_barang');
            $table->integer('qty');
            $table->decimal('harga', 15, 2);
            $table->timestamps();

            // Foreign key
            $table->foreign('pembelian_id')
                  ->references('id')
                  ->on('pembelian')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
