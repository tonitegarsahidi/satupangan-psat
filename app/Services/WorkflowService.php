<?php

namespace App\Services;

use App\Models\Workflow;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\WorkflowRepository;

class WorkflowService
{
    private $workflowRepository;

    public function __construct(WorkflowRepository $workflowRepository)
    {
        $this->workflowRepository = $workflowRepository;
    }

    public function listAllWorkflows($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->workflowRepository->getAllWorkflows($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getWorkflowDetail($workflowId): ?Workflow
    {
        return $this->workflowRepository->getWorkflowById($workflowId);
    }

    public function checkWorkflowTitleExist(string $title): bool
    {
        return $this->workflowRepository->isTitleExist($title);
    }

    public function addNewWorkflow(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $workflow = $this->workflowRepository->createWorkflow($validatedData);
            DB::commit();
            return $workflow;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new Workflow to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateWorkflow(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $workflow = Workflow::findOrFail($id);
            $this->workflowRepository->update($id, $validatedData);
            DB::commit();
            return $workflow;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update Workflow in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteWorkflow($workflowId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->workflowRepository->deleteWorkflowById($workflowId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete Workflow with id $workflowId: {$exception->getMessage()}");
            return false;
        }
    }
}
