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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

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

        // Get current authenticated user's petugas data for province filtering
        $currentPetugas = \App\Models\Petugas::where('user_id', Auth::id())->first();
        $currentProvinsiId = null;

        if ($currentPetugas && $currentPetugas->penempatan) {
            $currentProvinsiId = $currentPetugas->penempatan;
        }

        $pengawasanRekapList = $this->pengawasanRekapService->listAllRekap($perPage, $sortField, $sortOrder, $keyword, $currentProvinsiId);

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
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();

            // Get current authenticated user ID
            $userId = Auth::id();

            // Add created_by and updated_by with current user ID
            $validatedData['created_by'] = $userId;
            $validatedData['updated_by'] = $userId;

            // Extract pengawasan IDs from the request
            $pengawasanIds = $request->input('pengawasan_ids', []);

            // Process file uploads
            $lampiranFields = ['lampiran1', 'lampiran2', 'lampiran3', 'lampiran4', 'lampiran5', 'lampiran6'];
            foreach ($lampiranFields as $field) {
                if ($request->hasFile($field) && $request->file($field)->isValid()) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('pengawasan/rekap', $fileName, 'public');
                    $validatedData[$field] = $filePath;
                } else {
                    $validatedData[$field] = null;
                }
            }

            // Add pengawasan IDs to the data
            $validatedData['pengawasan_ids'] = $pengawasanIds;

            $result = $this->pengawasanRekapService->addNewRekap($validatedData);

            if (!$result) {
                throw new Exception("Failed to create rekap");
            }

            DB::commit();
            $alert = AlertHelper::createAlert('success', 'Data Pengawasan Rekap successfully added');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to store pengawasan rekap: {$exception->getMessage()}");
            $alert = AlertHelper::createAlert('danger', 'Data Pengawasan Rekap failed to be added');
        }

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
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();

            // Add updated_by with current user ID
            $validatedData['updated_by'] = Auth::id();

            // Extract pengawasan IDs from the request
            $pengawasanIds = $request->input('pengawasan_ids', []);
            Log::info('PengawasanRekap store - Received pengawasan_ids:', [
                'count' => count($pengawasanIds),
                'ids' => $pengawasanIds,
                'user_id' => Auth::id()
            ]);

            // Process file uploads
            $lampiranFields = ['lampiran1', 'lampiran2', 'lampiran3', 'lampiran4', 'lampiran5', 'lampiran6'];
            foreach ($lampiranFields as $field) {
                if ($request->hasFile($field) && $request->file($field)->isValid()) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('pengawasan/rekap', $fileName, 'public');
                    $validatedData[$field] = $filePath;
                }
                // If no file is uploaded, keep the existing value (don't set to null)
            }

            // Add pengawasan IDs to the data
            $validatedData['pengawasan_ids'] = $pengawasanIds;

            $result = $this->pengawasanRekapService->updateRekap($validatedData, $id);

            if (!$result) {
                throw new Exception("Failed to update rekap");
            }

            DB::commit();
            $alert = AlertHelper::createAlert('success', 'Data Pengawasan Rekap successfully updated');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update pengawasan rekap: {$exception->getMessage()}");
            $alert = AlertHelper::createAlert('danger', 'Data Pengawasan Rekap failed to be updated');
        }

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
            'lampiran1' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran2' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran3' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran4' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran5' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran6' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
        ]);

        DB::beginTransaction();
        try {
            $rekap = $this->pengawasanRekapService->getRekapDetail($id);
            if (!$rekap) {
                throw new Exception("Rekap not found");
            }

            // Process each file upload
            foreach ($validatedData as $field => $file) {
                if ($file && $file->isValid()) {
                    // Generate unique filename
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('pengawasan/rekap', $fileName, 'public');

                    // Update the rekap record with file path
                    $rekap->$field = $filePath;
                    $rekap->save();
                } elseif ($file === null) {
                    // If no file provided, set to null
                    $rekap->$field = null;
                    $rekap->save();
                }
            }

            DB::commit();
            $alert = AlertHelper::createAlert('success', 'Lampiran Pengawasan Rekap successfully updated');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update lampiran for rekap $id: {$exception->getMessage()}");
            $alert = AlertHelper::createAlert('danger', 'Lampiran Pengawasan Rekap failed to be updated');
        }

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
        try {
            $keyword = $request->input('keyword');
            $sortField = $request->input('sort_field', 'tanggal_mulai');
            $sortOrder = $request->input('sort_order', 'desc');
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10); // Default 10 items per page for selection

            Log::info('getPengawasanData called', [
                'keyword' => $keyword,
                'sortField' => $sortField,
                'sortOrder' => $sortOrder,
                'page' => $page,
                'perPage' => $perPage,
                'user_id' => Auth::id()
            ]);

            // Get current authenticated user's petugas data
            $currentPetugas = \App\Models\Petugas::where('user_id', Auth::id())->first();
            $currentProvinsiId = null;

            if ($currentPetugas && $currentPetugas->penempatan) {
                $currentProvinsiId = $currentPetugas->penempatan;
            }

            Log::info('User province info', [
                'petugas_found' => $currentPetugas ? true : false,
                'penempatan' => $currentPetugas ? $currentPetugas->penempatan : null,
                'currentProvinsiId' => $currentProvinsiId
            ]);

        // Use the same query structure as in PengawasanRepository::getAllPengawasan
        $query = \App\Models\Pengawasan::query()
            ->with([
                'initiator',
                'jenisPsat',
                'produkPsat',
                'lokasiKota',
                'lokasiProvinsi'
            ]);

        // Filter by province if available
        if ($currentProvinsiId) {
            $query->where('lokasi_provinsi_id', $currentProvinsiId);
        }

        // Apply keyword filter if provided
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->whereRaw('lower(lokasi_alamat) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereHas('initiator', function($q) use ($keyword) {
                      $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                  })->orWhereHas('jenisPsat', function($q) use ($keyword) {
                      $q->whereRaw('lower(nama_jenis_pangan_segar) LIKE ?', ['%' . strtolower($keyword) . '%']);
                  })->orWhereHas('produkPsat', function($q) use ($keyword) {
                      $q->whereRaw('lower(nama_bahan_pangan_segar) LIKE ?', ['%' . strtolower($keyword) . '%']);
                  })->orWhereHas('lokasiProvinsi', function($q) use ($keyword) {
                      $q->whereRaw('lower(nama_provinsi) LIKE ?', ['%' . strtolower($keyword) . '%']);
                  })->orWhereHas('lokasiKota', function($q) use ($keyword) {
                      $q->whereRaw('lower(nama_kota) LIKE ?', ['%' . strtolower($keyword) . '%']);
                  });
            });
        }

        // Apply sorting
        if ($sortField === 'jenis_psat.nama_jenis_pangan_segar') {
            $query->leftJoin('master_jenis_pangan_segars', 'pengawasan.jenis_psat_id', '=', 'master_jenis_pangan_segars.id')
                  ->select('pengawasan.*')
                  ->orderBy('master_jenis_pangan_segars.nama_jenis_pangan_segar', $sortOrder);
        } elseif ($sortField === 'produk_psat.nama_bahan_pangan_segar') {
            $query->leftJoin('master_bahan_pangan_segars', 'pengawasan.produk_psat_id', '=', 'master_bahan_pangan_segars.id')
                  ->select('pengawasan.*')
                  ->orderBy('master_bahan_pangan_segars.nama_bahan_pangan_segar', $sortOrder);
        } elseif ($sortField === 'lokasi_provinsi.nama_provinsi') {
            $query->leftJoin('master_provinsis', 'pengawasan.lokasi_provinsi_id', '=', 'master_provinsis.id')
                  ->select('pengawasan.*')
                  ->orderBy('master_provinsis.nama_provinsi', $sortOrder);
        } elseif ($sortField === 'lokasi_kota.nama_kota') {
            $query->leftJoin('master_kotas', 'pengawasan.lokasi_kota_id', '=', 'master_kotas.id')
                  ->select('pengawasan.*')
                  ->orderBy('master_kotas.nama_kota', $sortOrder);
        } elseif ($sortField === 'initiator.name') {
            $query->leftJoin('users', 'pengawasan.user_id_initiator', '=', 'users.id')
                  ->select('pengawasan.*')
                  ->orderBy('users.name', $sortOrder);
        } elseif ($sortField === 'status') {
            $query->orderBy('status', $sortOrder);
        } else {
            $query->orderBy($sortField, $sortOrder);
        }

        // Get paginated results
        $pengawasanList = $query->paginate($perPage, ['*'], 'page', $page);

        Log::info('Query results', [
            'total_results' => $pengawasanList->total(),
            'current_page' => $pengawasanList->currentPage(),
            'per_page' => $pengawasanList->perPage(),
            'items_count' => count($pengawasanList->items())
        ]);

        return response()->json([
            'success' => true,
            'data' => $pengawasanList->items(),
            'pagination' => [
                'current_page' => $pengawasanList->currentPage(),
                'last_page' => $pengawasanList->lastPage(),
                'per_page' => $pengawasanList->perPage(),
                'total' => $pengawasanList->total(),
                'from' => $pengawasanList->firstItem(),
                'to' => $pengawasanList->lastItem()
            ]
        ]);
        } catch (\Exception $exception) {
            Log::error('Error in getPengawasanData', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data pengawasan: ' . $exception->getMessage()
            ], 500);
        }
    }
}
