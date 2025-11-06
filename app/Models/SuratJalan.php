<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    protected $table = 'surat_jalan';

    protected $fillable = [
        'nomor_surat',
        'pemesanan_id',
        'kendaraan_id',
        'user_id',
        'approved_by',
        'driver_id',
        'keperluan',
        'tujuan',
        'penumpang',
        'tanggal_berangkat',
        'tanggal_kembali',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_berangkat' => 'datetime',
        'tanggal_kembali' => 'datetime'
    ];

    // Relationships
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Generate nomor surat otomatis
    public static function generateNomorSurat()
    {
        $year = date('Y');
        $month = date('m');
        
        // Format: SJ/001/MM/YYYY
        $lastSurat = self::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->orderBy('id', 'desc')
                        ->first();
        
        $nextNumber = $lastSurat ? (intval(substr($lastSurat->nomor_surat, 3, 3)) + 1) : 1;
        
        return sprintf('SJ/%03d/%s/%s', $nextNumber, $month, $year);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
