<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LaporanPengaduan extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'laporan_pengaduan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'nama_pelapor',
        'nik_pelapor',
        'nomor_telepon_pelapor',
        'email_pelapor',
        'lokasi_kejadian',
        'provinsi_id',
        'kota_id',
        'isi_laporan',
        'tindak_lanjut_pertama',
        'workflow_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_id', 'id');
    }

    public function kota()
    {
        return $this->belongsTo(MasterKota::class, 'kota_id', 'id');
    }

    public function workflow()
    {
        // Setiap laporan pengaduan pasti memiliki satu workflow (wajib), tapi tidak sebaliknya
        return $this->belongsTo(Workflow::class, 'workflow_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
