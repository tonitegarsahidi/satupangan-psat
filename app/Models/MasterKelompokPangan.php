<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKelompokPangan extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'master_kelompok_pangans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kode_kelompok_pangan',
        'nama_kelompok_pangan',
        'keterangan',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function jenisPangan()
    {
        return $this->hasMany(MasterJenisPanganSegar::class, 'kelompok_id', 'id');
    }
}
