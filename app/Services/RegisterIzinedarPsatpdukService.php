<?php

namespace App\Services;

use App\Models\RegisterIzinedarPsatpduk;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\RegisterIzinedarPsatpdukRepository;

class RegisterIzinedarPsatpdukService
{
    private $registerIzinedarPsatpdukRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(RegisterIzinedarPsatpdukRepository $registerIzinedarPsatpdukRepository)
    {
        $this->registerIzinedarPsatpdukRepository = $registerIzinedarPsatpdukRepository;
    }

    /**
     * =============================================
     *  list all RegisterIzinedarPsatpduk along with filter, sort, etc
     * =============================================
     */
    public function listAllRegisterIzinedarPsatpduk($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, $user = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->registerIzinedarPsatpdukRepository->getAllRegisterIzinedarPsatpduks($perPage, $sortField, $sortOrder, $keyword, $user);
    }

    /**
     * =============================================
     * get single RegisterIzinedarPsatpduk data
     * =============================================
     */
    public function getRegisterIzinedarPsatpdukDetail($registerIzinedarPsatpdukId): ?RegisterIzinedarPsatpduk
    {
        return $this->registerIzinedarPsatpdukRepository->getRegisterIzinedarPsatpdukById($registerIzinedarPsatpdukId);
    }

    /**
     * =============================================
     * Check if certain nomor_izinedar_pduk is exists or not
     * YOU CAN ALSO BLACKLIST some nomor_izinedar_pduk in this logic
     * =============================================
     */
    public function checkRegisterIzinedarPsatpdukExist(string $nomor_izinedar_pduk): bool{
        return $this->registerIzinedarPsatpdukRepository->isRegisterIzinedarPsatpdukExist($nomor_izinedar_pduk);
    }

    /**
     * =============================================
     * process add new RegisterIzinedarPsatpduk to database
     * =============================================
     */
    public function addNewRegisterIzinedarPsatpduk(array $validatedData)
    {
        DB::beginTransaction();
        try {
            // Set default values for file fields if not provided
            $validatedData['file_nib'] = $validatedData['file_nib'] ?? null;
            $validatedData['file_sppb'] = $validatedData['file_sppb'] ?? null;
            $validatedData['file_izinedar_psatpduk'] = $validatedData['file_izinedar_psatpduk'] ?? null;

            $registerIzinedarPsatpduk = $this->registerIzinedarPsatpdukRepository->createRegisterIzinedarPsatpduk($validatedData);

            DB::commit();
            return $registerIzinedarPsatpduk;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new RegisterIzinedarPsatpduk to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update RegisterIzinedarPsatpduk data
     * =============================================
     */
    public function updateRegisterIzinedarPsatpduk(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $registerIzinedarPsatpduk = RegisterIzinedarPsatpduk::findOrFail($id);

            // Preserve existing file paths if not provided in the update
            if (!isset($validatedData['file_nib'])) {
                $validatedData['file_nib'] = $registerIzinedarPsatpduk->file_nib;
            }
            if (!isset($validatedData['file_sppb'])) {
                $validatedData['file_sppb'] = $registerIzinedarPsatpduk->file_sppb;
            }
            if (!isset($validatedData['file_izinedar_psatpduk'])) {
                $validatedData['file_izinedar_psatpduk'] = $registerIzinedarPsatpduk->file_izinedar_psatpduk;
            }

            // Preserve existing photo paths if not provided in the update
            for ($i = 1; $i <= 6; $i++) {
                $photoField = 'foto_' . $i;
                if (!isset($validatedData[$photoField])) {
                    $validatedData[$photoField] = $registerIzinedarPsatpduk->$photoField;
                }
            }

            $this->registerIzinedarPsatpdukRepository->update($id, $validatedData);

            DB::commit();
            return $registerIzinedarPsatpduk;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update RegisterIzinedarPsatpduk in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete RegisterIzinedarPsatpduk
     * =============================================
     */
    public function deleteRegisterIzinedarPsatpduk($registerIzinedarPsatpdukId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->registerIzinedarPsatpdukRepository->deleteRegisterIzinedarPsatpdukById($registerIzinedarPsatpdukId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete RegisterIzinedarPsatpduk with id $registerIzinedarPsatpdukId: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * =============================================
     *      update status
     * =============================================
     */
    public function updateStatus($id, $status, $updatedBy)
    {
        DB::beginTransaction();
        try {
            $registerIzinedarPsatpduk = $this->registerIzinedarPsatpdukRepository->updateStatus($id, $status);
            $registerIzinedarPsatpduk->updated_by = $updatedBy;
            $registerIzinedarPsatpduk->save();

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update status for RegisterIzinedarPsatpduk with id $id: {$exception->getMessage()}");
            return false;
        }
    }
}
