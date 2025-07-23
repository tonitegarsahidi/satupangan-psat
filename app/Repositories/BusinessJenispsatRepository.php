<?php

namespace App\Repositories;

use App\Models\BusinessJenispsat;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class BusinessJenispsatRepository
{
    public function getAllBusinessJenispsat(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $query = BusinessJenispsat::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $query->whereHas('business', function($q) use ($keyword) {
                $q->whereRaw('lower(nama_perusahaan) LIKE ?', ['%' . strtolower($keyword) . '%']);
            });
        }

        $paginator = $query->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isRelationExist($business_id, $jenispsat_id): bool
    {
        return BusinessJenispsat::where('business_id', $business_id)
            ->where('jenispsat_id', $jenispsat_id)
            ->exists();
    }

    public function getBusinessJenispsatById($id): ?BusinessJenispsat
    {
        return BusinessJenispsat::find($id);
    }

    public function createBusinessJenispsat($data)
    {
        return BusinessJenispsat::create($data);
    }

    public function update($id, $data)
    {
        $item = BusinessJenispsat::where('id', $id)->first();
        if ($item) {
            $item->update($data);
            return $item;
        } else {
            throw new Exception("BusinessJenispsat not found");
        }
    }

    public function deleteBusinessJenispsatById($id): ?bool
    {
        try {
            $item = BusinessJenispsat::findOrFail($id);
            $item->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
