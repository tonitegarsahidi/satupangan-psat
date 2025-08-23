<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengawasan;
use App\Models\User;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterKota;
use App\Models\MasterProvinsi;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengawasanSeeder extends Seeder
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
        $kotas = MasterKota::pluck('id', 'nama_kota')->toArray();
        $provinsis = MasterProvinsi::pluck('id', 'nama_provinsi')->toArray();

        // Sample pengawasan data
        $pengawasanData = [
            [
                'id' => Str::uuid(),
                'user_id_initiator' => $users['kantorjateng@panganaman.my.id'] ?? null,
                'lokasi_alamat' => 'Jl. Sudirman No. 123, Semarang',
                'lokasi_kota_id' => $kotas['Kota Semarang'] ?? null,
                'lokasi_provinsi_id' => $provinsis['Jawa Tengah'] ?? null,
                'tanggal_mulai' => Carbon::now()->subDays(10),
                'tanggal_selesai' => Carbon::now()->subDays(5),
                'jenis_psat_id' => $jenisPangan['JP001'] ?? null,
                'produk_psat_id' => $bahanPangan['BP001'] ?? null,
                'hasil_pengawasan' => 'Pemeriksaan rutin berjalan lancar, tidak ditemukan pelanggaran.',
                'status' => 'SELESAI',
                'tindakan_rekomendasikan' => 'Tidak ada tindakan khusus yang diperlukan.',
                'is_active' => true,
                'created_by' => $users['kantorjateng@panganaman.my.id'] ?? null,
                'updated_by' => $users['kantorjateng@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'user_id_initiator' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'lokasi_alamat' => 'Jl. Gatot Subroto No. 456, Kota Surabaya',
                'lokasi_kota_id' => $kotas['Kota Surabaya'] ?? null,
                'lokasi_provinsi_id' => $provinsis['Jawa Timur'] ?? null,
                'tanggal_mulai' => Carbon::now()->subDays(8),
                'tanggal_selesai' => Carbon::now()->subDays(3),
                'jenis_psat_id' => $jenisPangan['JP005'] ?? null,
                'produk_psat_id' => $bahanPangan['BP016'] ?? null,
                'hasil_pengawasan' => 'Ditemukan cemaran mikroba dalam batas aman, namun perbaikan sanitasi diperlukan.',
                'status' => 'SELESAI',
                'tindakan_rekomendasikan' => 'Melakukan perbaikan sistem sanitasi dan pelatihan karyawan.',
                'is_active' => true,
                'created_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'updated_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'user_id_initiator' => $users['kantorjabar@panganaman.my.id'] ?? null,
                'lokasi_alamat' => 'Jl. Raya Bogor Km. 25, Kota Depok',
                'lokasi_kota_id' => $kotas['Kota Depok'] ?? null,
                'lokasi_provinsi_id' => $provinsis['Jawa Barat'] ?? null,
                'tanggal_mulai' => Carbon::now()->subDays(15),
                'tanggal_selesai' => Carbon::now()->subDays(10),
                'jenis_psat_id' => $jenisPangan['JP007'] ?? null,
                'produk_psat_id' => $bahanPangan['BP025'] ?? null,
                'hasil_pengawasan' => 'Pemeriksaan menunjukkan kepatuan standar operasional prosedur yang baik.',
                'status' => 'SELESAI',
                'tindakan_rekomendasikan' => 'Mempertahankan kinerja yang baik dan terus meningkatkan kualitas.',
                'is_active' => true,
                'created_by' => $users['kantorjabar@panganaman.my.id'] ?? null,
                'updated_by' => $users['kantorjabar@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'user_id_initiator' => $users['kantorjabar@panganaman.my.id'] ?? null,
                'lokasi_alamat' => 'Jl. Ahmad Yani No. 78, Kota Bandung',
                'lokasi_kota_id' => $kotas['Kota Bandung'] ?? null,
                'lokasi_provinsi_id' => $provinsis['Jawa Barat'] ?? null,
                'tanggal_mulai' => Carbon::now()->subDays(5),
                'tanggal_selesai' => Carbon::now()->subDays(2),
                'jenis_psat_id' => $jenisPangan['JP013'] ?? null,
                'produk_psat_id' => $bahanPangan['BP041'] ?? null,
                'hasil_pengawasan' => 'Terdapat kekurangan dokumentasi pelabelan produk.',
                'status' => 'SELESAI',
                'tindakan_rekomendasikan' => 'Melengkapi semua dokumen pelabelan sesuai standar.',
                'is_active' => true,
                'created_by' => $users['kantorjabar@panganaman.my.id'] ?? null,
                'updated_by' => $users['kantorjabar@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'user_id_initiator' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'lokasi_alamat' => 'Jl. Basuki Rahmat No. 12, Kota Malang',
                'lokasi_kota_id' => $kotas['Kota Malang'] ?? null,
                'lokasi_provinsi_id' => $provinsis['Jawa Timur'] ?? null,
                'tanggal_mulai' => Carbon::now()->subDays(12),
                'tanggal_selesai' => Carbon::now()->subDays(7),
                'jenis_psat_id' => $jenisPangan['JP004'] ?? null,
                'produk_psat_id' => $bahanPangan['BP010'] ?? null,
                'hasil_pengawasan' => 'Pemeriksaan laboratorium menunjukkan hasil normal.',
                'status' => 'SELESAI',
                'tindakan_rekomendasikan' => 'Tidak ada tindakan khusus yang diperlukan.',
                'is_active' => true,
                'created_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'updated_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
            ],
        ];

        // Insert pengawasan data
        foreach ($pengawasanData as $data) {
            Pengawasan::create($data);
        }
    }
}
