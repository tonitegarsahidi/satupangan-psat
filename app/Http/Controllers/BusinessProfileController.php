<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Http\Requests\BusinessProfileUpdateRequest;
use App\Services\ImageUploadService;
use App\Services\UserProfileService;
use App\Repositories\MasterProvinsiRepository;
use App\Repositories\MasterKotaRepository;
use App\Models\Business;
use App\Models\MasterJenisPanganSegar;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * ################################################
 *      THIS IS BUSINESS PROFILE CONTROLLER
 * handles business profile operations including
 * both user profile data and business-specific data.
 * ################################################
 */
class BusinessProfileController extends Controller
{

    private $userProfileService;
    private $imageUploadService;
    private $mainBreadcrumbs;

    private $provinsiRepository;
    private $kotaRepository;

    public function __construct(
        UserProfileService $userProfileService,
        ImageUploadService $imageUploadService,
        MasterProvinsiRepository $provinsiRepository,
        MasterKotaRepository $kotaRepository
    ) {
        $this->userProfileService = $userProfileService;
        $this->imageUploadService = $imageUploadService;
        $this->provinsiRepository = $provinsiRepository;
        $this->kotaRepository = $kotaRepository;
        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Dashboard' => route('dashboard')
        ];
    }

    /**
     * =============================================
     * load user data, userProfile data and business data
     * then display it in form
     * =============================================
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $profile = $this->userProfileService->getUserProfile($user->id);
        $business = Business::where('user_id', $user->id)->first();
        
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Profil Bisnis' => null]);
        $alerts = AlertHelper::getAlerts();

        // Ambil semua provinsi aktif
        $provinsis = \App\Models\MasterProvinsi::where('is_active', 1)->orderBy('nama_provinsi')->get();

        // Ambil kota dari provinsi terpilih, atau kosong jika belum ada
        $kotas = collect();
        $selectedProvinsiId = old('provinsi_id', $profile->provinsi_id ?? null);
        if ($selectedProvinsiId) {
            $kotas = \App\Models\MasterKota::where('provinsi_id', $selectedProvinsiId)->where('is_active', 1)->orderBy('nama_kota')->get();
        }

        // Ambil semua jenis PSAT
        $jenispsats = MasterJenisPanganSegar::where('is_active', 1)->orderBy('nama_jenis_pangan_segar')->get();

        // Ambil jenis PSAT yang sudah dipilih oleh business ini
        $selectedJenispsats = collect();
        if ($business) {
            $selectedJenispsats = $business->jenispsats->pluck('id');
        }

        return view('admin.pages.business.profile-index', compact('profile', 'business', 'breadcrumbs', 'provinsis', 'kotas', 'jenispsats', 'selectedJenispsats', 'alerts'));
    }

    /**
     * =============================================
     *     process update user, userProfile and business data
     * =============================================
     */
    public function updateOrCreate(BusinessProfileUpdateRequest $request)
    {
        // The validated data will be available via $request->validated()
        $validated = $request->validated();
        $userId = Auth::user()->id;

        // Handle the profile picture upload if a new file is provided
        try {
            if ($request->hasFile('profile_picture')) {
                $path = $this->imageUploadService->uploadImage($request->file('profile_picture'), "profpic");
                $validated['profile_picture'] = $path;
            }
            else{
                $validated['profile_picture'] = null;
            }

            // Update or create user profile
            $profileResult = $this->userProfileService->updateOrCreate($userId, $validated);

            // Update or create business data
            $businessData = [
                'nama_perusahaan' => $validated['nama_perusahaan'],
                'alamat_perusahaan' => $validated['alamat_perusahaan'],
                'jabatan_perusahaan' => $validated['jabatan_perusahaan'],
                'nib' => $validated['nib'],
                'updated_by' => $userId,
            ];

            $business = Business::where('user_id', $userId)->first();
            if ($business) {
                $business->update($businessData);
                $businessResult = true;
            } else {
                $businessData['user_id'] = $userId;
                $businessData['created_by'] = $userId;
                $business = Business::create($businessData);
                $businessResult = true;
            }

            // Update jenis PSAT relationships
            if (isset($validated['jenispsat_id']) && $business) {
                $business->jenispsats()->sync($validated['jenispsat_id']);
            }

            // Create success or failure alert
            $alert = ($profileResult && $businessResult)
                ? AlertHelper::createAlert('success', 'Profil bisnis berhasil diperbarui.')
                : AlertHelper::createAlert('danger', 'Profil bisnis gagal diperbarui.');

        } catch (Exception $e) {
            // Handle any exceptions (e.g. upload errors)
            $alert = AlertHelper::createAlert('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // Redirect back with the alert
        return redirect()->route('business.profile.index')->with(['alerts' => [$alert]]);
    }

    /**
     * Endpoint AJAX: get kota by provinsi
     */
    public function getKotaByProvinsi($provinsiId)
    {
        $kotas = \App\Models\MasterKota::where('provinsi_id', $provinsiId)->where('is_active', 1)->orderBy('nama_kota')->get(['id', 'nama_kota']);
        return response()->json($kotas);
    }
}