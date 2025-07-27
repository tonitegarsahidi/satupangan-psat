<?php

namespace App\Services;

use App\Models\RegisterSppb;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\RegisterSppbRepository;


class RegisterSppbService
{
    private $RegisterSppbRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(RegisterSppbRepository $RegisterSppbRepository)
    {
        $this->RegisterSppbRepository = $RegisterSppbRepository;
    }

    /**
     * =============================================
     *  list all RegisterSppb along with filter, sort, etc
     * =============================================
     */
    public function listAllRegisterSppb($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->RegisterSppbRepository->getAllRegisterSppbs($perPage, $sortField, $sortOrder, $keyword);
    }

    /**
     * =============================================
     * get single RegisterSppb data
     * =============================================
     */
    public function getRegisterSppbDetail($registerSppbId): ?RegisterSppb
    {
        return $this->RegisterSppbRepository->getRegisterSppbById($registerSppbId);
    }


    /**
     * =============================================
     * Check if certain nomor_registrasi is exists or not
     * YOU CAN ALSO BLACKLIST some nomor_registrasi in this logic
     * =============================================
     */
    public function checkRegisterSppbExist(string $nomor_registrasi): bool{
        return $this->RegisterSppbRepository->isRegisterSppbExist($nomor_registrasi);
    }

    /**
     * =============================================
     * process add new RegisterSppb to database
     * =============================================
     */
    public function addNewRegisterSppb(array $validatedData, array $jenispsatIds = [])
    {
        DB::beginTransaction();
        try {
            $registerSppb = $this->RegisterSppbRepository->createRegisterSppb($validatedData);

            // Attach the jenispsat relationships
            if (!empty($jenispsatIds)) {
                $registerSppb->jenispsats()->sync($jenispsatIds);
            }

            DB::commit();
            return $registerSppb;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new RegisterSppb to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update RegisterSppb data
     * =============================================
     */
    public function updateRegisterSppb(array $validatedData, $id, array $jenispsatIds = [])
    {
        DB::beginTransaction();
        try {
            $registerSppb = RegisterSppb::findOrFail($id);

            $this->RegisterSppbRepository->update($id, $validatedData);

            // Update the jenispsat relationships
            if (!empty($jenispsatIds)) {
                $registerSppb->jenispsats()->sync($jenispsatIds);
            }

            DB::commit();
            return $registerSppb;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update RegisterSppb in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete RegisterSppb
     * =============================================
     */
    public function deleteRegisterSppb($registerSppbId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->RegisterSppbRepository->deleteRegisterSppbById($registerSppbId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete RegisterSppb with id $registerSppbId: {$exception->getMessage()}");
            return false;
        }
    }
}
