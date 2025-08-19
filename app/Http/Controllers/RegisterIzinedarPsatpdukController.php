<?php

namespace App\Http\Controllers;

use App\Services\RegisterIzinedarPsatpdukService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\MasterProvinsi;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKota;
use App\Helpers\AlertHelper;
use App\Http\Requests\RegisterIzinedarPsatpdukRequest;
use App\Models\User;

class RegisterIzinedarPsatpdukController extends Controller
{
    private $registerIzinedarPsatpdukService;
    private $mainBreadcrumbs;

    public function __construct(RegisterIzinedarPsatpdukService $registerIzinedarPsatpdukService)
    {
        $this->registerIzinedarPsatpdukService = $registerIzinedarPsatpdukService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('register-izinedar-psatpduk.index'),
            'Register Izin EDAR PSATPDUK' => route('register-izinedar-psatpduk.index'),
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
        $registerIzinedarPsatpduks = $this->registerIzinedarPsatpdukService->listAllRegisterIzinedarPsatpduk($perPage, $sortField, $sortOrder, $keyword, $user);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.register-izinedar-psatpduk.index', compact('registerIzinedarPsatpduks', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new RegisterIzinedarPsatpduk" pages
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

        return view('admin.pages.register-izinedar-psatpduk.add', compact('breadcrumbs', 'business', 'provinsis', 'kotas', 'jenispsats', 'assignees'));
    }

    /**
     * =============================================
     *      proses "add new RegisterIzinedarPsatpduk" from previous form
     * =============================================
     */
    public function store(RegisterIzinedarPsatpdukRequest $request)
    {
        // dd($request->all());
        $validatedData = $request->except(['foto_1', 'foto_2', 'foto_3', 'foto_4', 'foto_5', 'foto_6', 'file_nib', 'file_sppb', 'file_izinedar_psatpduk']);

        $user = Auth::user();
        $validatedData['created_by'] = $user->id;
        $validatedData['updated_by'] = $user->id;

        // Set default values for status and is_enabled
        $validatedData['status'] = 'DIAJUKAN';
        $validatedData['is_enabled'] = true;

        // Handle file uploads for foto_1 to foto_6
        $uploadPath = 'images/upload/register';
        $publicPath = public_path($uploadPath);

        // Create directory if it doesn't exist
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        // Process each photo field
        for ($i = 1; $i <= 6; $i++) {
            $photoField = 'foto_' . $i;
            if ($request->hasFile($photoField)) {
                $file = $request->file($photoField);
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $file->move($publicPath, $filename);
                $validatedData[$photoField] = env('BASE_URL') . '/' . $uploadPath . '/' . $filename;
            }
        }

        // Handle file uploads for file_nib, file_sppb, and file_izinedar_psatpduk
        $fileUploadPath = 'files/upload/register';
        $filePublicPath = public_path($fileUploadPath);

        // Create directory if it doesn't exist
        if (!file_exists($filePublicPath)) {
            mkdir($filePublicPath, 0755, true);
        }

        // Process each file field
        $fileFields = ['file_nib', 'file_sppb', 'file_izinedar_psatpduk'];
        foreach ($fileFields as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $file->move($filePublicPath, $filename);
                $validatedData[$fileField] = env('BASE_URL') . '/' . $fileUploadPath . '/' . $filename;
            }
        }

        $result = $this->registerIzinedarPsatpdukService->addNewRegisterIzinedarPsatpduk($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nomor_izinedar_pduk . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nomor_izinedar_pduk . ' failed to be added');

        return redirect()->route('register-izinedar-psatpduk.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single RegisterIzinedarPsatpduk entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->registerIzinedarPsatpdukService->getRegisterIzinedarPsatpdukDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.register-izinedar-psatpduk.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit RegisterIzinedarPsatpduk" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $registerIzinedarPsatpduk = $this->registerIzinedarPsatpdukService->getRegisterIzinedarPsatpdukDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        $provinsis = MasterProvinsi::all();
        $jenispsats = MasterJenisPanganSegar::all();

        // Get assignee users from config
        $assigneeEmail = config('constant.REGISTER_IZINEDAR_PL_ASSIGNEE');
        $assignees = User::where('email', $assigneeEmail)->get();

        // If business exists and has a provinsi_id, load the corresponding kotas
        $kotas = collect();
        if ($registerIzinedarPsatpduk->provinsi_unitusaha) {
            $kotas = MasterKota::where('provinsi_id', $registerIzinedarPsatpduk->provinsi_unitusaha)->get();
        }

        return view('admin.pages.register-izinedar-psatpduk.edit', compact('breadcrumbs', 'registerIzinedarPsatpduk', 'provinsis', 'kotas', 'jenispsats', 'assignees'));
    }

    /**
     * =============================================
     *      process "edit RegisterIzinedarPsatpduk" from previous form
     * =============================================
     */
    public function update(RegisterIzinedarPsatpdukRequest $request, $id)
    {
        // Get existing data first
        $existingData = $this->registerIzinedarPsatpdukService->getRegisterIzinedarPsatpdukDetail($id);

        // Get validated data except file fields
        $validatedData = $request->except(['foto_1', 'foto_2', 'foto_3', 'foto_4', 'foto_5', 'foto_6', 'file_nib', 'file_sppb', 'file_izinedar_psatpduk']);

        $user = Auth::user();
        $validatedData['updated_by'] = $user->id;

        // Ensure status and is_enabled are set (they might be removed from form)
        $validatedData['status'] = $validatedData['status'] ?? config('workflow.izinedar_statuses.DIAJUKAN');
        $validatedData['is_unitusaha'] = false;
        $validatedData['is_enabled'] = $validatedData['is_enabled'] ?? true;

        // Handle file uploads for foto_1 to foto_6
        $uploadPath = 'images/upload/register';
        $publicPath = public_path($uploadPath);

        // Create directory if it doesn't exist
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        // Process each photo field
        for ($i = 1; $i <= 6; $i++) {
            $photoField = 'foto_' . $i;
            if ($request->hasFile($photoField)) {
                $file = $request->file($photoField);
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $file->move($publicPath, $filename);
                $validatedData[$photoField] = env('BASE_URL') . '/' . $uploadPath . '/' . $filename;
            } else {
                // Keep existing file if no new file is uploaded
                $validatedData[$photoField] = $existingData->$photoField;
            }
        }

        // Handle file uploads for file_nib, file_sppb, and file_izinedar_psatpduk
        $fileUploadPath = 'files/upload/register';
        $filePublicPath = public_path($fileUploadPath);

        // Create directory if it doesn't exist
        if (!file_exists($filePublicPath)) {
            mkdir($filePublicPath, 0755, true);
        }

        // Process each file field
        $fileFields = ['file_nib', 'file_sppb', 'file_izinedar_psatpduk'];
        foreach ($fileFields as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $file->move($filePublicPath, $filename);
                $validatedData[$fileField] = env('BASE_URL') . '/' . $fileUploadPath . '/' . $filename;
            } else {
                // Keep existing file if no new file is uploaded
                $validatedData[$fileField] = $existingData->$fileField;
            }
        }

        $result = $this->registerIzinedarPsatpdukService->updateRegisterIzinedarPsatpduk($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nomor_izinedar_pduk . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nomor_izinedar_pduk . ' failed to be updated');

        return redirect()->route('register-izinedar-psatpduk.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for RegisterIzinedarPsatpduk
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(Request $request)
    {
        $data = $this->registerIzinedarPsatpdukService->getRegisterIzinedarPsatpdukDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.register-izinedar-psatpduk.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(Request $request)
    {
        $registerIzinedarPsatpduk = $this->registerIzinedarPsatpdukService->getRegisterIzinedarPsatpdukDetail($request->id);
        if (!is_null($registerIzinedarPsatpduk)) {
            $result = $this->registerIzinedarPsatpdukService->deleteRegisterIzinedarPsatpduk($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $registerIzinedarPsatpduk->nomor_izinedar_pduk . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('register-izinedar-psatpduk.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      update status
     * =============================================
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $user = Auth::user();

        $result = $this->registerIzinedarPsatpdukService->updateStatus($id, $status, $user->id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Status successfully updated to ' . $status)
            : AlertHelper::createAlert('danger', 'Failed to update status');

        return redirect()->route('register-izinedar-psatpduk.detail', ['id' => $id])->with('alerts', [$alert]);
    }
}
