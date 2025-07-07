<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;

class MasterKelompokPanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterKelompokPangan::create([
            'id' => Str::uuid(),
            'kode_kelompok_pangan' => 'KP001',
            'nama_kelompok_pangan' => 'Serealia',
            'keterangan' => 'Kelompok pangan serealia',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);

        MasterKelompokPangan::create([
            'id' => Str::uuid(),
            'kode_kelompok_pangan' => 'KP002',
            'nama_kelompok_pangan' => 'Umbi-umbian',
            'keterangan' => 'Kelompok pangan umbi-umbian',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);
    }
}
