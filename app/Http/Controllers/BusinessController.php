<?php

namespace App\Http\Controllers;

use App\Services\BusinessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\MasterProvinsi;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKota;
use App\Helpers\AlertHelper;
use App\Http\Requests\Business\BusinessListRequest;
use App\Http\Requests\Business\BusinessAddRequest;
use App\Http\Requests\Business\BusinessEditRequest;
use Illuminate\Validation\ValidationException;

class BusinessController extends Controller
{
    private $businessService;
    private $mainBreadcrumbs;

    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('business.index'),
            'Business' => route('business.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(BusinessListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'nama_perusahaan'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $businesses = $this->businessService->listAllBusiness($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.business.index', compact('businesses', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new Business" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        $provinsis = MasterProvinsi::all();
        $jenispsats = MasterJenisPanganSegar::all();

        // If business exists and has a provinsi_id, load the corresponding kotas
        $kotas = collect();
        if ($request->old('provinsi_id')) {
            $kotas = \App\Models\MasterKota::where('provinsi_id', $request->old('provinsi_id'))->get();
        }

        return view('admin.pages.business.add', compact('breadcrumbs', 'provinsis', 'kotas', 'jenispsats'));
    }

    /**
     * =============================================
     *      proses "add new Business" from previous form
     * =============================================
     */
    public function store(BusinessAddRequest $request)
    {
        $validatedData = $request->validated();

        // Extract jenispsat_id from validated data
        $jenispsatIds = $validatedData['jenispsat_id'] ?? [];
        unset($validatedData['jenispsat_id']);

        $result = $this->businessService->addNewBusiness($validatedData, $jenispsatIds);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_perusahaan . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data failed to be added');

        return redirect()->route('business.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single Business entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->businessService->getBusinessDetail($request->id);

        // Eager load relationships to avoid N+1 queries and null reference errors
        if ($data) {
            $data->load(['provinsi', 'kota', 'jenispsats', 'user.roles', 'creator', 'updater']);
        }

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.business.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit Business" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $business = $this->businessService->getBusinessDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        $provinsis = MasterProvinsi::all();
        $jenispsats = MasterJenisPanganSegar::all();

        // If business exists and has a provinsi_id, load the corresponding kotas
        $kotas = collect();
        if ($business && $business->provinsi_id) {
            $kotas = MasterKota::where('provinsi_id', $business->provinsi_id)->get();
        }

        return view('admin.pages.business.edit', compact('breadcrumbs', 'business', 'provinsis', 'kotas', 'jenispsats'));
    }

    /**
     * =============================================
     *      process "edit Business" from previous form
     * =============================================
     */
    public function update(BusinessEditRequest $request, $id)
    {
        $validatedData = $request->validated();

        // Extract jenispsat_id array and remove it from validated data
        $jenispsatIds = $validatedData['jenispsat_id'] ?? [];
        unset($validatedData['jenispsat_id']);

        $result = $this->businessService->updateBusiness($validatedData, $id, $jenispsatIds);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_perusahaan . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data failed to be updated');

        return redirect()->route('business.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for Business
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(BusinessListRequest $request)
    {
        $data = $this->businessService->getBusinessDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.business.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(BusinessListRequest $request)
    {
        // This method will now deactivate the business instead of deleting it.
        // The actual deletion logic will be removed or moved if needed elsewhere.
        $business = $this->businessService->getBusinessDetail($request->id);
        if (!is_null($business)) {
            $statusToSet = !$business->is_active; // Toggle the status
            $result = $this->businessService->updateStatus($request->id, $statusToSet, Auth::id());
        } else {
            $result = false;
        }

        $action = $business->is_active ? 'Deactivated' : 'Activated';
        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $business->nama_perusahaan . ' successfully ' . $action)
            : AlertHelper::createAlert('danger', 'Oops! failed to ' . strtolower($action));

        return redirect()->route('business.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      update status
     * =============================================
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('is_active');
        $user = Auth::user();

        $result = $this->businessService->updateStatus($id, $status, $user->id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Status successfully updated to ' . ($status ? 'Active' : 'Inactive'))
            : AlertHelper::createAlert('danger', 'Failed to update status');

        return redirect()->route('business.detail', ['id' => $id])->with('alerts', [$alert]);
    }

    /**
     * Endpoint AJAX: get kota by provinsi
     */
    public function getKotaByProvinsi($provinsiId)
    {
        $kotas = \App\Models\MasterKota::where('provinsi_id', $provinsiId)->where('is_active', 1)->orderBy('nama_kota')->get(['id', 'nama_kota']);
        return response()->json($kotas);
    }
}
