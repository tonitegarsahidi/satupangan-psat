<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Config;

class Pengawasan extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pengawasan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id_initiator',
        'lokasi_alamat',
        'lokasi_kota_id',
        'lokasi_provinsi_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_psat_id',
        'produk_psat_id',
        'hasil_pengawasan',
        'status',
        'tindakan_rekomendasikan',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function initiator()
    {
        return $this->belongsTo(User::class, 'user_id_initiator');
    }

    public function jenisPsat()
    {
        return $this->belongsTo(MasterJenisPanganSegar::class, 'jenis_psat_id');
    }

    public function produkPsat()
    {
        return $this->belongsTo(MasterBahanPanganSegar::class, 'produk_psat_id');
    }

    public function lokasiKota()
    {
        return $this->belongsTo(MasterKota::class, 'lokasi_kota_id');
    }

    public function lokasiProvinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'lokasi_provinsi_id');
    }

    public function rekapRecords()
    {
        return $this->belongsToMany(PengawasanRekap::class, 'pengawasan_rekap_pengawasan', 'pengawasan_id', 'pengawasan_rekap_id');
    }

    public function attachments()
    {
        return $this->hasMany(PengawasanAttachment::class, 'linked_id')
            ->where('linked_type', 'PENGAWASAN');
    }

    /**
     * Get valid status options
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return Config::get('pengawasan.pengawasan_statuses', []);
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
