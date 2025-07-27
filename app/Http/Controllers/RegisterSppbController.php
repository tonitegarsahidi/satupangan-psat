<?php

namespace App\Http\Controllers;

use App\Services\RegisterSppbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\MasterProvinsi;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterPenanganan;
use App\Helpers\AlertHelper;
use App\Http\Requests\RegisterSppb\RegisterSppbAddRequest;
use App\Http\Requests\RegisterSppb\RegisterSppbEditRequest;
use App\Http\Requests\RegisterSppb\RegisterSppbListRequest;
use Illuminate\Validation\ValidationException;

class RegisterSppbController extends Controller
{
    private $RegisterSppbService;
    private $mainBreadcrumbs;

    public function __construct(RegisterSppbService $RegisterSppbService)
    {
        $this->RegisterSppbService = $RegisterSppbService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('register-sppb.index'),
            'Register SPPB' => route('register-sppb.index'),
        ];
    }

    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(RegisterSppbListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $user = \Auth::user();
        $registerSppbs = $this->RegisterSppbService->listAllRegisterSppb($perPage, $sortField, $sortOrder, $keyword, $user);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.register-sppb.index', compact('registerSppbs', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new RegisterSppb" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        $user = Auth::user();
        $business = $user->business; // Get the business relationship directly (hasOne)
        $provinsis = MasterProvinsi::all();
        $jenispsats = \App\Models\MasterJenisPanganSegar::all();
        $penanganans = MasterPenanganan::all();

        // If business exists and has a provinsi_id, load the corresponding kotas
        $kotas = collect();
        if ($business && $business->provinsi_id) {
            $kotas = \App\Models\MasterKota::where('provinsi_id', $business->provinsi_id)->get();
        }

        return view('admin.pages.register-sppb.add', compact('breadcrumbs', 'business', 'provinsis', 'kotas', 'jenispsats', 'penanganans'));
    }

    /**
     * =============================================
     *      proses "add new RegisterSppb" from previous form
     * =============================================
     */
    public function store(RegisterSppbAddRequest $request)
    {
        $validatedData = $request->validated();

        // Extract jenispsat_id and ruang_lingkup_penanganan from validated data
        $jenispsatIds = $validatedData['jenispsat_id'] ?? [];
        $ruangLingkupPenanganan = $validatedData['ruang_lingkup_penanganan'] ?? null;
        unset($validatedData['jenispsat_id']);
        unset($validatedData['ruang_lingkup_penanganan']);

        // Add ruang_lingkup_penanganan to validated data
        $validatedData['status'] = config('workflow.sppb_statuses.DIAJUKAN');
        $validatedData['penanganan_id'] = $ruangLingkupPenanganan;

        $result = $this->RegisterSppbService->addNewRegisterSppb($validatedData, $jenispsatIds);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nomor_registrasi . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nomor_registrasi . ' failed to be added');

        return redirect()->route('register-sppb.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single RegisterSppb entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->RegisterSppbService->getRegisterSppbDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.register-sppb.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit RegisterSppb" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $registerSppb = $this->RegisterSppbService->getRegisterSppbDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.register-sppb.edit', compact('breadcrumbs', 'registerSppb'));
    }

    /**
     * =============================================
     *      process "edit RegisterSppb" from previous form
     * =============================================
     */
    public function update(RegisterSppbEditRequest $request, $id)
    {
        $validatedData = $request->validated();

        // Extract jenispsat_id array and remove it from validated data
        $jenispsatIds = $validatedData['jenispsat_id'];
        unset($validatedData['jenispsat_id']);

        $result = $this->RegisterSppbService->updateRegisterSppb($validatedData, $id, $jenispsatIds);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nomor_registrasi . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nomor_registrasi . ' failed to be updated');

        return redirect()->route('register-sppb.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for RegisterSppb
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(RegisterSppbListRequest $request)
    {
        $data = $this->RegisterSppbService->getRegisterSppbDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.register-sppb.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(RegisterSppbListRequest $request)
    {
        $registerSppb = $this->RegisterSppbService->getRegisterSppbDetail($request->id);
        if (!is_null($registerSppb)) {
            $result = $this->RegisterSppbService->deleteRegisterSppb($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $registerSppb->nomor_registrasi . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('register-sppb.index')->with('alerts', [$alert]);
    }
}
