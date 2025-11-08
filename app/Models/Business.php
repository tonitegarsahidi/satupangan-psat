<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessJenispsatPivot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'business';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'nama_perusahaan',
        'alamat_perusahaan',
        'jabatan_perusahaan',
        'nib',
        'is_active',
        'is_umkm',
        'created_by',
        'updated_by',
        'provinsi_id',
        'kota_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenispsats()
    {
        return $this->belongsToMany(
            MasterJenisPanganSegar::class,
            'business_jenispsat',
            'business_id',
            'jenispsat_id'
        )->using(BusinessJenispsatPivot::class)->withPivot('id'); // Include the 'id' column from the pivot table
    }

    public function provinsi()
    {
        return $this->belongsTo(\App\Models\MasterProvinsi::class, 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(\App\Models\MasterKota::class, 'kota_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($business) {
            if (Auth::check()) {
                $business->created_by = Auth::id();
                $business->updated_by = Auth::id();
            }
        });

        static::updating(function ($business) {
            if (Auth::check()) {
                $business->updated_by = Auth::id();
            }
        });
    }
}
