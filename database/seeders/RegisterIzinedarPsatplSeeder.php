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
        $jenisPsat = MasterJenisPanganSegar::first();

        // Create sample data for register_izinedar_psatpl
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-SPPB-001',
            'nomor_izinedar_pl' => 'REG-IZINPL-001',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Melon',
            'alamat_unitusaha' => 'Jl. Melon Manis No. 1',
            'alamat_unitpenanganan' => 'Jl. Pengolahan Melon No. 2',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MELON-001',

            'jenis_psat' => $jenisPsat?->id,

            'nama_komoditas' => 'Apal Red Delicious',
            'nama_latin' => 'Malus domestica',
            'negara_asal' => 'Amerika Serikat',
            'merk_dagang' => 'Apel Oklahoma',
            'jenis_kemasan' => 'Karton Box',
            'ukuran_berat' => '10 kg per box',
            'klaim' => 'Import Premium, Fresh from Farm',
            'foto_1' => 'photos/izinedar/1.jpg',
            'foto_2' => 'photos/izinedar/2.jpg',
            'foto_3' => 'photos/izinedar/3.jpg',
            'foto_4' => 'photos/izinedar/4.jpg',
            'foto_5' => 'photos/izinedar/5.jpg',
            'foto_6' => 'photos/izinedar/6.jpg',
            'file_nib' => 'files/nib/NIB-MELON-001.pdf',
            'file_sppb' => 'files/sppb/SPPB-MELON-001.pdf',
            'file_izinedar_psatpl' => 'files/izinedar/IZIN-MELON-001.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => '2026-01-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create a second sample entry
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-IZIN-002',
            'nomor_izinedar_pl' => 'REG-IZIN-002',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Semangka No. 5',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenisPsat?->id,

            'nama_komoditas' => 'Grapes Red Globe',
            'nama_latin' => 'Vitis vinifera',
            'negara_asal' => 'Chile',
            'merk_dagang' => 'Grapes Chile Import',
            'jenis_kemasan' => 'Plastik Cling',
            'ukuran_berat' => '5 kg per tray',
            'klaim' => 'Import Fresh, Sweet and Juicy',
            'foto_1' => 'photos/izinedar/7.jpg',
            'foto_2' => 'photos/izinedar/8.jpg',
            'foto_3' => 'photos/izinedar/9.jpg',
            'foto_4' => 'photos/izinedar/10.jpg',
            'foto_5' => 'photos/izinedar/11.jpg',
            'foto_6' => 'photos/izinedar/12.jpg',
            'file_nib' => 'files/nib/NIB-SEMANGKA-001.pdf',
            'file_sppb' => 'files/sppb/SPPB-SEMANGKA-001.pdf',
            'file_izinedar_psatpl' => 'files/izinedar/IZIN-SEMANGKA-001.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-02-01',
            'tanggal_terakhir' => '2026-02-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }
}
