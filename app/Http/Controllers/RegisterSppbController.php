<?php

namespace App\Http\Controllers;

use App\Services\RegisterSppbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\MasterProvinsi;
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

        $registerSppbs = $this->RegisterSppbService->listAllRegisterSppb($perPage, $sortField, $sortOrder, $keyword);

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
        $business = $user->business->first(); // Assuming a user has one business
        $provinsis = MasterProvinsi::all();
        $kotas = [];

        return view('admin.pages.register-sppb.add', compact('breadcrumbs', 'business', 'provinsis', 'kotas'));
    }

    /**
     * =============================================
     *      proses "add new RegisterSppb" from previous form
     * =============================================
     */
    public function store(RegisterSppbAddRequest $request)
    {
        $validatedData = $request->validated();
        // Set default values for removed fields
        $validatedData['status'] = true;
        $validatedData['nomor_registrasi'] = null;
        $validatedData['tanggal_terbit'] = null;
        $validatedData['tanggal_terakhir'] = null;
        $validatedData['is_unitusaha'] = true;
        $result = $this->RegisterSppbService->addNewRegisterSppb($validatedData);

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
        $result = $this->RegisterSppbService->updateRegisterSppb($request->validated(), $id);

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
