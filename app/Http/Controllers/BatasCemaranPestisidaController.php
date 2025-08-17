<?php

namespace App\Http\Controllers;

use App\Services\BatasCemaranPestisidaService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\BatasCemaranPestisida\BatasCemaranPestisidaAddRequest;
use App\Http\Requests\BatasCemaranPestisida\BatasCemaranPestisidaEditRequest;
use App\Http\Requests\BatasCemaranPestisida\BatasCemaranPestisidaListRequest;
use Illuminate\Validation\ValidationException;

class BatasCemaranPestisidaController extends Controller
{
    private $BatasCemaranPestisidaService;
    private $mainBreadcrumbs;

    public function __construct(BatasCemaranPestisidaService $BatasCemaranPestisidaService)
    {
        $this->BatasCemaranPestisidaService = $BatasCemaranPestisidaService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Batas Cemaran Pestisida' => route('admin.batas-cemaran-pestisida.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(BatasCemaranPestisidaListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $batasCemaranPestisidas = $this->BatasCemaranPestisidaService->listAllBatasCemaranPestisidas($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.batas-cemaran-pestisida.index', compact('batasCemaranPestisidas', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new BatasCemaranPestisida" page
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        $jenisPangans = $this->BatasCemaranPestisidaService->getAllJenisPangan();
        $cemaranPestisidas = $this->BatasCemaranPestisidaService->getAllCemaranPestisida();

        return view('admin.pages.batas-cemaran-pestisida.add', compact('breadcrumbs', 'jenisPangans', 'cemaranPestisidas'));
    }

    /**
     * =============================================
     *      process "add new BatasCemaranPestisida" from previous form
     * =============================================
     */
    public function store(BatasCemaranPestisidaAddRequest $request)
    {
        $validatedData = $request->validated();

        if ($this->BatasCemaranPestisidaService->checkBatasCemaranPestisidaExist(
            $validatedData["jenis_psat"],
            $validatedData["cemaran_pestisida"]
        )) {
            throw ValidationException::withMessages([
                'jenis_psat' => 'Jenis Pangan and Cemaran Pestisida combination already exists.'
            ]);
        }

        $result = $this->BatasCemaranPestisidaService->addNewBatasCemaranPestisida($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully added')
            : AlertHelper::createAlert('danger', 'Data failed to be added');

        return redirect()->route('admin.batas-cemaran-pestisida.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single BatasCemaranPestisida entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->BatasCemaranPestisidaService->getBatasCemaranPestisidaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.batas-cemaran-pestisida.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit BatasCemaranPestisida" page
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $batasCemaranPestisida = $this->BatasCemaranPestisidaService->getBatasCemaranPestisidaDetail($id);
        $jenisPangans = $this->BatasCemaranPestisidaService->getAllJenisPangan();
        $cemaranPestisidas = $this->BatasCemaranPestisidaService->getAllCemaranPestisida();

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.batas-cemaran-pestisida.edit', compact('breadcrumbs', 'batasCemaranPestisida', 'jenisPangans', 'cemaranPestisidas'));
    }

    /**
     * =============================================
     *      process "edit BatasCemaranPestisida" from previous form
     * =============================================
     */
    public function update(BatasCemaranPestisidaEditRequest $request, $id)
    {
        $result = $this->BatasCemaranPestisidaService->updateBatasCemaranPestisida($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully updated')
            : AlertHelper::createAlert('danger', 'Data failed to be updated');

        return redirect()->route('admin.batas-cemaran-pestisida.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for BatasCemaranPestisida
     * =============================================
     */
    public function deleteConfirm(BatasCemaranPestisidaListRequest $request)
    {
        $data = $this->BatasCemaranPestisidaService->getBatasCemaranPestisidaDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.batas-cemaran-pestisida.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(BatasCemaranPestisidaListRequest $request)
    {
        $batasCemaranPestisida = $this->BatasCemaranPestisidaService->getBatasCemaranPestisidaDetail($request->id);
        if (!is_null($batasCemaranPestisida)) {
            $result = $this->BatasCemaranPestisidaService->deleteBatasCemaranPestisida($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.batas-cemaran-pestisida.index')->with('alerts', [$alert]);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
