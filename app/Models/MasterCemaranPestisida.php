<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasUuid;

class MasterCemaranPestisida extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'master_cemaran_pestisidas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_cemaran_pestisida',
        'nama_cemaran_pestisida',
        'keterangan',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
