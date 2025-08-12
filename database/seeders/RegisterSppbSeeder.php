<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegisterSppb;
use App\Models\Business;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use App\Models\MasterPenanganan;
use Illuminate\Support\Str;

class RegisterSppbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are businesses for the specified emails
        $business1 = Business::whereHas('user', function($query) {
            $query->where('email', 'pengusaha@panganaman.my.id');
        })->first();

        if (!$business1) {
            $user1 = \App\Models\User::where('email', 'pengusaha@panganaman.my.id')->first();
            if (!$user1) {
                // Create user if doesn't exist
                $user1 = \App\Models\User::create([
                    'name' => 'Pengusaha',
                    'email' => 'pengusaha@panganaman.my.id',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]);
            }
            $business1 = Business::create([
                'id' => Str::uuid(),
                'user_id' => $user1->id,
                'nama_perusahaan' => 'Bisnis 1',
                'alamat_perusahaan' => 'Jl. Bisnis 1 No. 123',
                'jabatan_perusahaan' => 'Owner',
                'nib' => 'NIB001',
                'is_active' => true,
            ]);
        }


        // Ensure there are at least two penanganan records
        $penanganan1 = MasterPenanganan::where('nama_penanganan', 'Penyimpanan suhu dingin')->first();
        if (!$penanganan1) {
            $penanganan1 = MasterPenanganan::create([
                'id' => Str::uuid(),
                'nama_penanganan' => 'Penyimpanan suhu dingin',
            ]);
        }

        $penanganan2 = MasterPenanganan::where('nama_penanganan', 'Pengemasan')->first();
        if (!$penanganan2) {
            $penanganan2 = MasterPenanganan::create([
                'id' => Str::uuid(),
                'nama_penanganan' => 'Pengemasan',
            ]);
        }

        // Ensure there are at least two jenis psat records
        $jenispsat1 = MasterJenisPanganSegar::where('nama_jenis_pangan_segar', 'Buah Kulit Tidak Dimakan')->first();
        if (!$jenispsat1) {
            $kelompok1 = MasterKelompokPangan::where('nama_kelompok_pangan', 'Buah')->first();
            if (!$kelompok1) {
                $kelompok1 = MasterKelompokPangan::create([
                    'id' => Str::uuid(),
                    'kode_kelompok_pangan' => 'KB001',
                    'nama_kelompok_pangan' => 'Buah',
                    'is_active' => true,
                ]);
            }
            $jenispsat1 = MasterJenisPanganSegar::create([
                'id' => Str::uuid(),
                'kelompok_id' => $kelompok1->id,
                'kode_jenis_pangan_segar' => 'JP013',
                'nama_jenis_pangan_segar' => 'Buah Kulit Tidak Dimakan',
                'is_active' => true,
            ]);
        }

        $jenispsat2 = MasterJenisPanganSegar::where('nama_jenis_pangan_segar', 'Sayuran Umbi dan Akar')->first();
        if (!$jenispsat2) {
            $kelompok2 = MasterKelompokPangan::where('nama_kelompok_pangan', 'Sayur, termasuk Jamur')->first();
            if (!$kelompok2) {
                $kelompok2 = MasterKelompokPangan::create([
                    'id' => Str::uuid(),
                    'kode_kelompok_pangan' => 'KS001',
                    'nama_kelompok_pangan' => 'Sayur, termasuk Jamur',
                    'is_active' => true,
                ]);
            }
            $jenispsat2 = MasterJenisPanganSegar::create([
                'id' => Str::uuid(),
                'kelompok_id' => $kelompok2->id,
                'kode_jenis_pangan_segar' => 'JP009',
                'nama_jenis_pangan_segar' => 'Sayuran Umbi dan Akar',
                'is_active' => true,
            ]);
        }

        // Create SPPB 1
        RegisterSppb::create([
            'id' => Str::uuid(),
            'business_id' => $business1->id,
            'status' => config('workflow.sppb_statuses.DIAJUKAN'),
            'is_enabled' => true,
            'nomor_registrasi' => 'REG-SPPB-DNGN-001',
            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => '2026-01-01',
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha A',
            'alamat_unitusaha' => 'Jl. Unit A No. 1',
            'provinsi_unitusaha' => null,
            'kota_unitusaha' => null,
            'nib_unitusaha' => 'NIB-A-001',
            'jenis_psat' => $jenispsat1->id,
            'nama_komoditas' => 'Melon',
            'penanganan_id' => $penanganan1->id,
            'penanganan_keterangan' => 'Penyimpanan suhu dingin',
            'alamat_unit_penanganan' => 'Jl. Penanganan A No. 1',
        ]);

        // Create SPPB 2
        RegisterSppb::create([
            'id' => Str::uuid(),
            'business_id' => $business1->id,
            'status' => config('workflow.sppb_statuses.DISETUJUI'),
            'is_enabled' => true,
            'nomor_registrasi' => 'REG-SPPB-KMSN-002',
            'tanggal_terbit' => '2025-02-01',
            'tanggal_terakhir' => '2026-02-01',
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'provinsi_unitusaha' => null,
            'kota_unitusaha' => null,
            'nib_unitusaha' => null,
            'jenis_psat' => $jenispsat2->id,
            'nama_komoditas' => 'Kentang',
            'penanganan_id' => $penanganan2->id,
            'penanganan_keterangan' => 'Pengemasan',
            'alamat_unit_penanganan' => 'Jl. Penanganan B No. 2',
        ]);
    }
}
