<?php

namespace App\Services;

use App\Models\MasterCemaranLogamBerat;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MasterCemaranLogamBeratRepository;

class MasterCemaranLogamBeratService
{
    private $MasterCemaranLogamBeratRepository;

    public function __construct(MasterCemaranLogamBeratRepository $MasterCemaranLogamBeratRepository)
    {
        $this->MasterCemaranLogamBeratRepository = $MasterCemaranLogamBeratRepository;
    }

    public function listAllMasterCemaranLogamBerat($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->MasterCemaranLogamBeratRepository->getAllCemaranLogamBerats($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getMasterCemaranLogamBeratDetail($MasterCemaranLogamBeratId): ?MasterCemaranLogamBerat
    {
        return $this->MasterCemaranLogamBeratRepository->getCemaranLogamBeratById($MasterCemaranLogamBeratId);
    }

    public function checkMasterCemaranLogamBeratExist(string $nama_cemaran_logam_berat): bool
    {
        return $this->MasterCemaranLogamBeratRepository->isCemaranLogamBeratnameExist($nama_cemaran_logam_berat);
    }

    public function addNewMasterCemaranLogamBerat(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $MasterCemaranLogamBerat = $this->MasterCemaranLogamBeratRepository->createCemaranLogamBerat($validatedData);
            DB::commit();
            return $MasterCemaranLogamBerat;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new MasterCemaranLogamBerat to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateMasterCemaranLogamBerat(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $MasterCemaranLogamBerat = MasterCemaranLogamBerat::findOrFail($id);

            $this->MasterCemaranLogamBeratRepository->update($id, $validatedData);
            DB::commit();
            return $MasterCemaranLogamBerat;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update MasterCemaranLogamBerat in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteMasterCemaranLogamBerat($MasterCemaranLogamBeratId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->MasterCemaranLogamBeratRepository->deleteCemaranLogamBeratById($MasterCemaranLogamBeratId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete MasterCemaranLogamBerat with id $MasterCemaranLogamBeratId: {$exception->getMessage()}");
            return false;
        }
    }
}
