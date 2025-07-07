<?php

namespace App\Services;

use App\Models\MasterKota;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterKotaRepository;

class MasterKotaService
{
    private $MasterKotaRepository;

    public function __construct(MasterKotaRepository $MasterKotaRepository)
    {
        $this->MasterKotaRepository = $MasterKotaRepository;
    }

    public function listAllMasterKota($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterKotaRepository->getAllKotas($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getMasterKotaDetail($MasterKotaId): ?MasterKota
    {
        return $this->MasterKotaRepository->getKotaById($MasterKotaId);
    }

    public function checkMasterKotaExist(string $nama_kota): bool
    {
        return $this->MasterKotaRepository->isKotanameExist($nama_kota);
    }

    public function addNewMasterKota(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterKota = $this->MasterKotaRepository->createKota($validatedData);
            DB::commit();
            return $MasterKota;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterKota to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateMasterKota(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterKota = MasterKota::findOrFail($id);

            $this->MasterKotaRepository->update($id, $validatedData);
            DB::commit();
            return $MasterKota;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterKota in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteMasterKota($MasterKotaId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterKotaRepository->deleteKotaById($MasterKotaId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterKota with id $MasterKotaId: {$exception->getMessage()}");
            return false;
        }
    }
}
