<?php

namespace App\Repositories;

use App\Models\MasterProvinsi;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class MasterProvinsiRepository
{
    public function getAllProvinsis(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterProvinsi::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_provinsi) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_provinsi) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isProvinsinameExist(String $provinsiname){
        return MasterProvinsi::where('nama_provinsi', $provinsiname)->exists();
    }

    public function getProvinsiById($provinsiId): ?MasterProvinsi
    {
        return MasterProvinsi::find($provinsiId);
    }

    public function createProvinsi($data)
    {
        return MasterProvinsi::create($data);
    }

    public function update($provinsiId, $data)
    {
        // Find the Provinsi profile by Provinsi_id
        $provinsiProfile = MasterProvinsi::where('id', $provinsiId)->first();
        if ($provinsiProfile) {
            // Update the profile with the provided data
            $provinsiProfile->update($data);
            return $provinsiProfile;
        } else {
            throw new Exception("Provinsi not found");
        }
    }


    public function deleteProvinsiById($provinsiId): ?bool

    {
        try {
            $provinsi = MasterProvinsi::findOrFail($provinsiId); // Find the Provinsi by ID
            $provinsi->delete(); // Delete the Provinsi
            return true; // Return true on successful deletion
        } catch (\Exception $e) {
            // Handle any exceptions, such as Provinsi not found
            throw $e; // Return false if deletion fails
        }
    }
}
