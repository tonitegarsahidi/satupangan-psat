<?php

namespace App\Services;

use App\Models\RegisterIzinedarPsatpd;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\RegisterIzinedarPsatpdRepository;

class RegisterIzinedarPsatpdService
{
    private $registerIzinedarPsatpdRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(RegisterIzinedarPsatpdRepository $registerIzinedarPsatpdRepository)
    {
        $this->registerIzinedarPsatpdRepository = $registerIzinedarPsatpdRepository;
    }

    /**
     * =============================================
     *  list all RegisterIzinedarPsatpd along with filter, sort, etc
     * =============================================
     */
    public function listAllRegisterIzinedarPsatpd($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, $user = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->registerIzinedarPsatpdRepository->getAllRegisterIzinedarPsatpds($perPage, $sortField, $sortOrder, $keyword, $user);
    }

    /**
     * =============================================
     * get single RegisterIzinedarPsatpd data
     * =============================================
     */
    public function getRegisterIzinedarPsatpdDetail($registerIzinedarPsatpdId): ?RegisterIzinedarPsatpd
    {
        return $this->registerIzinedarPsatpdRepository->getRegisterIzinedarPsatpdById($registerIzinedarPsatpdId);
    }

    /**
     * =============================================
     * Check if certain nomor_izinedar_pl is exists or not
     * YOU CAN ALSO BLACKLIST some nomor_izinedar_pl in this logic
     * =============================================
     */
    public function checkRegisterIzinedarPsatpdExist(string $nomor_izinedar_pl): bool{
        return $this->registerIzinedarPsatpdRepository->isRegisterIzinedarPsatpdExist($nomor_izinedar_pl);
    }

    /**
     * =============================================
     * process add new RegisterIzinedarPsatpd to database
     * =============================================
     */
    public function addNewRegisterIzinedarPsatpd(array $validatedData)
    {
        DB::beginTransaction();
        try {
            // Set default values for file fields if not provided
            $validatedData['file_nib'] = $validatedData['file_nib'] ?? null;
            $validatedData['file_sppb'] = $validatedData['file_sppb'] ?? null;
            $validatedData['file_izinedar_psatpd'] = $validatedData['file_izinedar_psatpd'] ?? null;

            $registerIzinedarPsatpd = $this->registerIzinedarPsatpdRepository->createRegisterIzinedarPsatpd($validatedData);

            DB::commit();
            return $registerIzinedarPsatpd;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new RegisterIzinedarPsatpd to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update RegisterIzinedarPsatpd data
     * =============================================
     */
    public function updateRegisterIzinedarPsatpd(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $registerIzinedarPsatpd = RegisterIzinedarPsatpd::findOrFail($id);

            // Preserve existing file paths if not provided in the update
            if (!isset($validatedData['file_nib'])) {
                $validatedData['file_nib'] = $registerIzinedarPsatpd->file_nib;
            }
            if (!isset($validatedData['file_sppb'])) {
                $validatedData['file_sppb'] = $registerIzinedarPsatpd->file_sppb;
            }
            if (!isset($validatedData['file_izinedar_psatpd'])) {
                $validatedData['file_izinedar_psatpd'] = $registerIzinedarPsatpd->file_izinedar_psatpd;
            }

            // Preserve existing photo paths if not provided in the update
            for ($i = 1; $i <= 6; $i++) {
                $photoField = 'foto_' . $i;
                if (!isset($validatedData[$photoField])) {
                    $validatedData[$photoField] = $registerIzinedarPsatpd->$photoField;
                }
            }

            $this->registerIzinedarPsatpdRepository->update($id, $validatedData);

            DB::commit();
            return $registerIzinedarPsatpd;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update RegisterIzinedarPsatpd in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete RegisterIzinedarPsatpd
     * =============================================
     */
    public function deleteRegisterIzinedarPsatpd($registerIzinedarPsatpdId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->registerIzinedarPsatpdRepository->deleteRegisterIzinedarPsatpdById($registerIzinedarPsatpdId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete RegisterIzinedarPsatpd with id $registerIzinedarPsatpdId: {$exception->getMessage()}");
            return false;
        }
    }
}
