<?php

namespace App\Repositories;

use App\Models\WorkflowAction;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkflowActionRepository
{
    public function getAllActions(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $query = WorkflowAction::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy("is_active", "desc");
        }

        if (!is_null($keyword)) {
            $query->whereRaw('lower(action_type) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(description) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $query->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getActionById($actionId): ?WorkflowAction
    {
        return WorkflowAction::find($actionId);
    }

    public function createAction($data)
    {
        return WorkflowAction::create($data);
    }

    public function update($actionId, $data)
    {
        $action = WorkflowAction::where('id', $actionId)->first();
        if ($action) {
            $action->update($data);
            return $action;
        } else {
            throw new Exception("WorkflowAction not found");
        }
    }

    public function deleteActionById($actionId): ?bool
    {
        try {
            $action = WorkflowAction::findOrFail($actionId);
            $action->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
