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
        // Ensure there's at least one business, province, city, and jenis_psat for foreign keys
        $business = Business::first();
        if (!$business) {
            $user = \App\Models\User::first();
            $business = Business::create([
                'id' => Str::uuid(),
                'user_id' => $user ? $user->id : null,
                'nama_perusahaan' => 'Dummy Business',
                'alamat_perusahaan' => 'Jl. Dummy No. 123',
                'jabatan_perusahaan' => 'Owner',
                'nib' => '123456789012345',
                'is_active' => true,
            ]);
        }

        $provinsi = MasterProvinsi::first();
        if (!$provinsi) {
            $provinsi = MasterProvinsi::create([
                'id' => Str::uuid(),
                'kode_provinsi' => 'DP',
                'nama_provinsi' => 'Dummy Provinsi',
                'is_active' => true,
            ]);
        }

        $kota = MasterKota::first();
        if (!$kota) {
            $kota = MasterKota::create([
                'id' => Str::uuid(),
                'provinsi_id' => $provinsi->id,
                'kode_kota' => 'DK',
                'nama_kota' => 'Dummy Kota',
                'is_active' => true,
            ]);
        }

        $jenisPsat = MasterJenisPanganSegar::first();
        if (!$jenisPsat) {
            // Create a dummy jenis_psat if none exists
            $kelompok = MasterKelompokPangan::first();
            if (!$kelompok) {
                $kelompok = MasterKelompokPangan::create([
                    'id' => Str::uuid(),
                    'kode_kelompok_pangan' => 'KP001',
                    'nama_kelompok_pangan' => 'Dummy Kelompok',
                    'is_active' => true,
                ]);
            }
            $jenisPsat = MasterJenisPanganSegar::create([
                'id' => Str::uuid(),
                'kelompok_id' => $kelompok->id,
                'kode_jenis_pangan_segar' => 'JP000',
                'nama_jenis_pangan_segar' => 'Dummy Jenis Pangan Segar',
                'is_active' => true,
            ]);
        }

        RegisterSppb::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DRAFT',
            'is_enabled' => true,
            'nomor_registrasi' => 'REG-SPPB-001',
            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => '2026-01-01',
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha A',
            'alamat_unitusaha' => 'Jl. Unit A No. 1',
            'provinsi_unitusaha' => $provinsi->id,
            'kota_unitusaha' => $kota->id,
            'nib_unitusaha' => 'NIB-A-001',
            'jenis_psat' => $jenisPsat->id,
            'nama_komoditas' => 'Komoditas A',
            'penanganan_id' => MasterPenanganan::first()?->id,
            'penanganan_keterangan' => 'Keterangan Penanganan A',
        ]);

        RegisterSppb::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'SUBMITTED',
            'is_enabled' => true,
            'nomor_registrasi' => 'REG-SPPB-002',
            'tanggal_terbit' => '2025-02-01',
            'tanggal_terakhir' => '2026-02-01',
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'provinsi_unitusaha' => null,
            'kota_unitusaha' => null,
            'nib_unitusaha' => null,
            'jenis_psat' => $jenisPsat->id,
            'nama_komoditas' => 'Komoditas B',
            'penanganan_id' => MasterPenanganan::first()?->id,
            'penanganan_keterangan' => 'Keterangan Penanganan B',
        ]);
    }
}
