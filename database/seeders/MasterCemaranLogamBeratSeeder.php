<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterCemaranLogamBerat;
use Illuminate\Support\Str;

class MasterCemaranLogamBeratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterCemaranLogamBerat::create([
            'id' => Str::uuid(),
            'kode_cemaran_logam_berat' => 'CLB001',
            'nama_cemaran_logam_berat' => 'Timbal (Pb)',
            'keterangan' => 'Cemaran Timbal',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);

        MasterCemaranLogamBerat::create([
            'id' => Str::uuid(),
            'kode_cemaran_logam_berat' => 'CLB002',
            'nama_cemaran_logam_berat' => 'Kadmium (Cd)',
            'keterangan' => 'Cemaran Kadmium',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);
    }
}
