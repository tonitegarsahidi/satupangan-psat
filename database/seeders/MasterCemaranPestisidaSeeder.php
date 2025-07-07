<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MasterCemaranPestisidaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_cemaran_pestisidas')->insert([
            [
                'id' => (string) Str::uuid(),
                'kode_cemaran_pestisida' => 'PST001',
                'nama_cemaran_pestisida' => 'Karbofuran',
                'keterangan' => 'Pestisida golongan karbamat',
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'kode_cemaran_pestisida' => 'PST002',
                'nama_cemaran_pestisida' => 'Klorpirifos',
                'keterangan' => 'Pestisida golongan organofosfat',
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
