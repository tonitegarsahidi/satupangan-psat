<?php

namespace App\Services;

use App\Models\MasterPenanganan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterPenangananRepository;

class MasterPenangananService
{
    private $MasterPenangananRepository;

    public function __construct(MasterPenangananRepository $MasterPenangananRepository)
    {
        $this->MasterPenangananRepository = $MasterPenangananRepository;
    }

    public function listAllMasterPenanganan($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterPenangananRepository->getAllMasterPenanganans($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getMasterPenangananDetail($penangananId): ?MasterPenanganan
    {
        return $this->MasterPenangananRepository->getMasterPenangananById($penangananId);
    }

    public function checkMasterPenangananExist(string $nama_penanganan): bool
    {
        return $this->MasterPenangananRepository->isPenangananNameExist($nama_penanganan);
    }

    public function addNewMasterPenanganan(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $penanganan = $this->MasterPenangananRepository->createMasterPenanganan($validatedData);
            DB::commit();
            return $penanganan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterPenanganan to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateMasterPenanganan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $penanganan = MasterPenanganan::findOrFail($id);

            $this->MasterPenangananRepository->update($id, $validatedData);
            DB::commit();
            return $penanganan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterPenanganan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteMasterPenanganan($penangananId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterPenangananRepository->deleteMasterPenangananById($penangananId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterPenanganan with id $penangananId: {$exception->getMessage()}");
            return false;
        }
    }
}
