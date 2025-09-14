<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Config;

class PengawasanTindakan extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pengawasan_tindakan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pengawasan_rekap_id',
        'user_id_pimpinan',
        'tindak_lanjut',
        'status',
        'pic_tindakan_ids',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'pic_tindakan_ids' => 'array',
    ];

    public function rekap()
    {
        return $this->belongsTo(PengawasanRekap::class, 'pengawasan_rekap_id');
    }

    public function pimpinan()
    {
        return $this->belongsTo(User::class, 'user_id_pimpinan');
    }

    public function picTindakans()
    {
        return $this->hasMany(PengawasanTindakanPic::class, 'tindakan_id');
    }

    public function tindakanLanjutan()
    {
        return $this->hasOne(PengawasanTindakanLanjutan::class);
    }

    public function attachments()
    {
        return $this->hasMany(PengawasanAttachment::class, 'linked_id')
            ->where('linked_type', 'TINDAKAN');
    }

    /**
     * Get valid status options
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return Config::get('pengawasan.pengawasan_tindakan_statuses', []);
    }

    /**
     * Get status label
     *
     * @return string
     */
    public function statusLabel()
    {
        return $this->getStatusOptions()[$this->status] ?? $this->status;
    }
}
