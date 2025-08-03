<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegisterIzinrumahPengemasan extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'register_izinrumah_pengemasan';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'business_id',
        'status',
        'is_enabled',
        'nomor_sppb',
        'nomor_izinrumah_pl',
        'is_unitusaha',
        'nama_unitusaha',
        'alamat_unitusaha',
        'alamat_unitpenanganan',
        'provinsi_unitusaha',
        'kota_unitusaha',
        'nib_unitusaha',
        'jenis_psat',
        'nama_komoditas',
        'nama_latin',
        'negara_asal',
        'merk_dagang',
        'jenis_kemasan',
        'ukuran_berat',
        'klaim',
        'foto_1',
        'foto_2',
        'foto_3',
        'foto_4',
        'foto_5',
        'foto_6',
        'file_nib',
        'file_sppb',
        'file_izinrumah_pengemasan',
        'okkp_penangungjawab',
        'tanggal_terbit',
        'tanggal_terakhir',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'is_unitusaha' => 'boolean',
        'tanggal_terbit' => 'date',
        'tanggal_terakhir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the business that owns the RegisterIzinrumahPengemasan.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    /**
     * Get the provinsi that owns the RegisterIzinrumahPengemasan.
     */
    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_unitusaha');
    }

    /**
     * Get the kota that owns the RegisterIzinrumahPengemasan.
     */
    public function kota(): BelongsTo
    {
        return $this->belongsTo(MasterKota::class, 'kota_unitusaha');
    }

    /**
     * Get the jenisPsat that owns the RegisterIzinrumahPengemasan.
     */
    public function jenisPsat(): BelongsTo
    {
        return $this->belongsTo(MasterJenisPanganSegar::class, 'jenis_psat');
    }

    /**
     * Get the okkpPenanggungJawab that owns the RegisterIzinrumahPengemasan.
     */
    public function okkpPenanggungJawab(): BelongsTo
    {
        return $this->belongsTo(User::class, 'okkp_penangungjawab');
    }

    /**
     * Get the createdBy that owns the RegisterIzinrumahPengemasan.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the updatedBy that owns the RegisterIzinrumahPengemasan.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
