<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterBahanPanganSegar extends Model
{
    use SoftDeletes;

    protected $table = 'master_bahan_pangan_segars';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'jenis_id',
        'kode_bahan_pangan_segar',
        'nama_bahan_pangan_segar',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(MasterJenisPanganSegar::class, 'jenis_id', 'id');
    }
}
