<?php

namespace App\Http\Controllers;

use App\Services\RegisterIzinedarPsatplService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\MasterProvinsi;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKota;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class RegisterIzinedarPsatplController extends Controller
{
    private $registerIzinedarPsatplService;
    private $mainBreadcrumbs;

    public function __construct(RegisterIzinedarPsatplService $registerIzinedarPsatplService)
    {
        $this->registerIzinedarPsatplService = $registerIzinedarPsatplService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('register-izinedar-psatpl.index'),
            'Register Izin EDAR PSATPL' => route('register-izinedar-psatpl.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(Request $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $user = Auth::user();
        $registerIzinedarPsatpls = $this->registerIzinedarPsatplService->listAllRegisterIzinedarPsatpl($perPage, $sortField, $sortOrder, $keyword, $user);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.register-izinedar-psatpl.index', compact('registerIzinedarPsatpls', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new RegisterIzinedarPsatpl" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        $user = Auth::user();
        $business = $user->business; // Get the business relationship directly (hasOne)
        $provinsis = MasterProvinsi::all();
        $jenispsats = MasterJenisPanganSegar::all();

        // Get assignee users from config
        $assigneeEmail = config('constant.REGISTER_IZINEDAR_PL_ASSIGNEE');
        $assignees = User::where('email', $assigneeEmail)->get();

        // If business exists and has a provinsi_id, load the corresponding kotas
        $kotas = collect();
        if ($business && $business->provinsi_id) {
            $kotas = MasterKota::where('provinsi_id', $business->provinsi_id)->get();
        }

        return view('admin.pages.register-izinedar-psatpl.add', compact('breadcrumbs', 'business', 'provinsis', 'kotas', 'jenispsats', 'assignees'));
    }

    /**
     * =============================================
     *      proses "add new RegisterIzinedarPsatpl" from previous form
     * =============================================
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'business_id' => 'required|uuid|exists:business,id',
            'nomor_registrasi' => 'nullable|string|max:50',
            'is_unitusaha' => 'required|boolean',
            'nama_unitusaha' => 'nullable|string|max:200',
            'alamat_unitusaha' => 'nullable|string|max:200',
            'alamat_unitpenanganan' => 'nullable|string|max:200',
            'provinsi_unitusaha' => 'nullable|uuid|exists:master_provinsis,id',
            'kota_unitusaha' => 'nullable|uuid|exists:master_kotas,id',
            'nib_unitusaha' => 'nullable|string|max:200',
            'jenis_psat' => 'nullable|uuid|exists:master_jenis_pangan_segars,id',
            'nama_komoditas' => 'nullable|string|max:200',
            'nama_latin' => 'nullable|string|max:200',
            'negara_asal' => 'nullable|string|max:200',
            'merk_dagang' => 'nullable|string|max:200',
            'jenis_kemasan' => 'nullable|string|max:200',
            'ukuran_berat' => 'nullable|string|max:200',
            'klaim' => 'nullable|string|max:200',
            'foto_1' => 'nullable|string|max:200',
            'foto_2' => 'nullable|string|max:200',
            'foto_3' => 'nullable|string|max:200',
            'foto_4' => 'nullable|string|max:200',
            'foto_5' => 'nullable|string|max:200',
            'foto_6' => 'nullable|string|max:200',
            'okkp_penangungjawab' => 'nullable|uuid|exists:users,id',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_terakhir' => 'nullable|date',
            'created_by' => 'nullable|string',
            'updated_by' => 'nullable|string',
        ]);

        $user = Auth::user();
        $validatedData['created_by'] = $user->id;
        $validatedData['updated_by'] = $user->id;

        // Set default values for status and is_enabled
        $validatedData['status'] = 'DIAJUKAN';
        $validatedData['is_enabled'] = true;

        $result = $this->registerIzinedarPsatplService->addNewRegisterIzinedarPsatpl($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nomor_registrasi . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nomor_registrasi . ' failed to be added');

        return redirect()->route('register-izinedar-psatpl.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single RegisterIzinedarPsatpl entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->registerIzinedarPsatplService->getRegisterIzinedarPsatplDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.register-izinedar-psatpl.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit RegisterIzinedarPsatpl" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $registerIzinedarPsatpl = $this->registerIzinedarPsatplService->getRegisterIzinedarPsatplDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        $provinsis = MasterProvinsi::all();
        $jenispsats = MasterJenisPanganSegar::all();

        // If business exists and has a provinsi_id, load the corresponding kotas
        $kotas = collect();
        if ($registerIzinedarPsatpl->provinsi_unitusaha) {
            $kotas = MasterKota::where('provinsi_id', $registerIzinedarPsatpl->provinsi_unitusaha)->get();
        }

        return view('admin.pages.register-izinedar-psatpl.edit', compact('breadcrumbs', 'registerIzinedarPsatpl', 'provinsis', 'kotas', 'jenispsats'));
    }

    /**
     * =============================================
     *      process "edit RegisterIzinedarPsatpl" from previous form
     * =============================================
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'business_id' => 'required|uuid|exists:business,id',
            'nomor_registrasi' => 'nullable|string|max:50',
            'is_unitusaha' => 'required|boolean',
            'nama_unitusaha' => 'nullable|string|max:200',
            'alamat_unitusaha' => 'nullable|string|max:200',
            'alamat_unitpenanganan' => 'nullable|string|max:200',
            'provinsi_unitusaha' => 'nullable|uuid|exists:master_provinsis,id',
            'kota_unitusaha' => 'nullable|uuid|exists:master_kotas,id',
            'nib_unitusaha' => 'nullable|string|max:200',
            'jenis_psat' => 'nullable|uuid|exists:master_jenis_pangan_segars,id',
            'nama_komoditas' => 'nullable|string|max:200',
            'nama_latin' => 'nullable|string|max:200',
            'negara_asal' => 'nullable|string|max:200',
            'merk_dagang' => 'nullable|string|max:200',
            'jenis_kemasan' => 'nullable|string|max:200',
            'ukuran_berat' => 'nullable|string|max:200',
            'klaim' => 'nullable|string|max:200',
            'foto_1' => 'nullable|string|max:200',
            'foto_2' => 'nullable|string|max:200',
            'foto_3' => 'nullable|string|max:200',
            'foto_4' => 'nullable|string|max:200',
            'foto_5' => 'nullable|string|max:200',
            'foto_6' => 'nullable|string|max:200',
            'okkp_penangungjawab' => 'nullable|uuid|exists:users,id',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_terakhir' => 'nullable|date',
            'updated_by' => 'nullable|string',
        ]);

        $user = Auth::user();
        $validatedData['updated_by'] = $user->id;

        // Ensure status and is_enabled are set (they might be removed from form)
        $validatedData['status'] = $validatedData['status'] ?? 'DIAJUKAN';
        $validatedData['is_enabled'] = $validatedData['is_enabled'] ?? true;

        $result = $this->registerIzinedarPsatplService->updateRegisterIzinedarPsatpl($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nomor_registrasi . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nomor_registrasi . ' failed to be updated');

        return redirect()->route('register-izinedar-psatpl.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for RegisterIzinedarPsatpl
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(Request $request)
    {
        $data = $this->registerIzinedarPsatplService->getRegisterIzinedarPsatplDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.register-izinedar-psatpl.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(Request $request)
    {
        $registerIzinedarPsatpl = $this->registerIzinedarPsatplService->getRegisterIzinedarPsatplDetail($request->id);
        if (!is_null($registerIzinedarPsatpl)) {
            $result = $this->registerIzinedarPsatplService->deleteRegisterIzinedarPsatpl($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $registerIzinedarPsatpl->nomor_registrasi . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('register-izinedar-psatpl.index')->with('alerts', [$alert]);
    }
}
