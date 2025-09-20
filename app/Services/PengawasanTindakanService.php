<?php

namespace App\Services;

use App\Models\PengawasanTindakan;
use App\Models\PengawasanTindakanPic;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanRekap;
use App\Models\PengawasanAttachment;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PengawasanTindakanRepository;
use App\Repositories\PengawasanAttachmentRepository;
use Exception;

class PengawasanTindakanService
{
    private $pengawasanTindakanRepository;
    private $pengawasanTindakanLanjutanDetailService;
    private $pengawasanTindakanLanjutanRepository;
    private $pengawasanTindakanPicRepository;
    private $pengawasanAttachmentRepository;

    public function __construct(
        PengawasanTindakanRepository $pengawasanTindakanRepository,
        PengawasanAttachmentRepository $pengawasanAttachmentRepository,
        PengawasanTindakanLanjutanDetailService $pengawasanTindakanLanjutanDetailService
    ) {
        $this->pengawasanTindakanRepository = $pengawasanTindakanRepository;
        $this->pengawasanAttachmentRepository = $pengawasanAttachmentRepository;
        $this->pengawasanTindakanLanjutanDetailService = $pengawasanTindakanLanjutanDetailService;
    }

    public function listAllTindakan($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->pengawasanTindakanRepository->getAllTindakan($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getTindakanDetail($tindakanId): ?PengawasanTindakan
    {
        return $this->pengawasanTindakanRepository->getTindakanById($tindakanId);
    }

    public function addNewTindakan(array $validatedData, array $tindakanLanjutanData = [])
    {
        DB::beginTransaction();
        try {
            $tindakan = $this->pengawasanTindakanRepository->createTindakan($validatedData);

            // Link PICs to tindakan (old method - for backward compatibility)
            if (isset($validatedData['pic_tindakan_ids']) && is_array($validatedData['pic_tindakan_ids'])) {
                foreach ($validatedData['pic_tindakan_ids'] as $picId) {
                    $this->pengawasanTindakanRepository->linkPicToTindakan($tindakan->id, $picId);
                }
            }

            // Create tindakan lanjutan if data exists
            if (!empty($tindakanLanjutanData)) {
                foreach ($tindakanLanjutanData as $lanjutanItem) {
                    $lanjutanItem['pengawasan_tindakan_id'] = $tindakan->id;
                    $this->pengawasanTindakanLanjutanRepository->createTindakanLanjutanDetail($lanjutanItem);
                }
            }

            DB::commit();
            return $tindakan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new tindakan to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateTindakan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $tindakan = $this->pengawasanTindakanRepository->updateTindakan($id, $validatedData);

            // Update PICs
            if (isset($validatedData['pic_tindakan_ids']) && is_array($validatedData['pic_tindakan_ids'])) {
                // Delete existing PIC links
                $this->pengawasanTindakanRepository->deletePicsByTindakanId($tindakan->id);

                // Create new PIC links
                foreach ($validatedData['pic_tindakan_ids'] as $picId) {
                    $this->pengawasanTindakanRepository->linkPicToTindakan($tindakan->id, $picId);
                }
            }

            DB::commit();
            return $tindakan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update tindakan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteTindakan($tindakanId): ?bool
    {
        DB::beginTransaction();
        try {
            // Delete related records first
            $this->pengawasanTindakanRepository->deletePicsByTindakanId($tindakanId);

            if ($tindakan = $this->pengawasanTindakanRepository->getTindakanById($tindakanId)) {
                // Delete tindakan lanjutan if exists
                if ($tindakan->tindakanLanjutan) {
                    $this->pengawasanTindakanLanjutanRepository->delete($tindakan->tindakanLanjutan->id);
                }

                // Delete attachments
                $this->pengawasanAttachmentRepository->deleteByLinkedId($tindakanId, 'TINDAKAN');
            }

            $result = $this->pengawasanTindakanRepository->delete($tindakanId);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete tindakan with id $tindakanId: {$exception->getMessage()}");
            return false;
        }
    }

    public function getTindakanByRekapId($rekapId)
    {
        return $this->pengawasanTindakanRepository->getTindakanByRekapId($rekapId);
    }

    public function getTindakanByPimpinan($pimpinanId, int $perPage = 10)
    {
        return $this->pengawasanTindakanRepository->getTindakanByPimpinan($pimpinanId, $perPage);
    }

    public function getTindakanByPIC($picId, int $perPage = 10)
    {
        return $this->pengawasanTindakanRepository->getTindakanByPIC($picId, $perPage);
    }

    public function getTindakanByStatus($status, int $perPage = 10)
    {
        return $this->pengawasanTindakanRepository->getTindakanByStatus($status, $perPage);
    }

    public function linkPicToTindakan($tindakanId, $picId)
    {
        return $this->pengawasanTindakanRepository->linkPicToTindakan($tindakanId, $picId);
    }

    public function deletePicsByTindakanId($tindakanId)
    {
        return $this->pengawasanTindakanRepository->deletePicsByTindakanId($tindakanId);
    }

    public function getPicsByTindakanId($tindakanId)
    {
        return $this->pengawasanTindakanRepository->getPicsByTindakanId($tindakanId);
    }

    public function deleteByRekapId($rekapId): ?bool
    {
        return $this->pengawasanTindakanRepository->deleteByRekapId($rekapId);
    }

    public function getTindakanWithLanjutan()
    {
        return $this->pengawasanTindakanRepository->getTindakanWithLanjutan();
    }

    public function getStatusOptions()
    {
        return PengawasanTindakan::getStatusOptions();
    }

    public function getTindakanAttachments($tindakanId)
    {
        return $this->pengawasanTindakanRepository->getTindakanAttachments($tindakanId);
    }

    public function createTindakanLanjutanForTindakan($tindakanId, array $lanjutanData)
    {
        DB::beginTransaction();
        try {
            // Check if tindakan already has lanjutan
            $tindakan = $this->pengawasanTindakanRepository->getTindakanById($tindakanId);

            if (!$tindakan) {
                throw new Exception("Tindakan not found");
            }

            if ($tindakan->tindakanLanjutan) {
                // Update existing lanjutan
                $lanjutan = $this->pengawasanTindakanLanjutanDetailService->updateDetail($tindakan->tindakanLanjutan->id, $lanjutanData);
            } else {
                // Create new lanjutan
                $lanjutanData['pengawasan_tindakan_id'] = $tindakanId;
                $lanjutan = $this->pengawasanTindakanLanjutanDetailService->createDetail($tindakanId, $lanjutanData);
            }

            DB::commit();
            return null; // Temporarily return null until repository is implemented
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to create/update tindakan lanjutan for tindakan $tindakanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteTindakanLanjutan($tindakanLanjutanId): ?bool
    {
        // return $this->pengawasanTindakanLanjutanRepository->delete($tindakanLanjutanId);
        return false; // Temporarily return false until repository is implemented
    }

    public function addAttachmentToTindakan($tindakanId, array $attachmentData)
    {
        DB::beginTransaction();
        try {
            $attachmentData['linked_id'] = $tindakanId;
            $attachmentData['linked_type'] = 'TINDAKAN';
            $attachment = $this->pengawasanAttachmentRepository->createAttachment($attachmentData);

            DB::commit();
            return $attachment;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to add attachment to tindakan $tindakanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function removeAttachmentFromTindakan($attachmentId)
    {
        // return $this->pengawasanAttachmentRepository->deleteAttachment($attachmentId);
        return false; // Temporarily return false until repository is implemented
    }
}
