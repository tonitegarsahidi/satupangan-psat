<?php

namespace App\Repositories;

use App\Models\MasterCemaranLogamBerat;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class MasterCemaranLogamBeratRepository
{
    public function getAllCemaranLogamBerats(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $queryResult = MasterCemaranLogamBerat::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_cemaran_logam_berat) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(kode_cemaran_logam_berat) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isCemaranLogamBeratnameExist(string $cemaranLogamBeratname)
    {
        return MasterCemaranLogamBerat::where('nama_cemaran_logam_berat', $cemaranLogamBeratname)->exists();
    }

    public function getCemaranLogamBeratById($cemaranLogamBeratId): ?MasterCemaranLogamBerat
    {
        return MasterCemaranLogamBerat::find($cemaranLogamBeratId);
    }

    public function createCemaranLogamBerat($data)
    {
        return MasterCemaranLogamBerat::create($data);
    }

    public function update($cemaranLogamBeratId, $data)
    {
        $cemaranLogamBeratProfile = MasterCemaranLogamBerat::where('id', $cemaranLogamBeratId)->first();
        if ($cemaranLogamBeratProfile) {
            $cemaranLogamBeratProfile->update($data);
            return $cemaranLogamBeratProfile;
        } else {
            throw new Exception("Cemaran Logam Berat not found");
        }
    }

    public function deleteCemaranLogamBeratById($cemaranLogamBeratId): ?bool
    {
        try {
            $cemaranLogamBerat = MasterCemaranLogamBerat::findOrFail($cemaranLogamBeratId);
            $cemaranLogamBerat->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
