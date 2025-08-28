<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pengawasan\PengawasanListRequest;
use App\Http\Requests\Pengawasan\PengawasanAddRequest;
use App\Http\Requests\Pengawasan\PengawasanEditRequest;
use App\Services\PengawasanService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Get the logged-in user
        $user = Auth::user();

        // Check if user is petugas and get their province authority
        $provinsiId = null;
        if ($user->petugas) {
            $provinsiId = $user->petugas->penempatan;
        }

        $pengawasanList = $this->pengawasanService->listAllPengawasan($perPage, $sortField, $sortOrder, $keyword, $provinsiId);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.pengawasan.index', compact('pengawasanList', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts', 'user'));
    }

    /**
     * =============================================
     *      display "add new pengawasan" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        // Get the logged-in user
        $user = Auth::user();

        // Filter provinces based on user role
        // Check if user has ROLE_ADMIN by querying the database directly
        $isAdmin = $user->hasRole('ROLE_ADMIN');

        if ($isAdmin) {
            // Admin can see all provinces
            $provinsis = \App\Models\MasterProvinsi::orderBy('nama_provinsi', 'asc')->get();
        } else {
            // Regular users can only see their assigned province
            $provinsis = collect();
            if ($user->petugas && $user->petugas->penempatan) {
                $provinsis = \App\Models\MasterProvinsi::where('id', $user->petugas->penempatan)->orderBy('nama_provinsi', 'asc')->get();
            }
        }

        $kotas = [];

        // Get jenis psat and produk psat data
        $jenisPsats = \App\Models\MasterJenisPanganSegar::where('is_active', 1)->orderBy('nama_jenis_pangan_segar', 'asc')->get();
        $produkPsats = [];

        return view('admin.pages.pengawasan.add', compact('breadcrumbs', 'provinsis', 'kotas', 'jenisPsats', 'produkPsats'));
    }

    /**
     * =============================================
     *      proses "add new pengawasan" from previous form
     * =============================================
     */
    public function store(PengawasanAddRequest $request)
    {
        $validatedData = $request->validated();

        // Get current authenticated user ID
        $userId = Auth::id();

        // Add user_id_initiator if not present
        if (!isset($validatedData['user_id_initiator'])) {
            $validatedData['user_id_initiator'] = $userId;
        }

        // Add created_by and updated_by with current user ID
        $validatedData['created_by'] = $userId;
        $validatedData['updated_by'] = $userId;

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

        // Get the logged-in user
        $user = Auth::user();

        // Filter provinces based on user role
        // Check if user has ROLE_ADMIN by querying the database directly
        $isAdmin = DB::table('role_user')
            ->join('role_master', 'role_user.role_id', '=', 'role_master.id')
            ->where('role_user.user_id', $user->id)
            ->where('role_master.role_code', 'ROLE_ADMIN')
            ->exists();

        if ($isAdmin) {
            // Admin can see all provinces
            $provinsis = \App\Models\MasterProvinsi::orderBy('nama_provinsi', 'asc')->get();
        } else {
            // Regular users can only see their assigned province
            $provinsis = collect();
            if ($user->petugas && $user->petugas->penempatan) {
                $provinsis = \App\Models\MasterProvinsi::where('id', $user->petugas->penempatan)->orderBy('nama_provinsi', 'asc')->get();
            }
        }

        $kotas = [];
        if ($pengawasan && $pengawasan->lokasi_provinsi_id) {
            $kotas = \App\Models\MasterKota::where('provinsi_id', $pengawasan->lokasi_provinsi_id)->get();
        }

        // Get jenis psat and produk psat data
        $jenisPsats = \App\Models\MasterJenisPanganSegar::where('is_active', 1)->orderBy('nama_jenis_pangan_segar', 'asc')->get();
        $produkPsats = [];
        if ($pengawasan && $pengawasan->jenis_psat_id) {
            $produkPsats = \App\Models\MasterBahanPanganSegar::where('jenis_id', $pengawasan->jenis_psat_id)->where('is_active', 1)->orderBy('nama_bahan_pangan_segar', 'asc')->get();
        }

        return view('admin.pages.pengawasan.edit', compact('breadcrumbs', 'pengawasan', 'provinsis', 'kotas', 'jenisPsats', 'produkPsats'));
    }

    /**
     * =============================================
     *      process "edit pengawasan" from previous form
     * =============================================
     */
    public function update(PengawasanEditRequest $request, $id)
    {
        $validatedData = $request->validated();

        // Add updated_by with current user ID
        $validatedData['updated_by'] = Auth::id();

        $result = $this->pengawasanService->updatePengawasan($validatedData, $id);

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

        return response()->json($formattedPengawasan);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
