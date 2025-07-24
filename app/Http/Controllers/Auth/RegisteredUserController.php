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
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'jenis_kelamin' => ['required', 'in:male,female'],
            'no_hp' => ['required', 'string', 'max:20'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'alamat_domisili' => ['required', 'string', 'max:255'],
            'provinsi_id' => ['required', 'exists:master_provinsis,id'],
            'kota_id' => ['required', 'exists:master_kotas,id'],
            'password' => ['required', Rules\Password::defaults()],
            'agree' => 'accepted',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis Kelamin tidak valid.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'alamat_domisili.required' => 'Alamat Domisili wajib diisi.',
            'provinsi_id.required' => 'Provinsi wajib dipilih.',
            'provinsi_id.exists' => 'Provinsi tidak valid.',
            'kota_id.required' => 'Kabupaten/Kota wajib dipilih.',
            'kota_id.exists' => 'Kabupaten/Kota tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'agree.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

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

            event(new Registered($user));

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
    public function storeBusiness(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'jenis_kelamin' => ['required', 'in:male,female'],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat_domisili' => ['required', 'string', 'max:255'],
            'provinsi_id' => ['required', 'exists:master_provinsis,id'],
            'kota_id' => ['required', 'exists:master_kotas,id'],
            'password' => ['required', Rules\Password::defaults()],
            'agree' => 'accepted',
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat_perusahaan' => ['nullable', 'string', 'max:255'],
            'jabatan_perusahaan' => ['nullable', 'string', 'max:100'],
            'nib' => ['nullable', 'string', 'max:100'],
            'jenispsat_id' => ['required', 'array'],
            'jenispsat_id.*' => ['exists:master_jenis_pangan_segars,id'],
        ]);

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

            event(new Registered($user));

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
    public function storePetugas(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'jenis_kelamin' => ['required', 'in:male,female'],
            'no_hp' => ['required', 'string', 'max:20'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'alamat_domisili' => ['required', 'string', 'max:255'],
            'provinsi_id' => ['required', 'exists:master_provinsis,id'],
            'kota_id' => ['required', 'exists:master_kotas,id'],
            'password' => ['required', Rules\Password::defaults()],
            'agree' => 'accepted',
        ]);

        try {
            DB::beginTransaction();
            $roleId = RoleMaster::where('role_code', '=', config('constant.NEW_USER_DEFAULT_ROLES'))->first("id")->id; // Adjust role for petugas if needed

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

            event(new Registered($user));

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
            return back()->withErrors(['register' => 'Terjadi kesalahan saat registrasi petugas. Silakan coba lagi.']);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
