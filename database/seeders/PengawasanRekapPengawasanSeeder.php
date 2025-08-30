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
        // Get all rekap and pengawasan records
        $rekapRecords = PengawasanRekap::all();
        $pengawasanRecords = Pengawasan::all();

        // Create relationships between rekap and pengawasan records
        // Group pengawasan records by province, jenis_psat, and produk_psat
        $groupedPengawasan = $pengawasanRecords->groupBy(function($pengawasan) {
            return $pengawasan->lokasi_provinsi_id . '_' . $pengawasan->jenis_psat_id . '_' . $pengawasan->produk_psat_id;
        });

        // Create relationship data
        $rekapPengawasanData = [];

        foreach ($rekapRecords as $rekap) {
            // Find pengawasan records that match this rekap's criteria
            $matchingPengawasan = $pengawasanRecords->filter(function($pengawasan) use ($rekap) {
                return $pengawasan->lokasi_provinsi_id == $rekap->provinsi_id &&
                       $pengawasan->jenis_psat_id == $rekap->jenis_psat_id &&
                       $pengawasan->produk_psat_id == $rekap->produk_psat_id;
            });

            // Create relationship for each matching pengawasan record
            foreach ($matchingPengawasan as $pengawasan) {
                $rekapPengawasanData[] = [
                    'id' => Str::uuid(),
                    'pengawasan_rekap_id' => $rekap->id,
                    'pengawasan_id' => $pengawasan->id,
                ];
            }
        }

        // Insert pengawasan rekap pengawasan data
        foreach ($rekapPengawasanData as $data) {
            PengawasanRekapPengawasan::create($data);
        }
    }
}
