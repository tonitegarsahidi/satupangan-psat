<?php

namespace App\Repositories;

use App\Models\Petugas;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class PetugasRepository
{
    public function getAllPetugas(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $query = Petugas::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $query->whereRaw('lower(unit_kerja) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(jabatan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $query->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isPetugasNameExist(string $unit_kerja): bool
    {
        return Petugas::where('unit_kerja', $unit_kerja)->exists();
    }

    public function getPetugasById($petugasId): ?Petugas
    {
        return Petugas::find($petugasId);
    }

    public function createPetugas($data)
    {
        return Petugas::create($data);
    }

    public function update($petugasId, $data)
    {
        $petugas = Petugas::where('id', $petugasId)->first();
        if ($petugas) {
            $petugas->update($data);
            return $petugas;
        } else {
            throw new Exception("Petugas not found");
        }
    }

    public function deletePetugasById($petugasId): ?bool
    {
        try {
            $petugas = Petugas::findOrFail($petugasId);
            $petugas->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
