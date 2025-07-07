<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCemaranMikroba extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'master_cemaran_mikrobas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kode_cemaran_mikroba',
        'nama_cemaran_mikroba',
        'keterangan',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
