<?php

namespace App\Repositories;

use App\Models\MasterPenanganan;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class MasterPenangananRepository
{
    public function getAllMasterPenanganans(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterPenanganan::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_penanganan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isPenangananNameExist(String $penangananName){
        return MasterPenanganan::where('nama_penanganan', $penangananName)->exists();
    }

    public function getMasterPenangananById($penangananId): ?MasterPenanganan
    {
        return MasterPenanganan::find($penangananId);
    }

    public function createMasterPenanganan($data)
    {
        return MasterPenanganan::create($data);
    }

    public function update($penangananId, $data)
    {
        $penanganan = MasterPenanganan::where('id', $penangananId)->first();
        if ($penanganan) {
            $penanganan->update($data);
            return $penanganan;
        } else {
            throw new Exception("Master Penanganan not found");
        }
    }

    public function deleteMasterPenangananById($penangananId): ?bool
    {
        try {
            $penanganan = MasterPenanganan::findOrFail($penangananId);
            $penanganan->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
