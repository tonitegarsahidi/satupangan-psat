<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Http\Requests\PetugasProfileUpdateRequest;
use App\Services\ImageUploadService;
use App\Services\UserProfileService;
use App\Repositories\MasterProvinsiRepository;
use App\Repositories\MasterKotaRepository;
use App\Models\Petugas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * ################################################
 *      THIS IS PETUGAS PROFILE CONTROLLER
 * handles petugas profile operations including
 * both user profile data and petugas-specific data.
 * ################################################
 */
class PetugasProfileController extends Controller
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
     * load user data, userProfile data and petugas data
     * then display it in form
     * =============================================
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $profile = $this->userProfileService->getUserProfile($user->id);
        $petugas = Petugas::where('user_id', $user->id)->first();
        
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Data Petugas' => null]);
        $alerts = AlertHelper::getAlerts();

        // Ambil semua provinsi aktif
        $provinsis = \App\Models\MasterProvinsi::where('is_active', 1)->orderBy('nama_provinsi')->get();

        // Ambil kota dari provinsi terpilih, atau kosong jika belum ada
        $kotas = collect();
        $selectedProvinsiId = old('provinsi_id', $profile->provinsi_id ?? null);
        if ($selectedProvinsiId) {
            $kotas = \App\Models\MasterKota::where('provinsi_id', $selectedProvinsiId)->where('is_active', 1)->orderBy('nama_kota')->get();
        }

        return view('admin.pages.petugas.profile-index', compact('profile', 'petugas', 'breadcrumbs', 'provinsis', 'kotas', 'alerts'));
    }

    /**
     * =============================================
     *     process update user, userProfile and petugas data
     * =============================================
     */
    public function updateOrCreate(PetugasProfileUpdateRequest $request)
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

            // Update or create petugas data
            $petugasData = [
                'unit_kerja' => $validated['unit_kerja'],
                'jabatan' => $validated['jabatan'],
                'is_kantor_pusat' => $validated['is_kantor_pusat'],
                'penempatan' => $validated['is_kantor_pusat'] == '1' ? null : $validated['penempatan'],
                'updated_by' => $userId,
            ];

            $petugas = Petugas::where('user_id', $userId)->first();
            if ($petugas) {
                $petugas->update($petugasData);
                $petugasResult = true;
            } else {
                $petugasData['user_id'] = $userId;
                $petugasData['created_by'] = $userId;
                Petugas::create($petugasData);
                $petugasResult = true;
            }

            // Create success or failure alert
            $alert = ($profileResult && $petugasResult)
                ? AlertHelper::createAlert('success', 'Data petugas berhasil diperbarui.')
                : AlertHelper::createAlert('danger', 'Data petugas gagal diperbarui.');

        } catch (Exception $e) {
            // Handle any exceptions (e.g. upload errors)
            $alert = AlertHelper::createAlert('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // Redirect back with the alert
        return redirect()->route('petugas.profile.index')->with(['alerts' => [$alert]]);
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