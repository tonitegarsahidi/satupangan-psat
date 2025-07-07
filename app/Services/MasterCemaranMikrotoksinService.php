<?php

namespace App\Services;

use App\Models\MasterCemaranMikrotoksin;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterCemaranMikrotoksinRepository;

class MasterCemaranMikrotoksinService
{
    private $MasterCemaranMikrotoksinRepository;

    public function __construct(MasterCemaranMikrotoksinRepository $MasterCemaranMikrotoksinRepository)
    {
        $this->MasterCemaranMikrotoksinRepository = $MasterCemaranMikrotoksinRepository;
    }

    public function listAllMasterCemaranMikrotoksin($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterCemaranMikrotoksinRepository->getAllCemaranMikrotoksins($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getMasterCemaranMikrotoksinDetail($MasterCemaranMikrotoksinId): ?MasterCemaranMikrotoksin
    {
        return $this->MasterCemaranMikrotoksinRepository->getCemaranMikrotoksinById($MasterCemaranMikrotoksinId);
    }

    public function checkMasterCemaranMikrotoksinExist(string $nama_cemaran_mikrotoksin): bool
    {
        return $this->MasterCemaranMikrotoksinRepository->isCemaranMikrotoksinnameExist($nama_cemaran_mikrotoksin);
    }

    public function addNewMasterCemaranMikrotoksin(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterCemaranMikrotoksin = $this->MasterCemaranMikrotoksinRepository->createCemaranMikrotoksin($validatedData);
            DB::commit();
            return $MasterCemaranMikrotoksin;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterCemaranMikrotoksin to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateMasterCemaranMikrotoksin(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterCemaranMikrotoksin = MasterCemaranMikrotoksin::findOrFail($id);

            $this->MasterCemaranMikrotoksinRepository->update($id, $validatedData);
            DB::commit();
            return $MasterCemaranMikrotoksin;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterCemaranMikrotoksin in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteMasterCemaranMikrotoksin($MasterCemaranMikrotoksinId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterCemaranMikrotoksinRepository->deleteCemaranMikrotoksinById($MasterCemaranMikrotoksinId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterCemaranMikrotoksin with id $MasterCemaranMikrotoksinId: {$exception->getMessage()}");
            return false;
        }
    }
}
