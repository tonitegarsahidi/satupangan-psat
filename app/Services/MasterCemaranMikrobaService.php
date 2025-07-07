<?php

namespace App\Services;

use App\Models\MasterCemaranMikroba;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterCemaranMikrobaRepository;

class MasterCemaranMikrobaService
{
    private $MasterCemaranMikrobaRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(MasterCemaranMikrobaRepository $MasterCemaranMikrobaRepository)
    {
        $this->MasterCemaranMikrobaRepository = $MasterCemaranMikrobaRepository;
    }

    /**
     * =============================================
     *  list all MasterCemaranMikroba with filter, sort, etc
     * =============================================
     */
    public function listAllMasterCemaranMikroba($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterCemaranMikrobaRepository->getAllCemaranMikrobas($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single MasterCemaranMikroba data
     * =============================================
     */
    public function getMasterCemaranMikrobaDetail($MasterCemaranMikrobaId): ?MasterCemaranMikroba
    {
        return $this->MasterCemaranMikrobaRepository->getCemaranMikrobaById($MasterCemaranMikrobaId);
    }

    /**
     * =============================================
     * Check if certain MasterCemaranMikrobaname exists
     * =============================================
     */
    public function checkMasterCemaranMikrobaExist(string $nama_cemaran_mikroba): bool
    {
        return $this->MasterCemaranMikrobaRepository->isCemaranMikrobanameExist($nama_cemaran_mikroba);
    }

    /**
     * =============================================
     * process add new MasterCemaranMikroba to database
     * =============================================
     */
    public function addNewMasterCemaranMikroba(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterCemaranMikroba = $this->MasterCemaranMikrobaRepository->createCemaranMikroba($validatedData);
            DB::commit();
            return $MasterCemaranMikroba;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterCemaranMikroba to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update MasterCemaranMikroba data
     * =============================================
     */
    public function updateMasterCemaranMikroba(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterCemaranMikroba = MasterCemaranMikroba::findOrFail($id);

            $this->MasterCemaranMikrobaRepository->update($id, $validatedData);
            DB::commit();
            return $MasterCemaranMikroba;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterCemaranMikroba in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete MasterCemaranMikroba
     * =============================================
     */
    public function deleteMasterCemaranMikroba($MasterCemaranMikrobaId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterCemaranMikrobaRepository->deleteCemaranMikrobaById($MasterCemaranMikrobaId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterCemaranMikroba with id $MasterCemaranMikrobaId: {$exception->getMessage()}");
            return false;
        }
    }
}
