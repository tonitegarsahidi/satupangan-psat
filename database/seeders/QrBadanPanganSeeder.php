<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QrBadanPanganSeeder extends Seeder
{
    public function run()
    {
        // Get user IDs for various roles
        $user1 = DB::table('users')->where('email', 'pengusaha@satupangan.id')->first();
        $user2 = DB::table('users')->where('email', 'pengusaha2@satupangan.id')->first();
        $petugas = DB::table('users')->where('email', 'petugas@satupangan.id')->first();
        $supervisor = DB::table('users')->where('email', 'supervisor@satupangan.id')->first();

        // Get business IDs
        $business1 = DB::table('business')->where('nama_perusahaan', 'PT Melon Segar')->first();
        $business2 = DB::table('business')->where('nama_perusahaan', 'CV Sambo Importir')->first();

        // Get reference IDs
        $sppb = DB::table('register_sppb')->first();
        $izinedarPsatpl = DB::table('register_izinedar_psatpl')->first();
        $izinedarPsatpd = DB::table('register_izinedar_psatpd')->first();
        $izinedarPsatpduk = DB::table('register_izinedar_psatpduk')->first();
        $izinrumahPengemasan = DB::table('register_izinrumah_pengemasan')->first();
        $sertifikatKeamananPangan = DB::table('register_sertifikat_keamanan_pangan')->first();
        $jenisPsat = DB::table('master_jenis_pangan_segars')->first();

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
                'status' => 'approved',
                'is_published' => true,
                'business_id' => $business1 ? $business1->id : null,
                'nama_komoditas' => 'Melon',
                'nama_latin' => 'Cucumis melo',
                'merk_dagang' => 'Melon Segar Jaya',
                'jenis_psat' => $jenisPsat ? $jenisPsat->id : null,
                'referensi_sppb' => $sppb ? $sppb->id : null,
                'referensi_izinedar_psatpl' => $izinedarPsatpl ? $izinedarPsatpl->id : null,
                'referensi_izinedar_psatpd' => $izinedarPsatpd ? $izinedarPsatpd->id : null,
                'referensi_izinedar_psatpduk' => $izinedarPsatpduk ? $izinedarPsatpduk->id : null,
                'referensi_izinrumah_pengemasan' => $izinrumahPengemasan ? $izinrumahPengemasan->id : null,
                'referensi_sertifikat_keamanan_pangan' => $sertifikatKeamananPangan ? $sertifikatKeamananPangan->id : null,
                'file_lampiran1' => 'lampiran1.pdf',
                'file_lampiran2' => 'lampiran2.pdf',
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
                'requested_by' => $user2 ? $user2->id : null,
                'requested_at' => $now->copy()->subDays(4),
                'reviewed_by' => null,
                'reviewed_at' => null,
                'approved_by' => null,
                'approved_at' => null,
                'status' => 'pending',
                'is_published' => false,
                'business_id' => $business2 ? $business2->id : null,
                'nama_komoditas' => 'Mangga',
                'nama_latin' => 'Mangifera indica',
                'merk_dagang' => 'Mangga Impor Premium',
                'jenis_psat' => $jenisPsat ? $jenisPsat->id : null,
                'referensi_sppb' => $sppb ? $sppb->id : null,
                'referensi_izinedar_psatpl' => $izinedarPsatpl ? $izinedarPsatpl->id : null,
                'referensi_izinedar_psatpd' => $izinedarPsatpd ? $izinedarPsatpd->id : null,
                'referensi_izinedar_psatpduk' => $izinedarPsatpduk ? $izinedarPsatpduk->id : null,
                'referensi_izinrumah_pengemasan' => $izinrumahPengemasan ? $izinrumahPengemasan->id : null,
                'referensi_sertifikat_keamanan_pangan' => $sertifikatKeamananPangan ? $sertifikatKeamananPangan->id : null,
                'file_lampiran1' => 'lampiran1.pdf',
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
                'qr_code' => 'QR-BP-003',
                'current_assignee' => $supervisor ? $supervisor->id : null,
                'requested_by' => $user1 ? $user1->id : null,
                'requested_at' => $now->copy()->subDays(3),
                'reviewed_by' => $petugas ? $petugas->id : null,
                'reviewed_at' => $now->copy()->subDays(2),
                'approved_by' => null,
                'approved_at' => null,
                'status' => 'reviewed',
                'is_published' => false,
                'business_id' => $business1 ? $business1->id : null,
                'nama_komoditas' => 'Pisang',
                'nama_latin' => 'Musa',
                'merk_dagang' => 'Pisang Cavendish',
                'jenis_psat' => $jenisPsat ? $jenisPsat->id : null,
                'referensi_sppb' => $sppb ? $sppb->id : null,
                'referensi_izinedar_psatpl' => $izinedarPsatpl ? $izinedarPsatpl->id : null,
                'referensi_izinedar_psatpd' => $izinedarPsatpd ? $izinedarPsatpd->id : null,
                'referensi_izinedar_psatpduk' => $izinedarPsatpduk ? $izinedarPsatpduk->id : null,
                'referensi_izinrumah_pengemasan' => $izinrumahPengemasan ? $izinrumahPengemasan->id : null,
                'referensi_sertifikat_keamanan_pangan' => $sertifikatKeamananPangan ? $sertifikatKeamananPangan->id : null,
                'file_lampiran1' => 'lampiran1.pdf',
                'file_lampiran2' => 'lampiran2.pdf',
                'file_lampiran3' => 'lampiran3.pdf',
                'file_lampiran4' => null,
                'file_lampiran5' => null,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(2),
                'deleted_at' => null,
            ],
        ];

        DB::table('qr_badan_pangan')->insert($qrBadanPangans);
    }
}
