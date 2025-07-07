<?php

namespace App\Http\Controllers;

use App\Services\MasterKelompokPanganService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterKelompokPangan\MasterKelompokPanganAddRequest;
use App\Http\Requests\MasterKelompokPangan\MasterKelompokPanganEditRequest;
use App\Http\Requests\MasterKelompokPangan\MasterKelompokPanganListRequest;
use Illuminate\Validation\ValidationException;

class MasterKelompokPanganController extends Controller
{
    private $MasterKelompokPanganService;
    private $mainBreadcrumbs;

    public function __construct(MasterKelompokPanganService $MasterKelompokPanganService)
    {
        $this->MasterKelompokPanganService = $MasterKelompokPanganService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-kelompok-pangan.index'),
            'Master Kelompok Pangan' => route('admin.master-kelompok-pangan.index'),
        ];
    }



    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(MasterKelompokPanganListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $kelompokPangans = $this->MasterKelompokPanganService->listAllMasterKelompokPangan($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-kelompok-pangan.index', compact('kelompokPangans', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new MasterKelompokPangan" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);


        return view('admin.pages.master-kelompok-pangan.add', compact('breadcrumbs'));
    }

    /**
     * =============================================
     *      proses "add new MasterKelompokPangan" from previous form
     * =============================================
     */
    public function store(MasterKelompokPanganAddRequest $request)
    {
        $validatedData = $request->validated();
        // No need to check for nama_kelompok_pangan existence here, as it's handled by unique rule in request
        // No need to check for kode_kelompok_pangan existence here, as it's handled by unique rule in request
        $result = $this->MasterKelompokPanganService->addNewMasterKelompokPangan($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_kelompok_pangan . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_kelompok_pangan . ' failed to be added');



        return redirect()->route('admin.master-kelompok-pangan.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single MasterKelompokPangan entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->MasterKelompokPanganService->getMasterKelompokPanganDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-kelompok-pangan.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit MasterKelompokPangan" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $kelompokPangan = $this->MasterKelompokPanganService->getMasterKelompokPanganDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-kelompok-pangan.edit', compact('breadcrumbs', 'kelompokPangan'));
    }

    /**
     * =============================================
     *      process "edit MasterKelompokPangan" from previous form
     * =============================================
     */
    public function update(MasterKelompokPanganEditRequest $request, $id)
    {
        $result = $this->MasterKelompokPanganService->updateMasterKelompokPangan($request->validated(), $id);


        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_kelompok_pangan . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_kelompok_pangan . ' failed to be updated');

        return redirect()->route('admin.master-kelompok-pangan.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for MasterKelompokPangan
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(MasterKelompokPanganListRequest $request)
    {
        $data = $this->MasterKelompokPanganService->getMasterKelompokPanganDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-kelompok-pangan.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(MasterKelompokPanganListRequest $request)
    {
        $kelompokPangan = $this->MasterKelompokPanganService->getMasterKelompokPanganDetail($request->id);
        if (!is_null($kelompokPangan)) {
            $result = $this->MasterKelompokPanganService->deleteMasterKelompokPangan($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $kelompokPangan->nama_kelompok_pangan . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-kelompok-pangan.index')->with('alerts', [$alert]);
    }


    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================

}
