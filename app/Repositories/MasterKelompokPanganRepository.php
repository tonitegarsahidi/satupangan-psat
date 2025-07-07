<?php

namespace App\Repositories;

use App\Models\MasterKelompokPangan;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class MasterKelompokPanganRepository
{
    public function getAllKelompokPangans(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterKelompokPangan::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_kelompok_pangan) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_kelompok_pangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isKelompokPanganNameExist(String $kelompokPanganName){
        return MasterKelompokPangan::where('nama_kelompok_pangan', $kelompokPanganName)->exists();
    }

    public function getKelompokPanganById($kelompokPanganId): ?MasterKelompokPangan
    {
        return MasterKelompokPangan::find($kelompokPanganId);
    }

    public function createKelompokPangan($data)
    {
        return MasterKelompokPangan::create($data);
    }

    public function update($kelompokPanganId, $data)
    {
        // Find the KelompokPangan profile by kelompokPangan_id
        $kelompokPanganProfile = MasterKelompokPangan::where('id', $kelompokPanganId)->first();
        if ($kelompokPanganProfile) {
            // Update the profile with the provided data
            $kelompokPanganProfile->update($data);
            return $kelompokPanganProfile;
        } else {
            throw new Exception("Kelompok Pangan not found");
        }
    }


    public function deleteKelompokPanganById($kelompokPanganId): ?bool

    {
        try {
            $kelompokPangan = MasterKelompokPangan::findOrFail($kelompokPanganId); // Find the KelompokPangan by ID
            $kelompokPangan->delete(); // Delete the KelompokPangan
            return true; // Return true on successful deletion
        } catch (\Exception $e) {
            // Handle any exceptions, such as KelompokPangan not found
            throw $e; // Return false if deletion fails
        }
    }
}
