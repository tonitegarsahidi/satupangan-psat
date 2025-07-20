<?php

namespace App\Repositories;

use App\Models\LaporanPengaduan;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanPengaduanRepository
{
    public function getAllLaporanPengaduan(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null,   string $userId = null): LengthAwarePaginator
    {
        $queryResult = LaporanPengaduan::query();

        // dd($userId);

        // Filter berdasarkan user_id jika diberikan
        if (!is_null($userId)) {
            $queryResult->where('user_id', $userId);
        }

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nama_pelapor) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(isi_laporan) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isLaporanExist(string $namaPelapor, string $isiLaporan)
    {
        return LaporanPengaduan::where('nama_pelapor', $namaPelapor)
            ->where('isi_laporan', $isiLaporan)
            ->exists();
    }

    public function getLaporanById($laporanId): ?LaporanPengaduan
    {
        return LaporanPengaduan::with([
            'workflow',
            'workflow.threads.user',
            'workflow.actions.user'
        ])->find($laporanId);
    }

    public function createLaporan($data)
    {
        return LaporanPengaduan::create($data);
    }

    public function update($laporanId, $data)
    {
        $laporan = LaporanPengaduan::where('id', $laporanId)->first();
        if ($laporan) {
            $laporan->update($data);
            return $laporan;
        } else {
            throw new Exception("Laporan Pengaduan not found");
        }
    }

    public function deleteLaporanById($laporanId): ?bool
    {
        try {
            $laporan = LaporanPengaduan::findOrFail($laporanId);
            $laporan->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
