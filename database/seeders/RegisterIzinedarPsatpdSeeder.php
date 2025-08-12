<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegisterIzinedarPsatpd;
use App\Models\Business;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisterIzinedarPsatpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the user with email pengusaha@panganaman.my.id
        $user = User::where('email', 'pengusaha@panganaman.my.id')->first();
        if (!$user) {
            $this->command->error('User with email pengusaha@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
            return;
        }

        $userpetugas = User::where('email', 'kantorjatim@panganaman.my.id')->first();
        if (!$userpetugas) {
            $this->command->error('User with email kantorjatim@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
            return;
        }

        // Get the business associated with this user
        $business = Business::where('user_id', $user->id)->first();
        if (!$business) {
            $this->command->error('No business found for user pengusaha@panganaman.my.id. Please ensure the business exists before running this seeder.');
            return;
        }

        // Get sample provinsi and kota (using Jawa Timur and Kota Malang as examples)
        $provinsi = MasterProvinsi::where('nama_provinsi', 'Jawa Timur')->first();
        $kota = MasterKota::where('nama_kota', 'Kota Malang')->first();

        // Get a sample jenis_psat
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

        // Create sample data for register_izinedar_Psatpd
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-002',
            'nomor_izinedar_pd' => 'REG-IZINPD-KNTNG-001',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Kentang',
            'alamat_unitusaha' => 'Jl. Kentang Manis No. 1',
            'alamat_unitpenanganan' => 'Jl. Kentang Manis No. 1',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MELON-001',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Sakel',
            'ukuran_berat' => '20 kg per sakel',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => 'images/upload/register/kentang1.jpg',
            'foto_2' => 'images/upload/register/kentang2.jpg',
            'foto_3' => 'images/upload/register/kentang3.jpg',
            'foto_4' => 'images/upload/register/kentang4.jpg',
            'foto_5' => 'images/upload/register/kentang5.jpg',
            'foto_6' => null,
            'file_nib' => 'files/upload/register/contohdokumen.pdf',
            'file_sppb' => 'files/upload/register/contohdokumen.pdf',
            'file_izinedar_Psatpd' => 'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => '2026-01-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create a second sample entry
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-IZIN-002',
            'nomor_izinedar_pd' => 'REG-IZIN-002',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Kentang No. 5',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Sakel',
            'ukuran_berat' => '20 kg per karung',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => 'images/upload/register/kentang_7.jpg',
            'foto_2' => 'images/upload/register/kentang_8.jpg',
            'foto_3' => 'images/upload/register/kentang_9.jpg',
            'foto_4' => 'images/upload/register/kentang_10.jpg',
            'foto_5' => 'images/upload/register/kentang_11.jpg',
            'foto_6' => 'images/upload/register/kentang_12.jpg',
            'file_nib' => 'files/upload/register/NIB-KENTANG-002.pdf',
            'file_sppb' => 'files/upload/register/SPPB-KENTANG-002.pdf',
            'file_izinedar_Psatpd' => 'files/upload/register/IZIN-KENTANG-002.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-02-01',
            'tanggal_terakhir' => '2026-02-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }
}
