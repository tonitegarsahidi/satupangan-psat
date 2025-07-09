<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Workflow;
use App\Models\WorkflowAction;
use App\Models\WorkflowThread;
use App\Models\WorkflowAttachment;

class WorkflowAttachmentSeeder extends Seeder
{
    public function run(): void
    {
        $workflow = Workflow::first();
        $action = WorkflowAction::first();
        $thread = WorkflowThread::first();

        // Attachment untuk Workflow
        WorkflowAttachment::create([
            'id' => (string) Str::uuid(),
            'linked_type' => 'Workflow',
            'linked_id' => $workflow ? $workflow->id : (string) Str::uuid(),
            'attachment_type' => 'document',
            'attachment_url' => 'https://dummy.com/workflow.pdf',
            'file_name' => 'workflow.pdf',
            'is_active' => true,
            'created_by' => 'seeder',
            'updated_by' => null,
        ]);

        // Attachment untuk Action
        WorkflowAttachment::create([
            'id' => (string) Str::uuid(),
            'linked_type' => 'Action',
            'linked_id' => $action ? $action->id : (string) Str::uuid(),
            'attachment_type' => 'image',
            'attachment_url' => 'https://dummy.com/action.png',
            'file_name' => 'action.png',
            'is_active' => true,
            'created_by' => 'seeder',
            'updated_by' => null,
        ]);

        // Attachment untuk Thread
        WorkflowAttachment::create([
            'id' => (string) Str::uuid(),
            'linked_type' => 'Thread',
            'linked_id' => $thread ? $thread->id : (string) Str::uuid(),
            'attachment_type' => 'link',
            'attachment_url' => 'https://dummy.com/thread-link',
            'file_name' => 'thread-link.txt',
            'is_active' => true,
            'created_by' => 'seeder',
            'updated_by' => null,
        ]);
    }
}
