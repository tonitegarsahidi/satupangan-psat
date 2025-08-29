<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanRekap;
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

        // Sample pengawasan rekap data
        $rekapData = [
            [
                'id' => Str::uuid(),
                'user_id_admin' => $users['admin@panganaman.my.id'] ?? null,
                'jenis_psat_id' => $jenisPangan['JP001'] ?? null,
                'produk_psat_id' => $bahanPangan['BP001'] ?? null,
                'provinsi_id' => $provinsis['DKI Jakarta'] ?? null,
                'hasil_rekap' => 'Rekapitulasi pemeriksaan bulan Januari menunjukkan peningkatan kualitas produk serealia.',
                'lampiran1' => 'files/upload/lampiran1_rekap_sample1.pdf',
                'lampiran2' => 'files/upload/lampiran2_rekap_sample1.pdf',
                'lampiran3' => 'files/upload/lampiran3_rekap_sample1.pdf',
                'lampiran4' => 'files/upload/lampiran4_rekap_sample1.pdf',
                'lampiran5' => 'files/upload/lampiran5_rekap_sample1.pdf',
                'lampiran6' => 'files/upload/lampiran6_rekap_sample1.pdf',
                'status' => 'SELESAI',
                'pic_tindakan_id' => $users['supervisor@panganaman.my.id'] ?? null,
                'is_active' => true,
                'created_by' => $users['admin@panganaman.my.id'] ?? null,
                'updated_by' => $users['admin@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'user_id_admin' => $users['supervisor@panganaman.my.id'] ?? null,
                'jenis_psat_id' => $jenisPangan['JP005'] ?? null,
                'produk_psat_id' => $bahanPangan['BP016'] ?? null,
                'provinsi_id' => $provinsis['Jawa Barat'] ?? null,
                'hasil_rekap' => 'Beberapa lokasi memerlukan perbaikan sanitasi untuk mencegah kontaminasi.',
                'lampiran1' => 'files/upload/lampiran1_rekap_sample2.pdf',
                'lampiran2' => 'files/upload/lampiran2_rekap_sample2.pdf',
                'lampiran3' => 'files/upload/lampiran3_rekap_sample2.pdf',
                'lampiran4' => 'files/upload/lampiran4_rekap_sample2.pdf',
                'lampiran5' => 'files/upload/lampiran5_rekap_sample2.pdf',
                'lampiran6' => 'files/upload/lampiran6_rekap_sample2.pdf',
                'status' => 'PROSES',
                'pic_tindakan_id' => $users['operator@panganaman.my.id'] ?? null,
                'is_active' => true,
                'created_by' => $users['supervisor@panganaman.my.id'] ?? null,
                'updated_by' => $users['supervisor@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'user_id_admin' => $users['operator@panganaman.my.id'] ?? null,
                'jenis_psat_id' => $jenisPangan['JP007'] ?? null,
                'produk_psat_id' => $bahanPangan['BP025'] ?? null,
                'provinsi_id' => $provinsis['Jawa Tengah'] ?? null,
                'hasil_rekap' => 'Kepatuuan SOP sangat baik, tidak ditemukan masalah signifikan.',
                'lampiran1' => 'files/upload/lampiran1_rekap_sample3.pdf',
                'lampiran2' => 'files/upload/lampiran2_rekap_sample3.pdf',
                'lampiran3' => 'files/upload/lampiran3_rekap_sample3.pdf',
                'lampiran4' => 'files/upload/lampiran4_rekap_sample3.pdf',
                'lampiran5' => 'files/upload/lampiran5_rekap_sample3.pdf',
                'lampiran6' => 'files/upload/lampiran6_rekap_sample3.pdf',
                'status' => 'SELESAI',
                'pic_tindakan_id' => $users['user@panganaman.my.id'] ?? null,
                'is_active' => true,
                'created_by' => $users['operator@panganaman.my.id'] ?? null,
                'updated_by' => $users['operator@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'user_id_admin' => $users['user@panganaman.my.id'] ?? null,
                'jenis_psat_id' => $jenisPangan['JP013'] ?? null,
                'produk_psat_id' => $bahanPangan['BP041'] ?? null,
                'provinsi_id' => $provinsis['DI Yogyakarta'] ?? null,
                'hasil_rekap' => 'Kebutuhan pelabelan produk perlu diperhatikan di beberapa area.',
                'lampiran1' => 'files/upload/lampiran1_rekap_sample4.pdf',
                'lampiran2' => 'files/upload/lampiran2_rekap_sample4.pdf',
                'lampiran3' => 'files/upload/lampiran3_rekap_sample4.pdf',
                'lampiran4' => 'files/upload/lampiran4_rekap_sample4.pdf',
                'lampiran5' => 'files/upload/lampiran5_rekap_sample4.pdf',
                'lampiran6' => 'files/upload/lampiran6_rekap_sample4.pdf',
                'status' => 'PROSES',
                'pic_tindakan_id' => $users['kantorjabar@panganaman.my.id'] ?? null,
                'is_active' => true,
                'created_by' => $users['user@panganaman.my.id'] ?? null,
                'updated_by' => $users['user@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'user_id_admin' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'jenis_psat_id' => $jenisPangan['JP004'] ?? null,
                'produk_psat_id' => $bahanPangan['BP010'] ?? null,
                'provinsi_id' => $provinsis['Jawa Timur'] ?? null,
                'hasil_rekap' => 'Hasil laboratorium semua sampel menunjukkan hasil dalam batas aman.',
                'lampiran1' => 'files/upload/lampiran1_rekap_sample5.pdf',
                'lampiran2' => 'files/upload/lampiran2_rekap_sample5.pdf',
                'lampiran3' => 'files/upload/lampiran3_rekap_sample5.pdf',
                'lampiran4' => 'files/upload/lampiran4_rekap_sample5.pdf',
                'lampiran5' => 'files/upload/lampiran5_rekap_sample5.pdf',
                'lampiran6' => 'files/upload/lampiran6_rekap_sample5.pdf',
                'status' => 'SELESAI',
                'pic_tindakan_id' => $users['kantorjateng@panganaman.my.id'] ?? null,
                'is_active' => true,
                'created_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'updated_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
            ],
        ];

        // Insert pengawasan rekap data
        foreach ($rekapData as $data) {
            PengawasanRekap::create($data);
        }
    }
}
