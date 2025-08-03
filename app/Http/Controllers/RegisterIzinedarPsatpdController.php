<?php

namespace App\Http\Controllers;

use App\Services\RegisterIzinedarPsatpdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\MasterProvinsi;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKota;
use App\Helpers\AlertHelper;
use App\Http\Requests\RegisterIzinedarPsatpdRequest;
use App\Models\User;

class RegisterIzinedarPsatpdController extends Controller
{
    private $registerIzinedarPsatpdService;
    private $mainBreadcrumbs;

    public function __construct(RegisterIzinedarPsatpdService $registerIzinedarPsatpdService)
    {
        $this->registerIzinedarPsatpdService = $registerIzinedarPsatpdService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('register-izinedar-psatpd.index'),
            'Register Izin EDAR PSATPD' => route('register-izinedar-psatpd.index'),
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
        $registerIzinedarPsatpds = $this->registerIzinedarPsatpdService->listAllRegisterIzinedarPsatpd($perPage, $sortField, $sortOrder, $keyword, $user);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.register-izinedar-psatpd.index', compact('registerIzinedarPsatpds', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new RegisterIzinedarPsatpd" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        $user = Auth::user();
        $business = $user->business; // Get the business relationship directly (hasOne)
        $provinsis = MasterProvinsi::all();
        $jenispsats = MasterJenisPanganSegar::all();

        // Get assignee users from config yang  roles nya operator, tapi bukan kantorpusat
        $notAssigneeEmail = config('constant.REGISTER_IZINEDAR_PL_ASSIGNEE');
        $assignees = User::where('email', '!=', $notAssigneeEmail)
                        ->whereHas('roles', function($query) {
                            $query->where('role_code', 'ROLE_OPERATOR');
                        })->orderBy('name')->get();

        // If business exists and has a provinsi_id, load the corresponding kotas
        $kotas = collect();
        if ($business && $business->provinsi_id) {
            $kotas = MasterKota::where('provinsi_id', $business->provinsi_id)->get();
        }

        return view('admin.pages.register-izinedar-psatpd.add', compact('breadcrumbs', 'business', 'provinsis', 'kotas', 'jenispsats', 'assignees'));
    }

    /**
     * =============================================
     *      proses "add new RegisterIzinedarPsatpd" from previous form
     * =============================================
     */
    public function store(RegisterIzinedarPsatpdRequest $request)
    {
        // dd($request->all());
        $validatedData = $request->except(['foto_1', 'foto_2', 'foto_3', 'foto_4', 'foto_5', 'foto_6', 'file_nib', 'file_sppb', 'file_izinedar_psatpd']);

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

        // Handle file uploads for file_nib, file_sppb, and file_izinedar_psatpd
        $fileUploadPath = 'files/upload/register';
        $filePublicPath = public_path($fileUploadPath);

        // Create directory if it doesn't exist
        if (!file_exists($filePublicPath)) {
            mkdir($filePublicPath, 0755, true);
        }

        // Process each file field
        $fileFields = ['file_nib', 'file_sppb', 'file_izinedar_psatpd'];
        foreach ($fileFields as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $file->move($filePublicPath, $filename);
                $validatedData[$fileField] = env('BASE_URL') . '/' . $fileUploadPath . '/' . $filename;
            }
        }

        $result = $this->registerIzinedarPsatpdService->addNewRegisterIzinedarPsatpd($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nomor_izinedar_pl . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nomor_izinedar_pl . ' failed to be added');

        return redirect()->route('register-izinedar-psatpd.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single RegisterIzinedarPsatpd entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->registerIzinedarPsatpdService->getRegisterIzinedarPsatpdDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.register-izinedar-psatpd.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit RegisterIzinedarPsatpd" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $registerIzinedarPsatpd = $this->registerIzinedarPsatpdService->getRegisterIzinedarPsatpdDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        $provinsis = MasterProvinsi::all();
        $jenispsats = MasterJenisPanganSegar::all();

        // Get assignee users from config yang  roles nya operator, tapi bukan kantorpusat
        $notAssigneeEmail = config('constant.REGISTER_IZINEDAR_PL_ASSIGNEE');
        $assignees = User::where('email', '!=', $notAssigneeEmail)
                        ->whereHas('roles', function($query) {
                            $query->where('role_code', 'ROLE_OPERATOR');
                        })->orderBy('name')->get();


        // If business exists and has a provinsi_id, load the corresponding kotas
        $kotas = collect();
        if ($registerIzinedarPsatpd->provinsi_unitusaha) {
            $kotas = MasterKota::where('provinsi_id', $registerIzinedarPsatpd->provinsi_unitusaha)->get();
        }

        return view('admin.pages.register-izinedar-psatpd.edit', compact('breadcrumbs', 'registerIzinedarPsatpd', 'provinsis', 'kotas', 'jenispsats', 'assignees'));
    }

    /**
     * =============================================
     *      process "edit RegisterIzinedarPsatpd" from previous form
     * =============================================
     */
    public function update(RegisterIzinedarPsatpdRequest $request, $id)
    {
        // Get existing data first
        $existingData = $this->registerIzinedarPsatpdService->getRegisterIzinedarPsatpdDetail($id);

        // Get validated data except file fields
        $validatedData = $request->except(['foto_1', 'foto_2', 'foto_3', 'foto_4', 'foto_5', 'foto_6', 'file_nib', 'file_sppb', 'file_izinedar_psatpd']);

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

        // Handle file uploads for file_nib, file_sppb, and file_izinedar_psatpd
        $fileUploadPath = 'files/upload/register';
        $filePublicPath = public_path($fileUploadPath);

        // Create directory if it doesn't exist
        if (!file_exists($filePublicPath)) {
            mkdir($filePublicPath, 0755, true);
        }

        // Process each file field
        $fileFields = ['file_nib', 'file_sppb', 'file_izinedar_psatpd'];
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

        $result = $this->registerIzinedarPsatpdService->updateRegisterIzinedarPsatpd($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nomor_izinedar_pl . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nomor_izinedar_pl . ' failed to be updated');

        return redirect()->route('register-izinedar-psatpd.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for RegisterIzinedarPsatpd
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(Request $request)
    {
        $data = $this->registerIzinedarPsatpdService->getRegisterIzinedarPsatpdDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.register-izinedar-psatpd.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(Request $request)
    {
        $registerIzinedarPsatpd = $this->registerIzinedarPsatpdService->getRegisterIzinedarPsatpdDetail($request->id);
        if (!is_null($registerIzinedarPsatpd)) {
            $result = $this->registerIzinedarPsatpdService->deleteRegisterIzinedarPsatpd($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $registerIzinedarPsatpd->nomor_izinedar_pl . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('register-izinedar-psatpd.index')->with('alerts', [$alert]);
    }
}
