<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RoleMaster;
use App\Models\RoleUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repositories\UserProfileRepository;
use App\Services\UserService;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegisterUserAddRequest;
use App\Http\Requests\RegisterBusinessAddRequest;
use App\Http\Requests\RegisterPetugasAddRequest;

class RegisteredUserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * ======================================
     * Display the registration view.
     * ======================================
     */
    public function create(): View
    {
        $provinsis = \App\Models\MasterProvinsi::where('is_active', 1)->orderBy('nama_provinsi')->get();
        $kotas = collect();
        return view('admin.auth.register', compact('provinsis', 'kotas'));
    }

    /**
     * ======================================
     * Display the needActivation view (after registration).
     * ======================================
     */
    public function needActivation(): View
    {
        return view('admin.auth.need-activation');
    }

    /**
     * ============================================================
     * Handle an incoming registration request.
     * ============================================================
     */
    public function store(RegisterUserAddRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();
            $roleId = RoleMaster::where('role_code', '=', config('constant.NEW_USER_DEFAULT_ROLES'))->first("id")->id;

            $user = $this->userService->addNewUser([
                'name' => $validatedData["name"],
                'email' => $validatedData["email"],
                'password' => Hash::make($validatedData["password"]),
                'is_active' => config('constant.NEW_USER_STATUS_ACTIVE'),
                'phone_number' => $validatedData['no_hp'],
                'roles'     => [$roleId]
            ]);

            app(UserProfileRepository::class)->create([
                'user_id' => $user->id,
                'gender' => $validatedData['jenis_kelamin'],
                'pekerjaan' => $validatedData['pekerjaan'],
                'address' => $validatedData['alamat_domisili'],
                'provinsi_id' => $validatedData['provinsi_id'],
                'kota_id' => $validatedData['kota_id'],
            ]);

            DB::commit();

            // event(new Registered($user));

            if (config('constant.NEW_USER_STATUS_ACTIVE') && !config('constant.NEW_USER_NEED_VERIFY_EMAIL')) {
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            } elseif (!config('constant.NEW_USER_STATUS_ACTIVE')) {
                return redirect(route('register.needactivation'));
            } elseif (config('constant.NEW_USER_NEED_VERIFY_EMAIL')) {
                return redirect(route('verification.notice'));
            }
        } catch (Exception $e) {
            Log::error("error in registration : ", ["exception" => $e]);
            DB::rollback();
        }

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Show the registration form for business.
     */
    public function createBusiness()
    {
        $provinsis = \App\Models\MasterProvinsi::where('is_active', 1)->orderBy('nama_provinsi')->get();
        $kotas = collect();
        $jenispsats = \App\Models\MasterJenisPanganSegar::where('is_active', 1)->orderBy('nama_jenis_pangan_segar')->get();
        return view('admin.auth.register-business', compact('provinsis', 'kotas', 'jenispsats'));
    }

    /**
     * Handle the registration for business.
     */
    public function storeBusiness(RegisterBusinessAddRequest $request)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            // Assign appropriate role for business users
            $roleCode = 'ROLE_USER_BUSINESS'; // Business users should have ROLE_USER_BUSINESS
            $roleId = RoleMaster::where('role_code', '=', $roleCode)->first("id")->id;

            $roleCodeUser = 'ROLE_USER'; // Business users should have ROLE_USER_BUSINESS
            $roleIdUser = RoleMaster::where('role_code', '=', $roleCodeUser)->first("id")->id;

            $user = $this->userService->addNewUser([
                'name' => $validatedData["name"],
                'email' => $validatedData["email"],
                'password' => Hash::make($validatedData["password"]),
                'is_active' => config('constant.NEW_USER_STATUS_ACTIVE'),
                'phone_number' => $validatedData['no_hp'],
                'roles'     => [$roleId, $roleIdUser]
            ]);

            app(UserProfileRepository::class)->create([
                'user_id' => $user->id,
                'gender' => $validatedData['jenis_kelamin'],
                'address' => $validatedData['alamat_domisili'],
                'provinsi_id' => $validatedData['provinsi_id'],
                'kota_id' => $validatedData['kota_id'],
            ]);

            $business = \App\Models\Business::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'nama_perusahaan' => $validatedData['nama_perusahaan'],
                'alamat_perusahaan' => $validatedData['alamat_perusahaan'],
                'jabatan_perusahaan' => $validatedData['jabatan_perusahaan'],
                'nib' => $validatedData['nib'],
                'is_active' => true,
                'created_by' => 'register-business',
                'updated_by' => 'register-business',
            ]);

            foreach ($validatedData['jenispsat_id'] as $jenispsatId) {
                \App\Models\BusinessJenispsat::create([
                    'id' => Str::uuid(),
                    'business_id' => $business->id,
                    'jenispsat_id' => $jenispsatId,
                    'is_active' => true,
                    'created_by' => 'register-business',
                    'updated_by' => 'register-business',
                ]);
            }

            DB::commit();

            // event(new Registered($user));

            if (config('constant.NEW_USER_STATUS_ACTIVE') && !config('constant.NEW_USER_NEED_VERIFY_EMAIL')) {
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            } elseif (!config('constant.NEW_USER_STATUS_ACTIVE')) {
                return redirect(route('register.needactivation'));
            } elseif (config('constant.NEW_USER_NEED_VERIFY_EMAIL')) {
                return redirect(route('verification.notice'));
            }
        } catch (Exception $e) {
            Log::error("error in registration business : ", ["exception" => $e]);
            DB::rollback();
            return back()->withErrors(['register' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Show the registration form for petugas.
     */
    public function createPetugas()
    {
        $provinsis = \App\Models\MasterProvinsi::where('is_active', 1)->orderBy('nama_provinsi')->get();
        $kotas = collect();
        return view('admin.auth.register-petugas', compact('provinsis', 'kotas'));
    }

    /**
     * Handle the registration for petugas.
     */
    public function storePetugas(RegisterPetugasAddRequest $request)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            // Assign appropriate role for petugas (ROLE_OPERATOR or ROLE_SUPERVISOR)
            $roleCode = 'ROLE_OPERATOR'; // Default to operator, can be changed based on business logic
            $roleId = RoleMaster::where('role_code', '=', $roleCode)->first("id")->id;

            $roleCodeUser = 'ROLE_USER'; // Business users should have ROLE_USER_BUSINESS
            $roleIdUser = RoleMaster::where('role_code', '=', $roleCodeUser)->first("id")->id;

            $user = $this->userService->addNewUser([
                'name' => $validatedData["name"],
                'email' => $validatedData["email"],
                'password' => Hash::make($validatedData["password"]),
                'is_active' => config('constant.NEW_USER_STATUS_ACTIVE'),
                'phone_number' => $validatedData['no_hp'],
                'roles'     => [$roleId, $roleIdUser]
            ]);

            app(UserProfileRepository::class)->create([
                'user_id' => $user->id,
                'gender' => $validatedData['jenis_kelamin'],
                'pekerjaan' => $validatedData['pekerjaan'],
                'address' => $validatedData['alamat_domisili'],
                'provinsi_id' => $validatedData['provinsi_id'],
                'kota_id' => $validatedData['kota_id'],
            ]);

            // Create Petugas record
            \App\Models\Petugas::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'unit_kerja' => $validatedData['unit_kerja'],
                'jabatan' => $validatedData['jabatan'],
                'is_kantor_pusat' => $validatedData['is_kantor_pusat'],
                'penempatan' => $validatedData['is_kantor_pusat'] == '1' ? null : $validatedData['penempatan'],
                'is_active' => true,
                'created_by' => 'register-petugas',
                'updated_by' => 'register-petugas',
            ]);

            DB::commit();

            // event(new Registered($user));

            if (config('constant.NEW_USER_STATUS_ACTIVE') && !config('constant.NEW_USER_NEED_VERIFY_EMAIL')) {
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            } elseif (!config('constant.NEW_USER_STATUS_ACTIVE')) {
                return redirect(route('register.needactivation'));
            } elseif (config('constant.NEW_USER_NEED_VERIFY_EMAIL')) {
                return redirect(route('verification.notice'));
            }
        } catch (Exception $e) {
            Log::error("error in registration petugas : ", ["exception" => $e]);
            DB::rollback();
            return back()->withErrors(['register' => 'Terjadi kesalahan saat registrasi petugas. Silakan coba lagi.'])->withInput();
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
