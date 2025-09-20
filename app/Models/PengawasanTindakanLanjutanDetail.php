<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PengawasanTindakanLanjutanDetail extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'pengawasan_tindakan_lanjutan_detail';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pengawasan_tindakan_lanjutan_id',
        'user_id',
        'message',
        'lampiran1',
        'lampiran2',
        'lampiran3',
        'lampiran4',
        'lampiran5',
        'lampiran6',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function tindakanLanjutan()
    {
        return $this->belongsTo(PengawasanTindakanLanjutan::class, 'pengawasan_tindakan_lanjutan_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tindakan()
    {
        return $this->hasOneThrough(
            PengawasanTindakan::class,
            PengawasanTindakanLanjutan::class,
            'id', // Foreign key on pengawasan_tindakan_lanjutan table
            'id', // Foreign key on pengawasan_tindakan table
            'pengawasan_tindakan_lanjutan_id', // Local key on pengawasan_tindakan_lanjutan_detail table
            'pengawasan_tindakan_id' // Local key on pengawasan_tindakan_lanjutan table
        );
    }

    public function rekap()
    {
        return $this->hasOneThrough(
            PengawasanRekap::class,
            PengawasanTindakanLanjutan::class,
            'id', // Foreign key on pengawasan_tindakan_lanjutan table
            'id', // Foreign key on pengawasan_rekap table
            'pengawasan_tindakan_lanjutan_id', // Local key on pengawasan_tindakan_lanjutan_detail table
            'pengawasan_tindakan_id' // Local key on pengawasan_tindakan_lanjutan table
        );
    }

    public function pengawasan()
    {
        return $this->hasOneThrough(
            \App\Models\Pengawasan::class,
            PengawasanTindakanLanjutan::class,
            'id', // Foreign key on pengawasan_tindakan_lanjutan table
            'id', // Foreign key on pengawasan table
            'pengawasan_tindakan_lanjutan_id', // Local key on pengawasan_tindakan_lanjutan_detail table
            'pengawasan_tindakan_id' // Local key on pengawasan_tindakan_lanjutan table
        );
    }

    public function pic()
    {
        return $this->hasOneThrough(
            User::class,
            PengawasanTindakanLanjutan::class,
            'id', // Foreign key on pengawasan_tindakan_lanjutan table
            'id', // Foreign key on users table
            'pengawasan_tindakan_lanjutan_id', // Local key on pengawasan_tindakan_lanjutan_detail table
            'user_id_pic' // Local key on pengawasan_tindakan_lanjutan table
        );
    }

    /**
     * Get all attachment paths
     *
     * @return array
     */
    public function getAttachments()
    {
        $attachments = [];
        for ($i = 1; $i <= 6; $i++) {
            $lampiranKey = "lampiran{$i}";
            if (!empty($this->$lampiranKey)) {
                $attachments[] = [
                    'name' => "Lampiran {$i}",
                    'path' => $this->$lampiranKey,
                    'url' => asset($this->$lampiranKey)
                ];
            }
        }
        return $attachments;
    }
}
