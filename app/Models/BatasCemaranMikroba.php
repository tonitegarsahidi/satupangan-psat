<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatasCemaranMikroba extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'batas_cemaran_mikrobas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'jenis_psat',
        'cemaran_mikroba',
        'value_min',
        'value_max',
        'satuan',
        'metode',
        'keterangan',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function jenisPangan(): BelongsTo
    {
        return $this->belongsTo(MasterJenisPanganSegar::class, 'jenis_psat', 'id');
    }

    public function cemaranMikroba(): BelongsTo
    {
        return $this->belongsTo(MasterCemaranMikroba::class, 'cemaran_mikroba', 'id');
    }
}
