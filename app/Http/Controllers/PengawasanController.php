<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pengawasan\PengawasanListRequest;
use App\Http\Requests\Pengawasan\PengawasanAddRequest;
use App\Http\Requests\Pengawasan\PengawasanEditRequest;
use App\Services\PengawasanService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

/**
 * ################################################
 *      THIS IS PENGAWASAN CONTROLLER
 *  the main purpose of this class is to show functionality
 *  for ULTIMATE CRUD concept in this SamBoilerplate
 *  I use this Pengawasan model since it's really needed
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
class PengawasanController extends Controller
{
    private $pengawasanService;
    private $mainBreadcrumbs;

    public function __construct(PengawasanService $pengawasanService)
    {
        $this->pengawasanService = $pengawasanService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Pengawasan' => route('pengawasan.index'),
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


        $pengawasanList = $this->pengawasanService->listAllPengawasan($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.pengawasan.index', compact('pengawasanList', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new pengawasan" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        // You might need to get dropdown data here (e.g., jenis_psat, produk_psat, etc.)
        // For now, we'll leave this empty and add it later if needed

        return view('admin.pages.pengawasan.add', compact('breadcrumbs'));
    }

    /**
     * =============================================
     *      proses "add new pengawasan" from previous form
     * =============================================
     */
    public function store(PengawasanAddRequest $request)
    {
        $validatedData = $request->validated();

        // Add user_id_initiator if not present
        if (!isset($validatedData['user_id_initiator'])) {
            $validatedData['user_id_initiator'] = auth()->id();
        }

        $result = $this->pengawasanService->addNewPengawasan($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan successfully added')
            : AlertHelper::createAlert('danger', 'Data Pengawasan failed to be added');

        return redirect()->route('pengawasan.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single pengawasan entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->pengawasanService->getPengawasanDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.pengawasan.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit pengawasan" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $pengawasan = $this->pengawasanService->getPengawasanDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.pengawasan.edit', compact('breadcrumbs', 'pengawasan'));
    }

    /**
     * =============================================
     *      process "edit pengawasan" from previous form
     * =============================================
     */
    public function update(PengawasanEditRequest $request, $id)
    {
        $result = $this->pengawasanService->updatePengawasan($request->validated(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan successfully updated')
            : AlertHelper::createAlert('danger', 'Data Pengawasan failed to be updated');

        return redirect()->route('pengawasan.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for pengawasan
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(PengawasanListRequest $request)
    {
        $data = $this->pengawasanService->getPengawasanDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.pengawasan.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(PengawasanListRequest $request)
    {
        $pengawasan = $this->pengawasanService->getPengawasanDetail($request->id);
        if (!is_null($pengawasan)) {
            $result = $this->pengawasanService->deletePengawasan($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('pengawasan.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Search pengawasan for Select2
     * =============================================
     */
    public function search(Request $request)
    {
        $search = $request->input('q');

        // You need to implement a search method in the service
        // For now, we'll return empty array
        $pengawasanList = [];

        $formattedPengawasan = $pengawasanList->map(function ($pengawasan) {
            return ['id' => $pengawasan->id, 'text' => $pengawasan->lokasi_alamat];
        });

        return response()->json($formattedPengasan);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
