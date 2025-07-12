<?php

namespace App\Http\Controllers;

use App\Services\WorkflowActionService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

class WorkflowActionController extends Controller
{
    private $workflowActionService;
    private $userService;
    private $mainBreadcrumbs;

    public function __construct(WorkflowActionService $workflowActionService, \App\Services\UserService $userService)
    {
        $this->workflowActionService = $workflowActionService;
        $this->userService = $userService;
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.workflow-action.index'),
            'Workflow Action' => route('admin.workflow-action.index'),
        ];
    }

    public function index(Request $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));
        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $actions = $this->workflowActionService->listAllActions($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.workflow-action.index', compact('actions', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request, $workflow_id)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        $users = $this->userService->getAllUsersSortedByName();
        return view('admin.pages.workflow-action.add', compact('breadcrumbs', 'workflow_id', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->all();
        if (empty($validatedData['action_time'])) {
            $validatedData['action_time'] = now();
        }
        // For backward compatibility: if "action" is set but "action_type" is not, use it
        if (empty($validatedData['action_type']) && !empty($validatedData['action'])) {
            $validatedData['action_type'] = $validatedData['action'];
        }
        // For backward compatibility: if "note" is set but "notes" is not, use it
        if (empty($validatedData['notes']) && !empty($validatedData['note'])) {
            $validatedData['notes'] = $validatedData['note'];
        }
        $result = $this->workflowActionService->addNewAction($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data action berhasil ditambahkan')
            : AlertHelper::createAlert('danger', 'Data action gagal ditambahkan');

        if ($result) {
            return redirect()->route('admin.workflow.history', ['id' => $validatedData['workflow_id']])
                ->with(['alerts' => [$alert]]);
        } else {
            return back()->withErrors(['error' => 'Failed to add action'])->withInput();
        }
    }

    public function detail(Request $request)
    {
        $data = $this->workflowActionService->getActionDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);
        return view('admin.pages.workflow-action.detail', compact('breadcrumbs', 'data'));
    }

    public function edit(Request $request, $id)
    {
        $action = $this->workflowActionService->getActionDetail($id);
        $users = $this->userService->getAllUsersSortedByName();
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);
        return view('admin.pages.workflow-action.edit', compact('breadcrumbs', 'action', 'users'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->workflowActionService->updateAction($request->all(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data action berhasil diupdate')
            : AlertHelper::createAlert('danger', 'Data action gagal diupdate');

        return redirect()->route('admin.workflow-action.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(Request $request)
    {
        $data = $this->workflowActionService->getActionDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);
        return view('admin.pages.workflow-action.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(Request $request)
    {
        $action = $this->workflowActionService->getActionDetail($request->id);
        if (!is_null($action)) {
            $result = $this->workflowActionService->deleteAction($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data action berhasil dihapus')
            : AlertHelper::createAlert('danger', 'Oops! gagal dihapus');

        return redirect()->route('admin.workflow-action.index')->with('alerts', [$alert]);
    }
}
