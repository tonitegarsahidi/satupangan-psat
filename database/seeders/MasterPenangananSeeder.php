<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterPenanganan;
use Illuminate\Support\Str;

class MasterPenangananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterPenanganan::create([
            'id' => Str::uuid(),
            'nama_penanganan' => 'Penyimpanan suhu ruang',
        ]);
        MasterPenanganan::create([
            'id' => Str::uuid(),
            'nama_penanganan' => 'Penyimpanan suhu dingin',
        ]);
        MasterPenanganan::create([
            'id' => Str::uuid(),
            'nama_penanganan' => 'Penyimpanan beku',
        ]);
        MasterPenanganan::create([
            'id' => Str::uuid(),
            'nama_penanganan' => 'Pengemasan',
        ]);
        MasterPenanganan::create([
            'id' => Str::uuid(),
            'nama_penanganan' => 'Pengupasan, pemotongan',
        ]);
        MasterPenanganan::create([
            'id' => Str::uuid(),
            'nama_penanganan' => 'Penggilingan',
        ]);
        MasterPenanganan::create([
            'id' => Str::uuid(),
            'nama_penanganan' => 'Pengeringan',
        ]);
        MasterPenanganan::create([
            'id' => Str::uuid(),
            'nama_penanganan' => 'Pengolahan minimal lainnya (sebutkan)',
        ]);
    }
}
