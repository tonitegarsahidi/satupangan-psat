<?php

namespace App\Services;

use App\Models\PengawasanAttachment;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PengawasanAttachmentRepository;

class PengawasanAttachmentService
{
    private $pengawasanAttachmentRepository;

    public function __construct(PengawasanAttachmentRepository $pengawasanAttachmentRepository)
    {
        $this->pengawasanAttachmentRepository = $pengawasanAttachmentRepository;
    }

    public function listAllAttachments($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->pengawasanAttachmentRepository->getAllAttachments($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getAttachmentDetail($attachmentId): ?PengawasanAttachment
    {
        return $this->pengawasanAttachmentRepository->getAttachmentById($attachmentId);
    }

    public function addNewAttachment(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $attachment = $this->pengawasanAttachmentRepository->createAttachment($validatedData);
            DB::commit();
            return $attachment;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new attachment to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateAttachment(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $attachment = $this->pengawasanAttachmentRepository->update($id, $validatedData);
            DB::commit();
            return $attachment;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update attachment in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteAttachment($attachmentId): ?bool
    {
        return $this->pengawasanAttachmentRepository->delete($attachmentId);
    }

    public function getAttachmentsByLinkedId($linkedId, $linkedType)
    {
        return $this->pengawasanAttachmentRepository->getAttachmentsByLinkedId($linkedId, $linkedType);
    }

    public function getAttachmentsByType($linkedType, int $perPage = 10)
    {
        return $this->pengawasanAttachmentRepository->getAttachmentsByType($linkedType, $perPage);
    }

    public function getAttachmentsByUser($userId, int $perPage = 10)
    {
        return $this->pengawasanAttachmentRepository->getAttachmentsByUser($userId, $perPage);
    }

    public function getAttachmentsByFileType($fileType, int $perPage = 10)
    {
        return $this->pengawasanAttachmentRepository->getAttachmentsByFileType($fileType, $perPage);
    }

    public function deleteByLinkedId($linkedId, $linkedType): ?bool
    {
        return $this->pengawasanAttachmentRepository->deleteByLinkedId($linkedId, $linkedType);
    }

    public function getAttachmentsBySizeRange($minSize, $maxSize, int $perPage = 10)
    {
        return $this->pengawasanAttachmentRepository->getAttachmentsBySizeRange($minSize, $maxSize, $perPage);
    }

    public function getTotalFileSizeByLinkedId($linkedId, $linkedType)
    {
        return $this->pengawasanAttachmentRepository->getTotalFileSizeByLinkedId($linkedId, $linkedType);
    }

    public function getAttachmentCountByLinkedId($linkedId, $linkedType)
    {
        return $this->pengawasanAttachmentRepository->getAttachmentCountByLinkedId($linkedId, $linkedType);
    }

    public function getLinkedTypeOptions()
    {
        return PengawasanAttachment::getLinkedTypeOptions();
    }

    public function getAttachmentTypeLabel($linkedType)
    {
        return PengawasanAttachment::getLinkedTypeLabel($linkedType);
    }
}
