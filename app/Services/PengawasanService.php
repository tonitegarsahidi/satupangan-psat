<?php

namespace App\Services;

use App\Models\Pengawasan;
use App\Models\PengawasanRekap;
use App\Models\PengawasanAttachment;
use App\Models\PengawasanTindakan;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanTindakanPic;
use App\Models\User;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterKota;
use App\Models\MasterProvinsi;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PengawasanRepository;
use Exception;

class PengawasanService
{
    private $pengawasanRepository;
    private $pengawasanRekapRepository;
    private $pengawasanAttachmentRepository;
    private $pengawasanTindakanRepository;
    private $pengawasanTindakanLanjutanRepository;
    private $pengawasanTindakanPicRepository;

    public function __construct(
        PengawasanRepository $pengawasanRepository
    ) {
        $this->pengawasanRepository = $pengawasanRepository;
    }

    public function listAllPengawasan($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, $provinsiId = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->pengawasanRepository->getAllPengawasan($perPage, $sortField, $sortOrder, $keyword, $provinsiId);
    }

    public function getPengawasanDetail($pengawasanId, $withItems = false): ?Pengawasan
    {
        return $this->pengawasanRepository->getPengawasanById($pengawasanId, $withItems);
    }

    public function addNewPengawasan(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $pengawasan = $this->pengawasanRepository->createPengawasan($validatedData);
            DB::commit();
            return $pengawasan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new pengawasan to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updatePengawasan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $pengawasan = $this->pengawasanRepository->update($id, $validatedData);
            DB::commit();
            return $pengawasan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update pengawasan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deletePengawasan($pengawasanId): ?bool
    {
        DB::beginTransaction();
        try {
            // Delete related records first
            $this->pengawasanAttachmentRepository->deleteByLinkedId($pengawasanId, 'PENGAWASAN');

            $result = $this->pengawasanRepository->delete($pengawasanId);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete pengawasan with id $pengawasanId: {$exception->getMessage()}");
            return false;
        }
    }

    public function getPengawasanByInitiator($initiatorId, int $perPage = 10)
    {
        return $this->pengawasanRepository->getPengawasanByInitiator($initiatorId, $perPage);
    }

    public function getPengawasanByStatus($status, int $perPage = 10)
    {
        return $this->pengawasanRepository->getPengawasanByStatus($status, $perPage);
    }

    public function getPengawasanByDateRange($startDate, $endDate, int $perPage = 10)
    {
        return $this->pengawasanRepository->getPengawasanByDateRange($startDate, $endDate, $perPage);
    }

    public function getPengawasanWithRekap()
    {
        return $this->pengawasanRepository->getPengawasanWithRekap();
    }

    public function getPengawasanAttachments($pengawasanId)
    {
        return $this->pengawasanRepository->getPengawasanAttachments($pengawasanId);
    }

    public function getPengawasanByJenisPsat($jenisPsatId, int $perPage = 10)
    {
        return $this->pengawasanRepository->getPengawasanByJenisPsat($jenisPsatId, $perPage);
    }

    public function getPengawasanByProdukPsat($produkPsatId, int $perPage = 10)
    {
        return $this->pengawasanRepository->getPengawasanByProdukPsat($produkPsatId, $perPage);
    }

    public function getPengawasanByLocation($kotaId, $provinsiId = null, int $perPage = 10)
    {
        return $this->pengawasanRepository->getPengawasanByLocation($kotaId, $provinsiId, $perPage);
    }

    public function createRekapForPengawasan($pengawasanId, array $rekapData)
    {
        DB::beginTransaction();
        try {
            // Create rekap
            $rekapData['pengawasan_id'] = $pengawasanId;
            // $rekap = $this->pengawasanRekapRepository->createRekap($rekapData);

            // Link pengawasan to rekap
            // This will be implemented when we create the PengawasanRekapRepository

            DB::commit();
            return null; // Temporarily return null until repository is implemented
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to create rekap for pengawasan $pengawasanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateRekapForPengawasan($pengawasanId, array $rekapData)
    {
        DB::beginTransaction();
        try {
            $pengawasan = $this->pengawasanRepository->getPengawasanById($pengawasanId);

            if (!$pengawasan || !$pengawasan->rekap) {
                throw new Exception("Rekap not found for this pengawasan");
            }

            // $rekap = $this->pengawasanRekapRepository->updateRekap($pengawasan->rekap->id, $rekapData);

            DB::commit();
            return null; // Temporarily return null until repository is implemented
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update rekap for pengawasan $pengawasanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function addAttachmentToPengawasan($pengawasanId, array $attachmentData)
    {
        DB::beginTransaction();
        try {
            $attachmentData['linked_id'] = $pengawasanId;
            $attachmentData['linked_type'] = 'PENGAWASAN';
            // $attachment = $this->pengawasanAttachmentRepository->createAttachment($attachmentData);

            DB::commit();
            return null; // Temporarily return null until repository is implemented
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to add attachment to pengawasan $pengawasanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function removeAttachmentFromPengawasan($attachmentId)
    {
        // return $this->pengawasanAttachmentRepository->deleteAttachment($attachmentId);
        return false; // Temporarily return false until repository is implemented
    }

    public function getStatusOptions()
    {
        return Pengawasan::getStatusOptions();
    }

    public function getRekapStatusOptions()
    {
        return PengawasanRekap::getStatusOptions();
    }

    public function getTindakanStatusOptions()
    {
        return PengawasanTindakan::getStatusOptions();
    }

    public function getTindakanLanjutanStatusOptions()
    {
        return PengawasanTindakanLanjutan::getStatusOptions();
    }

    public function getAttachmentTypeOptions()
    {
        return PengawasanAttachment::getLinkedTypeOptions();
    }
}
