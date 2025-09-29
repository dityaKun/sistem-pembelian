<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::with('details')->get();

        // Calculate grand total for each purchase if not already set
        foreach ($pembelian as $p) {
            if ($p->grand_total == 0 && $p->details->count() > 0) {
                $p->grand_total = $p->details->sum(function ($detail) {
                    return $detail->qty * $detail->harga;
                });
                $p->save(); // Save the calculated grand total
            }
        }

        return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        return view('pembelian.create_custom');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_beli' => 'required|string|max:50',
            'supplier' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.nama_barang' => 'required|string|max:255',
            'details.*.qty' => 'required|numeric|min:0',
            'details.*.harga' => 'required|numeric|min:0',
            'details.*.keterangan' => 'nullable|string',
        ]);

        // Map field names to model expectations
        $data = [
            'nomor_beli' => $request->no_beli,
            'nama_supplier' => $request->supplier,
            'tanggal' => $request->tanggal,
            'grand_total' => 0, // Will be calculated
        ];

        $pembelian = Pembelian::create($data);

        $grandTotal = 0;
        foreach ($request->details as $detailData) {
            DetailPembelian::create([
                'pembelian_id' => $pembelian->id,
                'nama_barang' => $detailData['nama_barang'],
                'qty' => $detailData['qty'],
                'harga' => $detailData['harga'],
                'keterangan' => $detailData['keterangan'] ?? null,
            ]);

            $grandTotal += $detailData['qty'] * $detailData['harga'];
        }

        $pembelian->update(['grand_total' => $grandTotal]);

        return redirect()->route('pembelian.index')
                         ->with('success', 'Data pembelian berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pembelian = Pembelian::with('details')->findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        return view('pembelian.edit', compact('pembelian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_beli' => 'required|string|max:50|unique:pembelian,nomor_beli,' . $id,
            'nama_supplier' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'grand_total' => 'nullable|numeric|min:0',
        ]);

        $pembelian = Pembelian::findOrFail($id);
        $data = $request->all();
        $data['grand_total'] = $data['grand_total'] ?? 0;

        $pembelian->update($data);

        return redirect()->route('pembelian.index')
                         ->with('success', 'Data pembelian berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();

        return redirect()->route('pembelian.index')
                         ->with('success', 'Data pembelian berhasil dihapus!');
    }
}
