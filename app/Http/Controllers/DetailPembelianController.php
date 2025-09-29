<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPembelian;
use App\Models\Pembelian;

class DetailPembelianController extends Controller
{
    public function index()
    {
        $detail = DetailPembelian::with('pembelian')->get();
        return view('detail_pembelian.index', compact('detail'));
    }

    public function create()
    {
        $pembelian = Pembelian::all();
        return view('detail_pembelian.create', compact('pembelian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembelian_id' => 'required|exists:pembelian,id',
            'nama_barang' => 'required|string|max:255',
            'qty' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        DetailPembelian::create($request->all());

        return redirect()->route('detail-pembelian.index')
                         ->with('success', 'Detail pembelian berhasil ditambahkan!');
    }
}
