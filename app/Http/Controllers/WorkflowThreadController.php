<?php

namespace App\Http\Controllers;

use App\Services\WorkflowThreadService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

class WorkflowThreadController extends Controller
{
    private $workflowThreadService;
    private $mainBreadcrumbs;

    public function __construct(WorkflowThreadService $workflowThreadService)
    {
        $this->workflowThreadService = $workflowThreadService;
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.workflow-thread.index'),
            'Workflow Thread' => route('admin.workflow-thread.index'),
        ];
    }

    public function index(Request $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));
        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $threads = $this->workflowThreadService->listAllThreads($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.workflow-thread.index', compact('threads', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.workflow-thread.add', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->all();
        $result = $this->workflowThreadService->addNewThread($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data thread berhasil ditambahkan')
            : AlertHelper::createAlert('danger', 'Data thread gagal ditambahkan');

        return redirect()->route('admin.workflow-thread.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    public function detail(Request $request)
    {
        $data = $this->workflowThreadService->getThreadDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);
        return view('admin.pages.workflow-thread.detail', compact('breadcrumbs', 'data'));
    }

    public function edit(Request $request, $id)
    {
        $thread = $this->workflowThreadService->getThreadDetail($id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);
        return view('admin.pages.workflow-thread.edit', compact('breadcrumbs', 'thread'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->workflowThreadService->updateThread($request->all(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data thread berhasil diupdate')
            : AlertHelper::createAlert('danger', 'Data thread gagal diupdate');

        return redirect()->route('admin.workflow-thread.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(Request $request)
    {
        $data = $this->workflowThreadService->getThreadDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);
        return view('admin.pages.workflow-thread.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(Request $request)
    {
        $thread = $this->workflowThreadService->getThreadDetail($request->id);
        if (!is_null($thread)) {
            $result = $this->workflowThreadService->deleteThread($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data thread berhasil dihapus')
            : AlertHelper::createAlert('danger', 'Oops! gagal dihapus');

        return redirect()->route('admin.workflow-thread.index')->with('alerts', [$alert]);
    }
}
