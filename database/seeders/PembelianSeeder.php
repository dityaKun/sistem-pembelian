<?php
// database/seeders/PembelianSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembelian;
use App\Models\DetailPembelian;

class PembelianSeeder extends Seeder
{
    public function run(): void
    {
        $pembelian = Pembelian::create([
            'no_invoice' => 'INV001',
            'tanggal' => '2025-09-04',
            'supplier' => 'PT. Supplier Jaya'
        ]);

        DetailPembelian::create([
            'pembelian_id' => $pembelian->id,
            'nama_barang' => 'Laptop Asus',
            'qty' => 2,
            'harga' => 8500000
        ]);

        DetailPembelian::create([
            'pembelian_id' => $pembelian->id,
            'nama_barang' => 'Mouse Logitech',
            'qty' => 5,
            'harga' => 250000
        ]);
    }
}
