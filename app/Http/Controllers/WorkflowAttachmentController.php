<?php

namespace App\Http\Controllers;

use App\Services\WorkflowAttachmentService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

class WorkflowAttachmentController extends Controller
{
    private $workflowAttachmentService;
    private $mainBreadcrumbs;

    public function __construct(WorkflowAttachmentService $workflowAttachmentService)
    {
        $this->workflowAttachmentService = $workflowAttachmentService;
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.workflow-attachment.index'),
            'Workflow Attachment' => route('admin.workflow-attachment.index'),
        ];
    }

    public function index(Request $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));
        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $attachments = $this->workflowAttachmentService->listAllAttachments($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.workflow-attachment.index', compact('attachments', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.workflow-attachment.add', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->all();
        $result = $this->workflowAttachmentService->addNewAttachment($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data attachment berhasil ditambahkan')
            : AlertHelper::createAlert('danger', 'Data attachment gagal ditambahkan');

        return redirect()->route('admin.workflow-attachment.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    public function detail(Request $request)
    {
        $data = $this->workflowAttachmentService->getAttachmentDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);
        return view('admin.pages.workflow-attachment.detail', compact('breadcrumbs', 'data'));
    }

    public function edit(Request $request, $id)
    {
        $attachment = $this->workflowAttachmentService->getAttachmentDetail($id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);
        return view('admin.pages.workflow-attachment.edit', compact('breadcrumbs', 'attachment'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->workflowAttachmentService->updateAttachment($request->all(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data attachment berhasil diupdate')
            : AlertHelper::createAlert('danger', 'Data attachment gagal diupdate');

        return redirect()->route('admin.workflow-attachment.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(Request $request)
    {
        $data = $this->workflowAttachmentService->getAttachmentDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);
        return view('admin.pages.workflow-attachment.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(Request $request)
    {
        $attachment = $this->workflowAttachmentService->getAttachmentDetail($request->id);
        if (!is_null($attachment)) {
            $result = $this->workflowAttachmentService->deleteAttachment($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data attachment berhasil dihapus')
            : AlertHelper::createAlert('danger', 'Oops! gagal dihapus');

        return redirect()->route('admin.workflow-attachment.index')->with('alerts', [$alert]);
    }
}
