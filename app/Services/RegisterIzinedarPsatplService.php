<?php

namespace App\Services;

use App\Models\RegisterIzinedarPsatpl;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\RegisterIzinedarPsatplRepository;

class RegisterIzinedarPsatplService
{
    private $registerIzinedarPsatplRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(RegisterIzinedarPsatplRepository $registerIzinedarPsatplRepository)
    {
        $this->registerIzinedarPsatplRepository = $registerIzinedarPsatplRepository;
    }

    /**
     * =============================================
     *  list all RegisterIzinedarPsatpl along with filter, sort, etc
     * =============================================
     */
    public function listAllRegisterIzinedarPsatpl($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, $user = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->registerIzinedarPsatplRepository->getAllRegisterIzinedarPsatpls($perPage, $sortField, $sortOrder, $keyword, $user);
    }

    /**
     * =============================================
     * get single RegisterIzinedarPsatpl data
     * =============================================
     */
    public function getRegisterIzinedarPsatplDetail($registerIzinedarPsatplId): ?RegisterIzinedarPsatpl
    {
        return $this->registerIzinedarPsatplRepository->getRegisterIzinedarPsatplById($registerIzinedarPsatplId);
    }

    /**
     * =============================================
     * Check if certain nomor_izinedar_pl is exists or not
     * YOU CAN ALSO BLACKLIST some nomor_izinedar_pl in this logic
     * =============================================
     */
    public function checkRegisterIzinedarPsatplExist(string $nomor_izinedar_pl): bool{
        return $this->registerIzinedarPsatplRepository->isRegisterIzinedarPsatplExist($nomor_izinedar_pl);
    }

    /**
     * =============================================
     * process add new RegisterIzinedarPsatpl to database
     * =============================================
     */
    public function addNewRegisterIzinedarPsatpl(array $validatedData)
    {
        DB::beginTransaction();
        try {
            // Set default values for file fields if not provided
            $validatedData['file_nib'] = $validatedData['file_nib'] ?? null;
            $validatedData['file_sppb'] = $validatedData['file_sppb'] ?? null;
            $validatedData['file_izinedar_psatpl'] = $validatedData['file_izinedar_psatpl'] ?? null;

            $registerIzinedarPsatpl = $this->registerIzinedarPsatplRepository->createRegisterIzinedarPsatpl($validatedData);

            DB::commit();
            return $registerIzinedarPsatpl;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new RegisterIzinedarPsatpl to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update RegisterIzinedarPsatpl data
     * =============================================
     */
    public function updateRegisterIzinedarPsatpl(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $registerIzinedarPsatpl = RegisterIzinedarPsatpl::findOrFail($id);

            // Preserve existing file paths if not provided in the update
            if (!isset($validatedData['file_nib'])) {
                $validatedData['file_nib'] = $registerIzinedarPsatpl->file_nib;
            }
            if (!isset($validatedData['file_sppb'])) {
                $validatedData['file_sppb'] = $registerIzinedarPsatpl->file_sppb;
            }
            if (!isset($validatedData['file_izinedar_psatpl'])) {
                $validatedData['file_izinedar_psatpl'] = $registerIzinedarPsatpl->file_izinedar_psatpl;
            }

            $this->registerIzinedarPsatplRepository->update($id, $validatedData);

            DB::commit();
            return $registerIzinedarPsatpl;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update RegisterIzinedarPsatpl in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete RegisterIzinedarPsatpl
     * =============================================
     */
    public function deleteRegisterIzinedarPsatpl($registerIzinedarPsatplId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->registerIzinedarPsatplRepository->deleteRegisterIzinedarPsatplById($registerIzinedarPsatplId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete RegisterIzinedarPsatpl with id $registerIzinedarPsatplId: {$exception->getMessage()}");
            return false;
        }
    }
}
