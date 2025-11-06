<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan_kendaraan';
    
    protected $fillable = [
        'kendaraan_id',
        'user_id',
        'keperluan',
        'tujuan',
        'penumpang',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'approved_at' => 'datetime'
    ];

    // Relationships
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

    public function suratJalan()
    {
        return $this->hasOne(SuratJalan::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['pending', 'disetujui'])
                    ->where('tanggal_selesai', '>=', now());
    }
}
