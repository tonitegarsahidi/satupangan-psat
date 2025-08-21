<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanRekapPengawasan;
use App\Models\PengawasanRekap;
use App\Models\Pengawasan;
use Illuminate\Support\Str;

class PengawasanRekapPengawasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get reference data
        $rekapRecords = PengawasanRekap::pluck('id')->toArray();
        $pengawasanRecords = Pengawasan::pluck('id')->toArray();

        // Sample pengawasan rekap pengawasan data
        // This table links rekap records to individual pengawasan records
        $rekapPengawasanData = [
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[0] ?? null,
                'pengawasan_id' => $pengawasanRecords[0] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[0] ?? null,
                'pengawasan_id' => $pengawasanRecords[1] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[1] ?? null,
                'pengawasan_id' => $pengawasanRecords[2] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[2] ?? null,
                'pengawasan_id' => $pengawasanRecords[3] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[3] ?? null,
                'pengawasan_id' => $pengawasanRecords[4] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[4] ?? null,
                'pengawasan_id' => $pengawasanRecords[0] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[4] ?? null,
                'pengawasan_id' => $pengawasanRecords[2] ?? null,
            ],
        ];

        // Insert pengawasan rekap pengawasan data
        foreach ($rekapPengawasanData as $data) {
            PengawasanRekapPengawasan::create($data);
        }
    }
}
