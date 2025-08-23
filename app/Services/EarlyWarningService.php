<?php

namespace App\Services;

use App\Models\EarlyWarning;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\EarlyWarningRepository;


class EarlyWarningService
{
    private $EarlyWarningRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(EarlyWarningRepository $EarlyWarningRepository)
    {
        $this->EarlyWarningRepository = $EarlyWarningRepository;
    }

    /**
     * =============================================
     *  list all EarlyWarnings along with filter, sort, etc
     * =============================================
     */
    public function listAllEarlyWarnings($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, string $status = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->EarlyWarningRepository->getAllEarlyWarnings($perPage, $sortField, $sortOrder, $keyword, $status);
    }

    /**
     * =============================================
     * get single EarlyWarning data
     * =============================================
     */
    public function getEarlyWarningDetail($EarlyWarningId): ?EarlyWarning
    {
        return $this->EarlyWarningRepository->getEarlyWarningById($EarlyWarningId);
    }


    /**
     * =============================================
     * Check if certain EarlyWarning title is exists or not
     * =============================================
     */
    public function checkEarlyWarningExist(string $title): bool{
        return $this->EarlyWarningRepository->isEarlyWarningTitleExist($title);
    }

    /**
     * =============================================
     * process add new EarlyWarning to database
     * =============================================
     */
    public function addNewEarlyWarning(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $EarlyWarning = $this->EarlyWarningRepository->createEarlyWarning($validatedData);
            DB::commit();
            return $EarlyWarning;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new EarlyWarning to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update EarlyWarning data
     * =============================================
     */
    public function updateEarlyWarning(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $EarlyWarning = EarlyWarning::findOrFail($id);

            $this->EarlyWarningRepository->update($id, $validatedData);
            DB::commit();
            return $EarlyWarning;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update EarlyWarning in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete EarlyWarning
     * =============================================
     */
    public function deleteEarlyWarning($EarlyWarningId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->EarlyWarningRepository->deleteEarlyWarningById($EarlyWarningId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete EarlyWarning with id $EarlyWarningId: {$exception->getMessage()}");
            return false;
        }
    }
}
