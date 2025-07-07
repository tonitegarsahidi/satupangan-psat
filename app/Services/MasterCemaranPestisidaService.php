<?php

namespace App\Services;

use App\Models\MasterCemaranPestisida;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterCemaranPestisidaRepository;

class MasterCemaranPestisidaService
{
    private $MasterCemaranPestisidaRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(MasterCemaranPestisidaRepository $MasterCemaranPestisidaRepository)
    {
        $this->MasterCemaranPestisidaRepository = $MasterCemaranPestisidaRepository;
    }

    /**
     * =============================================
     *  list all MasterCemaranPestisida along with filter, sort, etc
     * =============================================
     */
    public function listAllMasterCemaranPestisida($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterCemaranPestisidaRepository->getAllCemaranPestisidas($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single MasterCemaranPestisida data
     * =============================================
     */
    public function getMasterCemaranPestisidaDetail($MasterCemaranPestisidaId): ?MasterCemaranPestisida
    {
        return $this->MasterCemaranPestisidaRepository->getCemaranPestisidaById($MasterCemaranPestisidaId);
    }

    /**
     * =============================================
     * Check if certain MasterCemaranPestisida name exists or not
     * YOU CAN ALSO BLACKLIST some nama_cemaran_pestisida in this logic
     * =============================================
     */
    public function checkMasterCemaranPestisidaExist(string $nama_cemaran_pestisida): bool{
        return $this->MasterCemaranPestisidaRepository->isCemaranPestisidaNameExist($nama_cemaran_pestisida);
    }

    /**
     * =============================================
     * process add new MasterCemaranPestisida to database
     * =============================================
     */
    public function addNewMasterCemaranPestisida(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterCemaranPestisida = $this->MasterCemaranPestisidaRepository->createCemaranPestisida($validatedData);
            DB::commit();
            return $MasterCemaranPestisida;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterCemaranPestisida to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update MasterCemaranPestisida data
     * =============================================
     */
    public function updateMasterCemaranPestisida(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterCemaranPestisida = MasterCemaranPestisida::findOrFail($id);

            $this->MasterCemaranPestisidaRepository->update($id, $validatedData);
            DB::commit();
            return $MasterCemaranPestisida;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterCemaranPestisida in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete MasterCemaranPestisida
     * =============================================
     */
    public function deleteMasterCemaranPestisida($MasterCemaranPestisidaId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterCemaranPestisidaRepository->deleteCemaranPestisidaById($MasterCemaranPestisidaId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterCemaranPestisida with id $MasterCemaranPestisidaId: {$exception->getMessage()}");
            return false;
        }
    }
}
