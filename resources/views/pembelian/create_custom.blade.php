@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Tambah Pembelian</h3>

    <div class="card shadow-sm p-4">
        <form action="{{ route('pembelian.store') }}" method="POST" id="formPembelianCustom">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_beli" class="form-label">Nomor Beli</label>
                        <input type="text" name="no_beli" id="no_beli" class="form-control" placeholder="Masukkan nomor pembelian" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="supplier" class="form-label">Nama Supplier</label>
                <input type="text" name="supplier" id="supplier" class="form-control" placeholder="Masukkan nama supplier" required>
            </div>

            <div class="mb-4">
                <h5>Detail Barang</h5>
                <button type="button" class="btn btn-success mb-2" onclick="addDetailRow()">Tambah Detail</button>
                <table class="table table-bordered" id="detailTable">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga (Rp)</th>
                            <th>Total (Rp)</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="detailTbody">
                        <!-- Initial empty row -->
                        <tr>
                            <td><input type="text" name="details[0][nama_barang]" class="form-control" placeholder="Nama barang" required></td>
                            <td><input type="number" name="details[0][qty]" class="form-control qty" min="0" step="1" onchange="calculateTotal(0)" onkeyup="calculateTotal(0)" required></td>
                            <td><input type="number" name="details[0][harga]" class="form-control harga" min="0" step="0.01" onchange="calculateTotal(0)" onkeyup="calculateTotal(0)" required></td>
                            <td><input type="number" name="details[0][total]" class="form-control total" readonly></td>
                            <td><textarea name="details[0][keterangan]" class="form-control" rows="1" placeholder="Keterangan (opsional)"></textarea></td>
                            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(0)">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mb-3">
                <label for="grand_total" class="form-label">Grand Total (Rp)</label>
                <input type="number" name="grand_total" id="grand_total" class="form-control" readonly value="0.00" step="0.01">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
let rowIndex = 1;

function addDetailRow() {
    const tbody = document.getElementById('detailTbody');
    const newRow = tbody.insertRow();
    newRow.innerHTML = `
        <td><input type="text" name="details[${rowIndex}][nama_barang]" class="form-control" placeholder="Nama barang" required></td>
        <td><input type="number" name="details[${rowIndex}][qty]" class="form-control qty" min="0" step="1" onchange="calculateTotal(${rowIndex})" onkeyup="calculateTotal(${rowIndex})" required></td>
        <td><input type="number" name="details[${rowIndex}][harga]" class="form-control harga" min="0" step="0.01" onchange="calculateTotal(${rowIndex})" onkeyup="calculateTotal(${rowIndex})" required></td>
        <td><input type="number" name="details[${rowIndex}][total]" class="form-control total" readonly></td>
        <td><textarea name="details[${rowIndex}][keterangan]" class="form-control" rows="1" placeholder="Keterangan (opsional)"></textarea></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(${rowIndex})">Hapus</button></td>
    `;
    rowIndex++;
    calculateGrandTotal();
}

function removeRow(index) {
    const row = document.querySelector(`input[name="details[${index}][nama_barang]"]`).closest('tr');
    row.remove();
    calculateGrandTotal();
    // Reindex if needed, but since names are fixed, it's ok for submit
}

function calculateTotal(index) {
    const qty = parseFloat(document.querySelector(`input[name="details[${index}][qty]"]`).value) || 0;
    const harga = parseFloat(document.querySelector(`input[name="details[${index}][harga]"]`).value) || 0;
    const total = qty * harga;
    document.querySelector(`input[name="details[${index}][total]"]`).value = total.toFixed(2);
    calculateGrandTotal();
}

function calculateGrandTotal() {
    let grandTotal = 0;
    const totals = document.querySelectorAll('.total');
    totals.forEach(total => {
        grandTotal += parseFloat(total.value) || 0;
    });
    document.getElementById('grand_total').value = grandTotal.toFixed(2);
}

// Initial calculation
calculateTotal(0);
</script>
@endsection
