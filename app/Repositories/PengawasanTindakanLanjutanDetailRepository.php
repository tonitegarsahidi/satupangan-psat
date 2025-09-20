<?php

namespace App\Repositories;

use App\Models\PengawasanTindakanLanjutanDetail;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengawasanTindakanLanjutanDetailRepository
{
    public function getAllDetailByLanjutanId(string $lanjutanId, int $perPage = 10): LengthAwarePaginator
    {
        return PengawasanTindakanLanjutanDetail::where('pengawasan_tindakan_lanjutan_id', $lanjutanId)
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getAllDetails(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = PengawasanTindakanLanjutanDetail::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        $queryResult->with([
            'tindakanLanjutan',
            'tindakanLanjutan.tindakan',
            'tindakanLanjutan.tindakan.rekap',
            'tindakanLanjutan.tindakan.rekap.pengawasan',
            'tindakanLanjutan.pic',
            'creator',
            'updater',
            'user'
        ]);

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(message) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereHas('tindakanLanjutan', function($q) use ($keyword) {
                    $q->whereRaw('lower(tindak_lanjut) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereHas('tindakanLanjutan.pic', function($q) use ($keyword) {
                    $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getDetailById($detailId): ?PengawasanTindakanLanjutanDetail
    {
        return PengawasanTindakanLanjutanDetail::with([
            'tindakanLanjutan',
            'tindakanLanjutan.tindakan',
            'tindakanLanjutan.tindakan.rekap',
            'tindakanLanjutan.tindakan.rekap.pengawasan',
            'tindakanLanjutan.pic',
            'creator',
            'updater',
            'user'
        ])->find($detailId);
    }

    public function createDetail($data)
    {
        return PengawasanTindakanLanjutanDetail::create($data);
    }

    public function updateDetail($detailId, $data)
    {
        $detail = PengawasanTindakanLanjutanDetail::findOrFail($detailId);
        $detail->update($data);
        return $detail;
    }

    public function delete($detailId): ?bool
    {
        try {
            $detail = PengawasanTindakanLanjutanDetail::findOrFail($detailId);
            $detail->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete tindakan lanjutan detail with id $detailId: {$e->getMessage()}");
            return false;
        }
    }

    public function deleteByLanjutanId($lanjutanId): ?bool
    {
        try {
            return PengawasanTindakanLanjutanDetail::where('pengawasan_tindakan_lanjutan_id', $lanjutanId)
                ->delete();
        } catch (\Exception $e) {
            Log::error("Failed to delete tindakan lanjutan details by lanjutan_id $lanjutanId: {$e->getMessage()}");
            return false;
        }
    }

    public function getDetailsByLanjutanId($lanjutanId)
    {
        return PengawasanTindakanLanjutanDetail::with([
            'creator',
            'updater',
            'user'
        ])->where('pengawasan_tindakan_lanjutan_id', $lanjutanId)
        ->orderBy("created_at", "desc")
        ->get();
    }

    public function getDetailsByCreator($creatorId, int $perPage = 10)
    {
        return PengawasanTindakanLanjutanDetail::where('created_by', $creatorId)
            ->with([
                'tindakanLanjutan',
                'tindakanLanjutan.tindakan',
                'tindakanLanjutan.tindakan.rekap',
                'tindakanLanjutan.tindakan.rekap.pengawasan',
                'tindakanLanjutan.pic',
                'user'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getDetailsByUpdater($updaterId, int $perPage = 10)
    {
        return PengawasanTindakanLanjutanDetail::where('updated_by', $updaterId)
            ->with([
                'tindakanLanjutan',
                'tindakanLanjutan.tindakan',
                'tindakanLanjutan.tindakan.rekap',
                'tindakanLanjutan.tindakan.rekap.pengawasan',
                'tindakanLanjutan.pic',
                'user'
            ])
            ->orderBy("updated_at", "desc")
            ->paginate($perPage);
    }

    public function getDetailsByPIC($picId, int $perPage = 10)
    {
        return PengawasanTindakanLanjutanDetail::whereHas('tindakanLanjutan', function($query) use ($picId) {
                $query->where('user_id_pic', $picId);
            })
            ->with([
                'tindakanLanjutan',
                'tindakanLanjutan.tindakan',
                'tindakanLanjutan.tindakan.rekap',
                'tindakanLanjutan.tindakan.rekap.pengawasan',
                'creator',
                'updater',
                'user'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getLatestDetailByLanjutanId($lanjutanId): ?PengawasanTindakanLanjutanDetail
    {
        return PengawasanTindakanLanjutanDetail::with(['user'])
            ->where('pengawasan_tindakan_lanjutan_id', $lanjutanId)
            ->orderBy("created_at", "desc")
            ->first();
    }

    public function getDetailCountByLanjutanId($lanjutanId): int
    {
        return PengawasanTindakanLanjutanDetail::where('pengawasan_tindakan_lanjutan_id', $lanjutanId)
            ->count();
    }

    public function getDetailsByUserId($userId, int $perPage = 10)
    {
        return PengawasanTindakanLanjutanDetail::where('user_id', $userId)
            ->with([
                'tindakanLanjutan',
                'tindakanLanjutan.tindakan',
                'tindakanLanjutan.tindakan.rekap',
                'tindakanLanjutan.tindakan.rekap.pengawasan',
                'tindakanLanjutan.pic',
                'creator',
                'updater'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }
}
