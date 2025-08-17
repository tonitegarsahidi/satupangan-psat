<?php

namespace App\Http\Controllers;

use App\Services\BatasCemaranMikrotoksinService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\BatasCemaranMikrotoksin\BatasCemaranMikrotoksinAddRequest;
use App\Http\Requests\BatasCemaranMikrotoksin\BatasCemaranMikrotoksinEditRequest;
use App\Http\Requests\BatasCemaranMikrotoksin\BatasCemaranMikrotoksinListRequest;
use Illuminate\Validation\ValidationException;

class BatasCemaranMikrotoksinController extends Controller
{
    private $BatasCemaranMikrotoksinService;
    private $mainBreadcrumbs;

    public function __construct(BatasCemaranMikrotoksinService $BatasCemaranMikrotoksinService)
    {
        $this->BatasCemaranMikrotoksinService = $BatasCemaranMikrotoksinService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Batas Cemaran Mikrotoksin' => route('admin.batas-cemaran-mikrotoksin.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(BatasCemaranMikrotoksinListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $batasCemaranMikrotoksins = $this->BatasCemaranMikrotoksinService->listAllBatasCemaranMikrotoksins($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.batas-cemaran-mikrotoksin.index', compact('batasCemaranMikrotoksins', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new BatasCemaranMikrotoksin" page
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        $jenisPangans = $this->BatasCemaranMikrotoksinService->getAllJenisPangan();
        $cemaranMikrotoksins = $this->BatasCemaranMikrotoksinService->getAllCemaranMikrotoksin();

        return view('admin.pages.batas-cemaran-mikrotoksin.add', compact('breadcrumbs', 'jenisPangans', 'cemaranMikrotoksins'));
    }

    /**
     * =============================================
     *      process "add new BatasCemaranMikrotoksin" from previous form
     * =============================================
     */
    public function store(BatasCemaranMikrotoksinAddRequest $request)
    {
        $validatedData = $request->validated();

        if ($this->BatasCemaranMikrotoksinService->checkBatasCemaranMikrotoksinExist(
            $validatedData["jenis_psat"],
            $validatedData["cemaran_mikrotoksin"]
        )) {
            throw ValidationException::withMessages([
                'jenis_psat' => 'Jenis Pangan and Cemaran Mikrotoksin combination already exists.'
            ]);
        }

        $result = $this->BatasCemaranMikrotoksinService->addNewBatasCemaranMikrotoksin($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully added')
            : AlertHelper::createAlert('danger', 'Data failed to be added');

        return redirect()->route('admin.batas-cemaran-mikrotoksin.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single BatasCemaranMikrotoksin entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->BatasCemaranMikrotoksinService->getBatasCemaranMikrotoksinDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.batas-cemaran-mikrotoksin.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit BatasCemaranMikrotoksin" page
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $batasCemaranMikrotoksin = $this->BatasCemaranMikrotoksinService->getBatasCemaranMikrotoksinDetail($id);
        $jenisPangans = $this->BatasCemaranMikrotoksinService->getAllJenisPangan();
        $cemaranMikrotoksins = $this->BatasCemaranMikrotoksinService->getAllCemaranMikrotoksin();

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.batas-cemaran-mikrotoksin.edit', compact('breadcrumbs', 'batasCemaranMikrotoksin', 'jenisPangans', 'cemaranMikrotoksins'));
    }

    /**
     * =============================================
     *      process "edit BatasCemaranMikrotoksin" from previous form
     * =============================================
     */
    public function update(BatasCemaranMikrotoksinEditRequest $request, $id)
    {
        $result = $this->BatasCemaranMikrotoksinService->updateBatasCemaranMikrotoksin($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully updated')
            : AlertHelper::createAlert('danger', 'Data failed to be updated');

        return redirect()->route('admin.batas-cemaran-mikrotoksin.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for BatasCemaranMikrotoksin
     * =============================================
     */
    public function deleteConfirm(BatasCemaranMikrotoksinListRequest $request)
    {
        $data = $this->BatasCemaranMikrotoksinService->getBatasCemaranMikrotoksinDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.batas-cemaran-mikrotoksin.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(BatasCemaranMikrotoksinListRequest $request)
    {
        $batasCemaranMikrotoksin = $this->BatasCemaranMikrotoksinService->getBatasCemaranMikrotoksinDetail($request->id);
        if (!is_null($batasCemaranMikrotoksin)) {
            $result = $this->BatasCemaranMikrotoksinService->deleteBatasCemaranMikrotoksin($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.batas-cemaran-mikrotoksin.index')->with('alerts', [$alert]);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
