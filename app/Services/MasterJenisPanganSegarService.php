<?php

namespace App\Services;

use App\Models\MasterJenisPanganSegar;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterJenisPanganSegarRepository;


class MasterJenisPanganSegarService
{
    private $MasterJenisPanganSegarRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(MasterJenisPanganSegarRepository $MasterJenisPanganSegarRepository)
    {
        $this->MasterJenisPanganSegarRepository = $MasterJenisPanganSegarRepository;
    }

    /**
     * =============================================
     *  list all MasterJenisPanganSegar along with filter, sort, etc
     * =============================================
     */
    public function listAllMasterJenisPanganSegar($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterJenisPanganSegarRepository->getAllJenisPanganSegars($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single MasterJenisPanganSegar data
     * =============================================
     */
    public function getMasterJenisPanganSegarDetail($MasterJenisPanganSegarId): ?MasterJenisPanganSegar
    {
        return $this->MasterJenisPanganSegarRepository->getJenisPanganSegarById($MasterJenisPanganSegarId);
    }


    /**
     * =============================================
     * Check if certain MasterJenisPanganSegarName or Kode Jenis Pangan Segar is exists or not
     * YOU CAN ALSO BLACKLIST some nama_jenis_pangan_segar or kode_jenis_pangan_segar in this logic
     * =============================================
     */
    public function checkMasterJenisPanganSegarExist(string $nama_jenis_pangan_segar, string $kode_jenis_pangan_segar, $id = null): bool{
        $query = MasterJenisPanganSegar::where('nama_jenis_pangan_segar', $nama_jenis_pangan_segar)
                                    ->where('kode_jenis_pangan_segar', $kode_jenis_pangan_segar);

        if ($id) {
            $query->where('id', '!=', $id);
        }

        return $query->exists();
    }

    /**
     * =============================================
     * process add new MasterJenisPanganSegar to database
     * =============================================
     */
    public function addNewMasterJenisPanganSegar(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterJenisPanganSegar = $this->MasterJenisPanganSegarRepository->createJenisPanganSegar($validatedData);
            DB::commit();
            return $MasterJenisPanganSegar;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterJenisPanganSegar to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update MasterJenisPanganSegar data
     * =============================================
     */
    public function updateMasterJenisPanganSegar(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterJenisPanganSegar = MasterJenisPanganSegar::findOrFail($id);

            $this->MasterJenisPanganSegarRepository->update($id, $validatedData);
            DB::commit();
            return $MasterJenisPanganSegar;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterJenisPanganSegar in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete MasterJenisPanganSegar
     * =============================================
     */
    public function deleteMasterJenisPanganSegar($MasterJenisPanganSegarId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterJenisPanganSegarRepository->deleteJenisPanganSegarById($MasterJenisPanganSegarId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterJenisPanganSegar with id $MasterJenisPanganSegarId: {$exception->getMessage()}");
            return false;
        }
    }
}
