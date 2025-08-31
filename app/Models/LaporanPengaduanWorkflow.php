<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LaporanPengaduanWorkflow extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'laporan_pengaduan_workflow';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'laporan_pengaduan_id',
        'status',
        'message',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user that owns the workflow entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the laporan pengaduan that owns the workflow entry.
     */
    public function laporanPengaduan()
    {
        return $this->belongsTo(LaporanPengaduan::class, 'laporan_pengaduan_id', 'id');
    }

    /**
     * Scope a query to filter by status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter by laporan pengaduan ID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $laporanPengaduanId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLaporanPengaduanId($query, $laporanPengaduanId)
    {
        return $query->where('laporan_pengaduan_id', $laporanPengaduanId);
    }

    /**
     * Scope a query to filter by user ID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
