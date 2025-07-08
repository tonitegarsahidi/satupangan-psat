<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RoleMaster;
use App\Models\RoleUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
        // Ambil semua provinsi aktif
        $provinsis = \App\Models\MasterProvinsi::where('is_active', 1)->orderBy('nama_provinsi')->get();

        // Ambil kota dari provinsi terpilih, atau kosong jika belum ada (untuk register, biasanya kosong)
        $kotas = collect();

        return view('admin.auth.register', compact('provinsis', 'kotas'));
    }

    /**
     * ======================================
     * Display the neecActivation view (after registration).
     * this is to info the user that
     * they need to wait for activation from Admin
     * before they can login and use the apps.
     * you can change the setting on 'config/constan'
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
     *
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

        //start insert operation
        try {
            DB::beginTransaction();
//find the roles ID (defaults role)
$roleId = RoleMaster::where('role_code', '=', config('constant.NEW_USER_DEFAULT_ROLES'))->first("id")->id;

//insert into database
$user = $this->userService->addNewUser(
    [
        'name' => $validatedData["name"],
        'email' => $validatedData["email"],
        'password' => Hash::make($validatedData["password"]),
        'is_active' => config('constant.NEW_USER_STATUS_ACTIVE'),
        'phone_number' => $validatedData['no_hp'],
        'roles'     => [$roleId]
    ]
);

// Insert ke user_profiles
app(\App\Repositories\UserProfileRepository::class)->create([
    'user_id' => $user->id,
    'gender' => $validatedData['jenis_kelamin'],
    'pekerjaan' => $validatedData['pekerjaan'],
    'address' => $validatedData['alamat_domisili'],
    'provinsi_id' => $validatedData['provinsi_id'],
    'kota_id' => $validatedData['kota_id'],
]);

DB::commit();

event(new Registered($user));


            // HANDLE REDIRECTS AFTER USER REGISTER
            //if user auto active and no need to verify email
            if (config('constant.NEW_USER_STATUS_ACTIVE') && !config('constant.NEW_USER_NEED_VERIFY_EMAIL')) {
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            }
            //if new user mechanism not auto active (need admin activation)
            else  if (!config('constant.NEW_USER_STATUS_ACTIVE')) {
                return redirect(route('register.needactivation'));
            } else if (config('constant.NEW_USER_NEED_VERIFY_EMAIL')) {

                return redirect(route('verification.notice'));
            }
        } catch (Exception $e) {
            Log::error("error in registration : ", ["exception" => $e]);
            DB::rollback();
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
