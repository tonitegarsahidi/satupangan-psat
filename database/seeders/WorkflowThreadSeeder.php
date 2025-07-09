<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Workflow;
use App\Models\WorkflowThread;

class WorkflowThreadSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil workflow pertama (atau buat dummy jika belum ada)
        $workflow = Workflow::first();
        if (!$workflow) {
            $workflow = Workflow::create([
                'id' => (string) Str::uuid(),
                'user_id_initiator' => (string) Str::uuid(),
                'type' => config('workflow.types')[0],
                'status' => config('workflow.statuses')[0],
                'title' => 'Dummy Workflow',
                'current_assignee_id' => (string) Str::uuid(),
                'parent_id' => null,
                'category' => config('workflow.categories')[0],
                'due_date' => Carbon::now()->addDays(3),
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => null,
            ]);
        }

        // Dummy user
        $user = $workflow->user_id_initiator;

        // Tambah beberapa thread
        for ($i = 1; $i <= 3; $i++) {
            WorkflowThread::create([
                'id' => (string) Str::uuid(),
                'workflow_id' => $workflow->id,
                'user_id' => $user,
                'message' => "Ini pesan thread ke-$i",
                'link_url' => $i === 2 ? 'https://example.com/thread-link' : null,
                'is_internal' => $i === 3,
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => null,
            ]);
        }
    }
}
