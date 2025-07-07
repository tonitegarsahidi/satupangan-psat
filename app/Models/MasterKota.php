<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterKota extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'master_kotas';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'provinsi_id',
        'kode_kota',
        'nama_kota',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_id');
    }
}
