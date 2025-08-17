<?php

namespace App\Repositories;

use App\Models\BatasCemaranMikroba;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterCemaranMikroba;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class BatasCemaranMikrobaRepository
{
    public function getAllBatasCemaranMikrobas(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $queryResult = BatasCemaranMikroba::query()
            ->with(['jenisPangan', 'cemaranMikroba']);

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereHas('jenisPangan', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_jenis_pangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereHas('cemaranMikroba', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_cemaran_mikroba) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereRaw('lower(keterangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isBatasCemaranMikrobaExist(string $jenis_psat, string $cemaran_mikroba)
    {
        return BatasCemaranMikroba::where('jenis_psat', $jenis_psat)
            ->where('cemaran_mikroba', $cemaran_mikroba)
            ->exists();
    }

    public function getBatasCemaranMikrobaById($batasCemaranMikrobaId): ?BatasCemaranMikroba
    {
        return BatasCemaranMikroba::with(['jenisPangan', 'cemaranMikroba'])->find($batasCemaranMikrobaId);
    }

    public function createBatasCemaranMikroba($data)
    {
        return BatasCemaranMikroba::create($data);
    }

    public function update($batasCemaranMikrobaId, $data)
    {
        $batasCemaranMikrobaProfile = BatasCemaranMikroba::where('id', $batasCemaranMikrobaId)->first();
        if ($batasCemaranMikrobaProfile) {
            $batasCemaranMikrobaProfile->update($data);
            return $batasCemaranMikrobaProfile;
        } else {
            throw new Exception("Batas Cemaran Mikroba not found");
        }
    }

    public function deleteBatasCemaranMikrobaById($batasCemaranMikrobaId): ?bool
    {
        try {
            $batasCemaranMikroba = BatasCemaranMikroba::findOrFail($batasCemaranMikrobaId);
            $batasCemaranMikroba->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getAllJenisPangan()
    {
        return MasterJenisPanganSegar::where('is_active', 1)->get();
    }

    public function getAllCemaranMikroba()
    {
        return MasterCemaranMikroba::where('is_active', 1)->get();
    }
}
