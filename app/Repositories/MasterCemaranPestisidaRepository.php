<?php

namespace App\Repositories;

use App\Models\MasterCemaranPestisida;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class MasterCemaranPestisidaRepository
{
    public function getAllCemaranPestisidas(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterCemaranPestisida::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_cemaran_pestisida) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_cemaran_pestisida) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isCemaranPestisidaNameExist(String $cemaranPestisidaName){
        return MasterCemaranPestisida::where('nama_cemaran_pestisida', $cemaranPestisidaName)->exists();
    }

    public function getCemaranPestisidaById($cemaranPestisidaId): ?MasterCemaranPestisida
    {
        return MasterCemaranPestisida::find($cemaranPestisidaId);
    }

    public function createCemaranPestisida($data)
    {
        return MasterCemaranPestisida::create($data);
    }

    public function update($cemaranPestisidaId, $data)
    {
        $cemaranPestisida = MasterCemaranPestisida::where('id', $cemaranPestisidaId)->first();
        if ($cemaranPestisida) {
            $cemaranPestisida->update($data);
            return $cemaranPestisida;
        } else {
            throw new Exception("Cemaran Pestisida not found");
        }
    }

    public function deleteCemaranPestisidaById($cemaranPestisidaId): ?bool
    {
        try {
            $cemaranPestisida = MasterCemaranPestisida::findOrFail($cemaranPestisidaId);
            $cemaranPestisida->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
