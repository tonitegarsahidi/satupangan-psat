<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegisterIzinedarPsatpl;
use App\Models\Business;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisterIzinedarPsatplSeeder extends Seeder
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

        $userpetugas = User::where('email', 'kantorpusat@panganaman.my.id')->first();
        if (!$userpetugas) {
            $this->command->error('User with email kantorpusat@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
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



        // Create sample data for register_izinedar_psatpl
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'PENDING',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-DNGN-001',
            'nomor_izinedar_pl' => 'REG-IZINPL-MLN-001',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Melon',
            'alamat_unitusaha' => 'Jl. Melon Manis No. 1',
            'alamat_unitpenanganan' => 'Jl. Melon Manis No. 1',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MELON-001',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Melon',
            'nama_latin' => 'Cucumis melo',
            'negara_asal' => 'India',
            'merk_dagang' => 'Melon Sweet',
            'jenis_kemasan' => 'Kardus',
            'ukuran_berat' => '5 kg per karton',
            'klaim' => 'Segar Manis, Berkualitas Export',
            'foto_1' => 'images/upload/register/melon1.jpg',
            'foto_2' => 'images/upload/register/melon2.jpg',
            'foto_3' => 'images/upload/register/melon3.jpg',
            'foto_4' => 'images/upload/register/melon4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' => 'files/upload/register/contohdokumen.pdf',
            'file_sppb' => 'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpl' => 'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => '2029-01-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

    }
}
