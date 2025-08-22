<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MessageThread;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all petugas users (users that exist in petugas table)
        $petugasUsers = DB::table('petugas')->pluck('user_id')->toArray();

        if (empty($petugasUsers)) {
            $this->command->error('No petugas users found. Please run PetugasSeeder first.');
            return;
        }

        // Get full user objects for petugas users
        $users = User::whereIn('id', $petugasUsers)->get();

        if ($users->count() === 0) {
            $this->command->error('No petugas users found. Please run PetugasSeeder first.');
            return;
        }

        // Define sample messages
        $sampleMessages = [
            'Selamat datang di sistem PSAT. Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.',
            'Informasi penting: Pastikan semua dokumen Anda sudah lengkap dan terbaru.',
            'Reminder: Mohon periksa kembali status pengajuan Anda di dashboard.',
            'Terima kasih telah menggunakan layanan kami. Kami siap membantu Anda.',
            'Update sistem: Fitur baru telah tersedia untuk meningkatkan pengalaman Anda.',
            'Pemberitahuan: Ada perubahan dalam prosedur administrasi yang perlu Anda ketahui.',
            'Kami menginformasikan bahwa jadwal inspeksi akan disesuaikan.',
            'Silakan lengkapi profil Anda untuk memaksimalkan penggunaan sistem.',
            'Terima kasih atas kerjasama Anda dalam menjalankan program PSAT.',
            'Informasi: Workshop pelatihan akan diadakan bulan depan.'
        ];

        // Create message threads and messages for each user
        foreach ($users as $user) {
            // Get all other users to create conversations with
            $otherUsers = $users->where('id', '!=', $user->id);

            // Ensure each petugas user gets at least 2 conversations
            $minConversations = 2;
            $conversationsCreated = 0;

            // Convert to array and shuffle for randomness
            $otherUsersArray = $otherUsers->shuffle()->values()->all();

            foreach ($otherUsersArray as $otherUser) {
                if ($conversationsCreated >= $minConversations && $conversationsCreated >= 3) break;

                // Create a thread between these two users
                $thread = MessageThread::create([
                    'id' => \Illuminate\Support\Str::uuid(),
                    'title' => 'Percakapan dengan ' . $otherUser->name,
                    'description' => 'Diskusi antara ' . $user->name . ' dan ' . $otherUser->name,
                    'initiator_id' => $user->id,
                    'participant_id' => $otherUser->id,
                    'is_read_by_initiator' => true,
                    'is_read_by_participant' => false,
                    'last_message_at' => Carbon::now()->subHours(rand(1, 24)),
                    'created_at' => Carbon::now()->subDays(rand(1, 7)),
                    'updated_at' => Carbon::now()->subHours(rand(1, 24)),
                ]);

                // Create at least 2 messages in the thread
                $messageCount = 0;
                for ($i = 0; $i < rand(2, 4); $i++) {
                    $sender = $i % 2 === 0 ? $user : $otherUser;
                    $message = Message::create([
                        'id' => \Illuminate\Support\Str::uuid(),
                        'thread_id' => $thread->id,
                        'sender_id' => $sender->id,
                        'message' => $sampleMessages[array_rand($sampleMessages)],
                        'is_read' => $sender->id === $user->id,
                        'read_at' => $sender->id === $user->id ? Carbon::now()->subHours(rand(1, 12)) : null,
                        'created_at' => Carbon::now()->subHours(rand(1, 48)),
                        'updated_at' => Carbon::now()->subHours(rand(1, 48)),
                    ]);

                    $messageCount++;

                    // Ensure at least 2 messages per thread
                    if ($messageCount >= 2) {
                        break;
                    }
                }

                $conversationsCreated++;
            }
        }

        // Also create some specific threads for important users as in the original seeder
        $kantorPusat = $users->where('email', 'kantorpusat@panganaman.my.id')->first();
        $pengusaha = $users->where('email', 'pengusaha@panganaman.my.id')->first();
        $kantorJatim = $users->where('email', 'kantorjatim@panganaman.my.id')->first();
        $pengusaha2 = $users->where('email', 'pengusaha2@panganaman.my.id')->first();
        $pimpinan = $users->where('email', 'pimpinan@panganaman.my.id')->first();

        // Check if these specific users exist before creating threads
        if ($kantorPusat && $pengusaha) {
            // Message Thread 1: Between kantorpusat and pengusaha about SPPB Extension
            $sppbThread = MessageThread::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Notifikasi Perpanjangan SPPB',
                'description' => 'Diskusi mengenai permintaan perpanjangan SPPB',
                'initiator_id' => $kantorPusat->id,
                'participant_id' => $pengusaha->id,
                'is_read_by_initiator' => true,
                'is_read_by_participant' => false,
                'last_message_at' => Carbon::now()->subHours(2),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subHours(2),
            ]);

            // Messages in SPPB thread
            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $sppbThread->id,
                'sender_id' => $kantorPusat->id,
                'message' => 'Selamat pagi, kami menerima permintaan perpanjangan SPPB dari Anda. Silakan konfirmasi apakah Anda masih memerlukan perpanjangan.',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(3),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $sppbThread->id,
                'sender_id' => $pengusaha->id,
                'message' => 'Ya, kami memerlukan perpanjangan SPPB. Bisakah kami berikan dokumen pendukungnya besok?',
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $sppbThread->id,
                'sender_id' => $kantorPusat->id,
                'message' => 'Tentu, silakan kirimkan dokumen pendukungnya besok pagi. Kami akan mereviewnya dan memberikan feedback dalam 1-2 hari kerja.',
                'is_read' => true,
                'read_at' => Carbon::now()->subHours(2),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $sppbThread->id,
                'sender_id' => $pengusaha->id,
                'message' => 'Terima kasih. Dokumen-dokumen pendukung sudah kami siapkan dan akan kami kirimkan besok pagi.',
                'is_read' => false,
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ]);
        }

        if ($kantorJatim && $pengusaha2) {
            // Message Thread 2: Between kantorjatim and pengusaha2 about PSAT PL document
            $psatThread = MessageThread::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'File Foto Dokumen PSAT PL kurang jelas',
                'description' => 'Diskusi mengenai kualitas dokumen PSAT PL',
                'initiator_id' => $kantorJatim->id,
                'participant_id' => $pengusaha2->id,
                'is_read_by_initiator' => false,
                'is_read_by_participant' => false,
                'last_message_at' => Carbon::now()->subHours(6),
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subHours(6),
            ]);

            // Messages in PSAT PL thread
            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $psatThread->id,
                'sender_id' => $kantorJatim->id,
                'message' => 'Selamat siang, kami mendapati dokumen PSAT PL yang Anda unggah memiliki kualitas gambar yang kurang jelas. Hal ini dapat mempengaruhi proses verifikasi.',
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $psatThread->id,
                'sender_id' => $pengusaha2->id,
                'message' => 'Maaf atas ketidaknyamanannya. Kami akan mencoba mengunggah ulang dokumen dengan kualitas yang lebih baik.',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(3),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $psatThread->id,
                'sender_id' => $pengusaha2->id,
                'message' => 'Sudah kami unggah ulang dokumen PSAT PL dengan kualitas yang lebih jelas. Mohon dicek kembali.',
                'is_read' => false,
                'created_at' => Carbon::now()->subHours(6),
                'updated_at' => Carbon::now()->subHours(6),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $psatThread->id,
                'sender_id' => $kantorJatim->id,
                'message' => 'Terima kasih atas respons cepatnya. Kami akan mereview dokumen yang baru diunggah dan akan memberikan informasi lebih lanjut.',
                'is_read' => false,
                'created_at' => Carbon::now()->subHours(5),
                'updated_at' => Carbon::now()->subHours(5),
            ]);

            // Additional message in PSAT PL thread
            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $psatThread->id,
                'sender_id' => $kantorJatim->id,
                'message' => 'Setelah kami review, dokumen PSAT PL Anda sudah memenuhi syarat. Terima kasih atas kerjasamanya.',
                'is_read' => false,
                'created_at' => Carbon::now()->subHours(4),
                'updated_at' => Carbon::now()->subHours(4),
            ]);
        }

        if ($pengusaha && $kantorPusat) {
            // Message Thread 3: Additional conversation between kantorpusat and pengusaha
            $additionalThread = MessageThread::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Pertanyaan tentang QR Code',
                'description' => 'Diskusi mengenai penerapan QR Code pada produk',
                'initiator_id' => $pengusaha->id,
                'participant_id' => $kantorPusat->id,
                'is_read_by_initiator' => true,
                'is_read_by_participant' => true,
                'last_message_at' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(1),
            ]);

            // Messages in additional thread
            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $additionalThread->id,
                'sender_id' => $pengusaha->id,
                'message' => 'Selamat siang, saya ingin bertanya tentang cara menerapkan QR Code pada produk kami.',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $additionalThread->id,
                'sender_id' => $kantorPusat->id,
                'message' => 'Selamat siang, QR Code dapat diterapkan dengan mencetaknya pada kemasan produk. Pastikan QR Code terlihat jelas dan mudah dipindai.',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $additionalThread->id,
                'sender_id' => $pengusaha->id,
                'message' => 'Terima kasih informasinya. Apakah ada ukuran standar untuk QR Code yang direkomendasikan?',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ]);
        }

        if ($pimpinan && $kantorPusat) {
            // Message Thread between pimpinan and kantorpusat about performance review
            $performanceThread = MessageThread::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Review Kinerja Bulanan',
                'description' => 'Diskusi mengenai review kinerja bulanan tim pengawasan',
                'initiator_id' => $pimpinan->id,
                'participant_id' => $kantorPusat->id,
                'is_read_by_initiator' => true,
                'is_read_by_participant' => false,
                'last_message_at' => Carbon::now()->subHours(4),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subHours(4),
            ]);

            // Messages in performance review thread
            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $performanceThread->id,
                'sender_id' => $pimpinan->id,
                'message' => 'Selamat pagi, saya ingin mengetahui ringkasan kinerja tim pengawasan untuk bulan ini. Apakah ada masalah yang perlu dibahas?',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $performanceThread->id,
                'sender_id' => $kantorPusat->id,
                'message' => 'Selamat pagi Bapak/Ibu Pimpinan. Secara umum kinerja tim baik, namun ada beberapa kendala di lapangan yang perlu ditindaklanjuti.',
                'is_read' => false,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ]);

            Message::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'thread_id' => $performanceThread->id,
                'sender_id' => $pimpinan->id,
                'message' => 'Silakan berikan detail masalah tersebut dan rekomendasi penyelesaiannya. Saya akan mendukung langkah-langkah yang diperlukan.',
                'is_read' => true,
                'read_at' => Carbon::now()->subHours(4),
                'created_at' => Carbon::now()->subHours(4),
                'updated_at' => Carbon::now()->subHours(4),
            ]);
        }

        // The threads above have already been created with proper null checking.
        // No need to duplicate them here.

        $this->command->info('MessageSeeder completed successfully.');
    }
}
