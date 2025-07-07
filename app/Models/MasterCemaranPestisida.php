<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCemaranPestisida extends Model
{
    use HasUuids, SoftDeletes;

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
