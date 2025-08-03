<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QrBadanPangan extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'qr_badan_pangan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'qr_code',
        'current_assignee',
        'requested_by',
        'requested_at',
        'reviewed_by',
        'reviewed_at',
        'approved_by',
        'approved_at',
        'status',
        'is_published',
        'business_id',
        'nama_komoditas',
        'nama_latin',
        'merk_dagang',
        'jenis_psat',
        'referensi_sppb',
        'referensi_izinedar_psatpl',
        'referensi_izinedar_psatpd',
        'referensi_izinedar_psatpduk',
        'referensi_izinrumah_pengemasan',
        'referensi_sertifikat_keamanan_pangan',
        'file_lampiran1',
        'file_lampiran2',
        'file_lampiran3',
        'file_lampiran4',
        'file_lampiran5',
        'created_by',
        'updated_by',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function jenisPsat()
    {
        return $this->belongsTo(MasterJenisPanganSegar::class, 'jenis_psat');
    }

    public function currentAssignee()
    {
        return $this->belongsTo(User::class, 'current_assignee');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function referensiSppb()
    {
        return $this->belongsTo(RegisterSppb::class, 'referensi_sppb');
    }

    public function referensiIzinedarPsatpl()
    {
        return $this->belongsTo(RegisterIzinedarPsatpl::class, 'referensi_izinedar_psatpl');
    }

    public function referensiIzinedarPsatpd()
    {
        return $this->belongsTo(RegisterIzinedarPsatpd::class, 'referensi_izinedar_psatpd');
    }

    public function referensiIzinedarPsatpduk()
    {
        return $this->belongsTo(RegisterIzinedarPsatpduk::class, 'referensi_izinedar_psatpduk');
    }

    public function referensiIzinrumahPengemasan()
    {
        return $this->belongsTo(RegisterIzinrumahPengemasan::class, 'referensi_izinrumah_pengemasan');
    }

    public function referensiSertifikatKeamananPangan()
    {
        return $this->belongsTo(RegisterSertifikatKeamananPangan::class, 'referensi_sertifikat_keamanan_pangan');
    }
}
