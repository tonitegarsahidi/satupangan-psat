<?php

namespace App\Repositories;

use App\Models\WorkflowThread;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkflowThreadRepository
{
    public function getAllThreads(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $query = WorkflowThread::with(['workflow'])->query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $query->whereRaw('lower(message) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $query->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getThreadById($threadId): ?WorkflowThread
    {
        return WorkflowThread::find($threadId);
    }

    public function createThread($data)
    {
        return WorkflowThread::create($data);
    }

    public function update($threadId, $data)
    {
        $thread = WorkflowThread::where('id', $threadId)->first();
        if ($thread) {
            $thread->update($data);
            return $thread;
        } else {
            throw new Exception("WorkflowThread not found");
        }
    }

    public function deleteThreadById($threadId): ?bool
    {
        try {
            $thread = WorkflowThread::findOrFail($threadId);
            $thread->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
