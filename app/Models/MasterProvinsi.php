<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterProvinsi extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'master_provinsis';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
