<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pengawasan\PengawasanListRequest;
use App\Http\Requests\Pengawasan\PengawasanTindakanLanjutanAddRequest;
use App\Http\Requests\Pengawasan\PengawasanTindakanLanjutanEditRequest;
use App\Services\PengawasanTindakanLanjutanService;
use App\Services\PengawasanTindakanLanjutanDetailService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

/**
 * ################################################
 *      THIS IS PENGAWASAN TINDAKAN LANJUTAN CONTROLLER
 *  the main purpose of this class is to show functionality
 *  for ULTIMATE CRUD concept in this SamBoilerplate
 *  I use this PengawasanTindakanLanjutan model since it's really needed
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
class PengawasanTindakanLanjutanController extends Controller
{
    private $pengawasanTindakanLanjutanService;
    private $pengawasanTindakanLanjutanDetailService;
    private $mainBreadcrumbs;

    public function __construct(
        PengawasanTindakanLanjutanService $pengawasanTindakanLanjutanService,
        PengawasanTindakanLanjutanDetailService $pengawasanTindakanLanjutanDetailService
    )
    {
        $this->pengawasanTindakanLanjutanService = $pengawasanTindakanLanjutanService;
        $this->pengawasanTindakanLanjutanDetailService = $pengawasanTindakanLanjutanDetailService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Pengawasan Tindakan Lanjutan' => route('pengawasan-tindakan-lanjutan.index'),
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


        $pengawasanTindakanLanjutanList = $this->pengawasanTindakanLanjutanService->listAllTindakanLanjutan($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.pengawasan-tindakan-lanjutan.index', compact('pengawasanTindakanLanjutanList', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new pengawasan tindakan lanjutan" pages
     * =============================================
     */
    public function create(Request $request, $pengawasanTindakanId = null)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        // Get current authenticated user's petugas data for province filtering
        $currentPetugas = \App\Models\Petugas::where('user_id', Auth::id())->first();
        $currentProvinsiId = null;

        if ($currentPetugas && $currentPetugas->penempatan) {
            $currentProvinsiId = $currentPetugas->penempatan;
        }

        // Get users for PIC selection, filtered by current user's province
        $pics = \App\Models\User::where('is_active', 1)
            ->whereHas('petugas', function($query) use ($currentProvinsiId) {
                if ($currentProvinsiId) {
                    $query->where('penempatan', $currentProvinsiId);
                }
            })
            ->orderBy('name', 'asc')
            ->get();

        // Get pengawasan tindakan options
        $pengawasanTindakans = \App\Models\PengawasanTindakan::where('is_active', 1)
            ->where('provinsi_id', $currentProvinsiId) // Filter by current user's province
            ->with(['rekap', 'pimpinan'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tindakan) {
                return [
                    'id' => $tindakan->id,
                    'tindak_lanjut' => $tindakan->tindak_lanjut ?? 'N/A',
                    'created_at' => $tindakan->created_at,
                    'formatted_date' => $tindakan->created_at->format('d/m/Y'),
                    'pimpinan_nama' => $tindakan->pimpinan?->name ?? 'N/A',
                    'rekap_judul' => $tindakan->rekap?->judul_rekap ?? 'N/A',
                ];
            });

        return view('admin.pages.pengawasan-tindakan-lanjutan.add', compact('breadcrumbs', 'pics', 'pengawasanTindakans', 'pengawasanTindakanId'));
    }

    /**
     * =============================================
     *      proses "add new pengawasan tindakan lanjutan" from previous form
     * =============================================
     */
    public function store(PengawasanTindakanLanjutanAddRequest $request)
    {
        $validatedData = $request->validated();

        // Get current authenticated user ID
        $userId = Auth::id();

        // Add created_by and updated_by with current user ID
        $validatedData['created_by'] = $userId;
        $validatedData['updated_by'] = $userId;

        $result = $this->pengawasanTindakanLanjutanService->addNewTindakanLanjutan($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Tindakan Lanjutan successfully added')
            : AlertHelper::createAlert('danger', 'Data Pengawasan Tindakan Lanjutan failed to be added');

        return redirect()->route('pengawasan-tindakan-lanjutan.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single pengawasan tindakan lanjutan entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->pengawasanTindakanLanjutanService->getTindakanLanjutanDetail($request->id);

        // Get tindakan lanjutan details if they exist
        $tindakanLanjutanDetails = collect();
        if ($data->details) {
            $tindakanLanjutanDetails = $this->pengawasanTindakanLanjutanDetailService->getDetailsByLanjutanId($data->id);
        }

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.pengawasan-tindakan-lanjutan.detail', compact('breadcrumbs', 'data', 'tindakanLanjutanDetails'));
    }

    /**
     * =============================================
     *     display "edit pengawasan tindakan lanjutan" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $pengawasanTindakanLanjutan = $this->pengawasanTindakanLanjutanService->getTindakanLanjutanDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        // Get users for PIC selection, filtered by current user's province
        $currentPetugasEdit = \App\Models\Petugas::where('user_id', Auth::id())->first();
        $currentProvinsiIdEdit = null;

        if ($currentPetugasEdit && $currentPetugasEdit->penempatan) {
            $currentProvinsiIdEdit = $currentPetugasEdit->penempatan;
        }

        $pics = \App\Models\User::where('is_active', 1)
            ->whereHas('petugas', function($query) use ($currentProvinsiIdEdit) {
                if ($currentProvinsiIdEdit) {
                    $query->where('penempatan', $currentProvinsiIdEdit);
                }
            })
            ->orderBy('name', 'asc')
            ->get();

        // Get pengawasan tindakan options
        $pengawasanTindakans = \App\Models\PengawasanTindakan::where('is_active', 1)
            ->with(['rekap', 'pimpinan'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tindakan) {
                return [
                    'id' => $tindakan->id,
                    'tindak_lanjut' => $tindakan->tindak_lanjut ?? 'N/A',
                    'created_at' => $tindakan->created_at,
                    'formatted_date' => $tindakan->created_at->format('d/m/Y'),
                    'pimpinan_nama' => $tindakan->pimpinan?->name ?? 'N/A',
                    'rekap_judul' => $tindakan->rekap?->judul_rekap ?? 'N/A',
                ];
            });

        return view('admin.pages.pengawasan-tindakan-lanjutan.edit', compact('breadcrumbs', 'pengawasanTindakanLanjutan', 'pics', 'pengawasanTindakans'));
    }

    /**
     * =============================================
     *      process "edit pengawasan tindakan lanjutan" from previous form
     * =============================================
     */
    public function update(PengawasanTindakanLanjutanEditRequest $request, $id)
    {
        $validatedData = $request->validated();

        // Add updated_by with current user ID
        $validatedData['updated_by'] = Auth::id();

        $result = $this->pengawasanTindakanLanjutanService->updateTindakanLanjutan($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Tindakan Lanjutan successfully updated')
            : AlertHelper::createAlert('danger', 'Data Pengawasan Tindakan Lanjutan failed to be updated');

        return redirect()->route('pengawasan-tindakan-lanjutan.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for pengawasan tindakan lanjutan
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(PengawasanListRequest $request)
    {
        $data = $this->pengawasanTindakanLanjutanService->getTindakanLanjutanDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.pengawasan-tindakan-lanjutan.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(PengawasanListRequest $request)
    {
        $pengawasanTindakanLanjutan = $this->pengawasanTindakanLanjutanService->getTindakanLanjutanDetail($request->id);
        if (!is_null($pengawasanTindakanLanjutan)) {
            $result = $this->pengawasanTindakanLanjutanService->deleteTindakanLanjutan($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data Pengawasan Tindakan Lanjutan successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('pengawasan-tindakan-lanjutan.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Search pengawasan tindakan lanjutan for Select2
     * =============================================
     */
    public function search(Request $request)
    {
        $search = $request->input('q');

        // You need to implement a search method in the service
        // For now, we'll return empty array
        $pengawasanTindakanLanjutanList = collect([]);

        $formattedPengawasanTindakanLanjutan = $pengawasanTindakanLanjutanList->map(function ($pengawasanTindakanLanjutan) {
            return ['id' => $pengawasanTindakanLanjutan->id, 'text' => $pengawasanTindakanLanjutan->tindak_lanjut];
        });

        return response()->json($formattedPengawasanTindakanLanjutan);
    }

    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
}
