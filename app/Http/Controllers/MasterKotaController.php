<?php

namespace App\Http\Controllers;

use App\Services\MasterKotaService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterKota\MasterKotaAddRequest;
use App\Http\Requests\MasterKota\MasterKotaEditRequest;
use App\Http\Requests\MasterKota\MasterKotaListRequest;
use Illuminate\Validation\ValidationException;

class MasterKotaController extends Controller
{
    private $MasterKotaService;
    private $mainBreadcrumbs;

    public function __construct(MasterKotaService $MasterKotaService)
    {
        $this->MasterKotaService = $MasterKotaService;

        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-kota.index'),
            'Master Kota' => route('admin.master-kota.index'),
        ];
    }

    public function index(MasterKotaListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $kotas = $this->MasterKotaService->listAllMasterKota($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-kota.index', compact('kotas', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        $provinsis = \App\Models\MasterProvinsi::orderBy('nama_provinsi')->get();
        return view('admin.pages.master-kota.add', compact('breadcrumbs', 'provinsis'));
    }

    public function store(MasterKotaAddRequest $request)
    {
        $validatedData = $request->validated();
        if ($this->MasterKotaService->checkMasterKotaExist($validatedData["nama_kota"])) {
            throw ValidationException::withMessages([
                'nama_kota' => 'Nama Kota sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterKotaService->addNewMasterKota($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_kota . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_kota . ' failed to be added');

        return redirect()->route('admin.master-kota.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    public function detail(Request $request)
    {
        $data = $this->MasterKotaService->getMasterKotaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-kota.detail', compact('breadcrumbs', 'data'));
    }

    public function edit(Request $request, $id)
    {
        $kota = $this->MasterKotaService->getMasterKotaDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);
        $provinsis = \App\Models\MasterProvinsi::orderBy('nama_provinsi')->get();

        return view('admin.pages.master-kota.edit', compact('breadcrumbs', 'kota', 'provinsis'));
    }

    public function update(MasterKotaEditRequest $request, $id)
    {
        $result = $this->MasterKotaService->updateMasterKota($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_kota . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_kota . ' failed to be updated');

        return redirect()->route('admin.master-kota.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(MasterKotaListRequest $request)
    {
        $data = $this->MasterKotaService->getMasterKotaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-kota.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(MasterKotaListRequest $request)
    {
        $kota = $this->MasterKotaService->getMasterKotaDetail($request->id);
        if (!is_null($kota)) {
            $result = $this->MasterKotaService->deleteMasterKota($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $kota->nama_kota . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-kota.index')->with('alerts', [$alert]);
    }
}
