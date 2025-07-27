<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RegisterSppb extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'register_sppb';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'business_id',
        'status',
        'is_enabled',
        'nomor_registrasi',
        'tanggal_terbit',
        'tanggal_terakhir',
        'is_unitusaha',
        'nama_unitusaha',
        'alamat_unitusaha',
        'provinsi_unitusaha',
        'kota_unitusaha',
        'nib_unitusaha',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function provinsiUnitusaha()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_unitusaha');
    }

    public function kotaUnitusaha()
    {
        return $this->belongsTo(MasterKota::class, 'kota_unitusaha');
    }
}
