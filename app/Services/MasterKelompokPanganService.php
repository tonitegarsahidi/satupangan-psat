<?php

namespace App\Services;

use App\Models\MasterKelompokPangan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterKelompokPanganRepository;


class MasterKelompokPanganService
{
    private $MasterKelompokPanganRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(MasterKelompokPanganRepository $MasterKelompokPanganRepository)
    {
        $this->MasterKelompokPanganRepository = $MasterKelompokPanganRepository;
    }

    /**
     * =============================================
     *  list all MasterKelompokPangan along with filter, sort, etc
     * =============================================
     */
    public function listAllMasterKelompokPangan($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterKelompokPanganRepository->getAllKelompokPangans($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single MasterKelompokPangan data
     * =============================================
     */
    public function getMasterKelompokPanganDetail($MasterKelompokPanganId): ?MasterKelompokPangan
    {
        return $this->MasterKelompokPanganRepository->getKelompokPanganById($MasterKelompokPanganId);
    }


    /**
     * =============================================
     * Check if certain MasterKelompokPanganName is exists or not
     * YOU CAN ALSO BLACKLIST some nama_kelompok_pangan in this logic
     * =============================================
     */
    public function checkMasterKelompokPanganExist(string $nama_kelompok_pangan): bool{
        return $this->MasterKelompokPanganRepository->isKelompokPanganNameExist($nama_kelompok_pangan);
    }

    /**
     * =============================================
     * process add new MasterKelompokPangan to database
     * =============================================
     */
    public function addNewMasterKelompokPangan(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterKelompokPangan = $this->MasterKelompokPanganRepository->createKelompokPangan($validatedData);
            DB::commit();
            return $MasterKelompokPangan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterKelompokPangan to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update MasterKelompokPangan data
     * =============================================
     */
    public function updateMasterKelompokPangan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterKelompokPangan = MasterKelompokPangan::findOrFail($id);

            $this->MasterKelompokPanganRepository->update($id, $validatedData);
            DB::commit();
            return $MasterKelompokPangan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterKelompokPangan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete MasterKelompokPangan
     * =============================================
     */
    public function deleteMasterKelompokPangan($MasterKelompokPanganId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterKelompokPanganRepository->deleteKelompokPanganById($MasterKelompokPanganId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterKelompokPangan with id $MasterKelompokPanganId: {$exception->getMessage()}");
            return false;
        }
    }
}
