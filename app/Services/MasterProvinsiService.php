<?php

namespace App\Services;

use App\Models\MasterProvinsi;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterProvinsiRepository;


class MasterProvinsiService
{
    private $MasterProvinsiRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(MasterProvinsiRepository $MasterProvinsiRepository)
    {
        $this->MasterProvinsiRepository = $MasterProvinsiRepository;
    }

    /**
     * =============================================
     *  list all MasterProvinsi along with filter, sort, etc
     * =============================================
     */
    public function listAllMasterProvinsi($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterProvinsiRepository->getAllProvinsis($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single MasterProvinsi data
     * =============================================
     */
    public function getMasterProvinsiDetail($MasterProvinsiId): ?MasterProvinsi
    {
        return $this->MasterProvinsiRepository->getProvinsiById($MasterProvinsiId);
    }


    /**
     * =============================================
     * Check if certain MasterProvinsiname is exists or not
     * YOU CAN ALSO BLACKLIST some nama_provinsi in this logic
     * =============================================
     */
    public function checkMasterProvinsiExist(string $nama_provinsi): bool{
        return $this->MasterProvinsiRepository->isProvinsinameExist($nama_provinsi);
    }

    /**
     * =============================================
     * process add new MasterProvinsi to database
     * =============================================
     */
    public function addNewMasterProvinsi(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterProvinsi = $this->MasterProvinsiRepository->createProvinsi($validatedData);
            DB::commit();
            return $MasterProvinsi;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterProvinsi to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update MasterProvinsi data
     * =============================================
     */
    public function updateMasterProvinsi(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterProvinsi = MasterProvinsi::findOrFail($id);

            $this->MasterProvinsiRepository->update($id, $validatedData);
            DB::commit();
            return $MasterProvinsi;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterProvinsi in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete MasterProvinsi
     * =============================================
     */
    public function deleteMasterProvinsi($MasterProvinsiId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterProvinsiRepository->deleteProvinsiById($MasterProvinsiId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterProvinsi with id $MasterProvinsiId: {$exception->getMessage()}");
            return false;
        }
    }
}
