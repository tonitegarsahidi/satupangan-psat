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
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-001',

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

        // Create second sample entry for Kentang
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-WRT-015',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-002',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Kentang No. 2',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Daucus carota',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Wortel Segar',
            'jenis_kemasan' => 'Karung',
            'ukuran_berat' => '20 kg per karung',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/kentang_7.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/kentang_8.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/kentang_9.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/kentang_10.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/kentang_11.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/kentang_12.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-KENTANG-002.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-KENTANG-002.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/IZIN-KENTANG-002.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-02-01',
            'tanggal_terakhir' => '2026-02-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create third sample entry for Kubis
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-KBS-003',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-003',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Kubis',
            'alamat_unitusaha' => 'Jl. Kubis Segar No. 3',
            'alamat_unitpenanganan' => 'Jl. Kubis Segar No. 3',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-KUBIS-001',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Brassica oleracea',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kubis Segar',
            'jenis_kemasan' => 'Kardus',
            'ukuran_berat' => '12 kg per kardus',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/kubis1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/kubis2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/kubis3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/kubis4.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/kubis5.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/kubis6.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-03-01',
            'tanggal_terakhir' => '2026-03-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create fourth sample entry for Tomat
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-TMT-004',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-004',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Tomat No. 4',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Solanum lycopersicum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Tomat Rajawali',
            'jenis_kemasan' => 'Pet',
            'ukuran_berat' => '1 kg per pet',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/tomat_7.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/tomat_8.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/tomat_9.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/tomat_10.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/tomat_11.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/tomat_12.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-TOMAT-004.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-TOMAT-004.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/IZIN-TOMAT-004.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-04-01',
            'tanggal_terakhir' => '2026-04-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create fifth sample entry for Bawang Merah
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-BWG-005',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-005',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Bawang Merah',
            'alamat_unitusaha' => 'Jl. Bawang Merah Bali No. 5',
            'alamat_unitpenanganan' => 'Jl. Bawang Merah Bali No. 5',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-BAWANG-001',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Allium cepa',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Bawang Merah Bali',
            'jenis_kemasan' => 'Sakel',
            'ukuran_berat' => '10 kg per sakel',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/bawang1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/bawang2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/bawang3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/bawang4.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/bawang5.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/bawang6.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-05-01',
            'tanggal_terakhir' => '2026-05-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create sixth sample entry for Kacang Panjang
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-KCP-006',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-006',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Kacang Panjang No. 6',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Vigna unguiculata',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kacang Panjang Hijau',
            'jenis_kemasan' => 'Pet',
            'ukuran_berat' => '500 gr per pet',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/kacang_7.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/kacang_8.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/kacang_9.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/kacang_10.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/kacang_11.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/kacang_12.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-KACANG-006.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-KACANG-006.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/IZIN-KACANG-006.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-06-01',
            'tanggal_terakhir' => '2026-06-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create seventh sample entry for Labu
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-LBU-007',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-007',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Labu',
            'alamat_unitusaha' => 'Jl. Labu Siam No. 7',
            'alamat_unitpenanganan' => 'Jl. Labu Siam No. 7',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-LABU-001',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Cucurbita pepo',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Labu Siam',
            'jenis_kemasan' => 'Karung',
            'ukuran_berat' => '25 kg per karung',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/labu1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/labu2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/labu3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/labu4.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/labu5.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/labu6.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-07-01',
            'tanggal_terakhir' => '2026-07-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create eighth sample entry for Wortel Hijau
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-WTH-008',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-008',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Wortel No. 8',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Daucus carota',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Wortel Hijau',
            'jenis_kemasan' => 'Kardus',
            'ukuran_berat' => '15 kg per kardus',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/wortel_7.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/wortel_8.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/wortel_9.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/wortel_10.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/wortel_11.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/wortel_12.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-WORTEL-008.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-WORTEL-008.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/IZIN-WORTEL-008.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-08-01',
            'tanggal_terakhir' => '2026-08-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create ninth sample entry for Kentang Merah
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-KTM-009',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-009',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Kentang Merah',
            'alamat_unitusaha' => 'Jl. Kentang Merah No. 9',
            'alamat_unitpenanganan' => 'Jl. Kentang Merah No. 9',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-KENTANG-002',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Merah',
            'jenis_kemasan' => 'Sakel',
            'ukuran_berat' => '5 kg per sakel',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/kentangmerah1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/kentangmerah2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/kentangmerah3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/kentangmerah4.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/kentangmerah5.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/kentangmerah6.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-09-01',
            'tanggal_terakhir' => '2026-09-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create tenth sample entry for Kubis Putih
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-KBP-010',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-010',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Kubis No. 10',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Brassica oleracea',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kubis Putih',
            'jenis_kemasan' => 'Kardus',
            'ukuran_berat' => '18 kg per kardus',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/kubisputih_7.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/kubisputih_8.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/kubisputih_9.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/kubisputih_10.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/kubisputih_11.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/kubisputih_12.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-KUBIS-010.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-KUBIS-010.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/IZIN-KUBIS-010.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-10-01',
            'tanggal_terakhir' => '2026-10-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create eleventh sample entry for Tomat Cherry
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-TMC-011',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-011',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Tomat Cherry',
            'alamat_unitusaha' => 'Jl. Tomat Cherry No. 11',
            'alamat_unitpenanganan' => 'Jl. Tomat Cherry No. 11',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-TOMAT-002',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Solanum lycopersicum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Tomat Cherry',
            'jenis_kemasan' => 'Pet',
            'ukuran_berat' => '250 gr per pet',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/tomatcherry1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/tomatcherry2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/tomatcherry3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/tomatcherry4.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/tomatcherry5.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/tomatcherry6.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-11-01',
            'tanggal_terakhir' => '2026-11-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create twelfth sample entry for Bawang Putih
        RegisterIzinedarPsatpduk::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-BWP-012',
            'nomor_izinedar_pduk' => 'REG-IZINPDUK-012',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Bawang No. 12',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Wortel',
            'nama_latin' => 'Allium sativum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Bawang Putih Lokal',
            'jenis_kemasan' => 'Sakel',
            'ukuran_berat' => '15 kg per sakel',
            'kategorilabel' => 'Label Hijau',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/bawangputih_7.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/bawangputih_8.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/bawangputih_9.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/bawangputih_10.jpg',
            'foto_5' =>  env('APP_URL').'/'.'images/upload/register/bawangputih_11.jpg',
            'foto_6' =>  env('APP_URL').'/'.'images/upload/register/bawangputih_12.jpg',
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-BAWANG-012.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-BAWANG-012.pdf',
            'file_izinedar_psatpduk' =>  env('APP_URL').'/'.'files/upload/register/IZIN-BAWANG-012.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-12-01',
            'tanggal_terakhir' => '2026-12-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }
}
