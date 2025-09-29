@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Tambah Pembelian</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('detail-pembelian.store') }}" method="POST" id="formPembelian">
                @csrf

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="no_beli" class="form-label">No Beli</label>
                    <input type="text" name="no_beli" id="no_beli" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="supplier" class="form-label">Supplier</label>
                    <input type="text" name="supplier" id="supplier" class="form-control" required>
                    <button type="button" class="btn btn-secondary mt-2" id="btnPilihSupplier">Pilih</button>
                </div>

                <h5>Detail Barang</h5>
                <table class="table table-bordered" id="detailBarangTable">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="detail-row">
                            <td>
                                <input type="text" name="barang[]" class="form-control barang-input" readonly>
                                <button type="button" class="btn btn-secondary btn-sm mt-1 btnPilihBarang">Pilih</button>
                            </td>
                            <td><input type="number" name="qty[]" class="form-control qty-input" min="1" value="1" required></td>
                            <td><input type="number" name="harga[]" class="form-control harga-input" min="0" value="0" required></td>
                            <td><input type="number" name="total[]" class="form-control total-input" readonly></td>
                            <td><input type="text" name="keterangan[]" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger btn-sm btnRemoveRow">X</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" id="btnTambahDetail">+ Tambah Detail</button>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('detail-pembelian.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateTotal(row) {
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
        const totalInput = row.querySelector('.total-input');
        totalInput.value = (qty * harga).toFixed(2);
    }

    // Update total on qty or harga change
    document.querySelector('#detailBarangTable').addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input') || e.target.classList.contains('harga-input')) {
            const row = e.target.closest('tr');
            updateTotal(row);
        }
    });

    // Add new detail row
    document.getElementById('btnTambahDetail').addEventListener('click', function() {
        const tableBody = document.querySelector('#detailBarangTable tbody');
        const newRow = document.querySelector('#detailBarangTable tbody tr.detail-row').cloneNode(true);

        // Clear inputs in new row
        newRow.querySelectorAll('input').forEach(input => {
            if (input.classList.contains('qty-input')) {
                input.value = 1;
            } else if (input.classList.contains('harga-input') || input.classList.contains('total-input')) {
                input.value = 0;
            } else {
                input.value = '';
            }
        });

        tableBody.appendChild(newRow);
    });

    // Remove detail row
    document.querySelector('#detailBarangTable').addEventListener('click', function(e) {
        if (e.target.classList.contains('btnRemoveRow')) {
            const rows = document.querySelectorAll('#detailBarangTable tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
            } else {
                alert('Minimal harus ada satu detail barang.');
            }
        }
    });

    // Initialize total for the first row
    updateTotal(document.querySelector('#detailBarangTable tbody tr'));
});
</script>
@endsection
```

Silakan salin seluruh isi di atas ke file `sistem-pembelian/resources/views/detail_pembelian/create.blade.php` Anda untuk menggantikan isi lama dengan form pengisian detail pembelian yang dinamis dan interaktif sesuai kebutuhan Anda.
