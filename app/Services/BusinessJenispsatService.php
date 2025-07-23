<?php

namespace App\Services;

use App\Models\BusinessJenispsat;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BusinessJenispsatRepository;

class BusinessJenispsatService
{
    private $businessJenispsatRepository;

    public function __construct(BusinessJenispsatRepository $businessJenispsatRepository)
    {
        $this->businessJenispsatRepository = $businessJenispsatRepository;
    }

    public function listAllBusinessJenispsat($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->businessJenispsatRepository->getAllBusinessJenispsat($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getBusinessJenispsatDetail($id): ?BusinessJenispsat
    {
        return $this->businessJenispsatRepository->getBusinessJenispsatById($id);
    }

    public function checkRelationExist($business_id, $jenispsat_id): bool
    {
        return $this->businessJenispsatRepository->isRelationExist($business_id, $jenispsat_id);
    }

    public function addNewBusinessJenispsat(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $item = $this->businessJenispsatRepository->createBusinessJenispsat($validatedData);
            DB::commit();
            return $item;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new BusinessJenispsat to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateBusinessJenispsat(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $item = BusinessJenispsat::findOrFail($id);
            $this->businessJenispsatRepository->update($id, $validatedData);
            DB::commit();
            return $item;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update BusinessJenispsat in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteBusinessJenispsat($id): ?bool
    {
        DB::beginTransaction();
        try {
            $this->businessJenispsatRepository->deleteBusinessJenispsatById($id);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete BusinessJenispsat with id $id: {$exception->getMessage()}");
            return false;
        }
    }
}
