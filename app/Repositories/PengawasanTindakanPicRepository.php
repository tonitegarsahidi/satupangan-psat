<?php

namespace App\Repositories;

use App\Models\PengawasanTindakanPic;
use App\Models\PengawasanTindakan;
use App\Models\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengawasanTindakanPicRepository
{
    public function getAllTindakanPic(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = PengawasanTindakanPic::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        $queryResult->with([
            'tindakan',
            'tindakan.rekap',
            'tindakan.rekap.pengawasan',
            'tindakan.pimpinan',
            'pic'
        ]);

        if (!is_null($keyword)) {
            $queryResult->whereHas('pic', function($q) use ($keyword) {
                $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
            })
            ->orWhereHas('tindakan', function($q) use ($keyword) {
                $q->whereRaw('lower(tindak_lanjut) LIKE ?', ['%' . strtolower($keyword) . '%']);
            });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getTindakanPicById($tindakanId, $picId)
    {
        return PengawasanTindakanPic::where('tindakan_id', $tindakanId)
            ->where('pic_id', $picId)
            ->with([
                'tindakan',
                'tindakan.rekap',
                'tindakan.rekap.pengawasan',
                'tindakan.pimpinan',
                'pic'
            ])
            ->first();
    }

    public function createTindakanPic($data)
    {
        return PengawasanTindakanPic::create($data);
    }

    public function delete($tindakanId, $picId): ?bool
    {
        try {
            $result = PengawasanTindakanPic::where('tindakan_id', $tindakanId)
                ->where('pic_id', $picId)
                ->delete();
            return $result > 0;
        } catch (\Exception $e) {
            Log::error("Failed to delete tindakan pic with tindakan_id $tindakanId and pic_id $picId: {$e->getMessage()}");
            return false;
        }
    }

    public function getPICsByTindakanId($tindakanId)
    {
        return PengawasanTindakanPic::where('tindakan_id', $tindakanId)
            ->with([
                'pic'
            ])
            ->get();
    }

    public function getTindakansByPICId($picId, int $perPage = 10)
    {
        return PengawasanTindakanPic::where('pic_id', $picId)
            ->with([
                'tindakan',
                'tindakan.rekap',
                'tindakan.rekap.pengawasan',
                'tindakan.pimpinan'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function isPICAssignedToTindakan($tindakanId, $picId)
    {
        return PengawasanTindakanPic::where('tindakan_id', $tindakanId)
            ->where('pic_id', $picId)
            ->exists();
    }

    public function deleteByTindakanId($tindakanId)
    {
        try {
            return PengawasanTindakanPic::where('tindakan_id', $tindakanId)
                ->delete();
        } catch (\Exception $e) {
            Log::error("Failed to delete tindakan pics by tindakan_id $tindakanId: {$e->getMessage()}");
            return false;
        }
    }

    public function deleteByPICId($picId)
    {
        try {
            return PengawasanTindakanPic::where('pic_id', $picId)
                ->delete();
        } catch (\Exception $e) {
            Log::error("Failed to delete tindakan pics by pic_id $picId: {$e->getMessage()}");
            return false;
        }
    }

    public function getTindakanCountByPICId($picId)
    {
        return PengawasanTindakanPic::where('pic_id', $picId)
            ->count();
    }

    public function getPICCountByTindakanId($tindakanId)
    {
        return PengawasanTindakanPic::where('tindakan_id', $tindakanId)
            ->count();
    }

    public function getPICIdsByTindakanId($tindakanId)
    {
        return PengawasanTindakanPic::where('tindakan_id', $tindakanId)
            ->pluck('pic_id');
    }

    public function getTindakanIdsByPICId($picId)
    {
        return PengawasanTindakanPic::where('pic_id', $picId)
            ->pluck('tindakan_id');
    }

    public function getAvailablePICs(int $perPage = 10)
    {
        // Get all users that are not currently assigned to any tindakan
        $assignedPICIds = PengawasanTindakanPic::pluck('pic_id')->unique();

        $query = User::whereNotIn('id', $assignedPICIds)
            ->where('is_active', 1);

        return $query->orderBy('name', 'asc')
            ->paginate($perPage);
    }
}
