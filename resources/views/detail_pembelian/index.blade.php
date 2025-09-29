@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Data Detail Pembelian</h3>

    <a href="{{ route('detail-pembelian.create') }}" class="btn btn-success mb-3">+ Tambah Detail</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Pembelian</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detail as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->pembelian->no_invoice ?? '-' }}</td>
                    <td>{{ $d->nama_barang }}</td>
                    <td>{{ $d->qty }}</td>
                    <td>{{ $d->harga }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
