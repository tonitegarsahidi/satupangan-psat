<?php

namespace App\Services;

use App\Models\BatasCemaranPestisida;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterCemaranPestisida;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BatasCemaranPestisidaRepository;

class BatasCemaranPestisidaService
{
    private $BatasCemaranPestisidaRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(BatasCemaranPestisidaRepository $BatasCemaranPestisidaRepository)
    {
        $this->BatasCemaranPestisidaRepository = $BatasCemaranPestisidaRepository;
    }

    /**
     * =============================================
     *  list all BatasCemaranPestisida with filter, sort, etc
     * =============================================
     */
    public function listAllBatasCemaranPestisidas($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->BatasCemaranPestisidaRepository->getAllBatasCemaranPestisidas($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single BatasCemaranPestisida data
     * =============================================
     */
    public function getBatasCemaranPestisidaDetail($BatasCemaranPestisidaId): ?BatasCemaranPestisida
    {
        return $this->BatasCemaranPestisidaRepository->getBatasCemaranPestisidaById($BatasCemaranPestisidaId);
    }

    /**
     * =============================================
     * Check if certain BatasCemaranPestisida exists
     * =============================================
     */
    public function checkBatasCemaranPestisidaExist(string $jenis_psat, string $cemaran_pestisida): bool
    {
        return $this->BatasCemaranPestisidaRepository->isBatasCemaranPestisidaExist($jenis_psat, $cemaran_pestisida);
    }

    /**
     * =============================================
     * process add new BatasCemaranPestisida to database
     * =============================================
     */
    public function addNewBatasCemaranPestisida(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $BatasCemaranPestisida = $this->BatasCemaranPestisidaRepository->createBatasCemaranPestisida($validatedData);
            DB::commit();
            return $BatasCemaranPestisida;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new BatasCemaranPestisida to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update BatasCemaranPestisida data
     * =============================================
     */
    public function updateBatasCemaranPestisida(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $BatasCemaranPestisida = BatasCemaranPestisida::findOrFail($id);

            $this->BatasCemaranPestisidaRepository->update($id, $validatedData);
            DB::commit();
            return $BatasCemaranPestisida;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update BatasCemaranPestisida in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete BatasCemaranPestisida
     * =============================================
     */
    public function deleteBatasCemaranPestisida($BatasCemaranPestisidaId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->BatasCemaranPestisidaRepository->deleteBatasCemaranPestisidaById($BatasCemaranPestisidaId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete BatasCemaranPestisida with id $BatasCemaranPestisidaId: {$exception->getMessage()}");
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
        return $this->BatasCemaranPestisidaRepository->getAllJenisPangan();
    }

    /**
     * =============================================
     * Get all cemaran pestisida for dropdown
     * =============================================
     */
    public function getAllCemaranPestisida()
    {
        return $this->BatasCemaranPestisidaRepository->getAllCemaranPestisida();
    }
}
