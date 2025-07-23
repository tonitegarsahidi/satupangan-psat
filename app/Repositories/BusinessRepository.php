<?php

namespace App\Repositories;

use App\Models\Business;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class BusinessRepository
{
    public function getAllBusinesses(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $query = Business::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $query->whereRaw('lower(nama_perusahaan) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(alamat_perusahaan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $query->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isBusinessNameExist(string $nama_perusahaan): bool
    {
        return Business::where('nama_perusahaan', $nama_perusahaan)->exists();
    }

    public function getBusinessById($businessId): ?Business
    {
        return Business::find($businessId);
    }

    public function createBusiness($data)
    {
        return Business::create($data);
    }

    public function update($businessId, $data)
    {
        $business = Business::where('id', $businessId)->first();
        if ($business) {
            $business->update($data);
            return $business;
        } else {
            throw new Exception("Business not found");
        }
    }

    public function deleteBusinessById($businessId): ?bool
    {
        try {
            $business = Business::findOrFail($businessId);
            $business->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
