<?php

namespace App\Http\Controllers;

use App\Services\EarlyWarningService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\EarlyWarning\EarlyWarningAddRequest;
use App\Http\Requests\EarlyWarning\EarlyWarningEditRequest;
use App\Http\Requests\EarlyWarning\EarlyWarningListRequest;
use Illuminate\Validation\ValidationException;
class EarlyWarningController extends Controller
{
    private $EarlyWarningService;
    private $mainBreadcrumbs;

    public function __construct(EarlyWarningService $EarlyWarningService)
    {
        $this->EarlyWarningService = $EarlyWarningService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Early Warning' => route('early-warning.index'),
        ];
    }



    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(EarlyWarningListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $earlyWarnings = $this->EarlyWarningService->listAllEarlyWarnings($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.early-warning.index', compact('earlyWarnings', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new EarlyWarning" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);


        return view('admin.pages.early-warning.add', compact('breadcrumbs'));
    }

    /**
     * =============================================
     *      proses "add new EarlyWarning" from previous form
     * =============================================
     */
    public function store(EarlyWarningAddRequest $request)
    {
        $validatedData = $request->validated();
        if($this->EarlyWarningService->checkEarlyWarningExist($validatedData["title"])){
            throw ValidationException::withMessages([
                'title' => 'Judul Peringatan Dini sudah ada sebelumnya.'
            ]);
        }
        $result = $this->EarlyWarningService->addNewEarlyWarning($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->title . ' failed to be added');



        return redirect()->route('early-warning.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single EarlyWarning entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->EarlyWarningService->getEarlyWarningDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.early-warning.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit EarlyWarning" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $earlyWarning = $this->EarlyWarningService->getEarlyWarningDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.early-warning.edit', compact('breadcrumbs', 'earlyWarning'));
    }

    /**
     * =============================================
     *      process "edit EarlyWarning" from previous form
     * =============================================
     */
    public function update(EarlyWarningEditRequest $request, $id)
    {
        $result = $this->EarlyWarningService->updateEarlyWarning($request->validated(), $id);


        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->title . ' failed to be updated');

        return redirect()->route('early-warning.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for EarlyWarning
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(EarlyWarningListRequest $request)
    {
        $data = $this->EarlyWarningService->getEarlyWarningDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.early-warning.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(EarlyWarningListRequest $request)
    {
        $earlyWarning = $this->EarlyWarningService->getEarlyWarningDetail($request->id);
        if (!is_null($earlyWarning)) {
            $result = $this->EarlyWarningService->deleteEarlyWarning($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $earlyWarning->title . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('early-warning.index')->with('alerts', [$alert]);
    }


    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================

}
