<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterCemaranMikrotoksin;
use Illuminate\Support\Str;

class MasterCemaranMikrotoksinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterCemaranMikrotoksin::create([
            'id' => Str::uuid(),
            'kode_cemaran_mikrotoksin' => 'CMT001',
            'nama_cemaran_mikrotoksin' => 'Aflatoksin',
            'keterangan' => 'Cemaran Aflatoksin',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);

        MasterCemaranMikrotoksin::create([
            'id' => Str::uuid(),
            'kode_cemaran_mikrotoksin' => 'CMT002',
            'nama_cemaran_mikrotoksin' => 'Okratoksin A',
            'keterangan' => 'Cemaran Okratoksin A',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);
    }
}
