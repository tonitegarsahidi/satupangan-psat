<?php

namespace App\Http\Controllers;

use App\Services\BatasCemaranLogamBeratService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\BatasCemaranLogamBerat\BatasCemaranLogamBeratAddRequest;
use App\Http\Requests\BatasCemaranLogamBerat\BatasCemaranLogamBeratEditRequest;
use App\Http\Requests\BatasCemaranLogamBerat\BatasCemaranLogamBeratListRequest;
use Illuminate\Validation\ValidationException;

class BatasCemaranLogamBeratController extends Controller
{
    private $BatasCemaranLogamBeratService;
    private $mainBreadcrumbs;

    public function __construct(BatasCemaranLogamBeratService $BatasCemaranLogamBeratService)
    {
        $this->BatasCemaranLogamBeratService = $BatasCemaranLogamBeratService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Batas Cemaran Logam Berat' => route('admin.batas-cemaran-logam-berat.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(BatasCemaranLogamBeratListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $batasCemaranLogamBerats = $this->BatasCemaranLogamBeratService->listAllBatasCemaranLogamBerat($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.batas-cemaran-logam-berat.index', compact('batasCemaranLogamBerats', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new BatasCemaranLogamBerat" page
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        $jenisPangans = $this->BatasCemaranLogamBeratService->getAllJenisPangan();
        $cemaranLogamBerats = $this->BatasCemaranLogamBeratService->getAllCemaranLogamBerat();

        return view('admin.pages.batas-cemaran-logam-berat.add', compact('breadcrumbs', 'jenisPangans', 'cemaranLogamBerats'));
    }

    /**
     * =============================================
     *      process "add new BatasCemaranLogamBerat" from previous form
     * =============================================
     */
    public function store(BatasCemaranLogamBeratAddRequest $request)
    {
        $validatedData = $request->validated();

        if ($this->BatasCemaranLogamBeratService->checkBatasCemaranLogamBeratExist(
            $validatedData["jenis_psat"],
            $validatedData["cemaran_logam_berat"]
        )) {
            throw ValidationException::withMessages([
                'jenis_psat' => 'Jenis Pangan and Cemaran Logam Berat combination already exists.'
            ]);
        }

        $result = $this->BatasCemaranLogamBeratService->addNewBatasCemaranLogamBerat($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully added')
            : AlertHelper::createAlert('danger', 'Data failed to be added');

        return redirect()->route('admin.batas-cemaran-logam-berat.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single BatasCemaranLogamBerat entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->BatasCemaranLogamBeratService->getBatasCemaranLogamBeratDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.batas-cemaran-logam-berat.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit BatasCemaranLogamBerat" page
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $batasCemaranLogamBerat = $this->BatasCemaranLogamBeratService->getBatasCemaranLogamBeratDetail($id);
        $jenisPangans = $this->BatasCemaranLogamBeratService->getAllJenisPangan();
        $cemaranLogamBerats = $this->BatasCemaranLogamBeratService->getAllCemaranLogamBerat();

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.batas-cemaran-logam-berat.edit', compact('breadcrumbs', 'batasCemaranLogamBerat', 'jenisPangans', 'cemaranLogamBerats'));
    }

    /**
     * =============================================
     *      process "edit BatasCemaranLogamBerat" from previous form
     * =============================================
     */
    public function update(BatasCemaranLogamBeratEditRequest $request, $id)
    {
        $result = $this->BatasCemaranLogamBeratService->updateBatasCemaranLogamBerat($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully updated')
            : AlertHelper::createAlert('danger', 'Data failed to be updated');

        return redirect()->route('admin.batas-cemaran-logam-berat.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for BatasCemaranLogamBerat
     * =============================================
     */
    public function deleteConfirm(BatasCemaranLogamBeratListRequest $request)
    {
        $data = $this->BatasCemaranLogamBeratService->getBatasCemaranLogamBeratDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.batas-cemaran-logam-berat.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(BatasCemaranLogamBeratListRequest $request)
    {
        $batasCemaranLogamBerat = $this->BatasCemaranLogamBeratService->getBatasCemaranLogamBeratDetail($request->id);
        if (!is_null($batasCemaranLogamBerat)) {
            $result = $this->BatasCemaranLogamBeratService->deleteBatasCemaranLogamBerat($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.batas-cemaran-logam-berat.index')->with('alerts', [$alert]);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
