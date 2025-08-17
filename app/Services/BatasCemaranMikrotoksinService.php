<?php

namespace App\Services;

use App\Models\BatasCemaranMikrotoksin;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterCemaranMikrotoksin;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BatasCemaranMikrotoksinRepository;

class BatasCemaranMikrotoksinService
{
    private $BatasCemaranMikrotoksinRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(BatasCemaranMikrotoksinRepository $BatasCemaranMikrotoksinRepository)
    {
        $this->BatasCemaranMikrotoksinRepository = $BatasCemaranMikrotoksinRepository;
    }

    /**
     * =============================================
     *  list all BatasCemaranMikrotoksin with filter, sort, etc
     * =============================================
     */
    public function listAllBatasCemaranMikrotoksins($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->BatasCemaranMikrotoksinRepository->getAllBatasCemaranMikrotoksins($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single BatasCemaranMikrotoksin data
     * =============================================
     */
    public function getBatasCemaranMikrotoksinDetail($BatasCemaranMikrotoksinId): ?BatasCemaranMikrotoksin
    {
        return $this->BatasCemaranMikrotoksinRepository->getBatasCemaranMikrotoksinById($BatasCemaranMikrotoksinId);
    }

    /**
     * =============================================
     * Check if certain BatasCemaranMikrotoksin exists
     * =============================================
     */
    public function checkBatasCemaranMikrotoksinExist(string $jenis_psat, string $cemaran_mikrotoksin): bool
    {
        return $this->BatasCemaranMikrotoksinRepository->isBatasCemaranMikrotoksinExist($jenis_psat, $cemaran_mikrotoksin);
    }

    /**
     * =============================================
     * process add new BatasCemaranMikrotoksin to database
     * =============================================
     */
    public function addNewBatasCemaranMikrotoksin(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $BatasCemaranMikrotoksin = $this->BatasCemaranMikrotoksinRepository->createBatasCemaranMikrotoksin($validatedData);
            DB::commit();
            return $BatasCemaranMikrotoksin;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new BatasCemaranMikrotoksin to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update BatasCemaranMikrotoksin data
     * =============================================
     */
    public function updateBatasCemaranMikrotoksin(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $BatasCemaranMikrotoksin = BatasCemaranMikrotoksin::findOrFail($id);

            $this->BatasCemaranMikrotoksinRepository->update($id, $validatedData);
            DB::commit();
            return $BatasCemaranMikrotoksin;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update BatasCemaranMikrotoksin in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete BatasCemaranMikrotoksin
     * =============================================
     */
    public function deleteBatasCemaranMikrotoksin($BatasCemaranMikrotoksinId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->BatasCemaranMikrotoksinRepository->deleteBatasCemaranMikrotoksinById($BatasCemaranMikrotoksinId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete BatasCemaranMikrotoksin with id $BatasCemaranMikrotoksinId: {$exception->getMessage()}");
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
        return $this->BatasCemaranMikrotoksinRepository->getAllJenisPangan();
    }

    /**
     * =============================================
     * Get all cemaran mikrotoksin for dropdown
     * =============================================
     */
    public function getAllCemaranMikrotoksin()
    {
        return $this->BatasCemaranMikrotoksinRepository->getAllCemaranMikrotoksin();
    }
}
