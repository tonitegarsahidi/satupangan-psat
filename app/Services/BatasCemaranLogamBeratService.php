<?php

namespace App\Services;

use App\Models\BatasCemaranLogamBerat;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterCemaranLogamBerat;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BatasCemaranLogamBeratRepository;

class BatasCemaranLogamBeratService
{
    private $BatasCemaranLogamBeratRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(BatasCemaranLogamBeratRepository $BatasCemaranLogamBeratRepository)
    {
        $this->BatasCemaranLogamBeratRepository = $BatasCemaranLogamBeratRepository;
    }

    /**
     * =============================================
     *  list all BatasCemaranLogamBerat with filter, sort, etc
     * =============================================
     */
    public function listAllBatasCemaranLogamBerat($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->BatasCemaranLogamBeratRepository->getAllBatasCemaranLogamBerats($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single BatasCemaranLogamBerat data
     * =============================================
     */
    public function getBatasCemaranLogamBeratDetail($BatasCemaranLogamBeratId): ?BatasCemaranLogamBerat
    {
        return $this->BatasCemaranLogamBeratRepository->getBatasCemaranLogamBeratById($BatasCemaranLogamBeratId);
    }

    /**
     * =============================================
     * Check if certain BatasCemaranLogamBerat exists
     * =============================================
     */
    public function checkBatasCemaranLogamBeratExist(string $jenis_psat, string $cemaran_logam_berat): bool
    {
        return $this->BatasCemaranLogamBeratRepository->isBatasCemaranLogamBeratExist($jenis_psat, $cemaran_logam_berat);
    }

    /**
     * =============================================
     * process add new BatasCemaranLogamBerat to database
     * =============================================
     */
    public function addNewBatasCemaranLogamBerat(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $BatasCemaranLogamBerat = $this->BatasCemaranLogamBeratRepository->createBatasCemaranLogamBerat($validatedData);
            DB::commit();
            return $BatasCemaranLogamBerat;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new BatasCemaranLogamBerat to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update BatasCemaranLogamBerat data
     * =============================================
     */
    public function updateBatasCemaranLogamBerat(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $BatasCemaranLogamBerat = BatasCemaranLogamBerat::findOrFail($id);

            $this->BatasCemaranLogamBeratRepository->update($id, $validatedData);
            DB::commit();
            return $BatasCemaranLogamBerat;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update BatasCemaranLogamBerat in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete BatasCemaranLogamBerat
     * =============================================
     */
    public function deleteBatasCemaranLogamBerat($BatasCemaranLogamBeratId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->BatasCemaranLogamBeratRepository->deleteBatasCemaranLogamBeratById($BatasCemaranLogamBeratId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete BatasCemaranLogamBerat with id $BatasCemaranLogamBeratId: {$exception->getMessage()}");
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
        return $this->BatasCemaranLogamBeratRepository->getAllJenisPangan();
    }

    /**
     * =============================================
     * Get all cemaran logam berat for dropdown
     * =============================================
     */
    public function getAllCemaranLogamBerat()
    {
        return $this->BatasCemaranLogamBeratRepository->getAllCemaranLogamBerat();
    }
}
