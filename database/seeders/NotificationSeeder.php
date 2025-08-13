<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the users we need to create notifications for
        $users = User::whereIn('email', [
            'kantorpusat@panganaman.my.id',
            'kantorjatim@panganaman.my.id',
            'pengusaha@panganaman.my.id',
            'pengusaha2@panganaman.my.id'
        ])->get();

        if ($users->count() !== 4) {
            $this->command->error('Required users not found. Please run UserSeeder first.');
            return;
        }

        $notifications = [
            // Notifications for kantorpusat@panganaman.my.id
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $users->where('email', 'kantorpusat@panganaman.my.id')->first()->id,
                'type' => 'sppb_extension',
                'title' => 'Permintaan Perpanjangan SPPB',
                'message' => 'Terdapat pengajuan perpanjangan SPPB dari pengusaha. Silakan cek detail dan berikan approval.',
                'data' => [
                    'sppb_id' => 'SPPB-2025-001',
                    'business_name' => 'Usaha Melon Importir',
                    'requested_date' => Carbon::now()->toDateString(),
                    'expiry_date' => Carbon::now()->addMonths(3)->toDateString()
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $users->where('email', 'kantorpusat@panganaman.my.id')->first()->id,
                'type' => 'system_alert',
                'title' => 'Update Sistem PSAT',
                'message' => 'Sistem PSAT akan undergo maintenance pada tanggal 15 Agustus 2025 pukul 00:00 - 02:00 WIB.',
                'data' => [
                    'maintenance_date' => '2025-08-15',
                    'maintenance_time' => '00:00 - 02:00 WIB',
                    'affected_features' => ['Registrasi', 'QR Code Generation', 'Reporting']
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],

            // Notifications for kantorjatim@panganaman.my.id
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $users->where('email', 'kantorjatim@panganaman.my.id')->first()->id,
                'type' => 'document_issue',
                'title' => 'File Dokumen PSAT PL Kurang Jelas',
                'message' => 'Dokumen PSAT PL dari pengusaha2@panganaman.my.id memiliki kualitas gambar yang kurang jelas. Silakan minta pengiriman ulang.',
                'data' => [
                    'document_id' => 'PSAT-PL-2025-045',
                    'business_name' => 'Pas Sambo Petani',
                    'issue_type' => 'unclear_image',
                    'required_action' => 'request_resubmission'
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $users->where('email', 'kantorjatim@panganaman.my.id')->first()->id,
                'type' => 'inspection_schedule',
                'title' => 'Jadwal Inspeksi Mendatang',
                'message' => 'Jadwal inspeksi untuk bulan September 2025 telah dirilis. Anda memiliki 3 inspeksi yang dijadwalkan.',
                'data' => [
                    'inspection_count' => 3,
                    'month' => 'September 2025',
                    'first_inspection' => '2025-09-05',
                    'last_inspection' => '2025-09-25'
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],

            // Notifications for pengusaha@panganaman.my.id
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $users->where('email', 'pengusaha@panganaman.my.id')->first()->id,
                'type' => 'sppb_status',
                'title' => 'Status SPPB: Perlu Perpanjangan',
                'message' => 'SPPB Anda (SPPB-2025-001) akan berakhir pada 30 September 2025. Silakan ajukan perpanjangan sebelum tanggal tersebut.',
                'data' => [
                    'sppb_id' => 'SPPB-2025-001',
                    'expiry_date' => '2025-09-30',
                    'days_remaining' => 17,
                    'action_required' => 'submit_extension_request'
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $users->where('email', 'pengusaha@panganaman.my.id')->first()->id,
                'type' => 'qr_code_generated',
                'title' => 'QR Code Telah Dibuat',
                'message' => 'QR Code untuk produk "Melon Importir" telah berhasil dibuat dan siap digunakan.',
                'data' => [
                    'qr_code' => 'QR-2025-0813-001',
                    'product_name' => 'Melon Importir',
                    'validity_period' => '1 tahun'
                ],
                'is_read' => true,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],

            // Notifications for pengusaha2@panganaman.my.id
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $users->where('email', 'pengusaha2@panganaman.my.id')->first()->id,
                'type' => 'document_feedback',
                'title' => 'Dokumen PSAT PL Perlu Perbaikan',
                'message' => 'Dokumen PSAT PL Anda perlu diperbaikan karena kualitas gambar yang kurang jelas. Silakan unggah ulang dokumen yang lebih jelas.',
                'data' => [
                    'document_id' => 'PSAT-PL-2025-045',
                    'issue_details' => 'image_quality',
                    'resubmission_deadline' => '2025-08-20'
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $users->where('email', 'pengusaha2@panganaman.my.id')->first()->id,
                'type' => 'training_announcement',
                'title' => 'Pelatihan PSAT Gratis',
                'message' => 'Kami mengadakan pelatihan PSAT gratis untuk pelaku usaha pada 20 Agustus 2025. Pendaftaran dibuka hingga 18 Agustus.',
                'data' => [
                    'training_date' => '2025-08-20',
                    'registration_deadline' => '2025-08-18',
                    'training_topic' => 'Standar Keamanan Pangan Segar',
                    'location' => 'Online via Zoom'
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
        ];

        // Insert notifications
        foreach ($notifications as $notification) {
            Notification::create($notification);
        }

        $this->command->info('NotificationSeeder completed successfully.');
    }
}
