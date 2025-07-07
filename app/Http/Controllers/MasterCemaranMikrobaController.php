<?php

namespace App\Http\Controllers;

use App\Services\MasterCemaranMikrobaService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterCemaranMikroba\MasterCemaranMikrobaAddRequest;
use App\Http\Requests\MasterCemaranMikroba\MasterCemaranMikrobaEditRequest;
use App\Http\Requests\MasterCemaranMikroba\MasterCemaranMikrobaListRequest;
use Illuminate\Validation\ValidationException;

class MasterCemaranMikrobaController extends Controller
{
    private $MasterCemaranMikrobaService;
    private $mainBreadcrumbs;

    public function __construct(MasterCemaranMikrobaService $MasterCemaranMikrobaService)
    {
        $this->MasterCemaranMikrobaService = $MasterCemaranMikrobaService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-cemaran-mikroba.index'),
            'Master Cemaran Mikroba' => route('admin.master-cemaran-mikroba.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(MasterCemaranMikrobaListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $cemaranMikrobas = $this->MasterCemaranMikrobaService->listAllMasterCemaranMikroba($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-cemaran-mikroba.index', compact('cemaranMikrobas', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new MasterCemaranMikroba" page
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        return view('admin.pages.master-cemaran-mikroba.add', compact('breadcrumbs'));
    }

    /**
     * =============================================
     *      process "add new MasterCemaranMikroba" from previous form
     * =============================================
     */
    public function store(MasterCemaranMikrobaAddRequest $request)
    {
        $validatedData = $request->validated();
        if ($this->MasterCemaranMikrobaService->checkMasterCemaranMikrobaExist($validatedData["nama_cemaran_mikroba"])) {
            throw ValidationException::withMessages([
                'nama_cemaran_mikroba' => 'Nama Cemaran Mikroba sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterCemaranMikrobaService->addNewMasterCemaranMikroba($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_cemaran_mikroba . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_cemaran_mikroba . ' failed to be added');

        return redirect()->route('admin.master-cemaran-mikroba.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single MasterCemaranMikroba entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->MasterCemaranMikrobaService->getMasterCemaranMikrobaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-cemaran-mikroba.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit MasterCemaranMikroba" page
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $cemaranMikroba = $this->MasterCemaranMikrobaService->getMasterCemaranMikrobaDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-cemaran-mikroba.edit', compact('breadcrumbs', 'cemaranMikroba'));
    }

    /**
     * =============================================
     *      process "edit MasterCemaranMikroba" from previous form
     * =============================================
     */
    public function update(MasterCemaranMikrobaEditRequest $request, $id)
    {
        $result = $this->MasterCemaranMikrobaService->updateMasterCemaranMikroba($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_cemaran_mikroba . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_cemaran_mikroba . ' failed to be updated');

        return redirect()->route('admin.master-cemaran-mikroba.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for MasterCemaranMikroba
     * =============================================
     */
    public function deleteConfirm(MasterCemaranMikrobaListRequest $request)
    {
        $data = $this->MasterCemaranMikrobaService->getMasterCemaranMikrobaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-cemaran-mikroba.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(MasterCemaranMikrobaListRequest $request)
    {
        $cemaranMikroba = $this->MasterCemaranMikrobaService->getMasterCemaranMikrobaDetail($request->id);
        if (!is_null($cemaranMikroba)) {
            $result = $this->MasterCemaranMikrobaService->deleteMasterCemaranMikroba($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $cemaranMikroba->nama_cemaran_mikroba . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-cemaran-mikroba.index')->with('alerts', [$alert]);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
