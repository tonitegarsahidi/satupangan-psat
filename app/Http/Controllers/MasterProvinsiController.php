<?php

namespace App\Http\Controllers;

use App\Services\MasterProvinsiService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterProvinsi\MasterProvinsiAddRequest;
use App\Http\Requests\MasterProvinsi\MasterProvinsiEditRequest;
use App\Http\Requests\MasterProvinsi\MasterProvinsiListRequest;
use Illuminate\Validation\ValidationException;
class MasterProvinsiController extends Controller
{
    private $MasterProvinsiService;
    private $mainBreadcrumbs;

    public function __construct(MasterProvinsiService $MasterProvinsiService)
    {
        $this->MasterProvinsiService = $MasterProvinsiService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-provinsi.index'),
            'Master Provinsi' => route('admin.master-provinsi.index'),
        ];
    }



    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(MasterProvinsiListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $provinsis = $this->MasterProvinsiService->listAllMasterProvinsi($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-provinsi.index', compact('provinsis', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new MasterProvinsi" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);


        return view('admin.pages.master-provinsi.add', compact('breadcrumbs'));
    }

    /**
     * =============================================
     *      proses "add new MasterProvinsi" from previous form
     * =============================================
     */
    public function store(MasterProvinsiAddRequest $request)
    {
        $validatedData = $request->validated();
        if($this->MasterProvinsiService->checkMasterProvinsiExist($validatedData["nama_provinsi"])){
            throw ValidationException::withMessages([
                'nama_provinsi' => 'Nama Provinsi sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterProvinsiService->addNewMasterProvinsi($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_provinsi . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_provinsi . ' failed to be added');



        return redirect()->route('admin.master-provinsi.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single MasterProvinsi entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->MasterProvinsiService->getMasterProvinsiDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-provinsi.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit MasterProvinsi" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $provinsi = $this->MasterProvinsiService->getMasterProvinsiDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-provinsi.edit', compact('breadcrumbs', 'MasterProvinsi'));
    }

    /**
     * =============================================
     *      process "edit MasterProvinsi" from previous form
     * =============================================
     */
    public function update(MasterProvinsiEditRequest $request, $id)
    {
        $result = $this->MasterProvinsiService->updateMasterProvinsi($request->validated(), $id);


        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_provinsi . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_provinsi . ' failed to be updated');

        return redirect()->route('admin.master-provinsi.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for MasterProvinsi
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(MasterProvinsiListRequest $request)
    {
        $data = $this->MasterProvinsiService->getMasterProvinsiDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-provinsi.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(MasterProvinsiListRequest $request)
    {
        $provinsi = $this->MasterProvinsiService->getMasterProvinsiDetail($request->id);
        if (!is_null($provinsi)) {
            $result = $this->MasterProvinsiService->deleteMasterProvinsi($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $provinsi->nama_provinsi . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-provinsi.index')->with('alerts', [$alert]);
    }


    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================

}
