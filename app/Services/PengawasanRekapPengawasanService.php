<?php

namespace App\Services;

use App\Models\PengawasanRekapPengawasan;
use App\Models\PengawasanRekap;
use App\Models\Pengawasan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PengawasanRekapPengawasanRepository;

class PengawasanRekapPengawasanService
{
    private $pengawasanRekapPengawasanRepository;

    public function __construct(PengawasanRekapPengawasanRepository $pengawasanRekapPengawasanRepository)
    {
        $this->pengawasanRekapPengawasanRepository = $pengawasanRekapPengawasanRepository;
    }

    public function getAllRekapPengawasan()
    {
        return $this->pengawasanRekapPengawasanRepository->getAllRekapPengawasan();
    }

    public function getRekapPengawasanDetail($id)
    {
        return $this->pengawasanRekapPengawasanRepository->getRekapPengawasanById($id);
    }

    public function addNewRekapPengawasan(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $rekapPengawasan = $this->pengawasanRekapPengawasanRepository->createRekapPengawasan($validatedData);
            DB::commit();
            return $rekapPengawasan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new rekap pengawasan to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateRekapPengawasan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $rekapPengawasan = $this->pengawasanRekapPengawasanRepository->updateRekapPengawasan($id, $validatedData);
            DB::commit();
            return $rekapPengawasan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update rekap pengawasan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteRekapPengawasan($id): ?bool
    {
        return $this->pengawasanRekapPengawasanRepository->deleteRekapPengawasan($id);
    }

    public function getRekapPengawasanByRekapId($rekapId)
    {
        return $this->pengawasanRekapPengawasanRepository->getRekapPengawasanByRekapId($rekapId);
    }

    public function getRekapPengawasanByPengawasanId($pengawasanId)
    {
        return $this->pengawasanRekapPengawasanRepository->getRekapPengawasanByPengawasanId($pengawasanId);
    }

    public function linkPengawasanToRekap($pengawasanId, $rekapId)
    {
        return $this->pengawasanRekapPengawasanRepository->linkPengawasanToRekap($pengawasanId, $rekapId);
    }

    public function unlinkPengawasanFromRekap($pengawasanId, $rekapId)
    {
        return $this->pengawasanRekapPengawasanRepository->unlinkPengawasanFromRekap($pengawasanId, $rekapId);
    }

    public function unlinkAllPengawasanFromRekap($rekapId)
    {
        return $this->pengawasanRekapPengawasanRepository->unlinkAllPengawasanFromRekap($rekapId);
    }

    public function unlinkAllRekapFromPengawasan($pengawasanId)
    {
        return $this->pengawasanRekapPengawasanRepository->unlinkAllRekapFromPengawasan($pengawasanId);
    }

    public function getRekapCountByPengawasanId($pengawasanId)
    {
        return $this->pengawasanRekapPengawasanRepository->getRekapCountByPengawasanId($pengawasanId);
    }

    public function getPengawasanCountByRekapId($rekapId)
    {
        return $this->pengawasanRekapPengawasanRepository->getPengawasanCountByRekapId($rekapId);
    }

    public function getRekapIdsByPengawasanId($pengawasanId)
    {
        return $this->pengawasanRekapPengawasanRepository->getRekapIdsByPengawasanId($pengawasanId);
    }

    public function getPengawasanIdsByRekapId($rekapId)
    {
        return $this->pengawasanRekapPengawasanRepository->getPengawasanIdsByRekapId($rekapId);
    }

    public function isPengawasanLinkedToRekap($pengawasanId, $rekapId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_rekap_id', $rekapId)
            ->where('pengawasan_id', $pengawasanId)
            ->exists();
    }

    public function getRekapsByPengawasanId($pengawasanId)
    {
        $rekapIds = $this->getRekapIdsByPengawasanId($pengawasanId);

        if ($rekapIds->isEmpty()) {
            return collect();
        }

        return PengawasanRekap::whereIn('id', $rekapIds)
            ->with(['admin', 'jenisPsat', 'produkPsat', 'picTindakan'])
            ->get();
    }

    public function getPengawasansByRekapId($rekapId)
    {
        $pengawasanIds = $this->getPengawasanIdsByRekapId($rekapId);

        if ($pengawasanIds->isEmpty()) {
            return collect();
        }

        return Pengawasan::whereIn('id', $pengawasanIds)
            ->with(['initiator', 'jenisPsat', 'produkPsat', 'lokasiKota', 'lokasiProvinsi'])
            ->get();
    }
}
