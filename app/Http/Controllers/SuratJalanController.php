<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratJalanController extends Controller
{
    public function index()
    {
        $query = SuratJalan::with(['pemesanan', 'kendaraan', 'user', 'approver']);
        
        // Security dan Admin Transport bisa melihat semua
        if (auth()->user()->can('view all pemesanan')) {
            $suratJalan = $query->latest()->paginate(15);
        } else {
            // User lain hanya bisa melihat surat jalan mereka sendiri
            $suratJalan = $query->where('user_id', auth()->id())->latest()->paginate(15);
        }
        
        return view('surat-jalan.index', compact('suratJalan'));
    }

    public function show(SuratJalan $suratJalan)
    {
        // Check authorization
        if (!auth()->user()->can('view all pemesanan') && $suratJalan->user_id !== auth()->id()) {
            abort(403);
        }

        $suratJalan->load(['pemesanan', 'kendaraan', 'user', 'approver']);
        return view('surat-jalan.show', compact('suratJalan'));
    }

    public function print(SuratJalan $suratJalan)
    {
        // Check authorization
        if (!auth()->user()->can('view all pemesanan') && $suratJalan->user_id !== auth()->id()) {
            abort(403);
        }

        $suratJalan->load(['pemesanan', 'kendaraan', 'user', 'approver']);
        
        // Replace "/" with "-" untuk nama file
        $fileName = 'Surat-Jalan-' . str_replace('/', '-', $suratJalan->nomor_surat) . '.pdf';
        
        $pdf = Pdf::loadView('surat-jalan.print', compact('suratJalan'))
                  ->setPaper('a4', 'portrait');
        
        return $pdf->stream($fileName);
    }

    public function download(SuratJalan $suratJalan)
    {
        // Check authorization
        if (!auth()->user()->can('view all pemesanan') && $suratJalan->user_id !== auth()->id()) {
            abort(403);
        }

        $suratJalan->load(['pemesanan', 'kendaraan', 'user', 'approver']);
        
        // Replace "/" with "-" untuk nama file
        $fileName = 'Surat-Jalan-' . str_replace('/', '-', $suratJalan->nomor_surat) . '.pdf';
        
        $pdf = Pdf::loadView('surat-jalan.print', compact('suratJalan'))
                  ->setPaper('a4', 'portrait');
        
        return $pdf->download($fileName);
    }

    public function complete(SuratJalan $suratJalan)
    {
        $suratJalan->update(['status' => 'selesai']);
        
        return back()->with('success', 'Surat jalan telah diselesaikan.');
    }
}
