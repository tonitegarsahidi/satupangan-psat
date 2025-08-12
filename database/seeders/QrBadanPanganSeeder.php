<?php

namespace Database\Seeders;

use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QrBadanPanganSeeder extends Seeder
{
    public function run()
    {
        // Get user IDs for various roles
        $user1 = DB::table('users')->where('email', 'pengusaha@panganaman.my.id')->first();
        $user2 = DB::table('users')->where('email', 'pengusaha2@panganaman.my.id')->first();
        $petugas = DB::table('users')->where('email', 'petugas@panganaman.my.id')->first();
        $supervisor = DB::table('users')->where('email', 'supervisor@panganaman.my.id')->first();

        // Get business IDs
        $business1 = DB::table('business')
            ->join('users', 'business.user_id', '=', 'users.id')
            ->where('users.email', 'pengusaha@panganaman.my.id')
            ->select('business.*')
            ->first();

        $business2 = DB::table('business')
            ->join('users', 'business.user_id', '=', 'users.id')
            ->where('users.email', 'pengusaha2@panganaman.my.id')
            ->select('business.*')
            ->first();

        // Get reference IDs
        $sppb = DB::table('register_sppb')->first();
        $sppb1 = DB::table('register_sppb')->where('nomor_registrasi', 'REG-SPPB-DNGN-001')->first();
        $sppb2 = DB::table('register_sppb')->where('nomor_registrasi', 'REG-SPPB-KMSN-002')->first();
        $izinedarPsatpl = DB::table('register_izinedar_psatpl')->first();
        $izinedarPsatpd = DB::table('register_izinedar_psatpd')->first();
        $izinedarPsatpduk = DB::table('register_izinedar_psatpduk')->first();


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

        $now = Carbon::now();

        $qrBadanPangans = [
            [
                'id' => Str::uuid(),
                'qr_code' => 'QR-BP-001',
                'current_assignee' => $petugas ? $petugas->id : null,
                'requested_by' => $user1 ? $user1->id : null,
                'requested_at' => $now->copy()->subDays(5),
                'reviewed_by' => $petugas ? $petugas->id : null,
                'reviewed_at' => $now->copy()->subDays(3),
                'approved_by' => $supervisor ? $supervisor->id : null,
                'approved_at' => $now->copy()->subDays(1),
                'status' => 'pending',
                'is_published' => true,
                'qr_category' => 1, // Produk Dalam Negeri
                'business_id' => $business1 ? $business1->id : null,
                'nama_komoditas' => 'Melon',
                'nama_latin' => 'Cucumis melo',
                'merk_dagang' => 'Melon Sweet',
                'jenis_psat' => $jenispsat1 ? $jenispsat1->id : null,
                'referensi_sppb' => $sppb1 ? $sppb1->id : null,
                'referensi_izinedar_psatpl' => $izinedarPsatpl ? $izinedarPsatpl->id : null,
                'referensi_izinedar_psatpd' => null,
                'referensi_izinedar_psatpduk' => null,
                'referensi_izinrumah_pengemasan' => null,
                'referensi_sertifikat_keamanan_pangan' => null,
                'file_lampiran1' => null,
                'file_lampiran2' => null,
                'file_lampiran3' => null,
                'file_lampiran4' => null,
                'file_lampiran5' => null,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(1),
                'deleted_at' => null,
            ],
            [
                'id' => Str::uuid(),
                'qr_code' => 'QR-BP-002',
                'current_assignee' => $petugas ? $petugas->id : null,
                'requested_by' => $user1 ? $user1->id : null,
                'requested_at' => $now->copy()->subDays(4),
                'reviewed_by' => null,
                'reviewed_at' => null,
                'approved_by' => null,
                'approved_at' => null,
                'status' => 'pending',
                'is_published' => false,
                'qr_category' => 2, // Produk Impor
                'business_id' => $business1 ? $business1->id : null,
                'nama_komoditas' => 'Kentang',
                'nama_latin' => 'Solanum tuberosum',
                'merk_dagang' => 'Kentang Garut',
                'jenis_psat' => $jenispsat2 ? $jenispsat2->id : null,
                'referensi_sppb' => $sppb2 ? $sppb2->id : null,
                'referensi_izinedar_psatpl' => null,
                'referensi_izinedar_psatpd' => $izinedarPsatpd ? $izinedarPsatpd->id : null,
                'referensi_izinedar_psatpduk' => null,
                'referensi_izinrumah_pengemasan' => null,
                'referensi_sertifikat_keamanan_pangan' => null,
                'file_lampiran1' => null,
                'file_lampiran2' => null,
                'file_lampiran3' => null,
                'file_lampiran4' => null,
                'file_lampiran5' => null,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(4),
                'deleted_at' => null,
            ],

            [
                'id' => Str::uuid(),
                'qr_code' => 'QR-BP-004',
                'current_assignee' => $petugas ? $petugas->id : null,
                'requested_by' => $user2 ? $user2->id : null,
                'requested_at' => $now->copy()->subDays(2),
                'reviewed_by' => null,
                'reviewed_at' => null,
                'approved_by' => null,
                'approved_at' => null,
                'status' => 'pending',
                'is_published' => false,
                'qr_category' => 4, // Produk Sayuran
                'business_id' => $business2 ? $business2->id : null,
                'nama_komoditas' => 'Wortel',
                'nama_latin' => 'Daucus carota',
                'merk_dagang' => 'Wortel Segar',
                'jenis_psat' => $jenispsat2 ? $jenispsat2->id : null,
                'referensi_sppb' => null,
                'referensi_izinedar_psatpl' => null,
                'referensi_izinedar_psatpd' => null,
                'referensi_izinedar_psatpduk' => $izinedarPsatpduk ? $izinedarPsatpduk->id : null,
                'referensi_izinrumah_pengemasan' => null,
                'referensi_sertifikat_keamanan_pangan' => null,
                'file_lampiran1' => null,
                'file_lampiran2' => null,
                'file_lampiran3' => null,
                'file_lampiran4' => null,
                'file_lampiran5' => null,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
                'deleted_at' => null,
            ],
        ];

        DB::table('qr_badan_pangan')->insert($qrBadanPangans);
    }
}
