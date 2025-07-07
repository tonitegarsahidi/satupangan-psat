<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterJenisPanganSegar;
use Illuminate\Support\Str;

class MasterBahanPanganSegarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisPangan1 = MasterJenisPanganSegar::where('kode_jenis_pangan_segar', 'JPS001')->first();
        $jenisPangan2 = MasterJenisPanganSegar::where('kode_jenis_pangan_segar', 'JPS002')->first();

        MasterBahanPanganSegar::create([
            'id' => Str::uuid(),
            'jenis_id' => $jenisPangan1->id,
            'kode_bahan_pangan_segar' => 'BPS001',
            'nama_bahan_pangan_segar' => 'Beras Putih',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);

        MasterBahanPanganSegar::create([
            'id' => Str::uuid(),
            'jenis_id' => $jenisPangan2->id,
            'kode_bahan_pangan_segar' => 'BPS002',
            'nama_bahan_pangan_segar' => 'Kentang Granola',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);
    }
}
