<?php

namespace App\Services;

use App\Models\MasterBahanPanganSegar;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterBahanPanganSegarRepository;


class MasterBahanPanganSegarService
{
    private $MasterBahanPanganSegarRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(MasterBahanPanganSegarRepository $MasterBahanPanganSegarRepository)
    {
        $this->MasterBahanPanganSegarRepository = $MasterBahanPanganSegarRepository;
    }

    /**
     * =============================================
     *  list all MasterBahanPanganSegar along with filter, sort, etc
     * =============================================
     */
    public function listAllMasterBahanPanganSegar($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterBahanPanganSegarRepository->getAllBahanPanganSegars($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single MasterBahanPanganSegar data
     * =============================================
     */
    public function getMasterBahanPanganSegarDetail($MasterBahanPanganSegarId): ?MasterBahanPanganSegar
    {
        return $this->MasterBahanPanganSegarRepository->getBahanPanganSegarById($MasterBahanPanganSegarId);
    }


    /**
     * =============================================
     * Check if certain MasterBahanPanganSegarName or Kode Bahan Pangan Segar is exists or not
     * YOU CAN ALSO BLACKLIST some nama_bahan_pangan_segar or kode_bahan_pangan_segar in this logic
     * =============================================
     */
    public function checkMasterBahanPanganSegarExist(string $nama_bahan_pangan_segar, string $kode_bahan_pangan_segar, $id = null): bool{
        $query = MasterBahanPanganSegar::where('nama_bahan_pangan_segar', $nama_bahan_pangan_segar)
                                    ->where('id', '!=', $id)
                                    ->where('kode_bahan_pangan_segar', $kode_bahan_pangan_segar);

        // dd($query->get());

        return $query->exists();
    }

    /**
     * =============================================
     * process add new MasterBahanPanganSegar to database
     * =============================================
     */
    public function addNewMasterBahanPanganSegar(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterBahanPanganSegar = $this->MasterBahanPanganSegarRepository->createBahanPanganSegar($validatedData);
            DB::commit();
            return $MasterBahanPanganSegar;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterBahanPanganSegar to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update MasterBahanPanganSegar data
     * =============================================
     */
    public function updateMasterBahanPanganSegar(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterBahanPanganSegar = MasterBahanPanganSegar::findOrFail($id);

            $this->MasterBahanPanganSegarRepository->update($id, $validatedData);
            DB::commit();
            return $MasterBahanPanganSegar;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterBahanPanganSegar in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete MasterBahanPanganSegar
     * =============================================
     */
    public function deleteMasterBahanPanganSegar($MasterBahanPanganSegarId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterBahanPanganSegarRepository->deleteBahanPanganSegarById($MasterBahanPanganSegarId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterBahanPanganSegar with id $MasterBahanPanganSegarId: {$exception->getMessage()}");
            return false;
        }
    }
}
