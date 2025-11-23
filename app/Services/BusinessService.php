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

    public function listAllBusiness($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, string $provinsiId = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->businessRepository->getAllBusinesses($perPage, $sortField, $sortOrder, $keyword, $provinsiId);
    }

    public function getBusinessDetail($businessId): ?Business
    {
        $business = $this->businessRepository->getBusinessById($businessId);
        if ($business) {
            $business->load(['provinsi', 'kota', 'jenispsats', 'user.roles', 'creator', 'updater']);
        }
        return $business;
    }

    public function checkBusinessNameExist(string $nama_perusahaan): bool
    {
        return $this->businessRepository->isBusinessNameExist($nama_perusahaan);
    }

    public function addNewBusiness(array $validatedData, array $jenispsatIds = [])
    {
        DB::beginTransaction();
        try {
            $business = $this->businessRepository->createBusiness($validatedData);

            // Attach jenispsat relationships if provided
            if (!empty($jenispsatIds)) {
                $business->jenispsats()->attach($jenispsatIds);
            }

            DB::commit();
            return $business;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new Business to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateBusiness(array $validatedData, $id, $jenispsatIds = [])
    {
        DB::beginTransaction();
        try {
            $business = Business::findOrFail($id);
            $this->businessRepository->update($id, $validatedData);

            // Update jenispsat relationships
            if (!empty($jenispsatIds)) {
                $business->jenispsats()->sync($jenispsatIds);
            }

            DB::commit();
            return $business;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update Business in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateStatus($businessId, $status, $userId)
    {
        DB::beginTransaction();
        try {
            $business = Business::findOrFail($businessId);
            $business->is_active = $status;
            $business->updated_by = $userId;
            $business->save();
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update Business status with id $businessId: {$exception->getMessage()}");
            return false;
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
