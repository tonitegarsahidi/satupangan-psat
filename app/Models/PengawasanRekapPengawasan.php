<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengawasanRekapPengawasan extends Model
{
    use SoftDeletes;

    protected $table = 'pengawasan_rekap_pengawasan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pengawasan_rekap_id',
        'pengawasan_id',
    ];

    public function pengawasanRekap()
    {
        return $this->belongsTo(PengawasanRekap::class, 'pengawasan_rekap_id');
    }

    public function pengawasan()
    {
        return $this->belongsTo(Pengawasan::class, 'pengawasan_id');
    }
}
