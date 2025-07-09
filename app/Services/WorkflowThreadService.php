<?php

namespace App\Services;

use App\Models\WorkflowThread;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\WorkflowThreadRepository;

class WorkflowThreadService
{
    private $workflowThreadRepository;

    public function __construct(WorkflowThreadRepository $workflowThreadRepository)
    {
        $this->workflowThreadRepository = $workflowThreadRepository;
    }

    public function listAllThreads($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->workflowThreadRepository->getAllThreads($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getThreadDetail($threadId): ?WorkflowThread
    {
        return $this->workflowThreadRepository->getThreadById($threadId);
    }

    public function addNewThread(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $thread = $this->workflowThreadRepository->createThread($validatedData);
            DB::commit();
            return $thread;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new WorkflowThread to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateThread(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $thread = WorkflowThread::findOrFail($id);
            $this->workflowThreadRepository->update($id, $validatedData);
            DB::commit();
            return $thread;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update WorkflowThread in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteThread($threadId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->workflowThreadRepository->deleteThreadById($threadId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete WorkflowThread with id $threadId: {$exception->getMessage()}");
            return false;
        }
    }
}
