<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    // Fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'address',
        'provinsi_id',
        'kota_id',
        'pekerjaan',
        'profile_picture',
        'created_by',
        'updated_by',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    // Define the one-to-one relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Relasi ke MasterKota
     */
    public function kota()
    {
        return $this->belongsTo(MasterKota::class, 'kota_id');
    }

    /**
     * Relasi ke MasterProvinsi
     */
    public function provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_id');
    }
}
