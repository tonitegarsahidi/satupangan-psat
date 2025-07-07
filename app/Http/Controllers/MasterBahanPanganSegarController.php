<?php

namespace App\Http\Controllers;

use App\Services\MasterBahanPanganSegarService;
use App\Services\MasterJenisPanganSegarService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Http\Requests\MasterBahanPanganSegar\MasterBahanPanganSegarAddRequest;
use App\Http\Requests\MasterBahanPanganSegar\MasterBahanPanganSegarEditRequest;
use App\Http\Requests\MasterBahanPanganSegar\MasterBahanPanganSegarListRequest;
use Illuminate\Validation\ValidationException;

class MasterBahanPanganSegarController extends Controller
{
    private $MasterBahanPanganSegarService;
    private $MasterJenisPanganSegarService;
    private $mainBreadcrumbs;

    public function __construct(MasterBahanPanganSegarService $MasterBahanPanganSegarService, MasterJenisPanganSegarService $MasterJenisPanganSegarService)
    {
        $this->MasterBahanPanganSegarService = $MasterBahanPanganSegarService;
        $this->MasterJenisPanganSegarService = $MasterJenisPanganSegarService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.master-bahan-pangan-segar.index'),
            'Master Bahan Pangan Segar' => route('admin.master-bahan-pangan-segar.index'),
        ];
    }



    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(MasterBahanPanganSegarListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');

        $bahanPanganSegars = $this->MasterBahanPanganSegarService->listAllMasterBahanPanganSegar($perPage, $sortField, $sortOrder, $keyword);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.master-bahan-pangan-segar.index', compact('bahanPanganSegars', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new MasterBahanPanganSegar" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);
        $jenisPanganSegars = $this->MasterJenisPanganSegarService->listAllMasterJenisPanganSegar(9999); // Get all for dropdown

        return view('admin.pages.master-bahan-pangan-segar.add', compact('breadcrumbs', 'jenisPanganSegars'));
    }

    /**
     * =============================================
     *      proses "add new MasterBahanPanganSegar" from previous form
     * =============================================
     */
    public function store(MasterBahanPanganSegarAddRequest $request)
    {
        $validatedData = $request->validated();
        if($this->MasterBahanPanganSegarService->checkMasterBahanPanganSegarExist($validatedData["nama_bahan_pangan_segar"], $validatedData["kode_bahan_pangan_segar"])){
            throw ValidationException::withMessages([
                'nama_bahan_pangan_segar' => 'Nama Bahan Pangan Segar atau Kode Bahan Pangan Segar sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterBahanPanganSegarService->addNewMasterBahanPanganSegar($validatedData);

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_bahan_pangan_segar . ' successfully added')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_bahan_pangan_segar . ' failed to be added');



        return redirect()->route('admin.master-bahan-pangan-segar.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single MasterBahanPanganSegar entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->MasterBahanPanganSegarService->getMasterBahanPanganSegarDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.master-bahan-pangan-segar.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit MasterBahanPanganSegar" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $bahanPanganSegar = $this->MasterBahanPanganSegarService->getMasterBahanPanganSegarDetail($id);
        $jenisPanganSegars = $this->MasterJenisPanganSegarService->listAllMasterJenisPanganSegar(9999); // Get all for dropdown

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.master-bahan-pangan-segar.edit', compact('breadcrumbs', 'bahanPanganSegar', 'jenisPanganSegars'));
    }

    /**
     * =============================================
     *      process "edit MasterBahanPanganSegar" from previous form
     * =============================================
     */
    public function update(MasterBahanPanganSegarEditRequest $request, $id)
    {
        $validatedData = $request->validated();


        if($this->MasterBahanPanganSegarService->checkMasterBahanPanganSegarExist($validatedData["nama_bahan_pangan_segar"], $validatedData["kode_bahan_pangan_segar"], $id)){
            throw ValidationException::withMessages([
                'nama_bahan_pangan_segar' => 'Nama Bahan Pangan Segar atau Kode Bahan Pangan Segar sudah ada sebelumnya.'
            ]);
        }
        $result = $this->MasterBahanPanganSegarService->updateMasterBahanPanganSegar($validatedData, $id);


        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $result->nama_bahan_pangan_segar . ' successfully updated')
            : AlertHelper::createAlert('danger', 'Data ' . $request->nama_bahan_pangan_segar . ' failed to be updated');

        return redirect()->route('admin.master-bahan-pangan-segar.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for MasterBahanPanganSegar
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(MasterBahanPanganSegarListRequest $request)
    {
        $data = $this->MasterBahanPanganSegarService->getMasterBahanPanganSegarDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.master-bahan-pangan-segar.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(MasterBahanPanganSegarListRequest $request)
    {
        $bahanPanganSegar = $this->MasterBahanPanganSegarService->getMasterBahanPanganSegarDetail($request->id);
        if (!is_null($bahanPanganSegar)) {
            $result = $this->MasterBahanPanganSegarService->deleteMasterBahanPanganSegar($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $bahanPanganSegar->nama_bahan_pangan_segar . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.master-bahan-pangan-segar.index')->with('alerts', [$alert]);
    }


    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================

}
