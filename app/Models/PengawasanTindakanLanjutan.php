<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Config;

// Add the missing import
use App\Models\User;

class PengawasanTindakanLanjutan extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pengawasan_tindakan_lanjutan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pengawasan_tindakan_id',
        'user_id_pic',
        'arahan_tindak_lanjut',
        'status',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function tindakan()
    {
        return $this->belongsTo(PengawasanTindakan::class, 'pengawasan_tindakan_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'user_id_pic');
    }

    public function attachments()
    {
        return $this->hasMany(PengawasanAttachment::class, 'linked_id')
            ->where('linked_type', 'TINDAKAN_LANJUTAN');
    }

    public function details()
    {
        return $this->hasMany(PengawasanTindakanLanjutanDetail::class, 'pengawasan_tindakan_lanjutan_id');
    }

    public function latestDetail()
    {
        return $this->hasOne(PengawasanTindakanLanjutanDetail::class, 'pengawasan_tindakan_lanjutan_id')
            ->latestOfMany();
    }

    /**
     * Get valid status options
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return Config::get('pengawasan.pengawasan_tindakan_lanjutan_statuses', []);
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
