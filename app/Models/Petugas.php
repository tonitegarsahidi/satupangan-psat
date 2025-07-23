<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'petugas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'unit_kerja',
        'jabatan',
        'is_kantor_pusat',
        'penempatan',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penempatanProvinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'penempatan');
    }
}
