<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Config;

class PengawasanAttachment extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pengawasan_attachment';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'linked_id',
        'linked_type',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'is_active',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get valid linked type options
     *
     * @return array
     */
    public static function getLinkedTypeOptions()
    {
        return Config::get('pengawasan.attachment_types', []);
    }

    /**
     * Get linked type label
     *
     * @return string
     */
    public function getLinkedTypeLabel()
    {
        return $this->getLinkedTypeOptions()[$this->linked_type] ?? $this->linked_type;
    }
}
