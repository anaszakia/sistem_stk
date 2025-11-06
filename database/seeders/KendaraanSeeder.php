<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kendaraan = [
            [
                'nama_kendaraan' => 'Toyota Avanza Putih',
                'jenis' => 'Mobil',
                'plat_nomor' => 'K 7743 IT',
                'pajak_stnk' => '2028-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kendaraan' => 'Toyota Innova Hitam',
                'jenis' => 'Mobil',
                'plat_nomor' => 'B 5678 DEF',
                'pajak_stnk' => '2028-11-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kendaraan' => 'Mitsubishi Colt Diesel',
                'jenis' => 'Truk',
                'plat_nomor' => 'B 9012 GHI',
                'pajak_stnk' => '2025-12-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kendaraan' => 'Isuzu Elf',
                'jenis' => 'Truk',
                'plat_nomor' => 'B 3456 JKL',
                'pajak_stnk' => '2025-03-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kendaraan' => 'Daihatsu Xenia Putih',
                'jenis' => 'Mobil',
                'plat_nomor' => 'K 7890 ST',
                'pajak_stnk' => '2029-08-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($kendaraan as $item) {
            \App\Models\Kendaraan::create($item);
        }
    }
}
