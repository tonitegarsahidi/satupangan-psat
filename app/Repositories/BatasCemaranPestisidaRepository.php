<?php

namespace App\Repositories;

use App\Models\BatasCemaranPestisida;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterCemaranPestisida;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class BatasCemaranPestisidaRepository
{
    public function getAllBatasCemaranPestisidas(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $queryResult = BatasCemaranPestisida::query()
            ->with(['jenisPangan', 'cemaranPestisida']);

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereHas('jenisPangan', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_jenis_pangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereHas('cemaranPestisida', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_cemaran_pestisida) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereRaw('lower(keterangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isBatasCemaranPestisidaExist(string $jenis_psat, string $cemaran_pestisida)
    {
        return BatasCemaranPestisida::where('jenis_psat', $jenis_psat)
            ->where('cemaran_pestisida', $cemaran_pestisida)
            ->exists();
    }

    public function getBatasCemaranPestisidaById($batasCemaranPestisidaId): ?BatasCemaranPestisida
    {
        return BatasCemaranPestisida::with(['jenisPangan', 'cemaranPestisida'])->find($batasCemaranPestisidaId);
    }

    public function createBatasCemaranPestisida($data)
    {
        return BatasCemaranPestisida::create($data);
    }

    public function update($batasCemaranPestisidaId, $data)
    {
        $batasCemaranPestisidaProfile = BatasCemaranPestisida::where('id', $batasCemaranPestisidaId)->first();
        if ($batasCemaranPestisidaProfile) {
            $batasCemaranPestisidaProfile->update($data);
            return $batasCemaranPestisidaProfile;
        } else {
            throw new Exception("Batas Cemaran Pestisida not found");
        }
    }

    public function deleteBatasCemaranPestisidaById($batasCemaranPestisidaId): ?bool
    {
        try {
            $batasCemaranPestisida = BatasCemaranPestisida::findOrFail($batasCemaranPestisidaId);
            $batasCemaranPestisida->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getAllJenisPangan()
    {
        return MasterJenisPanganSegar::where('is_active', 1)->get();
    }

    public function getAllCemaranPestisida()
    {
        return MasterCemaranPestisida::where('is_active', 1)->get();
    }
}
