<?php

namespace App\Services;

use App\Models\Petugas;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PetugasRepository;

class PetugasService
{
    private $petugasRepository;

    public function __construct(PetugasRepository $petugasRepository)
    {
        $this->petugasRepository = $petugasRepository;
    }

    public function listAllPetugas($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->petugasRepository->getAllPetugas($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getPetugasDetail($petugasId): ?Petugas
    {
        return $this->petugasRepository->getPetugasById($petugasId);
    }

    public function checkPetugasNameExist(string $unit_kerja): bool
    {
        return $this->petugasRepository->isPetugasNameExist($unit_kerja);
    }

    public function addNewPetugas(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $petugas = $this->petugasRepository->createPetugas($validatedData);
            DB::commit();
            return $petugas;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new Petugas to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updatePetugas(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $petugas = Petugas::findOrFail($id);
            $this->petugasRepository->update($id, $validatedData);
            DB::commit();
            return $petugas;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update Petugas in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deletePetugas($petugasId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->petugasRepository->deletePetugasById($petugasId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete Petugas with id $petugasId: {$exception->getMessage()}");
            return false;
        }
    }
}
