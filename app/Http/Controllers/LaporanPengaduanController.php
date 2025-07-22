<?php

namespace App\Http\Controllers;

use App\Services\LaporanPengaduanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LaporanPengaduan\LaporanPengaduanAddRequest;
use App\Helpers\AlertHelper;
use App\Services\UserService;

class LaporanPengaduanController extends Controller
{
    private $LaporanPengaduanService;
    private $userService;
    private $mainBreadcrumbs;

    public function __construct(LaporanPengaduanService $LaporanPengaduanService, UserService $userService)
    {
        $this->LaporanPengaduanService = $LaporanPengaduanService;
        $this->userService = $userService;

        $this->mainBreadcrumbs = [
            'Admin' => route('admin.laporan-pengaduan.index'),
            'Laporan Pengaduan' => route('admin.laporan-pengaduan.index'),
        ];
    }

    public function index(Request $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $laporans = $this->LaporanPengaduanService->listAllLaporanPengaduan($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);
        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.laporan-pengaduan.index', compact('laporans', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        $provinsis = \App\Models\MasterProvinsi::all();
        $kotas = [];

        $user = Auth::user();
        $userData = [
            'nama_pelapor' => $user->name ?? '',
            'nomor_telepon' => $user->userProfile->phone ?? '',
            'email' => $user->email ?? '',
        ];

        return view('admin.pages.laporan-pengaduan.add', compact('breadcrumbs', 'provinsis', 'kotas', 'userData'));
    }

    public function store(LaporanPengaduanAddRequest $request)
    {
        $validatedData = $request->validated();

        //dapatkan user Id yang login
        $user = Auth::user() ?? null;
        $result = $this->LaporanPengaduanService->addNewLaporanPengaduan($validatedData, $user ? $user->id : null);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Laporan berhasil disimpan')
            : AlertHelper::createAlert('danger', 'Laporan gagal disimpan');

        return redirect()->route('admin.laporan-pengaduan.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    public function detail(Request $request)
    {
        $data = $this->LaporanPengaduanService->getLaporanPengaduanDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);
        $users = $this->userService->getAllUsersSortedByName();
        return view('admin.pages.laporan-pengaduan.detail', compact('breadcrumbs', 'data', 'users'));
    }

    public function edit(Request $request, $id)
    {
        $laporan = $this->LaporanPengaduanService->getLaporanPengaduanDetail($id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);
        $provinsis = \App\Models\MasterProvinsi::all();
        $kotas = [];
        if ($laporan && $laporan->provinsi_id) {
            $kotas = \App\Models\MasterKota::where('provinsi_id', $laporan->provinsi_id)->get();
        }
        return view('admin.pages.laporan-pengaduan.edit', compact('breadcrumbs', 'laporan', 'provinsis', 'kotas'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->LaporanPengaduanService->updateLaporanPengaduan($request->all(), $id);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Laporan berhasil diupdate')
            : AlertHelper::createAlert('danger', 'Laporan gagal diupdate');

        return redirect()->route('admin.laporan-pengaduan.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    public function deleteConfirm(Request $request)
    {
        $data = $this->LaporanPengaduanService->getLaporanPengaduanDetail($request->id);
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);
        return view('admin.pages.laporan-pengaduan.delete-confirm', compact('breadcrumbs', 'data'));
    }

    public function destroy(Request $request)
    {
        $laporan = $this->LaporanPengaduanService->getLaporanPengaduanDetail($request->id);
        if (!is_null($laporan)) {
            $result = $this->LaporanPengaduanService->deleteLaporanPengaduan($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Laporan berhasil dihapus')
            : AlertHelper::createAlert('danger', 'Oops! gagal dihapus');

        return redirect()->route('admin.laporan-pengaduan.index')->with('alerts', [$alert]);
    }
}
