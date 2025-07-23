<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Workflow;
use App\Models\WorkflowAction;

class WorkflowActionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil workflow pertama (atau buat dummy jika belum ada)
        $workflow = Workflow::first();
        if (!$workflow) {
            $workflow = Workflow::create([
                'id' => (string) Str::uuid(),
                'user_id_initiator' => (string) Str::uuid(),
                'type' => array_values(config('workflow.types'))[0],
                'status' => array_values(config('workflow.statuses'))[0],
                'title' => 'Dummy Workflow',
                'current_assignee_id' => (string) Str::uuid(),
                'parent_id' => null,
                'category' => array_values(config('workflow.categories'))[0],
                'due_date' => Carbon::now()->addDays(3),
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => null,
            ]);
        }

        // Dummy user
        $user = $workflow->current_assignee_id;

        // Tambah beberapa action
        foreach (config('workflow.action_types') as $i => $actionType) {
            WorkflowAction::create([
                'id' => (string) Str::uuid(),
                'workflow_id' => $workflow->id,
                'user_id' => $user,
                'action_time' => Carbon::now()->addMinutes(10),
                'action_type' => $actionType,
                'action_target' => null,
                'description' => "Contoh action $actionType",
                'previous_status' => array_values(config('workflow.statuses'))[0],
                'new_status' => array_values(config('workflow.statuses'))[min($i, count(config('workflow.statuses'))-1)],
                'notes' => "Catatan untuk $actionType",
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => null,
            ]);
        }
    }
}
