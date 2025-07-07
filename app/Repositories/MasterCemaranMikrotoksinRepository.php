<?php

namespace App\Repositories;

use App\Models\MasterCemaranMikrotoksin;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class MasterCemaranMikrotoksinRepository
{
    public function getAllCemaranMikrotoksins(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterCemaranMikrotoksin::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_cemaran_mikrotoksin) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_cemaran_mikrotoksin) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isCemaranMikrotoksinnameExist(string $cemaranMikrotoksinname)
    {
        return MasterCemaranMikrotoksin::where('nama_cemaran_mikrotoksin', $cemaranMikrotoksinname)->exists();
    }

    public function getCemaranMikrotoksinById($cemaranMikrotoksinId): ?MasterCemaranMikrotoksin
    {
        return MasterCemaranMikrotoksin::find($cemaranMikrotoksinId);
    }

    public function createCemaranMikrotoksin($data)
    {
        return MasterCemaranMikrotoksin::create($data);
    }

    public function update($cemaranMikrotoksinId, $data)
    {
        $cemaranMikrotoksinProfile = MasterCemaranMikrotoksin::where('id', $cemaranMikrotoksinId)->first();
        if ($cemaranMikrotoksinProfile) {
            $cemaranMikrotoksinProfile->update($data);
            return $cemaranMikrotoksinProfile;
        } else {
            throw new Exception("Cemaran Mikrotoksin not found");
        }
    }

    public function deleteCemaranMikrotoksinById($cemaranMikrotoksinId): ?bool
    {
        try {
            $cemaranMikrotoksin = MasterCemaranMikrotoksin::findOrFail($cemaranMikrotoksinId);
            $cemaranMikrotoksin->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
