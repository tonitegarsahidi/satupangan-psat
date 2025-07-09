<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowAttachment extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'workflow_attachments';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'linked_type',
        'linked_id',
        'attachment_type',
        'attachment_url',
        'file_name',
        'is_active',
        'created_by',
        'updated_by',
    ];

    // Optionally, you can use morphTo if you want polymorphic relation
    // public function linked()
    // {
    //     return $this->morphTo();
    // }
}
