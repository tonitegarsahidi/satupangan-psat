<?php

namespace App\Http\Controllers;

use App\Services\WorkflowActionService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

class WorkflowActionController extends Controller
{
    private $workflowActionService;
    private $mainBreadcrumbs;

    public function __construct(WorkflowActionService $workflowActionService)
    {
        $this->workflowActionService = $workflowActionService;
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

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.workflow-action.add', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->all();
        $result = $this->workflowActionService->addNewAction($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data action berhasil ditambahkan')
            : AlertHelper::createAlert('danger', 'Data action gagal ditambahkan');

        return redirect()->route('admin.workflow-action.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
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
        $users = \App\Models\User::orderBy('name')->get();
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
