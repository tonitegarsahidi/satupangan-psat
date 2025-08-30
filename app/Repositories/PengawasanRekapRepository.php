<?php

namespace App\Repositories;

use App\Models\PengawasanRekap;
use App\Models\PengawasanRekapPengawasan;
use App\Models\PengawasanTindakan;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanAttachment;
use App\Models\User;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterKota;
use App\Models\MasterProvinsi;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengawasanRekapRepository
{
    public function getAllRekap(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = PengawasanRekap::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        $queryResult->with([
            'pengawasan',
            'admin',
            'jenisPsat',
            'produkPsat',
            'provinsi',
            'picTindakan',
            'lokasiKota',
            'lokasiProvinsi',
            'tindakan',
            'tindakan.pimpinan',
            'tindakan.picTindakans',
            'tindakan.tindakanLanjutan',
            'tindakan.tindakanLanjutan.pic',
            'attachments'
        ]);

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(hasil_rekap) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereHas('pengawasan', function($q) use ($keyword) {
                    $q->whereRaw('lower(lokasi_alamat) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereHas('admin', function($q) use ($keyword) {
                    $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getRekapById($rekapId): ?PengawasanRekap
    {
        return PengawasanRekap::with([
            'pengawasan',
            'admin',
            'jenisPsat',
            'produkPsat',
            'provinsi',
            'picTindakan',
            'lokasiKota',
            'lokasiProvinsi',
            'tindakan',
            'tindakan.pimpinan',
            'tindakan.picTindakans',
            'tindakan.tindakanLanjutan',
            'tindakan.tindakanLanjutan.pic',
            'attachments',
            'pengawasans'
        ])->find($rekapId);
    }

    public function createRekap($data)
    {
        return PengawasanRekap::create($data);
    }

    public function updateRekap($rekapId, $data)
    {
        $rekap = PengawasanRekap::findOrFail($rekapId);
        $rekap->update($data);
        return $rekap;
    }

    public function delete($rekapId): ?bool
    {
        try {
            $rekap = PengawasanRekap::findOrFail($rekapId);
            $rekap->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete rekap with id $rekapId: {$e->getMessage()}");
            return false;
        }
    }

    public function getRekapByAdmin($adminId, int $perPage = 10)
    {
        return PengawasanRekap::where('user_id_admin', $adminId)
            ->with([
                'pengawasan',
                'jenisPsat',
                'produkPsat',
                'picTindakan',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getRekapByStatus($status, int $perPage = 10)
    {
        return PengawasanRekap::where('status', $status)
            ->with([
                'pengawasan',
                'admin',
                'jenisPsat',
                'produkPsat',
                'picTindakan',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getRekapByPIC($picId, int $perPage = 10)
    {
        return PengawasanRekap::where('pic_tindakan_id', $picId)
            ->with([
                'pengawasan',
                'admin',
                'jenisPsat',
                'produkPsat',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getRekapByJenisPsat($jenisPsatId, int $perPage = 10)
    {
        return PengawasanRekap::where('jenis_psat_id', $jenisPsatId)
            ->with([
                'pengawasan',
                'admin',
                'produkPsat',
                'picTindakan',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getRekapByProdukPsat($produkPsatId, int $perPage = 10)
    {
        return PengawasanRekap::where('produk_psat_id', $produkPsatId)
            ->with([
                'pengawasan',
                'admin',
                'jenisPsat',
                'picTindakan',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getRekapByLocation($kotaId, $provinsiId = null, int $perPage = 10)
    {
        $query = PengawasanRekap::where('provinsi_id', $provinsiId);

        if ($kotaId) {
            $query->where('lokasi_kota_id', $kotaId);
        }

        return $query->with([
                'pengawasan',
                'admin',
                'jenisPsat',
                'produkPsat',
                'picTindakan'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getRekapWithTindakan()
    {
        return PengawasanRekap::with('tindakan')->get();
    }

    public function linkPengawasanToRekap($pengawasanId, $rekapId)
    {
        return PengawasanRekapPengawasan::create([
            'pengawasan_rekap_id' => $rekapId,
            'pengawasan_id' => $pengawasanId
        ]);
    }

    public function unlinkPengawasanFromRekap($pengawasanId, $rekapId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_rekap_id', $rekapId)
            ->where('pengawasan_id', $pengawasanId)
            ->delete();
    }

    public function getRekapAttachments($rekapId)
    {
        return PengawasanAttachment::where('linked_id', $rekapId)
            ->where('linked_type', 'REKAP')
            ->get();
    }

    public function getRekapTindakan($rekapId)
    {
        return PengawasanTindakan::with([
            'pimpinan',
            'picTindakans',
            'tindakanLanjutan',
            'tindakanLanjutan.pic',
            'attachments'
        ])->where('pengawasan_rekap_id', $rekapId)
        ->first();
    }

    public function getRekapTindakanLanjutan($tindakanId)
    {
        return PengawasanTindakanLanjutan::with([
            'pic',
            'attachments'
        ])->where('pengawasan_tindakan_id', $tindakanId)
        ->first();
    }

    public function getStatusOptions()
    {
        return PengawasanRekap::getStatusOptions();
    }

    /**
     * Get rekap by provinsi
     *
     * @param string $provinsiId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getRekapByProvinsi($provinsiId, int $perPage = 10)
    {
        return PengawasanRekap::where('provinsi_id', $provinsiId)
            ->with([
                'pengawasan',
                'admin',
                'jenisPsat',
                'produkPsat',
                'picTindakan',
                'lokasiKota'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    /**
     * Get lampiran fields
     *
     * @return array
     */
    public function getLampiranFields()
    {
        return ['lampiran1', 'lampiran2', 'lampiran3', 'lampiran4', 'lampiran5', 'lampiran6'];
    }

    /**
     * Get rekap with lampirans
     *
     * @param string $rekapId
     * @return PengawasanRekap|null
     */
    public function getRekapWithLampirans($rekapId)
    {
        return PengawasanRekap::find($rekapId);
    }
}
