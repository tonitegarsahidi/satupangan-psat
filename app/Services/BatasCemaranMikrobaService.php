<?php

namespace App\Services;

use App\Models\BatasCemaranMikroba;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterCemaranMikroba;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BatasCemaranMikrobaRepository;

class BatasCemaranMikrobaService
{
    private $BatasCemaranMikrobaRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(BatasCemaranMikrobaRepository $BatasCemaranMikrobaRepository)
    {
        $this->BatasCemaranMikrobaRepository = $BatasCemaranMikrobaRepository;
    }

    /**
     * =============================================
     *  list all BatasCemaranMikroba with filter, sort, etc
     * =============================================
     */
    public function listAllBatasCemaranMikroba($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->BatasCemaranMikrobaRepository->getAllBatasCemaranMikrobas($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single BatasCemaranMikroba data
     * =============================================
     */
    public function getBatasCemaranMikrobaDetail($BatasCemaranMikrobaId): ?BatasCemaranMikroba
    {
        return $this->BatasCemaranMikrobaRepository->getBatasCemaranMikrobaById($BatasCemaranMikrobaId);
    }

    /**
     * =============================================
     * Check if certain BatasCemaranMikroba exists
     * =============================================
     */
    public function checkBatasCemaranMikrobaExist(string $jenis_psat, string $cemaran_mikroba): bool
    {
        return $this->BatasCemaranMikrobaRepository->isBatasCemaranMikrobaExist($jenis_psat, $cemaran_mikroba);
    }

    /**
     * =============================================
     * process add new BatasCemaranMikroba to database
     * =============================================
     */
    public function addNewBatasCemaranMikroba(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $BatasCemaranMikroba = $this->BatasCemaranMikrobaRepository->createBatasCemaranMikroba($validatedData);
            DB::commit();
            return $BatasCemaranMikroba;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new BatasCemaranMikroba to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update BatasCemaranMikroba data
     * =============================================
     */
    public function updateBatasCemaranMikroba(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $BatasCemaranMikroba = BatasCemaranMikroba::findOrFail($id);

            $this->BatasCemaranMikrobaRepository->update($id, $validatedData);
            DB::commit();
            return $BatasCemaranMikroba;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update BatasCemaranMikroba in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete BatasCemaranMikroba
     * =============================================
     */
    public function deleteBatasCemaranMikroba($BatasCemaranMikrobaId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->BatasCemaranMikrobaRepository->deleteBatasCemaranMikrobaById($BatasCemaranMikrobaId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete BatasCemaranMikroba with id $BatasCemaranMikrobaId: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * =============================================
     * Get all jenis pangan for dropdown
     * =============================================
     */
    public function getAllJenisPangan()
    {
        return $this->BatasCemaranMikrobaRepository->getAllJenisPangan();
    }

    /**
     * =============================================
     * Get all cemaran mikroba for dropdown
     * =============================================
     */
    public function getAllCemaranMikroba()
    {
        return $this->BatasCemaranMikrobaRepository->getAllCemaranMikroba();
    }
}
