@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Tambah Pembelian</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nomor_beli" class="form-label">Nomor Beli</label>
                    <input type="text" name="nomor_beli" id="nomor_beli" class="form-control" required placeholder="Masukkan nomor pembelian">
                </div>

                <div class="mb-3">
                    <label for="nama_supplier" class="form-label">Nama Supplier</label>
                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" required placeholder="Masukkan nama supplier">
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="grand_total" class="form-label">Grand Total (Rp)</label>
                    <input type="number" name="grand_total" id="grand_total" class="form-control" min="0" step="0.01" placeholder="0.00">
                    <small class="form-text text-muted">Opsional. Akan dihitung otomatis jika dikosongkan.</small>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
