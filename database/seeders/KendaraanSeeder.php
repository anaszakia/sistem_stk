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
                'nama_kendaraan' => 'Toyota Avanza',
                'jenis' => 'Mobil',
                'plat_nomor' => 'B 1234 ABC',
                'pajak_stnk' => '2024-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kendaraan' => 'Honda Vario',
                'jenis' => 'Motor',
                'plat_nomor' => 'B 5678 DEF',
                'pajak_stnk' => '2024-11-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kendaraan' => 'Mitsubishi Colt Diesel',
                'jenis' => 'Truk',
                'plat_nomor' => 'B 9012 GHI',
                'pajak_stnk' => '2025-06-30',
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
                'nama_kendaraan' => 'Yamaha NMAX',
                'jenis' => 'Motor',
                'plat_nomor' => 'B 7890 MNO',
                'pajak_stnk' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($kendaraan as $item) {
            \App\Models\Kendaraan::create($item);
        }
    }
}
