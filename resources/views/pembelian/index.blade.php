@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Data Pembelian</h3>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-5">
                        <input type="date" class="form-control date-input" placeholder="mm/dd/yyyy">
                        <small class="form-text text-muted">Dari Tanggal</small>
                    </div>
                    <div class="col-md-5">
                        <input type="date" class="form-control date-input" placeholder="mm/dd/yyyy">
                        <small class="form-text text-muted">Sampai Tanggal</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary me-2">Filter</button>
                <button class="btn btn-secondary">Reset</button>
            </div>
        </div>
    </div>

    <!-- Add Purchase Button -->
    <div class="mb-3">
        <a href="{{ route('pembelian.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Tambah Pembelian
        </a>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tabel Pembelian</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">No Beli</th>
                            <th width="12%">Tanggal</th>
                            <th width="25%">Supplier</th>
                            <th width="15%">Grand Total</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelian as $index => $p)
                            <tr data-id="{{ $p->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->nomor_beli ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('Y-m-d') }}</td>
                                <td>{{ $p->nama_supplier }}</td>
                                <td>Rp {{ number_format($p->grand_total ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('pembelian.edit', $p->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('pembelian.destroy', $p->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-info btn-sm toggle-details" data-id="{{ $p->id }}" title="Lihat Detail">
                                            <i class="bi bi-chevron-down"></i> Lihat Detail
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @if($p->details->count() > 0)
                            <tr class="detail-row" data-id="{{ $p->id }}" style="display: none;">
                                <td colspan="6">
                                    <table class="table table-sm table-bordered ms-4">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th>Harga (Rp)</th>
                                                <th>Total (Rp)</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($p->details as $detail)
                                            <tr>
                                                <td>{{ $detail->nama_barang }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($detail->qty * $detail->harga, 0, ',', '.') }}</td>
                                                <td>{{ $detail->keterangan ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data pembelian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-details');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const detailRow = document.querySelector(`.detail-row[data-id="${id}"]`);
            if (detailRow) {
                if (detailRow.style.display === 'none' || detailRow.style.display === '') {
                    detailRow.style.display = 'table-row';
                    this.innerHTML = '<i class="bi bi-chevron-up"></i> Sembunyikan Detail';
                } else {
                    detailRow.style.display = 'none';
                    this.innerHTML = '<i class="bi bi-chevron-down"></i> Lihat Detail';
                }
            }
        });
    });
});
</script>
@endsection
