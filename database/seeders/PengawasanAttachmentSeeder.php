<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanAttachment;
use App\Models\Pengawasan;
use App\Models\PengawasanRekap;
use App\Models\PengawasanTindakan;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\User;
use Illuminate\Support\Str;

class PengawasanAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get reference data
        $users = User::pluck('id', 'email')->toArray();
        $pengawasanRecords = Pengawasan::pluck('id')->toArray();
        $rekapRecords = PengawasanRekap::pluck('id')->toArray();
        $tindakanRecords = PengawasanTindakan::pluck('id')->toArray();
        $tindakanLanjutanRecords = PengawasanTindakanLanjutan::pluck('id')->toArray();

        // Sample pengawasan attachment data
        $attachmentData = [
            // Attachments for Pengawasan
            [
                'id' => Str::uuid(),
                'linked_id' => $pengawasanRecords[0] ?? null,
                'linked_type' => 'PENGAWASAN',
                'file_path' => 'public/files/pengawasan/laporan_pengawasan_001.pdf',
                'file_name' => 'Laporan Pengawasan 001.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 2048576,
                'is_active' => true,
                'created_by' => $users['admin@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'linked_id' => $pengawasanRecords[0] ?? null,
                'linked_type' => 'PENGAWASAN',
                'file_path' => 'public/files/pengawasan/foto_lokasi_001.jpg',
                'file_name' => 'Foto Lokasi 001.jpg',
                'file_type' => 'image/jpeg',
                'file_size' => 1048576,
                'is_active' => true,
                'created_by' => $users['admin@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'linked_id' => $pengawasanRecords[1] ?? null,
                'linked_type' => 'PENGAWASAN',
                'file_path' => 'public/files/pengawasan/laporan_pengawasan_002.pdf',
                'file_name' => 'Laporan Pengawasan 002.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 3072000,
                'is_active' => true,
                'created_by' => $users['supervisor@panganaman.my.id'] ?? null,
            ],

            // Attachments for Rekap
            [
                'id' => Str::uuid(),
                'linked_id' => $rekapRecords[0] ?? null,
                'linked_type' => 'REKAP',
                'file_path' => 'public/files/rekap/rekap_bulanan_001.pdf',
                'file_name' => 'Rekap Bulanan 001.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 4096000,
                'is_active' => true,
                'created_by' => $users['admin@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'linked_id' => $rekapRecords[1] ?? null,
                'linked_type' => 'REKAP',
                'file_path' => 'public/files/rekap/grafik_pengawasan_001.png',
                'file_name' => 'Grafik Pengawasan 001.png',
                'file_type' => 'image/png',
                'file_size' => 512000,
                'is_active' => true,
                'created_by' => $users['supervisor@panganaman.my.id'] ?? null,
            ],

            // Attachments for Tindakan
            [
                'id' => Str::uuid(),
                'linked_id' => $tindakanRecords[0] ?? null,
                'linked_type' => 'TINDAKAN',
                'file_path' => 'public/files/tindakan/daftar_pic_001.xlsx',
                'file_name' => 'Daftar PIC 001.xlsx',
                'file_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'file_size' => 256000,
                'is_active' => true,
                'created_by' => $users['admin@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'linked_id' => $tindakanRecords[1] ?? null,
                'linked_type' => 'TINDAKAN',
                'file_path' => 'public/files/tindakan/rekomendasi_perbaikan_001.pdf',
                'file_name' => 'Rekomendasi Perbaikan 001.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 1536000,
                'is_active' => true,
                'created_by' => $users['supervisor@panganaman.my.id'] ?? null,
            ],

            // Attachments for Tindakan Lanjutan
            [
                'id' => Str::uuid(),
                'linked_id' => $tindakanLanjutanRecords[0] ?? null,
                'linked_type' => 'TINDAKAN_LANJUTAN',
                'file_path' => 'public/files/tindakan_lanjutan/bukti_pelaksanaan_001.jpg',
                'file_name' => 'Bukti Pelaksanaan 001.jpg',
                'file_type' => 'image/jpeg',
                'file_size' => 778240,
                'is_active' => true,
                'created_by' => $users['supervisor@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'linked_id' => $tindakanLanjutanRecords[1] ?? null,
                'linked_type' => 'TINDAKAN_LANJUTAN',
                'file_path' => 'public/files/tindakan_lanjutan/laporan_monitoring_001.pdf',
                'file_name' => 'Laporan Monitoring 001.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 3584000,
                'is_active' => true,
                'created_by' => $users['operator@panganaman.my.id'] ?? null,
            ],
        ];

        // Insert pengawasan attachment data
        foreach ($attachmentData as $data) {
            PengawasanAttachment::create($data);
        }
    }
}
