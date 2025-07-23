<?php

namespace App\Services;

use App\Models\Business;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BusinessRepository;

class BusinessService
{
    private $businessRepository;

    public function __construct(BusinessRepository $businessRepository)
    {
        $this->businessRepository = $businessRepository;
    }

    public function listAllBusiness($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->businessRepository->getAllBusinesses($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getBusinessDetail($businessId): ?Business
    {
        return $this->businessRepository->getBusinessById($businessId);
    }

    public function checkBusinessNameExist(string $nama_perusahaan): bool
    {
        return $this->businessRepository->isBusinessNameExist($nama_perusahaan);
    }

    public function addNewBusiness(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $business = $this->businessRepository->createBusiness($validatedData);
            DB::commit();
            return $business;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new Business to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateBusiness(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $business = Business::findOrFail($id);
            $this->businessRepository->update($id, $validatedData);
            DB::commit();
            return $business;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update Business in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteBusiness($businessId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->businessRepository->deleteBusinessById($businessId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete Business with id $businessId: {$exception->getMessage()}");
            return false;
        }
    }
}
