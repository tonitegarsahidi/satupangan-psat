<?php

namespace App\Repositories;

use App\Models\Workflow;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkflowRepository
{
    public function getAllWorkflows(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $query = Workflow::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $query->whereRaw('lower(title) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(category) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $query->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isTitleExist(string $title)
    {
        return Workflow::where('title', $title)->exists();
    }

    public function getWorkflowById($workflowId): ?Workflow
    {
        return Workflow::find($workflowId);
    }

    public function createWorkflow($data)
    {
        return Workflow::create($data);
    }

    public function update($workflowId, $data)
    {
        $workflow = Workflow::where('id', $workflowId)->first();
        if ($workflow) {
            $workflow->update($data);
            return $workflow;
        } else {
            throw new Exception("Workflow not found");
        }
    }

    public function deleteWorkflowById($workflowId): ?bool
    {
        try {
            $workflow = Workflow::findOrFail($workflowId);
            $workflow->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
