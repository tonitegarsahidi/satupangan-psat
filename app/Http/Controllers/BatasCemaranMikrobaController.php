<?php

namespace App\Http\Controllers;

use App\Services\BatasCemaranMikrobaService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\BatasCemaranMikroba\BatasCemaranMikrobaAddRequest;
use App\Http\Requests\BatasCemaranMikroba\BatasCemaranMikrobaEditRequest;
use App\Http\Requests\BatasCemaranMikroba\BatasCemaranMikrobaListRequest;
use Illuminate\Validation\ValidationException;

class BatasCemaranMikrobaController extends Controller
{
    private $BatasCemaranMikrobaService;
    private $mainBreadcrumbs;

    public function __construct(BatasCemaranMikrobaService $BatasCemaranMikrobaService)
    {
        $this->BatasCemaranMikrobaService = $BatasCemaranMikrobaService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Batas Cemaran Mikroba' => route('admin.batas-cemaran-mikroba.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(BatasCemaranMikrobaListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $batasCemaranMikrobas = $this->BatasCemaranMikrobaService->listAllBatasCemaranMikroba($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.batas-cemaran-mikroba.index', compact('batasCemaranMikrobas', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new BatasCemaranMikroba" page
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        $jenisPangans = $this->BatasCemaranMikrobaService->getAllJenisPangan();
        $cemaranMikrobas = $this->BatasCemaranMikrobaService->getAllCemaranMikroba();

        return view('admin.pages.batas-cemaran-mikroba.add', compact('breadcrumbs', 'jenisPangans', 'cemaranMikrobas'));
    }

    /**
     * =============================================
     *      process "add new BatasCemaranMikroba" from previous form
     * =============================================
     */
    public function store(BatasCemaranMikrobaAddRequest $request)
    {
        $validatedData = $request->validated();

        if ($this->BatasCemaranMikrobaService->checkBatasCemaranMikrobaExist(
            $validatedData["jenis_psat"],
            $validatedData["cemaran_mikroba"]
        )) {
            throw ValidationException::withMessages([
                'jenis_psat' => 'Jenis Pangan and Cemaran Mikroba combination already exists.'
            ]);
        }

        $result = $this->BatasCemaranMikrobaService->addNewBatasCemaranMikroba($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully added')
            : AlertHelper::createAlert('danger', 'Data failed to be added');

        return redirect()->route('admin.batas-cemaran-mikroba.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single BatasCemaranMikroba entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->BatasCemaranMikrobaService->getBatasCemaranMikrobaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.batas-cemaran-mikroba.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit BatasCemaranMikroba" page
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $batasCemaranMikroba = $this->BatasCemaranMikrobaService->getBatasCemaranMikrobaDetail($id);
        $jenisPangans = $this->BatasCemaranMikrobaService->getAllJenisPangan();
        $cemaranMikrobas = $this->BatasCemaranMikrobaService->getAllCemaranMikroba();

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.batas-cemaran-mikroba.edit', compact('breadcrumbs', 'batasCemaranMikroba', 'jenisPangans', 'cemaranMikrobas'));
    }

    /**
     * =============================================
     *      process "edit BatasCemaranMikroba" from previous form
     * =============================================
     */
    public function update(BatasCemaranMikrobaEditRequest $request, $id)
    {
        $result = $this->BatasCemaranMikrobaService->updateBatasCemaranMikroba($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully updated')
            : AlertHelper::createAlert('danger', 'Data failed to be updated');

        return redirect()->route('admin.batas-cemaran-mikroba.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for BatasCemaranMikroba
     * =============================================
     */
    public function deleteConfirm(BatasCemaranMikrobaListRequest $request)
    {
        $data = $this->BatasCemaranMikrobaService->getBatasCemaranMikrobaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.batas-cemaran-mikroba.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(BatasCemaranMikrobaListRequest $request)
    {
        $batasCemaranMikroba = $this->BatasCemaranMikrobaService->getBatasCemaranMikrobaDetail($request->id);
        if (!is_null($batasCemaranMikroba)) {
            $result = $this->BatasCemaranMikrobaService->deleteBatasCemaranMikroba($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.batas-cemaran-mikroba.index')->with('alerts', [$alert]);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
