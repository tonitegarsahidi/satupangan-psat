<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pengawasan\PengawasanListRequest;
use App\Http\Requests\Pengawasan\PengawasanTindakanAddRequest;
use App\Http\Requests\Pengawasan\PengawasanTindakanEditRequest;
use App\Services\PengawasanTindakanService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

/**
 * ################################################
 *      THIS IS PENGAWASAN TINDAKAN CONTROLLER
 *  the main purpose of this class is to show functionality
 *  for ULTIMATE CRUD concept in this SamBoilerplate
 *  I use this PengawasanTindakan model since it's really needed
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
class PengawasanTindakanController extends Controller
{
    private $pengawasanTindakanService;
    private $mainBreadcrumbs;

    public function __construct(PengawasanTindakanService $pengawasanTindakanService)
    {
        $this->pengawasanTindakanService = $pengawasanTindakanService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Pengawasan Tindakan' => route('pengawasan-tindakan.index'),
        ];
    }

    // ============================ START OF ULTIMATE CRUD FUNCTIONALITY ===============================

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(PengawasanListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');


        $pengawasanTindakanList = $this->pengawasanTindakanService->listAllTindakan($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.pengawasan-tindakan.index', compact('pengawasanTindakanList', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new pengawasan tindakan" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        // Get all users for pimpinan and PIC selection
        $pimpinans = \App\Models\User::where('is_active', 1)->orderBy('name', 'asc')->get();

        // Get pengawasan rekap options
        $pengawasanRekaps = \App\Models\PengawasanRekap::where('is_active', 1)
            ->with(['pengawasan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pages.pengawasan-tindakan.add', compact('breadcrumbs', 'pimpinans', 'pengawasanRekaps'));
    }

    /**
     * =============================================
     *      proses "add new pengawasan tindakan" from previous form
     * =============================================
     */
    public function store(PengawasanTindakanAddRequest $request)
    {
        $validatedData = $request->validated();

        // Get current authenticated user ID
        $userId = Auth::id();

        // Add created_by and updated_by with current user ID
        $validatedData['created_by'] = $userId;
        $validatedData['updated_by'] = $userId;

        $result = $this->pengawasanTindakanService->addNewTindakan($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Tindakan successfully added')
            : AlertHelper::createAlert('danger', 'Data Pengawasan Tindakan failed to be added');

        return redirect()->route('pengawasan-tindakan.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single pengawasan tindakan entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->pengawasanTindakanService->getTindakanDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.pengawasan-tindakan.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit pengawasan tindakan" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $pengawasanTindakan = $this->pengawasanTindakanService->getTindakanDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        // Get all users for pimpinan and PIC selection
        $pimpinans = \App\Models\User::where('is_active', 1)->orderBy('name', 'asc')->get();

        // Get pengawasan rekap options
        $pengawasanRekaps = \App\Models\PengawasanRekap::where('is_active', 1)
            ->with(['pengawasan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pages.pengawasan-tindakan.edit', compact('breadcrumbs', 'pengawasanTindakan', 'pimpinans', 'pengawasanRekaps'));
    }

    /**
     * =============================================
     *      process "edit pengawasan tindakan" from previous form
     * =============================================
     */
    public function update(PengawasanTindakanEditRequest $request, $id)
    {
        $validatedData = $request->validated();

        // Add updated_by with current user ID
        $validatedData['updated_by'] = Auth::id();

        $result = $this->pengawasanTindakanService->updateTindakan($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Tindakan successfully updated')
            : AlertHelper::createAlert('danger', 'Data Pengawasan Tindakan failed to be updated');

        return redirect()->route('pengawasan-tindakan.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for pengawasan tindakan
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(PengawasanListRequest $request)
    {
        $data = $this->pengawasanTindakanService->getTindakanDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.pengawasan-tindakan.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(PengawasanListRequest $request)
    {
        $pengawasanTindakan = $this->pengawasanTindakanService->getTindakanDetail($request->id);
        if (!is_null($pengawasanTindakan)) {
            $result = $this->pengawasanTindakanService->deleteTindakan($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Tindakan successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('pengawasan-tindakan.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Search pengawasan tindakan for Select2
     * =============================================
     */
    public function search(Request $request)
    {
        $search = $request->input('q');

        // You need to implement a search method in the service
        // For now, we'll return empty array
        $pengawasanTindakanList = [];

        $formattedPengawasanTindakan = $pengawasanTindakanList->map(function ($pengawasanTindakan) {
            return ['id' => $pengawasanTindakan->id, 'text' => $pengawasanTindakan->tindak_lanjut];
        });

        return response()->json($formattedPengawasanTindakan);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
