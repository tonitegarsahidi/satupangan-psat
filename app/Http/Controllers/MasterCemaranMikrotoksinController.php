<?php

namespace App\Http\Controllers;

use App\Services\MasterCemaranMikrotoksinService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterCemaranMikrotoksin\MasterCemaranMikrotoksinAddRequest;
use App\Http\Requests\MasterCemaranMikrotoksin\MasterCemaranMikrotoksinEditRequest;
use App\Http\Requests\MasterCemaranMikrotoksin\MasterCemaranMikrotoksinListRequest;
use Illuminate\Validation\ValidationException;

class MasterCemaranMikrotoksinController extends Controller
{
    private $MasterCemaranMikrotoksinService;
    private $mainBreadcrumbs;

    public function __construct(MasterCemaranMikrotoksinService $MasterCemaranMikrotoksinService)
    {
        $this->MasterCemaranMikrotoksinService = $MasterCemaranMikrotoksinService;

        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-cemaran-mikrotoksin.index'),
            'Master Cemaran Mikrotoksin' => route('admin.master-cemaran-mikrotoksin.index'),
        ];
    }

    public function index(MasterCemaranMikrotoksinListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $cemaranMikrotoksins = $this->MasterCemaranMikrotoksinService->listAllMasterCemaranMikrotoksin($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-cemaran-mikrotoksin.index', compact('cemaranMikrotoksins', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.master-cemaran-mikrotoksin.add', compact('breadcrumbs'));
    }

    public function store(MasterCemaranMikrotoksinAddRequest $request)
    {
        $validatedData = $request->validated();
        if ($this->MasterCemaranMikrotoksinService->checkMasterCemaranMikrotoksinExist($validatedData["nama_cemaran_mikrotoksin"])) {
            throw ValidationException::withMessages([
                'nama_cemaran_mikrotoksin' => 'Nama Cemaran Mikrotoksin sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterCemaranMikrotoksinService->addNewMasterCemaranMikrotoksin($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_cemaran_mikrotoksin . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_cemaran_mikrotoksin . ' failed to be added');

        return redirect()->route('admin.master-cemaran-mikrotoksin.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    public function detail(Request $request)
    {
        $data = $this->MasterCemaranMikrotoksinService->getMasterCemaranMikrotoksinDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-cemaran-mikrotoksin.detail', compact('breadcrumbs', 'data'));
    }

    public function edit(Request $request, $id)
    {
        $cemaranMikrotoksin = $this->MasterCemaranMikrotoksinService->getMasterCemaranMikrotoksinDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-cemaran-mikrotoksin.edit', compact('breadcrumbs', 'cemaranMikrotoksin'));
    }

    public function update(MasterCemaranMikrotoksinEditRequest $request, $id)
    {
        $result = $this->MasterCemaranMikrotoksinService->updateMasterCemaranMikrotoksin($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_cemaran_mikrotoksin . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_cemaran_mikrotoksin . ' failed to be updated');

        return redirect()->route('admin.master-cemaran-mikrotoksin.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(MasterCemaranMikrotoksinListRequest $request)
    {
        $data = $this->MasterCemaranMikrotoksinService->getMasterCemaranMikrotoksinDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-cemaran-mikrotoksin.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(MasterCemaranMikrotoksinListRequest $request)
    {
        $cemaranMikrotoksin = $this->MasterCemaranMikrotoksinService->getMasterCemaranMikrotoksinDetail($request->id);
        if (!is_null($cemaranMikrotoksin)) {
            $result = $this->MasterCemaranMikrotoksinService->deleteMasterCemaranMikrotoksin($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $cemaranMikrotoksin->nama_cemaran_mikrotoksin . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-cemaran-mikrotoksin.index')->with('alerts', [$alert]);
    }
}
