<?php

namespace App\Repositories;

use App\Models\MasterBahanPanganSegar;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class MasterBahanPanganSegarRepository
{
    public function getAllBahanPanganSegars(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterBahanPanganSegar::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_bahan_pangan_segar) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_bahan_pangan_segar) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isBahanPanganSegarNameExist(String $bahanPanganSegarName){
        return MasterBahanPanganSegar::where('nama_bahan_pangan_segar', $bahanPanganSegarName)->exists();
    }

    public function getBahanPanganSegarById($bahanPanganSegarId): ?MasterBahanPanganSegar
    {
        return MasterBahanPanganSegar::find($bahanPanganSegarId);
    }

    public function createBahanPanganSegar($data)
    {
        return MasterBahanPanganSegar::create($data);
    }

    public function update($bahanPanganSegarId, $data)
    {
        // Find the BahanPanganSegar profile by bahanPanganSegar_id
        $bahanPanganSegarProfile = MasterBahanPanganSegar::where('id', $bahanPanganSegarId)->first();
        if ($bahanPanganSegarProfile) {
            // Update the profile with the provided data
            $bahanPanganSegarProfile->update($data);
            return $bahanPanganSegarProfile;
        } else {
            throw new Exception("Bahan Pangan Segar not found");
        }
    }


    public function deleteBahanPanganSegarById($bahanPanganSegarId): ?bool

    {
        try {
            $bahanPanganSegar = MasterBahanPanganSegar::findOrFail($bahanPanganSegarId); // Find the BahanPanganSegar by ID
            $bahanPanganSegar->delete(); // Delete the BahanPanganSegar
            return true; // Return true on successful deletion
        } catch (\Exception $e) {
            // Handle any exceptions, such as BahanPanganSegar not found
            throw $e; // Return false if deletion fails
        }
    }
}
