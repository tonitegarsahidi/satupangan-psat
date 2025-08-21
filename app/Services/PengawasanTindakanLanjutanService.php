<?php

namespace App\Services;

use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanTindakan;
use App\Models\PengawasanAttachment;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PengawasanTindakanLanjutanRepository;
use App\Repositories\PengawasanAttachmentRepository;

class PengawasanTindakanLanjutanService
{
    private $pengawasanTindakanLanjutanRepository;
    private $pengawasanAttachmentRepository;

    public function __construct(
        PengawasanTindakanLanjutanRepository $pengawasanTindakanLanjutanRepository,
        PengawasanAttachmentRepository $pengawasanAttachmentRepository
    ) {
        $this->pengawasanTindakanLanjutanRepository = $pengawasanTindakanLanjutanRepository;
        $this->pengawasanAttachmentRepository = $pengawasanAttachmentRepository;
    }

    public function listAllTindakanLanjutan($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->pengawasanTindakanLanjutanRepository->getAllTindakanLanjutan($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getTindakanLanjutanDetail($lanjutanId): ?PengawasanTindakanLanjutan
    {
        return $this->pengawasanTindakanLanjutanRepository->getTindakanLanjutanById($lanjutanId);
    }

    public function addNewTindakanLanjutan(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $lanjutan = $this->pengawasanTindakanLanjutanRepository->createTindakanLanjutan($validatedData);
            DB::commit();
            return $lanjutan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new tindakan lanjutan to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateTindakanLanjutan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $lanjutan = $this->pengawasanTindakanLanjutanRepository->updateTindakanLanjutan($id, $validatedData);
            DB::commit();
            return $lanjutan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update tindakan lanjutan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteTindakanLanjutan($lanjutanId): ?bool
    {
        DB::beginTransaction();
        try {
            // Delete attachments first
            $this->pengawasanAttachmentRepository->deleteByLinkedId($lanjutanId, 'TINDAKAN_LANJUTAN');

            $result = $this->pengawasanTindakanLanjutanRepository->delete($lanjutanId);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete tindakan lanjutan with id $lanjutanId: {$exception->getMessage()}");
            return false;
        }
    }

    public function getTindakanLanjutanByTindakanId($tindakanId)
    {
        return $this->pengawasanTindakanLanjutanRepository->getTindakanLanjutanByTindakanId($tindakanId);
    }

    public function getTindakanLanjutanByPIC($picId, int $perPage = 10)
    {
        return $this->pengawasanTindakanLanjutanRepository->getTindakanLanjutanByPIC($picId, $perPage);
    }

    public function getTindakanLanjutanByStatus($status, int $perPage = 10)
    {
        return $this->pengawasanTindakanLanjutanRepository->getTindakanLanjutanByStatus($status, $perPage);
    }

    public function getTindakanLanjutanWithTindakan()
    {
        return $this->pengawasanTindakanLanjutanRepository->getTindakanLanjutanWithTindakan();
    }

    public function getTindakanLanjutanAttachments($lanjutanId)
    {
        return $this->pengawasanTindakanLanjutanRepository->getTindakanLanjutanAttachments($lanjutanId);
    }

    public function deleteByTindakanId($tindakanId): ?bool
    {
        return $this->pengawasanTindakanLanjutanRepository->deleteByTindakanId($tindakanId);
    }

    public function getStatusOptions()
    {
        return PengawasanTindakanLanjutan::getStatusOptions();
    }

    public function addAttachmentToTindakanLanjutan($lanjutanId, array $attachmentData)
    {
        DB::beginTransaction();
        try {
            $attachmentData['linked_id'] = $lanjutanId;
            $attachmentData['linked_type'] = 'TINDAKAN_LANJUTAN';
            $attachment = $this->pengawasanAttachmentRepository->createAttachment($attachmentData);

            DB::commit();
            return $attachment;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to add attachment to tindakan lanjutan $lanjutanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function removeAttachmentFromTindakanLanjutan($attachmentId)
    {
        // return $this->pengawasanAttachmentRepository->deleteAttachment($attachmentId);
        return false; // Temporarily return false until repository is implemented
    }
}
