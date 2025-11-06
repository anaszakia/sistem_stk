<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    
    protected $fillable = [
        'nama_kendaraan',
        'jenis',
        'plat_nomor',
        'pajak_stnk',
        'status'
    ];

    protected $casts = [
        'pajak_stnk' => 'date'
    ];

    // Relationship
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class);
    }

    // Scope untuk kendaraan yang tersedia (kosong)
    public function scopeTersedia($query)
    {
        return $query->where('status', 'kosong');
    }
}
