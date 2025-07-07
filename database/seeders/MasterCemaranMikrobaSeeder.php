<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterCemaranMikroba;
use Illuminate\Support\Str;

class MasterCemaranMikrobaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterCemaranMikroba::create([
            'id' => Str::uuid(),
            'kode_cemaran_mikroba' => 'CMB001',
            'nama_cemaran_mikroba' => 'Escherichia coli',
            'keterangan' => 'Cemaran Escherichia coli',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);

        MasterCemaranMikroba::create([
            'id' => Str::uuid(),
            'kode_cemaran_mikroba' => 'CMB002',
            'nama_cemaran_mikroba' => 'Salmonella sp.',
            'keterangan' => 'Cemaran Salmonella sp.',
            'is_active' => true,
            'created_by' => 'seeder',
        ]);
    }
}
