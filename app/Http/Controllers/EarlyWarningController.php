<?php

namespace App\Http\Controllers;

use App\Services\EarlyWarningService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $sortField = session()->get('sort_field', $request->input('sort_field', 'updated_at'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'desc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        // If user doesn't have ROLE_SUPERVISOR, only show published items
        $status = null;

        $earlyWarnings = $this->EarlyWarningService->listAllEarlyWarnings($perPage, $sortField, $sortOrder, $keyword, $status);

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

        // Add creator_id from authenticated user
        $validatedData['creator_id'] = Auth::user()->id;

        // Add status from the button click
        if ($request->has('status')) {
            $validatedData['status'] = $request->status;
        } else {
            $validatedData['status'] = 'Draft';
        }

        if($this->EarlyWarningService->checkEarlyWarningExist($validatedData["title"])){
            throw ValidationException::withMessages([
                'title' => 'Judul Peringatan Dini sudah ada sebelumnya.'
            ]);
        }
        $result = $this->EarlyWarningService->addNewEarlyWarning($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->title . ' failed to be added');

        // If it's a draft, redirect back to create page
        if ($request->status === 'Draft') {
            return redirect()->route('early-warning.create')->with([
                'alerts'        => [$alert],
                'sort_order'    => 'desc'
            ]);
        }

        // Otherwise, redirect to index page
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

        // Check if we need to publish this early warning
        if ($request->has('publish') && $data->status == 'Approved') {
            $result = $this->EarlyWarningService->publishEarlyWarning($request->id);

            if ($result) {
                $data = $this->EarlyWarningService->getEarlyWarningDetail($request->id); // Refresh data
                $alert = AlertHelper::createAlert('success', 'Data ' . $data->title . ' successfully published');
                return redirect()->route('early-warning.detail', ['id' => $request->id])->with('alerts', [$alert]);
            }
        }

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
        $validatedData = $request->validated();

        // Add status from the button click if provided
        if ($request->has('status')) {
            $validatedData['status'] = $request->status;
        }

        $result = $this->EarlyWarningService->updateEarlyWarning($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->title . ' failed to be updated');

        // If it's a draft, redirect back to edit page
        if ($request->status === 'Draft') {
            return redirect()->route('early-warning.edit', $id)->with([
                'alerts' => [$alert],
                'sort_field' => 'updated_at',
                'sort_order' => 'desc'
            ]);
        }

        // Otherwise, redirect to index page
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

    /**
     * =============================================
     *      process publish EarlyWarning
     * =============================================
     */
    public function publishEarlyWarning(Request $request, $id)
    {
        \Log::info('Publish early warning called with ID: ' . $id);

        $result = $this->EarlyWarningService->publishEarlyWarning($id);

        \Log::info('Publish result: ' . ($result ? 'Success' : 'Failed'));

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully published')
            : AlertHelper::createAlert('danger', 'Oops! failed to publish');

        return redirect()->route('early-warning.index')->with('alerts', [$alert]);
    }


    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================

}
