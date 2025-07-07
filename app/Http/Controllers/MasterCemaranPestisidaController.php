<?php

namespace App\Http\Controllers;

use App\Services\MasterCemaranPestisidaService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterCemaranPestisida\MasterCemaranPestisidaAddRequest;
use App\Http\Requests\MasterCemaranPestisida\MasterCemaranPestisidaEditRequest;
use App\Http\Requests\MasterCemaranPestisida\MasterCemaranPestisidaListRequest;
use Illuminate\Validation\ValidationException;

class MasterCemaranPestisidaController extends Controller
{
    private $MasterCemaranPestisidaService;
    private $mainBreadcrumbs;

    public function __construct(MasterCemaranPestisidaService $MasterCemaranPestisidaService)
    {
        $this->MasterCemaranPestisidaService = $MasterCemaranPestisidaService;

        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-cemaran-pestisida.index'),
            'Master Cemaran Pestisida' => route('admin.master-cemaran-pestisida.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(MasterCemaranPestisidaListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $cemaranPestisidas = $this->MasterCemaranPestisidaService->listAllMasterCemaranPestisida($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-cemaran-pestisida.index', compact('cemaranPestisidas', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new MasterCemaranPestisida" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.master-cemaran-pestisida.add', compact('breadcrumbs'));
    }

    /**
     * =============================================
     *      proses "add new MasterCemaranPestisida" from previous form
     * =============================================
     */
    public function store(MasterCemaranPestisidaAddRequest $request)
    {
        $validatedData = $request->validated();
        if($this->MasterCemaranPestisidaService->checkMasterCemaranPestisidaExist($validatedData["nama_cemaran_pestisida"])){
            throw ValidationException::withMessages([
                'nama_cemaran_pestisida' => 'Nama Cemaran Pestisida sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterCemaranPestisidaService->addNewMasterCemaranPestisida($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_cemaran_pestisida . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_cemaran_pestisida . ' failed to be added');

        return redirect()->route('admin.master-cemaran-pestisida.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single MasterCemaranPestisida entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->MasterCemaranPestisidaService->getMasterCemaranPestisidaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-cemaran-pestisida.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit MasterCemaranPestisida" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $cemaranPestisida = $this->MasterCemaranPestisidaService->getMasterCemaranPestisidaDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-cemaran-pestisida.edit', compact('breadcrumbs', 'cemaranPestisida'));
    }

    /**
     * =============================================
     *      process "edit MasterCemaranPestisida" from previous form
     * =============================================
     */
    public function update(MasterCemaranPestisidaEditRequest $request, $id)
    {
        $result = $this->MasterCemaranPestisidaService->updateMasterCemaranPestisida($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_cemaran_pestisida . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_cemaran_pestisida . ' failed to be updated');

        return redirect()->route('admin.master-cemaran-pestisida.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for MasterCemaranPestisida
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(MasterCemaranPestisidaListRequest $request)
    {
        $data = $this->MasterCemaranPestisidaService->getMasterCemaranPestisidaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-cemaran-pestisida.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(MasterCemaranPestisidaListRequest $request)
    {
        $cemaranPestisida = $this->MasterCemaranPestisidaService->getMasterCemaranPestisidaDetail($request->id);
        if (!is_null($cemaranPestisida)) {
            $result = $this->MasterCemaranPestisidaService->deleteMasterCemaranPestisida($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $cemaranPestisida->nama_cemaran_pestisida . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-cemaran-pestisida.index')->with('alerts', [$alert]);
    }
}
