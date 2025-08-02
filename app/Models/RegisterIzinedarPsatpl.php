<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegisterIzinedarPsatpl extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'register_izinedar_psatpl';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'business_id',
        'status',
        'is_enabled',
        'nomor_sppb',
        'nomor_izinedar_pl',
        'is_unitusaha',
        'nama_unitusaha',
        'alamat_unitusaha',
        'alamat_unitpenanganan',
        'provinsi_unitusaha',
        'kota_unitusaha',
        'nib_unitusaha',
        'jenis_psat',
        'nama_komoditas',
        'nama_latin',
        'negara_asal',
        'merk_dagang',
        'jenis_kemasan',
        'ukuran_berat',
        'klaim',
        'foto_1',
        'foto_2',
        'foto_3',
        'foto_4',
        'foto_5',
        'foto_6',
        'file_nib',
        'file_sppb',
        'file_izinedar_psatpl',
        'okkp_penangungjawab',
        'tanggal_terbit',
        'tanggal_terakhir',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the business that owns the registration.
     */
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
