<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowThread extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'workflow_threads';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'workflow_id',
        'user_id',
        'message',
        'link_url',
        'is_internal',
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
        return $this->hasMany(WorkflowAttachment::class, 'linked_id')->where('linked_type', 'Thread');
    }
}
