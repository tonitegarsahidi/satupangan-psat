<?php

namespace App\Http\Controllers;

use App\Services\MasterCemaranLogamBeratService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterCemaranLogamBerat\MasterCemaranLogamBeratAddRequest;
use App\Http\Requests\MasterCemaranLogamBerat\MasterCemaranLogamBeratEditRequest;
use App\Http\Requests\MasterCemaranLogamBerat\MasterCemaranLogamBeratListRequest;
use Illuminate\Validation\ValidationException;

class MasterCemaranLogamBeratController extends Controller
{
    private $MasterCemaranLogamBeratService;
    private $mainBreadcrumbs;

    public function __construct(MasterCemaranLogamBeratService $MasterCemaranLogamBeratService)
    {
        $this->MasterCemaranLogamBeratService = $MasterCemaranLogamBeratService;

        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-cemaran-logam-berat.index'),
            'Master Cemaran Logam Berat' => route('admin.master-cemaran-logam-berat.index'),
        ];
    }

    public function index(MasterCemaranLogamBeratListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $cemaranLogamBerats = $this->MasterCemaranLogamBeratService->listAllMasterCemaranLogamBerat($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-cemaran-logam-berat.index', compact('cemaranLogamBerats', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.master-cemaran-logam-berat.add', compact('breadcrumbs'));
    }

    public function store(MasterCemaranLogamBeratAddRequest $request)
    {
        $validatedData = $request->validated();
        if ($this->MasterCemaranLogamBeratService->checkMasterCemaranLogamBeratExist($validatedData["nama_cemaran_logam_berat"])) {
            throw ValidationException::withMessages([
                'nama_cemaran_logam_berat' => 'Nama Cemaran Logam Berat sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterCemaranLogamBeratService->addNewMasterCemaranLogamBerat($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_cemaran_logam_berat . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_cemaran_logam_berat . ' failed to be added');

        return redirect()->route('admin.master-cemaran-logam-berat.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    public function detail(Request $request)
    {
        $data = $this->MasterCemaranLogamBeratService->getMasterCemaranLogamBeratDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-cemaran-logam-berat.detail', compact('breadcrumbs', 'data'));
    }

    public function edit(Request $request, $id)
    {
        $cemaranLogamBerat = $this->MasterCemaranLogamBeratService->getMasterCemaranLogamBeratDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-cemaran-logam-berat.edit', compact('breadcrumbs', 'cemaranLogamBerat'));
    }

    public function update(MasterCemaranLogamBeratEditRequest $request, $id)
    {
        $result = $this->MasterCemaranLogamBeratService->updateMasterCemaranLogamBerat($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_cemaran_logam_berat . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_cemaran_logam_berat . ' failed to be updated');

        return redirect()->route('admin.master-cemaran-logam-berat.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(MasterCemaranLogamBeratListRequest $request)
    {
        $data = $this->MasterCemaranLogamBeratService->getMasterCemaranLogamBeratDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-cemaran-logam-berat.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(MasterCemaranLogamBeratListRequest $request)
    {
        $cemaranLogamBerat = $this->MasterCemaranLogamBeratService->getMasterCemaranLogamBeratDetail($request->id);
        if (!is_null($cemaranLogamBerat)) {
            $result = $this->MasterCemaranLogamBeratService->deleteMasterCemaranLogamBerat($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $cemaranLogamBerat->nama_cemaran_logam_berat . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-cemaran-logam-berat.index')->with('alerts', [$alert]);
    }
}
