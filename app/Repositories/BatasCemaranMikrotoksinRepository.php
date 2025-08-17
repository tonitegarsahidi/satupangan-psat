<?php

namespace App\Repositories;

use App\Models\BatasCemaranMikrotoksin;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterCemaranMikrotoksin;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class BatasCemaranMikrotoksinRepository
{
    public function getAllBatasCemaranMikrotoksins(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $queryResult = BatasCemaranMikrotoksin::query()
            ->with(['jenisPangan', 'cemaranMikrotoksin']);

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereHas('jenisPangan', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_jenis_pangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereHas('cemaranMikrotoksin', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_cemaran_mikrotoksin) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereRaw('lower(keterangan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isBatasCemaranMikrotoksinExist(string $jenis_psat, string $cemaran_mikrotoksin)
    {
        return BatasCemaranMikrotoksin::where('jenis_psat', $jenis_psat)
            ->where('cemaran_mikrotoksin', $cemaran_mikrotoksin)
            ->exists();
    }

    public function getBatasCemaranMikrotoksinById($batasCemaranMikrotoksinId): ?BatasCemaranMikrotoksin
    {
        return BatasCemaranMikrotoksin::with(['jenisPangan', 'cemaranMikrotoksin'])->find($batasCemaranMikrotoksinId);
    }

    public function createBatasCemaranMikrotoksin($data)
    {
        return BatasCemaranMikrotoksin::create($data);
    }

    public function update($batasCemaranMikrotoksinId, $data)
    {
        $batasCemaranMikrotoksinProfile = BatasCemaranMikrotoksin::where('id', $batasCemaranMikrotoksinId)->first();
        if ($batasCemaranMikrotoksinProfile) {
            $batasCemaranMikrotoksinProfile->update($data);
            return $batasCemaranMikrotoksinProfile;
        } else {
            throw new Exception("Batas Cemaran Mikrotoksin not found");
        }
    }

    public function deleteBatasCemaranMikrotoksinById($batasCemaranMikrotoksinId): ?bool
    {
        try {
            $batasCemaranMikrotoksin = BatasCemaranMikrotoksin::findOrFail($batasCemaranMikrotoksinId);
            $batasCemaranMikrotoksin->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getAllJenisPangan()
    {
        return MasterJenisPanganSegar::where('is_active', 1)->get();
    }

    public function getAllCemaranMikrotoksin()
    {
        return MasterCemaranMikrotoksin::where('is_active', 1)->get();
    }
}
