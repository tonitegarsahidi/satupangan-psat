<?php

namespace App\Repositories;

use App\Models\MasterKota;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class MasterKotaRepository
{
    public function getAllKotas(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterKota::with('provinsi');

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_kota) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_kota) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isKotanameExist(string $kotaname)
    {
        return MasterKota::where('nama_kota', $kotaname)->exists();
    }

    public function getKotaById($kotaId): ?MasterKota
    {
        return MasterKota::with('provinsi')->find($kotaId);
    }

    public function createKota($data)
    {
        return MasterKota::create($data);
    }

    public function update($kotaId, $data)
    {
        $kotaProfile = MasterKota::where('id', $kotaId)->first();
        if ($kotaProfile) {
            $kotaProfile->update($data);
            return $kotaProfile;
        } else {
            throw new Exception("Kota not found");
        }
    }

    public function deleteKotaById($kotaId): ?bool
    {
        try {
            $kota = MasterKota::findOrFail($kotaId);
            $kota->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
