<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'business';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'nama_perusahaan',
        'alamat_perusahaan',
        'jabatan_perusahaan',
        'nib',
        'is_active',
        'is_umkm',
        'created_by',
        'updated_by',
        'provinsi_id',
        'kota_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenispsats()
    {
        return $this->belongsToMany(
            MasterJenisPanganSegar::class,
            'business_jenispsat',
            'business_id',
            'jenispsat_id'
        );
    }
}
