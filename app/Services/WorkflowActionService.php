<?php

namespace App\Services;

use App\Models\WorkflowAction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\WorkflowActionRepository;

class WorkflowActionService
{
    private $workflowActionRepository;

    public function __construct(WorkflowActionRepository $workflowActionRepository)
    {
        $this->workflowActionRepository = $workflowActionRepository;
    }

    public function listAllActions($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->workflowActionRepository->getAllActions($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getActionDetail($actionId): ?WorkflowAction
    {
        return $this->workflowActionRepository->getActionById($actionId);
    }

    public function addNewAction(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $action = $this->workflowActionRepository->createAction($validatedData);
            DB::commit();
            return $action;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new WorkflowAction to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateAction(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $action = WorkflowAction::findOrFail($id);
            $this->workflowActionRepository->update($id, $validatedData);
            DB::commit();
            return $action;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update WorkflowAction in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteAction($actionId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->workflowActionRepository->deleteActionById($actionId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete WorkflowAction with id $actionId: {$exception->getMessage()}");
            return false;
        }
    }
}
