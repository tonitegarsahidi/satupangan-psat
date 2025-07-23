<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessJenispsat extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'business_jenispsat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'business_id',
        'jenispsat_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function jenispsat()
    {
        return $this->belongsTo(MasterJenisPanganSegar::class, 'jenispsat_id');
    }
}
