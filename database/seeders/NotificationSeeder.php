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
        // Get all users
        $users = User::all();

        if ($users->count() === 0) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        // Define sample notification templates
        $notificationTemplates = [
            [
                'type' => 'system_alert',
                'title' => 'Pemberitahuan Sistem',
                'message' => 'Ini adalah pemberitahuan penting dari sistem PSAT. Mohon periksa dashboard Anda untuk informasi lebih lanjut.',
                'data' => [
                    'priority' => 'high',
                    'category' => 'system',
                    'action_required' => true
                ]
            ],
            [
                'type' => 'document_reminder',
                'title' => 'Pengingat Dokumen',
                'message' => 'Beberapa dokumen Anda akan segera kedaluwarsa. Silakan perbarui dokumen Anda untuk melanjutkan layanan.',
                'data' => [
                    'document_type' => 'Sertifikasi',
                    'expiry_date' => Carbon::now()->addDays(30)->toDateString(),
                    'action_required' => 'renew_document'
                ]
            ],
            [
                'type' => 'training_announcement',
                'title' => 'Pelatihan Baru Tersedia',
                'message' => 'Kami mengadakan pelatihan baru tentang standar keamanan pangan. Pendaftaran sudah dibuka.',
                'data' => [
                    'training_topic' => 'Standar Keamanan Pangan Segar',
                    'training_date' => Carbon::now()->addDays(14)->toDateString(),
                    'location' => 'Online',
                    'registration_deadline' => Carbon::now()->addDays(7)->toDateString()
                ]
            ],
            [
                'type' => 'inspection_schedule',
                'title' => 'Jadwal Inspeksi',
                'message' => 'Jadwal inspeksi untuk bulan depan telah dirilis. Anda memiliki 2 inspeksi yang dijadwalkan.',
                'data' => [
                    'inspection_count' => 2,
                    'month' => Carbon::now()->addMonth()->format('F Y'),
                    'first_inspection' => Carbon::now()->addDays(10)->toDateString(),
                    'last_inspection' => Carbon::now()->addDays(25)->toDateString()
                ]
            ],
            [
                'type' => 'qr_code_generated',
                'title' => 'QR Code Telah Dibuat',
                'message' => 'QR Code untuk produk Anda telah berhasil dibuat dan siap digunakan.',
                'data' => [
                    'qr_code' => 'QR-' . Carbon::now()->format('Ym') . '-' . rand(100, 999),
                    'product_name' => 'Produk ' . rand(1, 100),
                    'validity_period' => '1 tahun'
                ]
            ],
            [
                'type' => 'sppb_status',
                'title' => 'Status SPPB',
                'message' => 'Status SPPB Anda telah diperbarui. Silakan cek detail di dashboard.',
                'data' => [
                    'sppb_id' => 'SPPB-' . Carbon::now()->format('Y') . '-' . rand(100, 999),
                    'status' => 'approved',
                    'expiry_date' => Carbon::now()->addMonths(6)->toDateString()
                ]
            ],
            [
                'type' => 'document_feedback',
                'title' => 'Umpan Balik Dokumen',
                'message' => 'Dokumen Anda telah diperiksa. Ada beberapa perbaikan yang diperlukan.',
                'data' => [
                    'document_id' => 'DOC-' . Carbon::now()->format('Ym') . '-' . rand(100, 999),
                    'status' => 'needs_revision',
                    'feedback_details' => 'Document needs improvement in image quality',
                    'resubmission_deadline' => Carbon::now()->addDays(7)->toDateString()
                ]
            ],
            [
                'type' => 'new_feature',
                'title' => 'Fitur Baru Tersedia',
                'message' => 'Kami telah menambahkan fitur baru di sistem PSAT. Jelajahi fitur-fitur terbaru kami.',
                'data' => [
                    'feature_name' => 'Dashboard Peningkatan',
                    'description' => 'Visualisasi data yang lebih baik dan analisis mendalam',
                    'release_date' => Carbon::now()->toDateString()
                ]
            ],
            [
                'type' => 'system_maintenance',
                'title' => 'Pemeliharaan Sistem',
                'message' => 'Sistem akan mengalami pemeliharaan pada tanggal yang telah ditentukan.',
                'data' => [
                    'maintenance_date' => Carbon::now()->addDays(3)->toDateString(),
                    'maintenance_time' => '00:00 - 02:00 WIB',
                    'affected_features' => ['Registrasi', 'QR Code', 'Laporan']
                ]
            ],
            [
                'type' => 'deadline_reminder',
                'title' => 'Pengingat Batas Waktu',
                'message' => 'Batas waktu pengajuan dokumen Anda akan segera berakhir.',
                'data' => [
                    'document_type' => 'PSAT PL',
                    'deadline_date' => Carbon::now()->addDays(5)->toDateString(),
                    'days_remaining' => 5,
                    'action_required' => 'submit_document'
                ]
            ]
        ];

        $notifications = [];

        // Create 3 notifications for each user
        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $template = $notificationTemplates[array_rand($notificationTemplates)];

                $notification = [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'user_id' => $user->id,
                    'type' => $template['type'],
                    'title' => $template['title'],
                    'message' => $template['message'],
                    'data' => $template['data'],
                    'is_read' => rand(0, 1) === 1, // Randomly set as read or unread
                    'created_at' => Carbon::now()->subDays(rand(1, 10)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 10)),
                ];

                $notifications[] = $notification;
            }
        }

        // Insert notifications
        foreach ($notifications as $notification) {
            Notification::create($notification);
        }

        // Also create some specific notifications for important users as in the original seeder
        $kantorPusat = $users->where('email', 'kantorpusat@panganaman.my.id')->first();
        $pengusaha = $users->where('email', 'pengusaha@panganaman.my.id')->first();
        $kantorJatim = $users->where('email', 'kantorjatim@panganaman.my.id')->first();
        $pengusaha2 = $users->where('email', 'pengusaha2@panganaman.my.id')->first();
        $pimpinan = $users->where('email', 'pimpinan@panganaman.my.id')->first();

        // Check if these specific users exist before creating notifications
        if ($kantorPusat) {
            // Additional notifications for kantorpusat
            $notifications[] = [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $kantorPusat->id,
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
            ];
        }

        if ($kantorJatim) {
            // Additional notifications for kantorjatim
            $notifications[] = [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $kantorJatim->id,
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
            ];
        }

        if ($pengusaha) {
            // Additional notifications for pengusaha
            $notifications[] = [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $pengusaha->id,
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
            ];
        }

        if ($pengusaha2) {
            // Additional notifications for pengusaha2
            $notifications[] = [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $pengusaha2->id,
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
            ];
        }

        if ($pimpinan) {
            // Additional notifications for pimpinan
            $notifications[] = [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $pimpinan->id,
                'type' => 'leader_report',
                'title' => 'Laporan Bulanan Kegiatan Pengawasan',
                'message' => 'Laporan bulanan kegiatan pengawasan telah tersedia. Silakan periksa dashboard untuk melihat ringkasan performa tim.',
                'data' => [
                    'report_month' => Carbon::now()->format('F Y'),
                    'total_inspections' => 42,
                    'completed_tasks' => 38,
                    'pending_tasks' => 4,
                    'action_required' => 'review_report'
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ];

            $notifications[] = [
                'id' => \Illuminate\Support\Str::uuid(),
                'user_id' => $pimpinan->id,
                'type' => 'policy_update',
                'title' => 'Update Kebijakan PSAT',
                'message' => 'Ada update terkait kebijakan PSAT yang perlu Anda ketahui. Dokumen kebijakan terbaru telah diunggah.',
                'data' => [
                    'policy_document' => 'Kebijakan PSAT 2025.pdf',
                    'effective_date' => Carbon::now()->addDays(7)->toDateString(),
                    'summary_changes' => 'Peningkatan standar keamanan pangan dan prosedur verifikasi yang diperbarui',
                    'action_required' => 'review_policy'
                ],
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ];
        }

        // Insert additional notifications
        foreach ($notifications as $notification) {
            // Skip if already inserted
            if (!Notification::find($notification['id'])) {
                Notification::create($notification);
            }
        }

        $this->command->info('NotificationSeeder completed successfully.');
    }
}
