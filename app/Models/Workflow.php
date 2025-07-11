<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'workflows';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id_initiator',
        'type',
        'status',
        'title',
        'current_assignee_id',
        'parent_id',
        'category',
        'due_date',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function initiator()
    {
        return $this->belongsTo(User::class, 'user_id_initiator');
    }

    public function currentAssignee()
    {
        return $this->belongsTo(User::class, 'current_assignee_id');
    }

    public function parent()
    {
        return $this->belongsTo(Workflow::class, 'parent_id');
    }

    public function actions()
    {
        return $this->hasMany(WorkflowAction::class, 'workflow_id');
    }

    public function threads()
    {
        return $this->hasMany(WorkflowThread::class, 'workflow_id');
    }

    public function attachments()
    {
        return $this->hasMany(WorkflowAttachment::class, 'linked_id')->where('linked_type', 'Workflow');
    }
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
