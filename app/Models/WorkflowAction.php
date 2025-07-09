<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowAction extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'workflow_actions';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'workflow_id',
        'user_id',
        'action_time',
        'action_type',
        'action_target',
        'description',
        'previous_status',
        'new_status',
        'notes',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class, 'workflow_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attachments()
    {
        return $this->hasMany(WorkflowAttachment::class, 'linked_id')->where('linked_type', 'Action');
    }
}
