<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegisterIzinedarPsatpduk;
use App\Models\Business;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisterIzinedarPsatpdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the user with email pengusaha@panganaman.my.id
        $user = User::where('email', 'pengusaha2@panganaman.my.id')->first();
        if (!$user) {
            $this->command->error('User with email pengusaha2@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
            return;
        }

        // Get the business associated with this user
        $business = Business::where('user_id', $user->id)->first();
        if (!$business) {
            $this->command->error('No business found for user pengusaha2@panganaman.my.id. Please ensure the business exists before running this seeder.');
            return;
        }

        $userpetugas = User::where('email', 'kantorjatim@panganaman.my.id')->first();
        if (!$userpetugas) {
            $this->command->error('User with email kantorjatim@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
            return;
        }

        // Get sample provinsi and kota (using Jawa Timur and Kota Malang as examples)
        $provinsi = MasterProvinsi::where('nama_provinsi', 'Jawa Timur')->first();
        $kota = MasterKota::where('nama_kota', 'Kota Malang')->first();

        // Get a sample jenis_psat
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

        // Create sample data for register_izinedar_psatpduk
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-SPPB-001',
            'nomor_izinedar_pduk' => 'REG-IZINPL-001',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Wortel',
            'alamat_unitusaha' => 'Jl. Wortel Manis No. 1',
            'alamat_unitpenanganan' => 'Jl. Wortel Manis No. 1',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MELON-001',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Daucus carota',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Wortel Segar',
            'jenis_kemasan' => 'Kardus',
            'ukuran_berat' => '10 kg per kardus',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/carrot1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/carrot2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/carrot3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/carrot4.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/carrot5.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/carrot6.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => '2026-01-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

    }
}
