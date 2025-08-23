<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pengawasan\PengawasanRekapListRequest;
use App\Http\Requests\Pengawasan\PengawasanRekapAddRequest;
use App\Http\Requests\Pengawasan\PengawasanRekapEditRequest;
use App\Services\PengawasanRekapService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

/**
 * ################################################
 *      THIS IS PENGAWASAN REKAP CONTROLLER
 *  the main purpose of this class is to show functionality
 *  for ULTIMATE CRUD concept in this SamBoilerplate
 *  I use this PengawasanRekap model since it's really needed
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
class PengawasanRekapController extends Controller
{
    private $pengawasanRekapService;
    private $mainBreadcrumbs;

    public function __construct(PengawasanRekapService $pengawasanRekapService)
    {
        $this->pengawasanRekapService = $pengawasanRekapService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Pengawasan Rekap' => route('pengawasan-rekap.index'),
        ];
    }

    // ============================ START OF ULTIMATE CRUD FUNCTIONALITY ===============================

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(PengawasanRekapListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');


        $pengawasanRekapList = $this->pengawasanRekapService->listAllRekap($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.pengawasan-rekap.index', compact('pengawasanRekapList', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new pengawasan rekap" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        // Get jenis psat and produk psat data
        $jenisPsats = \App\Models\MasterJenisPanganSegar::where('is_active', 1)->orderBy('nama_jenis_pangan_segar', 'asc')->get();
        $produkPsats = [];

        // Get admin users data
        $admins = \App\Models\User::where('role_id', 1)->orderBy('name', 'asc')->get();
        $pics = \App\Models\User::where('role_id', 2)->orderBy('name', 'asc')->get();

        return view('admin.pages.pengawasan-rekap.add', compact('breadcrumbs', 'jenisPsats', 'produkPsats', 'admins', 'pics'));
    }

    /**
     * =============================================
     *      proses "add new pengawasan rekap" from previous form
     * =============================================
     */
    public function store(PengawasanRekapAddRequest $request)
    {
        $validatedData = $request->validated();

        // Get current authenticated user ID
        $userId = Auth::id();

        // Add created_by and updated_by with current user ID
        $validatedData['created_by'] = $userId;
        $validatedData['updated_by'] = $userId;

        $result = $this->pengawasanRekapService->addNewRekap($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Rekap successfully added')
            : AlertHelper::createAlert('danger', 'Data Pengawasan Rekap failed to be added');

        return redirect()->route('pengawasan-rekap.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single pengawasan rekap entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->pengawasanRekapService->getRekapDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.pengawasan-rekap.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit pengawasan rekap" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $pengawasanRekap = $this->pengawasanRekapService->getRekapDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        // Get jenis psat and produk psat data
        $jenisPsats = \App\Models\MasterJenisPanganSegar::where('is_active', 1)->orderBy('nama_jenis_pangan_segar', 'asc')->get();
        $produkPsats = [];
        if ($pengawasanRekap && $pengawasanRekap->jenis_psat_id) {
            $produkPsats = \App\Models\MasterBahanPanganSegar::where('jenis_id', $pengawasanRekap->jenis_psat_id)->where('is_active', 1)->orderBy('nama_bahan_pangan_segar', 'asc')->get();
        }

        // Get admin users data
        $admins = \App\Models\User::where('role_id', 1)->orderBy('name', 'asc')->get();
        $pics = \App\Models\User::where('role_id', 2)->orderBy('name', 'asc')->get();

        return view('admin.pages.pengawasan-rekap.edit', compact('breadcrumbs', 'pengawasanRekap', 'jenisPsats', 'produkPsats', 'admins', 'pics'));
    }

    /**
     * =============================================
     *      process "edit pengawasan rekap" from previous form
     * =============================================
     */
    public function update(PengawasanRekapEditRequest $request, $id)
    {
        $validatedData = $request->validated();

        // Add updated_by with current user ID
        $validatedData['updated_by'] = Auth::id();

        $result = $this->pengawasanRekapService->updateRekap($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Rekap successfully updated')
            : AlertHelper::createAlert('danger', 'Data Pengawasan Rekap failed to be updated');

        return redirect()->route('pengawasan-rekap.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for pengawasan rekap
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(PengawasanRekapListRequest $request)
    {
        $data = $this->pengawasanRekapService->getRekapDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.pengawasan-rekap.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(PengawasanRekapListRequest $request)
    {
        $pengawasanRekap = $this->pengawasanRekapService->getRekapDetail($request->id);
        if (!is_null($pengawasanRekap)) {
            $result = $this->pengawasanRekapService->deleteRekap($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Rekap successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('pengawasan-rekap.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Search pengawasan rekap for Select2
     * =============================================
     */
    public function search(Request $request)
    {
        $search = $request->input('q');

        // You need to implement a search method in the service
        // For now, we'll return empty array
        $pengawasanRekapList = [];

        $formattedPengawasanRekap = $pengawasanRekapList->map(function ($pengawasanRekap) {
            return ['id' => $pengawasanRekap->id, 'text' => $pengawasanRekap->hasil_rekap];
        });

        return response()->json($formattedPengawasanRekap);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
