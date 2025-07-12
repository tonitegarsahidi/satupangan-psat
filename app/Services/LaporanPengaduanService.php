<?php

namespace App\Services;

use App\Models\LaporanPengaduan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\LaporanPengaduanRepository;

class LaporanPengaduanService
{
    private $LaporanPengaduanRepository;

    public function __construct(LaporanPengaduanRepository $LaporanPengaduanRepository)
    {
        $this->LaporanPengaduanRepository = $LaporanPengaduanRepository;
    }

    public function listAllLaporanPengaduan($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->LaporanPengaduanRepository->getAllLaporanPengaduan($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getLaporanPengaduanDetail($laporanId): ?LaporanPengaduan
    {
        return $this->LaporanPengaduanRepository->getLaporanById($laporanId);
    }

    public function checkLaporanExist(string $nama_pelapor, string $isi_laporan): bool
    {
        return $this->LaporanPengaduanRepository->isLaporanExist($nama_pelapor, $isi_laporan);
    }

    public function addNewLaporanPengaduan(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $laporan = $this->LaporanPengaduanRepository->createLaporan($validatedData);
            DB::commit();
            return $laporan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new LaporanPengaduan to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateLaporanPengaduan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $laporan = LaporanPengaduan::findOrFail($id);
            $this->LaporanPengaduanRepository->update($id, $validatedData);
            DB::commit();
            return $laporan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update LaporanPengaduan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteLaporanPengaduan($laporanId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->LaporanPengaduanRepository->deleteLaporanById($laporanId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete LaporanPengaduan with id $laporanId: {$exception->getMessage()}");
            return false;
        }
    }
}
