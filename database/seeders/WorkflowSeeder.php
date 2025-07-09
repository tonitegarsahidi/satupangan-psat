<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Workflow;
use App\Models\WorkflowAction;
use App\Models\WorkflowThread;
use App\Models\WorkflowAttachment;
use App\Models\User;

class WorkflowSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user yang sudah ada, atau buat dummy jika belum ada
        $user1 = User::first();
        if (!$user1) {
            $user1 = User::create([
                'id' => (string) Str::uuid(),
                'name' => 'Dummy User 1',
                'email' => 'dummy1@example.com',
                'password' => bcrypt('password'),
            ]);
        }
        $user2 = User::skip(1)->first();
        if (!$user2) {
            $user2 = User::create([
                'id' => (string) Str::uuid(),
                'name' => 'Dummy User 2',
                'email' => 'dummy2@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // 1. Workflow
        $workflow = Workflow::create([
            'id' => (string) Str::uuid(),
            'user_id_initiator' => $user1->id,
            'type' => 'LAPORAN',
            'status' => 'DIBUAT',
            'title' => 'Laporan Kendala Aplikasi',
            'current_assignee_id' => $user2->id,
            'parent_id' => null,
            'category' => 'Teknis',
            'due_date' => Carbon::now()->addDays(7),
            'is_active' => true,
            'created_by' => 'system',
            'updated_by' => null,
        ]);

        // 2. WorkflowAction
        $action = WorkflowAction::create([
            'id' => (string) Str::uuid(),
            'workflow_id' => $workflow->id,
            'user_id' => $user2->id,
            'action_time' => Carbon::now(),
            'action_type' => 'REVIEW',
            'action_target' => null,
            'description' => 'Review laporan kendala',
            'previous_status' => 'DIBUAT',
            'new_status' => 'DALAM REVIEW',
            'notes' => 'Perlu verifikasi lebih lanjut',
            'is_active' => true,
            'created_by' => 'system',
            'updated_by' => null,
        ]);

        // 3. WorkflowThread
        $thread = WorkflowThread::create([
            'id' => (string) Str::uuid(),
            'workflow_id' => $workflow->id,
            'user_id' => $user1->id,
            'message' => 'Saya mengalami error saat login.',
            'link_url' => null,
            'is_internal' => false,
            'is_active' => true,
            'created_by' => 'system',
            'updated_by' => null,
        ]);

        // 4. WorkflowAttachment
        WorkflowAttachment::create([
            'id' => (string) Str::uuid(),
            'linked_type' => 'Thread',
            'linked_id' => $thread->id,
            'attachment_type' => 'image',
            'attachment_url' => 'https://example.com/error_screenshot.png',
            'file_name' => 'error_screenshot.png',
            'is_active' => true,
            'created_by' => 'system',
            'updated_by' => null,
        ]);
    }
}
