<?php

namespace App\Repositories;

use App\Models\MasterCemaranMikroba;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class MasterCemaranMikrobaRepository
{
    public function getAllCemaranMikrobas(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterCemaranMikroba::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_cemaran_mikroba) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_cemaran_mikroba) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isCemaranMikrobanameExist(string $cemaranMikrobaname)
    {
        return MasterCemaranMikroba::where('nama_cemaran_mikroba', $cemaranMikrobaname)->exists();
    }

    public function getCemaranMikrobaById($cemaranMikrobaId): ?MasterCemaranMikroba
    {
        return MasterCemaranMikroba::find($cemaranMikrobaId);
    }

    public function createCemaranMikroba($data)
    {
        return MasterCemaranMikroba::create($data);
    }

    public function update($cemaranMikrobaId, $data)
    {
        $cemaranMikrobaProfile = MasterCemaranMikroba::where('id', $cemaranMikrobaId)->first();
        if ($cemaranMikrobaProfile) {
            $cemaranMikrobaProfile->update($data);
            return $cemaranMikrobaProfile;
        } else {
            throw new Exception("Cemaran Mikroba not found");
        }
    }

    public function deleteCemaranMikrobaById($cemaranMikrobaId): ?bool
    {
        try {
            $cemaranMikroba = MasterCemaranMikroba::findOrFail($cemaranMikrobaId);
            $cemaranMikroba->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
