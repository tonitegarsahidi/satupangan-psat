<?php

namespace App\Repositories;

use App\Models\PengawasanAttachment;
use App\Models\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengawasanAttachmentRepository
{
    public function getAllAttachments(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = PengawasanAttachment::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        $queryResult->with([
            'createdBy'
        ]);

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(file_name) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(file_type) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getAttachmentById($attachmentId): ?PengawasanAttachment
    {
        return PengawasanAttachment::with([
            'createdBy'
        ])->find($attachmentId);
    }

    public function createAttachment($data)
    {
        return PengawasanAttachment::create($data);
    }

    public function update($attachmentId, $data)
    {
        $attachment = PengawasanAttachment::findOrFail($attachmentId);
        $attachment->update($data);
        return $attachment;
    }

    public function delete($attachmentId): ?bool
    {
        try {
            $attachment = PengawasanAttachment::findOrFail($attachmentId);
            $attachment->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete attachment with id $attachmentId: {$e->getMessage()}");
            return false;
        }
    }

    public function getAttachmentsByLinkedId($linkedId, $linkedType)
    {
        return PengawasanAttachment::where('linked_id', $linkedId)
            ->where('linked_type', $linkedType)
            ->with([
                'createdBy'
            ])
            ->orderBy("created_at", "desc")
            ->get();
    }

    public function getAttachmentsByType($linkedType, int $perPage = 10)
    {
        return PengawasanAttachment::where('linked_type', $linkedType)
            ->with([
                'createdBy'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getAttachmentsByUser($userId, int $perPage = 10)
    {
        return PengawasanAttachment::where('created_by', $userId)
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getAttachmentsByFileType($fileType, int $perPage = 10)
    {
        return PengawasanAttachment::where('file_type', $fileType)
            ->with([
                'createdBy'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function deleteByLinkedId($linkedId, $linkedType): ?bool
    {
        try {
            PengawasanAttachment::where('linked_id', $linkedId)
                ->where('linked_type', $linkedType)
                ->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete attachments with linked_id $linkedId and linked_type $linkedType: {$e->getMessage()}");
            return false;
        }
    }

    public function getAttachmentsBySizeRange($minSize, $maxSize, int $perPage = 10)
    {
        return PengawasanAttachment::whereBetween('file_size', [$minSize, $maxSize])
            ->with([
                'createdBy'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getTotalFileSizeByLinkedId($linkedId, $linkedType)
    {
        return PengawasanAttachment::where('linked_id', $linkedId)
            ->where('linked_type', $linkedType)
            ->sum('file_size');
    }

    public function getAttachmentCountByLinkedId($linkedId, $linkedType)
    {
        return PengawasanAttachment::where('linked_id', $linkedId)
            ->where('linked_type', $linkedType)
            ->count();
    }
}
