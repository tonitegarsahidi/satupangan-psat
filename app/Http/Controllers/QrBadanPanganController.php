<?php

namespace App\Http\Controllers;

use App\Services\QrBadanPanganService;
use App\Services\RegisterIzinedarPsatplService;
use App\Services\RegisterIzinedarPsatpdService;
use App\Services\RegisterIzinedarPsatpdukService;
// use App\Services\IzinrumahPengemasanService;
// use App\Services\SertifikatKeamananPanganService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\MasterJenisPanganSegar;
use App\Models\User;
use App\Models\RegisterSppb;
use App\Models\RegisterIzinedarPsatpl;
use App\Models\RegisterIzinedarPsatpd;
use App\Models\RegisterIzinedarPsatpduk;
use App\Models\RegisterIzinrumahPengemasan;
use App\Models\RegisterSertifikatKeamananPangan;
use App\Helpers\AlertHelper;
use App\Http\Requests\QrBadanPanganRequest;
use App\Services\RegisterSppbService;

class QrBadanPanganController extends Controller
{
    private $qrBadanPanganService;
    private $registerSppbService;
    private $registerIzinedarPsatplService;
    private $registerIzinedarPsatpdService;
    private $registerIzinedarPsatpdukService;
    private $izinrumahPengemasanService;
    private $sertifikatKeamananPanganService;
    private $mainBreadcrumbs;

    public function __construct(QrBadanPanganService $qrBadanPanganService,
                                RegisterSppbService $registerSppbService,
                                RegisterIzinedarPsatplService $registerIzinedarPsatplService,
                                RegisterIzinedarPsatpdService $registerIzinedarPsatpdService,
                                RegisterIzinedarPsatpdukService $registerIzinedarPsatpdukService,
                                // IzinrumahPengemasanService $izinrumahPengemasanService,
                                // SertifikatKeamananPanganService $sertifikatKeamananPanganService
                                )
    {
        $this->qrBadanPanganService = $qrBadanPanganService;
        $this->registerSppbService = $registerSppbService;
        $this->registerIzinedarPsatplService = $registerIzinedarPsatplService;
        $this->registerIzinedarPsatpdService = $registerIzinedarPsatpdService;
        $this->registerIzinedarPsatpdukService = $registerIzinedarPsatpdukService;
        // $this->izinrumahPengemasanService = $izinrumahPengemasanService;
        // $this->sertifikatKeamananPanganService = $sertifikatKeamananPanganService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('qr-badan-pangan.index'),
            'QR Badan Pangan' => route('qr-badan-pangan.index'),
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
        $qrBadanPangans = $this->qrBadanPanganService->listAllQrBadanPangan($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.qr-badan-pangan.index', compact('qrBadanPangans', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new QrBadanPangan" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        $user = Auth::user();
        $business = $user->business; // Get the business relationship directly (hasOne)
        // dd($business);

        $jenispsats = MasterJenisPanganSegar::all();

        // Get assignee users from config
        $assigneeEmail = config('constant.QR_BADAN_PANGAN_ASSIGNEE');
        $assignees = User::where('email', $assigneeEmail)->get();

        // Get reference data filtered by user and approved status
        $sppbs = RegisterSppb::where('business_id', $business->id)
                              ->where('status', 'approved')
                              ->get();

        $sppbs = $this->registerSppbService->listAllRegisterSppb(1000, "created_at", "asc", null, $user);


        $izinedarPsatpls = $this->registerIzinedarPsatplService->listAllRegisterIzinedarPsatpl(1000, "created_at", "asc", null, $user);

        // dd($izinedarPsatpls);



        $izinedarPsatpds = $this->registerIzinedarPsatpdService->listAllRegisterIzinedarPsatpd(1000, "created_at", "asc", null, $user);

        $izinedarPsatpduks = $this->registerIzinedarPsatpdukService->listAllRegisterIzinedarPsatpduk(1000, "created_at", "asc", null, $user);

        // $izinrumahPengemasans = RegisterIzinrumahPengemasan::where('business_id', $business->id)
        //                                                    ->where('status', 'approved')
        //                                                    ->get();

        // $sertifikatKeamananPangans = RegisterSertifikatKeamananPangan::where('business_id', $business->id)
        //                                                            ->where('status', 'approved')
        //                                                            ->get();

        return view('admin.pages.qr-badan-pangan.add', compact(
            'breadcrumbs',
            'business',
            'jenispsats',
            'assignees',
            'sppbs',
            'izinedarPsatpls',
            'izinedarPsatpds',
            'izinedarPsatpduks',
            // 'izinrumahPengemasans',
            // 'sertifikatKeamananPangans'
        ));
    }

    /**
     * =============================================
     *      proses "add new QrBadanPangan" from previous form
     * =============================================
     */
    public function store(QrBadanPanganRequest $request)
    {
        $validatedData = $request->except(['file_lampiran1', 'file_lampiran2', 'file_lampiran3', 'file_lampiran4', 'file_lampiran5']);

        $user = Auth::user();
        $validatedData['created_by'] = $user->id;
        $validatedData['updated_by'] = $user->id;
        $validatedData['requested_by'] = $user->id;
        $validatedData['requested_at'] = now();

        // Set default values for status and is_published
        $validatedData['status'] = 'pending';
        $validatedData['is_published'] = false;

        // Handle file uploads for file_lampiran1 to file_lampiran5
        $uploadPath = 'files/upload/qr-badan-pangan';
        $publicPath = public_path($uploadPath);

        // Create directory if it doesn't exist
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        // Process each file field
        for ($i = 1; $i <= 5; $i++) {
            $fileField = 'file_lampiran' . $i;
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $file->move($publicPath, $filename);
                $validatedData[$fileField] = env('BASE_URL') . '/' . $uploadPath . '/' . $filename;
            }
        }

        $result = $this->qrBadanPanganService->addNewQrBadanPangan($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'QR Badan Pangan for ' . $result->nama_komoditas . ' successfully added')
            : AlertHelper::createAlert('danger', 'QR Badan Pangan for ' . $request->nama_komoditas . ' failed to be added');

        return redirect()->route('qr-badan-pangan.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single QrBadanPangan entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->qrBadanPanganService->getQrBadanPanganDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.qr-badan-pangan.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit QrBadanPangan" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $qrBadanPangan = $this->qrBadanPanganService->getQrBadanPanganDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        $jenispsats = MasterJenisPanganSegar::all();

        // Get assignee users from config
        $assigneeEmail = config('constant.QR_BADAN_PANGAN_ASSIGNEE');
        $assignees = User::where('email', $assigneeEmail)->get();

        // Get reference data filtered by user and approved status
        $business = $qrBadanPangan->business;
        $sppbs = RegisterSppb::where('business_id', $business->id)
                              ->where('status', 'approved')
                              ->get();

        $izinedarPsatpls = RegisterIzinedarPsatpl::where('business_id', $business->id)
                                                  ->where('status', 'approved')
                                                  ->get();

        $izinedarPsatpds = RegisterIzinedarPsatpd::where('business_id', $business->id)
                                                 ->where('status', 'approved')
                                                 ->get();

        $izinedarPsatpduks = RegisterIzinedarPsatpduk::where('business_id', $business->id)
                                                     ->where('status', 'approved')
                                                     ->get();

        $izinrumahPengemasans = RegisterIzinrumahPengemasan::where('business_id', $business->id)
                                                           ->where('status', 'approved')
                                                           ->get();

        $sertifikatKeamananPangans = RegisterSertifikatKeamananPangan::where('business_id', $business->id)
                                                                   ->where('status', 'approved')
                                                                   ->get();

        return view('admin.pages.qr-badan-pangan.edit', compact(
            'breadcrumbs',
            'qrBadanPangan',
            'jenispsats',
            'assignees',
            'sppbs',
            'izinedarPsatpls',
            'izinedarPsatpds',
            'izinedarPsatpduks',
            'izinrumahPengemasans',
            'sertifikatKeamananPangans'
        ));
    }

    /**
     * =============================================
     *      process "edit QrBadanPangan" from previous form
     * =============================================
     */
    public function update(QrBadanPanganRequest $request, $id)
    {
        // Get existing data first
        $existingData = $this->qrBadanPanganService->getQrBadanPanganDetail($id);

        // Get validated data except file fields
        $validatedData = $request->except(['file_lampiran1', 'file_lampiran2', 'file_lampiran3', 'file_lampiran4', 'file_lampiran5']);

        $user = Auth::user();
        $validatedData['updated_by'] = $user->id;

        // Ensure status is set (it might be removed from form)
        $validatedData['status'] = $validatedData['status'] ?? 'pending';

        // Handle file uploads for file_lampiran1 to file_lampiran5
        $uploadPath = 'files/upload/qr-badan-pangan';
        $publicPath = public_path($uploadPath);

        // Create directory if it doesn't exist
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        // Process each file field
        for ($i = 1; $i <= 5; $i++) {
            $fileField = 'file_lampiran' . $i;
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $file->move($publicPath, $filename);
                $validatedData[$fileField] = env('BASE_URL') . '/' . $uploadPath . '/' . $filename;
            } else {
                // Keep existing file if no new file is uploaded
                $validatedData[$fileField] = $existingData->$fileField;
            }
        }

        $result = $this->qrBadanPanganService->updateQrBadanPangan($validatedData, $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'QR Badan Pangan for ' . $result->nama_komoditas . ' successfully updated')
            : AlertHelper::createAlert('danger', 'QR Badan Pangan for ' . $request->nama_komoditas . ' failed to be updated');

        return redirect()->route('qr-badan-pangan.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for QrBadanPangan
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(Request $request)
    {
        $data = $this->qrBadanPanganService->getQrBadanPanganDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.qr-badan-pangan.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(Request $request)
    {
        $qrBadanPangan = $this->qrBadanPanganService->getQrBadanPanganDetail($request->id);
        if (!is_null($qrBadanPangan)) {
            $result = $this->qrBadanPanganService->deleteQrBadanPangan($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'QR Badan Pangan for ' . $qrBadanPangan->nama_komoditas . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('qr-badan-pangan.index')->with('alerts', [$alert]);
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

        $result = $this->qrBadanPanganService->updateStatus($id, $status, $user->id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Status successfully updated to ' . $status)
            : AlertHelper::createAlert('danger', 'Failed to update status');

        return redirect()->route('qr-badan-pangan.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      assign to user
     * =============================================
     */
    public function assignToUser(Request $request, $id)
    {
        $assigneeId = $request->input('current_assignee');

        $result = $this->qrBadanPanganService->assignToUser($id, $assigneeId);

        $alert = $result
            ? AlertHelper::createAlert('success', 'QR Badan Pangan successfully assigned')
            : AlertHelper::createAlert('danger', 'Failed to assign QR Badan Pangan');

        return redirect()->route('qr-badan-pangan.index')->with('alerts', [$alert]);
    }
}
