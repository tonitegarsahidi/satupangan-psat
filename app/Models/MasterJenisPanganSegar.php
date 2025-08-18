<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterJenisPanganSegar extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'master_jenis_pangan_segars';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kelompok_id',
        'kode_jenis_pangan_segar',
        'nama_jenis_pangan_segar',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(MasterKelompokPangan::class, 'kelompok_id', 'id');
    }

    public function bahanPangan(): HasMany
    {
        return $this->hasMany(MasterBahanPanganSegar::class, 'jenis_id', 'id');
    }
}
