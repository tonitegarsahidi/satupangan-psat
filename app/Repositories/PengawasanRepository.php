<?php

namespace App\Repositories;

use App\Models\Pengawasan;
use App\Models\PengawasanRekap;
use App\Models\PengawasanAttachment;
use App\Models\PengawasanTindakan;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanTindakanPic;
use App\Models\User;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterKota;
use App\Models\MasterProvinsi;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengawasanRepository
{
    public function getAllPengawasan(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = Pengawasan::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        $queryResult->with([
            'initiator',
            'jenisPsat',
            'produkPsat',
            'lokasiKota',
            'lokasiProvinsi',
            'rekap',
            'attachments'
        ]);

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(lokasi_alamat) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereHas('initiator', function($q) use ($keyword) {
                    $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getPengawasanById($pengawasanId): ?Pengawasan
    {
        return Pengawasan::with([
            'initiator',
            'jenisPsat',
            'produkPsat',
            'lokasiKota',
            'lokasiProvinsi',
            'rekap',
            'rekapRecords',
            'attachments'
        ])->find($pengawasanId);
    }

    public function createPengawasan($data)
    {
        return Pengawasan::create($data);
    }

    public function update($pengawasanId, $data)
    {
        $pengawasan = Pengawasan::findOrFail($pengawasanId);
        $pengawasan->update($data);
        return $pengawasan;
    }

    public function delete($pengawasanId): ?bool
    {
        try {
            $pengawasan = Pengawasan::findOrFail($pengawasanId);
            $pengawasan->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete pengawasan with id $pengawasanId: {$e->getMessage()}");
            return false;
        }
    }

    public function getPengawasanByInitiator($initiatorId, int $perPage = 10)
    {
        return Pengawasan::where('user_id_initiator', $initiatorId)
            ->with([
                'jenisPsat',
                'produkPsat',
                'lokasiKota',
                'lokasiProvinsi',
                'rekap'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getPengawasanByStatus($status, int $perPage = 10)
    {
        return Pengawasan::where('status', $status)
            ->with([
                'initiator',
                'jenisPsat',
                'produkPsat',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getPengawasanByDateRange($startDate, $endDate, int $perPage = 10)
    {
        return Pengawasan::whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
            ->with([
                'initiator',
                'jenisPsat',
                'produkPsat',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getPengawasanWithRekap()
    {
        return Pengawasan::with('rekap')->get();
    }

    public function getPengawasanAttachments($pengawasanId)
    {
        return PengawasanAttachment::where('linked_id', $pengawasanId)
            ->where('linked_type', 'PENGAWASAN')
            ->get();
    }

    public function getPengawasanByJenisPsat($jenisPsatId, int $perPage = 10)
    {
        return Pengawasan::where('jenis_psat_id', $jenisPsatId)
            ->with([
                'initiator',
                'produkPsat',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getPengawasanByProdukPsat($produkPsatId, int $perPage = 10)
    {
        return Pengawasan::where('produk_psat_id', $produkPsatId)
            ->with([
                'initiator',
                'jenisPsat',
                'lokasiKota',
                'lokasiProvinsi'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getPengawasanByLocation($kotaId, $provinsiId = null, int $perPage = 10)
    {
        $query = Pengawasan::where('lokasi_kota_id', $kotaId);

        if ($provinsiId) {
            $query->where('lokasi_provinsi_id', $provinsiId);
        }

        return $query->with([
                'initiator',
                'jenisPsat',
                'produkPsat'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }
}
