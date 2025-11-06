<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kendaraan = Kendaraan::paginate(10);
        return view('kendaraan.index', compact('kendaraan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:255|unique:kendaraan,plat_nomor',
            'pajak_stnk' => 'nullable|date',
            'status' => 'nullable|in:kosong,terpakai,service'
        ]);

        Kendaraan::create($request->all());

        return redirect()->route('kendaraan.index')
                         ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kendaraan $kendaraan)
    {
        return view('kendaraan.show', compact('kendaraan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:255|unique:kendaraan,plat_nomor,' . $kendaraan->id,
            'pajak_stnk' => 'nullable|date',
            'status' => 'nullable|in:kosong,terpakai,service'
        ]);

        $kendaraan->update($request->all());

        return redirect()->route('kendaraan.index')
                         ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')
                         ->with('success', 'Kendaraan berhasil dihapus.');
    }
}
