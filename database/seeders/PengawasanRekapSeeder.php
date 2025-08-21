<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanRekap;
use App\Models\User;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterBahanPanganSegar;
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

        // Sample pengawasan rekap data
        $rekapData = [
            [
                'id' => Str::uuid(),
                'user_id_admin' => $users['admin@panganaman.my.id'] ?? null,
                'jenis_psat_id' => $jenisPangan['JP001'] ?? null,
                'produk_psat_id' => $bahanPangan['BP001'] ?? null,
                'hasil_rekap' => 'Rekapitulasi pemeriksaan bulan Januari menunjukkan peningkatan kualitas produk serealia.',
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
                'hasil_rekap' => 'Beberapa lokasi memerlukan perbaikan sanitasi untuk mencegah kontaminasi.',
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
                'hasil_rekap' => 'Kepatuuan SOP sangat baik, tidak ditemukan masalah signifikan.',
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
                'hasil_rekap' => 'Kebutuhan pelabelan produk perlu diperhatikan di beberapa area.',
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
                'hasil_rekap' => 'Hasil laboratorium semua sampel menunjukkan hasil dalam batas aman.',
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
