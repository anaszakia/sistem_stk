<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kendaraan;
use App\Models\Pemesanan;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {
        $query = Pemesanan::with(['kendaraan', 'user', 'approver']);
        
        if (auth()->user()->can('view all pemesanan')) {
            $pemesanan = $query->latest()->paginate(15);
        } else {
            $pemesanan = $query->where('user_id', auth()->id())->latest()->paginate(15);
        }
        
        return view('pemesanan.index', compact('pemesanan'));
    }

    public function create()
    {
        $kendaraan = Kendaraan::tersedia()->get();
        return view('pemesanan.create', compact('kendaraan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'keperluan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'penumpang' => 'required|string',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        
        if ($kendaraan->status !== 'kosong') {
            return back()->with('error', 'Kendaraan tidak tersedia untuk dipesan.');
        }

        Pemesanan::create([
            'kendaraan_id' => $request->kendaraan_id,
            'user_id' => auth()->id(),
            'keperluan' => $request->keperluan,
            'tujuan' => $request->tujuan,
            'penumpang' => $request->penumpang,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'pending',
        ]);

        return redirect()->route('pemesanan.index')
            ->with('success', 'Pemesanan berhasil dibuat. Menunggu persetujuan Admin Transport.');
    }

    public function show(Pemesanan $pemesanan)
    {
        if (!auth()->user()->can('view all pemesanan') && $pemesanan->user_id !== auth()->id()) {
            abort(403);
        }

        $pemesanan->load(['kendaraan', 'user', 'approver']);
        return view('pemesanan.show', compact('pemesanan'));
    }

    public function edit(Pemesanan $pemesanan)
    {
        if ($pemesanan->user_id !== auth()->id() || $pemesanan->status !== 'pending') {
            return back()->with('error', 'Pemesanan tidak dapat diubah.');
        }

        $kendaraan = Kendaraan::tersedia()->orWhere('id', $pemesanan->kendaraan_id)->get();
        return view('pemesanan.edit', compact('pemesanan', 'kendaraan'));
    }

    public function update(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->user_id !== auth()->id() || $pemesanan->status !== 'pending') {
            return back()->with('error', 'Pemesanan tidak dapat diubah.');
        }

        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'keperluan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'penumpang' => 'required|string',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        $pemesanan->update($request->only([
            'kendaraan_id', 'keperluan', 'tujuan', 'penumpang', 'tanggal_mulai', 'tanggal_selesai'
        ]));

        return redirect()->route('pemesanan.index')
            ->with('success', 'Pemesanan berhasil diperbarui.');
    }

    public function destroy(Pemesanan $pemesanan)
    {
        if ($pemesanan->user_id !== auth()->id() || $pemesanan->status !== 'pending') {
            return back()->with('error', 'Pemesanan tidak dapat dihapus.');
        }

        $pemesanan->delete();
        return redirect()->route('pemesanan.index')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    public function approveForm(Pemesanan $pemesanan)
    {
        if ($pemesanan->status !== 'pending') {
            return back()->with('error', 'Pemesanan sudah diproses.');
        }

        // Get driver IDs yang sedang aktif di surat jalan
        $activeDriverIds = SuratJalan::where('status', 'aktif')
            ->whereNotNull('driver_id')
            ->pluck('driver_id')
            ->toArray();

        // Get users with driver role yang tidak sedang aktif
        $drivers = User::role('driver')
            ->whereNotIn('id', $activeDriverIds)
            ->get();
        
        return view('pemesanan.approve', compact('pemesanan', 'drivers'));
    }

    public function approve(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->status !== 'pending') {
            return back()->with('error', 'Pemesanan sudah diproses.');
        }

        $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($pemesanan, $request) {
            // Update pemesanan
            $pemesanan->update([
                'status' => 'disetujui',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
            
            // Update status kendaraan
            $pemesanan->kendaraan->update(['status' => 'terpakai']);
            
            // Buat surat jalan otomatis
            SuratJalan::create([
                'nomor_surat' => SuratJalan::generateNomorSurat(),
                'pemesanan_id' => $pemesanan->id,
                'kendaraan_id' => $pemesanan->kendaraan_id,
                'user_id' => $pemesanan->user_id,
                'approved_by' => auth()->id(),
                'driver_id' => $request->driver_id,
                'keperluan' => $pemesanan->keperluan,
                'tujuan' => $pemesanan->tujuan,
                'penumpang' => $pemesanan->penumpang ?? $pemesanan->user->name,
                'tanggal_berangkat' => $pemesanan->tanggal_mulai,
                'tanggal_kembali' => $pemesanan->tanggal_selesai,
                'status' => 'aktif',
            ]);
        });

        return redirect()->route('pemesanan.index')
            ->with('success', 'Pemesanan berhasil disetujui dan Surat Jalan telah dibuat.');
    }

    public function reject(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->status !== 'pending') {
            return back()->with('error', 'Pemesanan sudah diproses.');
        }

        $pemesanan->update([
            'status' => 'ditolak',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'keterangan' => $request->keterangan ?? 'Ditolak oleh Admin Transport',
        ]);

        return back()->with('success', 'Pemesanan telah ditolak.');
    }

    public function complete(Pemesanan $pemesanan)
    {
        if ($pemesanan->status !== 'disetujui') {
            return back()->with('error', 'Pemesanan tidak valid.');
        }

        DB::transaction(function () use ($pemesanan) {
            $pemesanan->update(['status' => 'selesai']);
            $pemesanan->kendaraan->update(['status' => 'kosong']);
        });

        return back()->with('success', 'Pemesanan telah diselesaikan.');
    }
}
