<?php

namespace App\Services;

use App\Models\WorkflowAttachment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\WorkflowAttachmentRepository;

class WorkflowAttachmentService
{
    private $workflowAttachmentRepository;

    public function __construct(WorkflowAttachmentRepository $workflowAttachmentRepository)
    {
        $this->workflowAttachmentRepository = $workflowAttachmentRepository;
    }

    public function listAllAttachments($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->workflowAttachmentRepository->getAllAttachments($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getAttachmentDetail($attachmentId): ?WorkflowAttachment
    {
        return $this->workflowAttachmentRepository->getAttachmentById($attachmentId);
    }

    public function addNewAttachment(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $attachment = $this->workflowAttachmentRepository->createAttachment($validatedData);
            DB::commit();
            return $attachment;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new WorkflowAttachment to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateAttachment(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $attachment = WorkflowAttachment::findOrFail($id);
            $this->workflowAttachmentRepository->update($id, $validatedData);
            DB::commit();
            return $attachment;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update WorkflowAttachment in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteAttachment($attachmentId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->workflowAttachmentRepository->deleteAttachmentById($attachmentId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete WorkflowAttachment with id $attachmentId: {$exception->getMessage()}");
            return false;
        }
    }
}
