<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProvinsi extends Model
{
    use SoftDeletes;

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
