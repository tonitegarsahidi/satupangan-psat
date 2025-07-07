<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterProvinsiAddRequest;
use App\Http\Requests\MasterProvinsiEditRequest;
use App\Http\Requests\MasterProvinsiListRequest;
use App\Services\RoleMasterService;
use App\Services\MasterProvinsiService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

    /**
     * ################################################
     *      THIS IS MasterProvinsi CONTROLLER
     *  the main purpose of this class is to show functionality
     *  for ULTIMATE CRUD concept in this SamBoilerplate
     *  I use this MasterProvinsi model since it real neeed
     *  modify as you wish.
     *
     *   ULTIMATE CRUD CONCEPT
     *  - List, search/filter, sort, paging
     *  - See Detail
     *  - Add - Process Add
     *  - Edit - Process Edit
     *  - Delete confirm - Process Delete
     * ################################################
     */
class MasterProvinsiController extends Controller
{
    private $MasterProvinsiService;
    private $roleMasterService;
    private $mainBreadcrumbs;

    public function __construct(MasterProvinsiService $MasterProvinsiService, RoleMasterService $roleMasterService)
    {
        $this->MasterProvinsiService = $MasterProvinsiService;
        $this->roleMasterService = $roleMasterService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-provinsi.index'),
            'Master Provinsi' => route('admin.master-provinsi.index'),
        ];
    }

    // ============================ START OF ULTIMATE CRUD FUNCTIONALITY ===============================



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

        $roles = $this->roleMasterService->getAllRoles();

        return view('admin.pages.master-provinsi.add', compact('breadcrumbs', 'roles'));
    }

    /**
     * =============================================
     *      proses "add new MasterProvinsi" from previous form
     * =============================================
     */
    public function store(MasterProvinsiAddRequest $request)
    {
        $validatedData = $request->validated();
        if($this->MasterProvinsiService->checkMasterProvinsiExist($validatedData["email"])){
            throw ValidationException::withMessages([
                'email' => 'The email address already exists.'
            ]);
        }
        $result = $this->MasterProvinsiService->addNewMasterProvinsi($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->name . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->name . ' failed to be added');



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
        $MasterProvinsi = $this->MasterProvinsiService->getMasterProvinsiDetail($id);
        $MasterProvinsi->load('roles');
        $roles = $this->roleMasterService->getAllRoles();

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-provinsi.edit', compact('breadcrumbs', 'MasterProvinsi', 'roles'));
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
            ? AlertHelper::createAlert('success', 'Data ' . $result->name . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->name . ' failed to be updated');

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
        $MasterProvinsi = $this->MasterProvinsiService->getMasterProvinsiDetail($request->id);
        if (!is_null($MasterProvinsi)) {
            $result = $this->MasterProvinsiService->deleteMasterProvinsi($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $MasterProvinsi->name . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-provinsi.index')->with('alerts', [$alert]);
    }


    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
    /**
     * =============================================
     *      Handle sample pages
     *      which can only be accessed
     *      by this role MasterProvinsi
     * =============================================
     */
    public function MasterProvinsiOnlyPage(Request $request)
    {
        return view('admin.pages.master-provinsi.master-provinsionlypage', ['message' => 'Hello MasterProvinsi, Thanks for using our products']);
    }
}
