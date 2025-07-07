<?php

namespace App\Http\Controllers;

use App\Services\MasterJenisPanganSegarService;
use App\Services\MasterKelompokPanganService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterJenisPanganSegar\MasterJenisPanganSegarAddRequest;
use App\Http\Requests\MasterJenisPanganSegar\MasterJenisPanganSegarEditRequest;
use App\Http\Requests\MasterJenisPanganSegar\MasterJenisPanganSegarListRequest;
use Illuminate\Validation\ValidationException;

class MasterJenisPanganSegarController extends Controller
{
    private $MasterJenisPanganSegarService;
    private $mainBreadcrumbs;

    private $MasterKelompokPanganService;

    public function __construct(MasterJenisPanganSegarService $MasterJenisPanganSegarService, MasterKelompokPanganService $MasterKelompokPanganService)
    {
        $this->MasterJenisPanganSegarService = $MasterJenisPanganSegarService;
        $this->MasterKelompokPanganService = $MasterKelompokPanganService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-jenis-pangan-segar.index'),
            'Master Jenis Pangan Segar' => route('admin.master-jenis-pangan-segar.index'),
        ];
    }



    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(MasterJenisPanganSegarListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $jenisPanganSegars = $this->MasterJenisPanganSegarService->listAllMasterJenisPanganSegar($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-jenis-pangan-segar.index', compact('jenisPanganSegars', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new MasterJenisPanganSegar" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);


        $kelompokPangans = $this->MasterKelompokPanganService->listAllMasterKelompokPangan(9999); // Get all for dropdown
        return view('admin.pages.master-jenis-pangan-segar.add', compact('breadcrumbs', 'kelompokPangans'));
    }

    /**
     * =============================================
     *      proses "add new MasterJenisPanganSegar" from previous form
     * =============================================
     */
    public function store(MasterJenisPanganSegarAddRequest $request)
    {
        $validatedData = $request->validated();
        if($this->MasterJenisPanganSegarService->checkMasterJenisPanganSegarExist($validatedData["nama_jenis_pangan_segar"], $validatedData["kode_jenis_pangan_segar"])){
            throw ValidationException::withMessages([
                'nama_jenis_pangan_segar' => 'Nama Jenis Pangan Segar atau Kode Jenis Pangan Segar sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterJenisPanganSegarService->addNewMasterJenisPanganSegar($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_jenis_pangan_segar . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_jenis_pangan_segar . ' failed to be added');



        return redirect()->route('admin.master-jenis-pangan-segar.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single MasterJenisPanganSegar entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->MasterJenisPanganSegarService->getMasterJenisPanganSegarDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-jenis-pangan-segar.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit MasterJenisPanganSegar" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $jenisPanganSegar = $this->MasterJenisPanganSegarService->getMasterJenisPanganSegarDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        $kelompokPangans = $this->MasterKelompokPanganService->listAllMasterKelompokPangan(9999); // Get all for dropdown
        return view('admin.pages.master-jenis-pangan-segar.edit', compact('breadcrumbs', 'jenisPanganSegar', 'kelompokPangans'));
    }

    /**
     * =============================================
     *      process "edit MasterJenisPanganSegar" from previous form
     * =============================================
     */
    public function update(MasterJenisPanganSegarEditRequest $request, $id)
    {
        $validatedData = $request->validated();
        if($this->MasterJenisPanganSegarService->checkMasterJenisPanganSegarExist($validatedData["nama_jenis_pangan_segar"], $validatedData["kode_jenis_pangan_segar"], $id)){
            throw ValidationException::withMessages([
                'nama_jenis_pangan_segar' => 'Nama Jenis Pangan Segar atau Kode Jenis Pangan Segar sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterJenisPanganSegarService->updateMasterJenisPanganSegar($validatedData, $id);


        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_jenis_pangan_segar . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_jenis_pangan_segar . ' failed to be updated');

        return redirect()->route('admin.master-jenis-pangan-segar.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for MasterJenisPanganSegar
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(MasterJenisPanganSegarListRequest $request)
    {
        $data = $this->MasterJenisPanganSegarService->getMasterJenisPanganSegarDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-jenis-pangan-segar.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(MasterJenisPanganSegarListRequest $request)
    {
        $jenisPanganSegar = $this->MasterJenisPanganSegarService->getMasterJenisPanganSegarDetail($request->id);
        if (!is_null($jenisPanganSegar)) {
            $result = $this->MasterJenisPanganSegarService->deleteMasterJenisPanganSegar($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $jenisPanganSegar->nama_jenis_pangan_segar . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-jenis-pangan-segar.index')->with('alerts', [$alert]);
    }


    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================

}
