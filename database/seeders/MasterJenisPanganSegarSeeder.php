<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;

class MasterJenisPanganSegarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelompokPangan1 = MasterKelompokPangan::where('kode_kelompok_pangan', 'KP001')->first();
        $kelompokPangan2 = MasterKelompokPangan::where('kode_kelompok_pangan', 'KP002')->first();

        MasterJenisPanganSegar::create([
            'id' => Str::uuid(),
            'kelompok_id' => $kelompokPangan1->id,
            'kode_jenis_pangan_segar' => 'JPS001',
            'nama_jenis_pangan_segar' => 'Beras',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);

        MasterJenisPanganSegar::create([
            'id' => Str::uuid(),
            'kelompok_id' => $kelompokPangan2->id,
            'kode_jenis_pangan_segar' => 'JPS002',
            'nama_jenis_pangan_segar' => 'Kentang',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);
    }
}
