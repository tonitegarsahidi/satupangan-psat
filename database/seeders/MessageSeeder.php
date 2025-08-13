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
        // Get the users we need to create messages for
        $users = User::whereIn('email', [
            'kantorpusat@panganaman.my.id',
            'pengusaha@panganaman.my.id',
            'kantorjatim@panganaman.my.id',
            'pengusaha2@panganaman.my.id'
        ])->get();

        if ($users->count() !== 4) {
            $this->command->error('Required users not found. Please run UserSeeder first.');
            return;
        }

        $kantorPusat = $users->where('email', 'kantorpusat@panganaman.my.id')->first();
        $pengusaha = $users->where('email', 'pengusaha@panganaman.my.id')->first();
        $kantorJatim = $users->where('email', 'kantorjatim@panganaman.my.id')->first();
        $pengusaha2 = $users->where('email', 'pengusaha2@panganaman.my.id')->first();

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

        $this->command->info('MessageSeeder completed successfully.');
    }
}
