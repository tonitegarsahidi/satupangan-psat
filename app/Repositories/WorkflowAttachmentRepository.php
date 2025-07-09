<?php

namespace App\Repositories;

use App\Models\WorkflowAttachment;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkflowAttachmentRepository
{
    public function getAllAttachments(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $query = WorkflowAttachment::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $query->whereRaw('lower(file_name) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(attachment_type) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $query->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getAttachmentById($attachmentId): ?WorkflowAttachment
    {
        return WorkflowAttachment::find($attachmentId);
    }

    public function createAttachment($data)
    {
        return WorkflowAttachment::create($data);
    }

    public function update($attachmentId, $data)
    {
        $attachment = WorkflowAttachment::where('id', $attachmentId)->first();
        if ($attachment) {
            $attachment->update($data);
            return $attachment;
        } else {
            throw new Exception("WorkflowAttachment not found");
        }
    }

    public function deleteAttachmentById($attachmentId): ?bool
    {
        try {
            $attachment = WorkflowAttachment::findOrFail($attachmentId);
            $attachment->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
