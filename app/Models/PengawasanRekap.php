<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Config;

class PengawasanRekap extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pengawasan_rekap';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pengawasan_id',
        'user_id_admin',
        'jenis_psat_id',
        'produk_psat_id',
        'provinsi_id',
        'hasil_rekap',
        'lampiran1',
        'lampiran2',
        'lampiran3',
        'lampiran4',
        'lampiran5',
        'lampiran6',
        'status',
        'pic_tindakan_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function pengawasan()
    {
        return $this->belongsTo(Pengawasan::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id_admin');
    }

    public function jenisPsat()
    {
        return $this->belongsTo(MasterJenisPanganSegar::class, 'jenis_psat_id');
    }

    public function produkPsat()
    {
        return $this->belongsTo(MasterBahanPanganSegar::class, 'produk_psat_id');
    }

    public function picTindakan()
    {
        return $this->belongsTo(User::class, 'pic_tindakan_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_id');
    }

    public function lokasiKota()
    {
        return $this->belongsTo(MasterKota::class, 'lokasi_kota_id');
    }

    public function lokasiProvinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'lokasi_provinsi_id');
    }

    public function pengawasans()
    {
        return $this->belongsToMany(Pengawasan::class, 'pengawasan_rekap_pengawasan', 'pengawasan_rekap_id', 'pengawasan_id');
    }

    public function tindakan()
    {
        return $this->hasOne(PengawasanTindakan::class);
    }

    public function attachments()
    {
        return $this->hasMany(PengawasanAttachment::class, 'linked_id')
            ->where('linked_type', 'REKAP');
    }

    /**
     * Get valid status options
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return Config::get('pengawasan.pengawasan_rekap_statuses', []);
    }

    /**
     * Get status label
     *
     * @return string
     */
    public function getStatusLabel()
    {
        return $this->getStatusOptions()[$this->status] ?? $this->status;
    }
}
