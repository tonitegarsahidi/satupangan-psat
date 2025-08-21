<?php

namespace App\Services;

use App\Models\PengawasanTindakanPic;
use App\Models\PengawasanTindakan;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PengawasanTindakanPicRepository;
use Exception;

class PengawasanTindakanPicService
{
    private $pengawasanTindakanPicRepository;

    public function __construct(PengawasanTindakanPicRepository $pengawasanTindakanPicRepository)
    {
        $this->pengawasanTindakanPicRepository = $pengawasanTindakanPicRepository;
    }

    public function listAllTindakanPic($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->pengawasanTindakanPicRepository->getAllTindakanPic($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getTindakanPicDetail($tindakanId, $picId)
    {
        return $this->pengawasanTindakanPicRepository->getTindakanPicById($tindakanId, $picId);
    }

    public function assignPICToTindakan($tindakanId, $picId)
    {
        DB::beginTransaction();
        try {
            // Check if already assigned
            if ($this->pengawasanTindakanPicRepository->isPICAssignedToTindakan($tindakanId, $picId)) {
                throw new Exception("PIC is already assigned to this tindakan");
            }

            $tindakanPic = $this->pengawasanTindakanPicRepository->createTindakanPic([
                'tindakan_id' => $tindakanId,
                'pic_id' => $picId
            ]);

            DB::commit();
            return $tindakanPic;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to assign PIC $picId to tindakan $tindakanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function removePICFromTindakan($tindakanId, $picId): ?bool
    {
        return $this->pengawasanTindakanPicRepository->delete($tindakanId, $picId);
    }

    public function getPICsByTindakanId($tindakanId)
    {
        return $this->pengawasanTindakanPicRepository->getPICsByTindakanId($tindakanId);
    }

    public function getTindakansByPICId($picId, int $perPage = 10)
    {
        return $this->pengawasanTindakanPicRepository->getTindakansByPICId($picId, $perPage);
    }

    public function isPICAssignedToTindakan($tindakanId, $picId)
    {
        return $this->pengawasanTindakanPicRepository->isPICAssignedToTindakan($tindakanId, $picId);
    }

    public function removePICsFromTindakan($tindakanId): ?bool
    {
        return $this->pengawasanTindakanPicRepository->deleteByTindakanId($tindakanId);
    }

    public function removePICFromAllTindakan($picId): ?bool
    {
        return $this->pengawasanTindakanPicRepository->deleteByPICId($picId);
    }

    public function getTindakanCountByPICId($picId)
    {
        return $this->pengawasanTindakanPicRepository->getTindakanCountByPICId($picId);
    }

    public function getPICCountByTindakanId($tindakanId)
    {
        return $this->pengawasanTindakanPicRepository->getPICCountByTindakanId($tindakanId);
    }

    public function getPICIdsByTindakanId($tindakanId)
    {
        return $this->pengawasanTindakanPicRepository->getPICIdsByTindakanId($tindakanId);
    }

    public function getTindakanIdsByPICId($picId)
    {
        return $this->pengawasanTindakanPicRepository->getTindakanIdsByPICId($picId);
    }

    public function getAvailablePICs(int $perPage = 10)
    {
        return $this->pengawasanTindakanPicRepository->getAvailablePICs($perPage);
    }

    public function assignMultiplePICsToTindakan($tindakanId, array $picIds)
    {
        DB::beginTransaction();
        try {
            // First, remove all existing PICs for this tindakan
            $this->removePICsFromTindakan($tindakanId);

            // Then assign the new PICs
            foreach ($picIds as $picId) {
                $this->assignPICToTindakan($tindakanId, $picId);
            }

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to assign multiple PICs to tindakan $tindakanId: {$exception->getMessage()}");
            return false;
        }
    }

    public function getPICDetails($picId)
    {
        return User::find($picId);
    }

    public function getTindakanDetails($tindakanId)
    {
        return PengawasanTindakan::with([
            'rekap',
            'rekap.pengawasan',
            'pimpinan',
            'picTindakans',
            'picTindakans.pic',
            'tindakanLanjutan',
            'tindakanLanjutan.pic'
        ])->find($tindakanId);
    }
}
