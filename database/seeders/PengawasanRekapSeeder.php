<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanRekap;
use App\Models\Pengawasan;
use App\Models\User;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterProvinsi;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengawasanRekapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get reference data
        $users = User::pluck('id', 'email')->toArray();
        $jenisPangan = MasterJenisPanganSegar::pluck('id', 'kode_jenis_pangan_segar')->toArray();
        $bahanPangan = MasterBahanPanganSegar::pluck('id', 'kode_bahan_pangan_segar')->toArray();
        $provinsis = MasterProvinsi::pluck('id', 'nama_provinsi')->toArray();

        // Get pengawasan records grouped by province and product type for aggregation
        $pengawasanRecords = Pengawasan::all();

        // Group pengawasan records by province, jenis_psat, and produk_psat
        $groupedPengawasan = $pengawasanRecords->groupBy(function($pengawasan) {
            return $pengawasan->lokasi_provinsi_id . '_' . $pengawasan->jenis_psat_id . '_' . $pengawasan->produk_psat_id;
        });

        // Create rekap data based on grouped pengawasan records
        $rekapData = [];

        foreach ($groupedPengawasan as $key => $group) {
            // Extract province, jenis_psat, and produk_psat from the key
            list($provinsiId, $jenisPsatId, $produkPsatId) = explode('_', $key);

            // Get corresponding province name
            $provinsiName = $provinsis[$provinsiId] ?? 'Unknown';

            // Count pengawasan records in this group
            $count = $group->count();

            // Generate a summary based on the pengawasan results
            $positiveResults = $group->where('status', 'SELESAI')->count();
            $percentage = $count > 0 ? round(($positiveResults / $count) * 100) : 0;

            // Determine admin user based on province ID
            $adminUser = null;
            if ($provinsiId == $provinsis['Jawa Tengah'] ?? null) {
                $adminUser = $users['kantorjateng@panganaman.my.id'] ?? null;
            } elseif ($provinsiId == $provinsis['Jawa Timur'] ?? null) {
                $adminUser = $users['kantorjatim@panganaman.my.id'] ?? null;
            } elseif ($provinsiId == $provinsis['Jawa Barat'] ?? null) {
                $adminUser = $users['kantorjabar@panganaman.my.id'] ?? null;
            } elseif ($provinsiId == $provinsis['Kewenangan Pusat'] ?? null) {
                $adminUser = $users['kantorpusat@panganaman.my.id'] ?? null;
            }

            // If no admin user found, use a default one
            if (!$adminUser && !empty($users)) {
                $adminUser = reset($users);
            }

            // Generate rekap summary based on results
            $status = $percentage >= 80 ? 'SELESAI' : 'PROSES';
            $summary = "Rekapitulasi pengawasan untuk {$provinsiName} menunjukkan {$percentage}% pelaksanaan berhasil ({$positiveResults} dari {$count} pengawasan). ";

            if ($percentage >= 80) {
                $summary .= "Secara keseluruhan, pelaksanaan pengawasan telah berjalan baik dengan tingkat kepatuhan yang memuaskan.";
            } else {
                $summary .= "Beberapa area memerlukan perhatian khusus untuk meningkatkan kualitas pelaksanaan pengawasan.";
            }

            // Add rekap data
            $rekapData[] = [
                'id' => Str::uuid(),
                'user_id_admin' => $adminUser,
                'jenis_psat_id' => $jenisPsatId,
                'produk_psat_id' => $produkPsatId,
                'judul_rekap' => "Rekapitulasi Pengawasan {$provinsiName}",
                'provinsi_id' => $provinsiId,
                'hasil_rekap' => $summary,
                'lampiran1' => 'files/upload/lampiran1_rekap_' . strtolower(str_replace(' ', '_', $provinsiName)) . '.pdf',
                'lampiran2' => 'files/upload/lampiran2_rekap_' . strtolower(str_replace(' ', '_', $provinsiName)) . '.pdf',
                'lampiran3' => 'files/upload/lampiran3_rekap_' . strtolower(str_replace(' ', '_', $provinsiName)) . '.pdf',
                'lampiran4' => 'files/upload/lampiran4_rekap_' . strtolower(str_replace(' ', '_', $provinsiName)) . '.pdf',
                'lampiran5' => 'files/upload/lampiran5_rekap_' . strtolower(str_replace(' ', '_', $provinsiName)) . '.pdf',
                'lampiran6' => 'files/upload/lampiran6_rekap_' . strtolower(str_replace(' ', '_', $provinsiName)) . '.pdf',
                'status' => $status,
                'pic_tindakan_id' => null,
                // Temporarily set tindakan_id to null as the pengawasan_tindakan table may not exist yet
                'tindakan_id' => null,
                'is_active' => true,
                'created_by' => $adminUser,
                'updated_by' => $adminUser,
            ];
        }

        // Insert pengawasan rekap data
        foreach ($rekapData as $data) {
            PengawasanRekap::create($data);
        }
    }
}

