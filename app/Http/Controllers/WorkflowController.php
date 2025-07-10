<?php

namespace App\Http\Controllers;

use App\Services\WorkflowService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
// use App\Http\Requests\Workflow\WorkflowAddRequest;
// use App\Http\Requests\Workflow\WorkflowEditRequest;
// use App\Http\Requests\Workflow\WorkflowListRequest;
use Illuminate\Validation\ValidationException;

class WorkflowController extends Controller
{
    private $workflowService;
    private $mainBreadcrumbs;

    public function __construct(WorkflowService $workflowService)
    {
        $this->workflowService = $workflowService;
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.workflow.index'),
            'Workflow' => route('admin.workflow.index'),
        ];
    }

    public function index(Request $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));
        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $workflows = $this->workflowService->listAllWorkflows($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.workflow.index', compact('workflows', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.workflow.add', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->all(); // Ganti dengan $request->validated() jika pakai FormRequest
        if ($this->workflowService->checkWorkflowTitleExist($validatedData["title"])) {
            throw ValidationException::withMessages([
                'title' => 'Judul Workflow sudah ada sebelumnya.'
            ]);
        }
        $result = $this->workflowService->addNewWorkflow($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->title . ' failed to be added');

        return redirect()->route('admin.workflow.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    public function detail(Request $request)
    {
        $data = $this->workflowService->getWorkflowDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);
        return view('admin.pages.workflow.detail', compact('breadcrumbs', 'data'));
    }

    public function edit(Request $request, $id)
    {
        $workflow = $this->workflowService->getWorkflowDetail($id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);
        return view('admin.pages.workflow.edit', compact('breadcrumbs', 'workflow'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->workflowService->updateWorkflow($request->all(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->title . ' failed to be updated');

        return redirect()->route('admin.workflow.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(Request $request)
    {
        $data = $this->workflowService->getWorkflowDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);
        return view('admin.pages.workflow.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(Request $request)
    {
        $workflow = $this->workflowService->getWorkflowDetail($request->id);
        if (!is_null($workflow)) {
            $result = $this->workflowService->deleteWorkflow($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $workflow->title . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.workflow.index')->with('alerts', [$alert]);
    }
    public function history(Request $request, $id)
    {
        $historyData = $this->workflowService->getWorkflowHistoryData($id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['History' => null]);
        return view('admin.pages.workflow.history', [
            'breadcrumbs' => $breadcrumbs,
            'workflow' => $historyData['workflow'],
            'historyItems' => $historyData['historyItems'],
        ]);
    }
}
