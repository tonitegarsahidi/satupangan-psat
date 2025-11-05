<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PengawasanItem extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pengawasan_items';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pengawasan_id',
        'jenis_pengawasan',
        'jenis_cemaran',
        'metode_pengujian',
        'jumlah_sampel',
        'is_positif',
        'keterangan',
    ];

    public function pengawasan()
    {
        return $this->belongsTo(Pengawasan::class, 'pengawasan_id');
    }

    public function komoditas()
    {
        return $this->belongsTo(MasterBahanPanganSegar::class, 'komoditas_id');
    }

    /**
     * Get valid type options
     *
     * @return array
     */
    public static function getTypeOptions()
    {
        return ['RAPID' => 'Rapid Test', 'LAB' => 'Laboratory'];
    }

    /**
     * Get type label
     *
     * @return string
     */
    public function getTypeLabel()
    {
        return $this->getTypeOptions()[$this->jenis_pengawasan] ?? $this->jenis_pengawasan;
    }
}
