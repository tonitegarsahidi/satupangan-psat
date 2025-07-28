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
     * Check if certain nomor_registrasi is exists or not
     * YOU CAN ALSO BLACKLIST some nomor_registrasi in this logic
     * =============================================
     */
    public function checkRegisterIzinedarPsatplExist(string $nomor_registrasi): bool{
        return $this->registerIzinedarPsatplRepository->isRegisterIzinedarPsatplExist($nomor_registrasi);
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
