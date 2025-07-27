<?php

namespace App\Http\Controllers;

use App\Services\MasterPenangananService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

class MasterPenangananController extends Controller
{
    private $MasterPenangananService;
    private $mainBreadcrumbs;

    public function __construct(MasterPenangananService $MasterPenangananService)
    {
        $this->MasterPenangananService = $MasterPenangananService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-penanganan.index'),
            'Master Penanganan' => route('admin.master-penanganan.index'),
        ];
    }

    public function index(Request $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $penanganans = $this->MasterPenangananService->listAllMasterPenanganan($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-penanganan.index', compact('penanganans', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.master-penanganan.add', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_penanganan' => 'required|string|max:50|unique:master_penanganan,nama_penanganan',
        ]);
        if($this->MasterPenangananService->checkMasterPenangananExist($validatedData["nama_penanganan"])){
            throw ValidationException::withMessages([
                'nama_penanganan' => 'Nama Penanganan sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterPenangananService->addNewMasterPenanganan($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_penanganan . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_penanganan . ' failed to be added');

        return redirect()->route('admin.master-penanganan.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    public function detail(Request $request, $id)
    {
        $data = $this->MasterPenangananService->getMasterPenangananDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-penanganan.detail', compact('breadcrumbs', 'data'));
    }

    public function edit(Request $request, $id)
    {
        $penanganan = $this->MasterPenangananService->getMasterPenangananDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-penanganan.edit', compact('breadcrumbs', 'penanganan'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_penanganan' => 'required|string|max:50|unique:master_penanganan,nama_penanganan,' . $id,
        ]);
        $result = $this->MasterPenangananService->updateMasterPenanganan($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_penanganan . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_penanganan . ' failed to be updated');

        return redirect()->route('admin.master-penanganan.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(Request $request, $id)
    {
        $data = $this->MasterPenangananService->getMasterPenangananDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-penanganan.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(Request $request, $id)
    {
        $penanganan = $this->MasterPenangananService->getMasterPenangananDetail($id);
        if (!is_null($penanganan)) {
            $result = $this->MasterPenangananService->deleteMasterPenanganan($id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $penanganan->nama_penanganan . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-penanganan.index')->with('alerts', [$alert]);
    }
}
