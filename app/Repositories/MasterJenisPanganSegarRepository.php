<?php

namespace App\Repositories;

use App\Models\MasterJenisPanganSegar;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class MasterJenisPanganSegarRepository
{
    public function getAllJenisPanganSegars(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterJenisPanganSegar::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_jenis_pangan_segar) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_jenis_pangan_segar) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isJenisPanganSegarNameExist(String $jenisPanganSegarName){
        return MasterJenisPanganSegar::where('nama_jenis_pangan_segar', $jenisPanganSegarName)->exists();
    }

    public function getJenisPanganSegarById($jenisPanganSegarId): ?MasterJenisPanganSegar
    {
        return MasterJenisPanganSegar::find($jenisPanganSegarId);
    }

    public function createJenisPanganSegar($data)
    {
        return MasterJenisPanganSegar::create($data);
    }

    public function update($jenisPanganSegarId, $data)
    {
        // Find the JenisPanganSegar profile by jenisPanganSegar_id
        $jenisPanganSegarProfile = MasterJenisPanganSegar::where('id', $jenisPanganSegarId)->first();
        if ($jenisPanganSegarProfile) {
            // Update the profile with the provided data
            $jenisPanganSegarProfile->update($data);
            return $jenisPanganSegarProfile;
        } else {
            throw new Exception("Jenis Pangan Segar not found");
        }
    }


    public function deleteJenisPanganSegarById($jenisPanganSegarId): ?bool

    {
        try {
            $jenisPanganSegar = MasterJenisPanganSegar::findOrFail($jenisPanganSegarId); // Find the JenisPanganSegar by ID
            $jenisPanganSegar->delete(); // Delete the JenisPanganSegar
            return true; // Return true on successful deletion
        } catch (\Exception $e) {
            // Handle any exceptions, such as JenisPanganSegar not found
            throw $e; // Return false if deletion fails
        }
    }
}
