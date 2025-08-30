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
        $admins = \App\Models\User::whereHas('roles', function($query) {
            $query->where('role_code', 'admin');
        })->orderBy('name', 'asc')->get();
        $pics = \App\Models\User::whereHas('roles', function($query) {
            $query->where('role_code', 'pic');
        })->orderBy('name', 'asc')->get();

        // Get current authenticated user's petugas data
        $currentPetugas = \App\Models\Petugas::where('user_id', Auth::id())->first();
        $currentProvinsiId = null;
        $initiators = collect();

        if ($currentPetugas && $currentPetugas->penempatan) {
            $currentProvinsiId = $currentPetugas->penempatan;

            // Get all petugas in the same provinsi for the initiator filter
            $petugasInSameProvinsi = \App\Models\Petugas::where('penempatan', $currentProvinsiId)
                ->where('is_active', 1)
                ->with('user')
                ->get();

            $initiators = $petugasInSameProvinsi->map(function($petugas) {
                return $petugas->user;
            })->filter()->sortBy('name');
        }

        // Get provinsi data - filter by current user's provinsi if available
        $provinsis = \App\Models\MasterProvinsi::where('is_active', 1);
        if ($currentProvinsiId) {
            $provinsis = $provinsis->where('id', $currentProvinsiId);
        }
        $provinsis = $provinsis->orderBy('nama_provinsi', 'asc')->get();

        // Get pengawasan data - filter by current user's provinsi if available
        $pengawasansQuery = \App\Models\Pengawasan::with([
            'jenisPsat',
            'produkPsat',
            'lokasiProvinsi',
            'lokasiKota',
            'initiator'
        ])->where('is_active', 1);

        if ($currentProvinsiId) {
            $pengawasansQuery->where('lokasi_provinsi_id', $currentProvinsiId);
        }

        $pengawasans = $pengawasansQuery->orderBy('tanggal_mulai', 'desc')->get();

        return view('admin.pages.pengawasan-rekap.add', compact('breadcrumbs', 'jenisPsats', 'produkPsats', 'admins', 'pics', 'provinsis', 'pengawasans', 'initiators'));
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

        // Extract pengawasan IDs from the request
        $pengawasanIds = $request->input('pengawasan_ids', []);

        // Add pengawasan IDs to the data
        $validatedData['pengawasan_ids'] = $pengawasanIds;

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
        $admins = \App\Models\User::whereHas('roles', function($query) {
            $query->where('role_code', 'admin');
        })->orderBy('name', 'asc')->get();
        $pics = \App\Models\User::whereHas('roles', function($query) {
            $query->where('role_code', 'pic');
        })->orderBy('name', 'asc')->get();

        // Get current authenticated user's petugas data
        $currentPetugas = \App\Models\Petugas::where('user_id', Auth::id())->first();
        $currentProvinsiId = null;
        $initiators = collect();

        if ($currentPetugas && $currentPetugas->penempatan) {
            $currentProvinsiId = $currentPetugas->penempatan;

            // Get all petugas in the same provinsi for the initiator filter
            $petugasInSameProvinsi = \App\Models\Petugas::where('penempatan', $currentProvinsiId)
                ->where('is_active', 1)
                ->with('user')
                ->get();

            $initiators = $petugasInSameProvinsi->map(function($petugas) {
                return $petugas->user;
            })->filter()->sortBy('name');
        }

        // Get provinsi data - filter by current user's provinsi if available
        $provinsis = \App\Models\MasterProvinsi::where('is_active', 1);
        if ($currentProvinsiId) {
            $provinsis = $provinsis->where('id', $currentProvinsiId);
        }
        $provinsis = $provinsis->orderBy('nama_provinsi', 'asc')->get();

        // Get pengawasan data - filter by current user's provinsi if available
        $pengawasansQuery = \App\Models\Pengawasan::with([
            'jenisPsat',
            'produkPsat',
            'lokasiProvinsi',
            'lokasiKota',
            'initiator'
        ])->where('is_active', 1);

        if ($currentProvinsiId) {
            $pengawasansQuery->where('lokasi_provinsi_id', $currentProvinsiId);
        }

        $pengawasans = $pengawasansQuery->orderBy('tanggal_mulai', 'desc')->get();

        // Get currently selected pengawasan IDs for this rekap
        $selectedPengawasanIds = [];
        if ($pengawasanRekap && $pengawasanRekap->pengawasans) {
            foreach ($pengawasanRekap->pengawasans as $pengawasan) {
                $selectedPengawasanIds[] = $pengawasan->id;
            }
        }

        return view('admin.pages.pengawasan-rekap.edit', compact('breadcrumbs', 'pengawasanRekap', 'jenisPsats', 'produkPsats', 'admins', 'pics', 'provinsis', 'pengawasans', 'selectedPengawasanIds', 'initiators'));
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

        // Extract pengawasan IDs from the request
        $pengawasanIds = $request->input('pengawasan_ids', []);

        // Add pengawasan IDs to the data
        $validatedData['pengawasan_ids'] = $pengawasanIds;

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
        $pengawasanRekapList = collect([]);

        $formattedPengawasanRekap = $pengawasanRekapList->map(function ($pengawasanRekap) {
            return ['id' => $pengawasanRekap->id, 'text' => $pengawasanRekap->hasil_rekap];
        });

        return response()->json($formattedPengawasanRekap);
    }

    /**
     * =============================================
     *      Get lampiran fields
     * =============================================
     */
    public function getLampiranFields()
    {
        $lampiranFields = $this->pengawasanRekapService->getLampiranFields();

        return response()->json([
            'lampiran_fields' => $lampiranFields
        ]);
    }

    /**
     * =============================================
     *      Update lampiran for rekap
     * =============================================
     */
    public function updateLampiran(Request $request, $id)
    {
        $validatedData = $request->validate([
            'lampiran1' => 'nullable|string|max:200',
            'lampiran2' => 'nullable|string|max:200',
            'lampiran3' => 'nullable|string|max:200',
            'lampiran4' => 'nullable|string|max:200',
            'lampiran5' => 'nullable|string|max:200',
            'lampiran6' => 'nullable|string|max:200',
        ]);

        $result = $this->pengawasanRekapService->updateLampiranForRekap($id, $validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Lampiran Pengawasan Rekap successfully updated')
            : AlertHelper::createAlert('danger', 'Lampiran Pengawasan Rekap failed to be updated');

        return redirect()->back()->with('alerts', [$alert]);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================

    /**
     * =============================================
     *      Get pengawasan data for select section
     * =============================================
     */
    public function getPengawasanData(Request $request)
    {
        $keyword = $request->input('keyword');

        // Get current authenticated user's petugas data
        $currentPetugas = \App\Models\Petugas::where('user_id', Auth::id())->first();
        $currentProvinsiId = null;

        if ($currentPetugas && $currentPetugas->penempatan) {
            $currentProvinsiId = $currentPetugas->penempatan;
        }

        $query = \App\Models\Pengawasan::with([
            'jenisPsat',
            'produkPsat',
            'lokasiProvinsi',
            'lokasiKota',
            'initiator'
        ])->where('is_active', 1);

        // Always filter by current user's provinsi if available
        if ($currentProvinsiId) {
            $query->where('lokasi_provinsi_id', $currentProvinsiId);
        }

        // Apply keyword filter if provided
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->whereHas('initiator', function($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                })->orWhereHas('jenisPsat', function($q) use ($keyword) {
                    $q->where('nama_jenis_pangan_segar', 'like', '%' . $keyword . '%');
                })->orWhereHas('produkPsat', function($q) use ($keyword) {
                    $q->where('nama_bahan_pangan_segar', 'like', '%' . $keyword . '%');
                })->orWhereHas('lokasiProvinsi', function($q) use ($keyword) {
                    $q->where('nama_provinsi', 'like', '%' . $keyword . '%');
                })->orWhereHas('lokasiKota', function($q) use ($keyword) {
                    $q->where('nama_kota', 'like', '%' . $keyword . '%');
                });
            });
        }

        $pengawasanList = $query->orderBy('tanggal_mulai', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $pengawasanList
        ]);
    }
}
