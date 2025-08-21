<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengawasanTindakanPic extends Model
{
    protected $table = 'pengawasan_tindakan_pic';
    protected $primaryKey = ['tindakan_id', 'pic_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'tindakan_id',
        'pic_id',
    ];

    public function tindakan()
    {
        return $this->belongsTo(PengawasanTindakan::class, 'tindakan_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    // Override the getIncrementing method
    public function getIncrementing()
    {
        return false;
    }

    // Override the getKeyType method
    public function getKeyType()
    {
        return 'string';
    }

    // Override the getKeyName method
    public function getKeyName()
    {
        return 'tindakan_id';
    }
}
