<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCemaranLogamBerat extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'master_cemaran_logam_berats';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kode_cemaran_logam_berat',
        'nama_cemaran_logam_berat',
        'keterangan',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
