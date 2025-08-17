<?php

namespace App\Repositories;

use App\Models\BatasCemaranLogamBerat;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterCemaranLogamBerat;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class BatasCemaranLogamBeratRepository
{
    public function getAllBatasCemaranLogamBerats(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $queryResult = BatasCemaranLogamBerat::query()
            ->with(['jenisPangan', 'cemaranLogamBerat']);

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereHas('jenisPangan', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_jenis_pangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereHas('cemaranLogamBerat', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_cemaran_logam_berat) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereRaw('lower(keterangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isBatasCemaranLogamBeratExist(string $jenis_psat, string $cemaran_logam_berat)
    {
        return BatasCemaranLogamBerat::where('jenis_psat', $jenis_psat)
            ->where('cemaran_logam_berat', $cemaran_logam_berat)
            ->exists();
    }

    public function getBatasCemaranLogamBeratById($batasCemaranLogamBeratId): ?BatasCemaranLogamBerat
    {
        return BatasCemaranLogamBerat::with(['jenisPangan', 'cemaranLogamBerat'])->find($batasCemaranLogamBeratId);
    }

    public function createBatasCemaranLogamBerat($data)
    {
        return BatasCemaranLogamBerat::create($data);
    }

    public function update($batasCemaranLogamBeratId, $data)
    {
        $batasCemaranLogamBeratProfile = BatasCemaranLogamBerat::where('id', $batasCemaranLogamBeratId)->first();
        if ($batasCemaranLogamBeratProfile) {
            $batasCemaranLogamBeratProfile->update($data);
            return $batasCemaranLogamBeratProfile;
        } else {
            throw new Exception("Batas Cemaran Logam Berat not found");
        }
    }

    public function deleteBatasCemaranLogamBeratById($batasCemaranLogamBeratId): ?bool
    {
        try {
            $batasCemaranLogamBerat = BatasCemaranLogamBerat::findOrFail($batasCemaranLogamBeratId);
            $batasCemaranLogamBerat->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getAllJenisPangan()
    {
        return MasterJenisPanganSegar::where('is_active', 1)->get();
    }

    public function getAllCemaranLogamBerat()
    {
        return MasterCemaranLogamBerat::where('is_active', 1)->get();
    }
}
