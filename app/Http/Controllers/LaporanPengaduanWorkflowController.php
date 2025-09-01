<?php

namespace App\Http\Controllers;

use App\Services\LaporanPengaduanWorkflowService;
use App\Services\LaporanPengaduanService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LaporanPengaduanWorkflowController extends Controller
{
    protected $laporanPengaduanWorkflowService;
    protected $laporanPengaduanService;

    public function __construct(
        LaporanPengaduanWorkflowService $laporanPengaduanWorkflowService,
        LaporanPengaduanService $laporanPengaduanService
    ) {
        $this->laporanPengaduanWorkflowService = $laporanPengaduanWorkflowService;
        $this->laporanPengaduanService = $laporanPengaduanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sortField = $request->input('sort_field', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $keyword = $request->input('keyword', null);
        $status = $request->input('status', null);

        try {
            $workflowEntries = $this->laporanPengaduanWorkflowService->listAllWorkflowEntries(
                $perPage,
                $sortField,
                $sortOrder,
                $keyword,
                $status
            );

            return view('admin.pages.laporan-pengaduan-workflow.index', compact('workflowEntries'));
        } catch (\Exception $exception) {
            Log::error("Failed to retrieve workflow entries: {$exception->getMessage()}");
            Session::flash('error', 'Gagal mengambil data workflow entries: ' . $exception->getMessage());
            return view('admin.pages.laporan-pengaduan-workflow.index', compact('workflowEntries'))->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Would typically load form view with dropdowns etc.
        return view('admin.pages.laporan-pengaduan-workflow.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'laporan_pengaduan_id' => 'required|uuid|exists:laporan_pengaduan,id',
            'status' => 'required|string|max:100',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();
            $data['user_id'] = Auth::id();
            $workflowEntry = $this->laporanPengaduanWorkflowService->addNewWorkflowEntry($data);

            if ($workflowEntry) {
                Session::flash('success', 'Workflow entry berhasil ditambahkan.');
                return redirect()->route('admin.laporan-pengaduan-workflow.index');
            } else {
                Session::flash('error', 'Gagal menambahkan workflow entry.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $exception) {
            Log::error("Failed to store workflow entry: {$exception->getMessage()}");
            Session::flash('error', 'Gagal menambahkan workflow entry: ' . $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $workflowEntry = $this->laporanPengaduanWorkflowService->getWorkflowEntryDetail($id);

            if (!$workflowEntry) {
                Session::flash('error', 'Workflow entry tidak ditemukan.');
                return redirect()->route('admin.laporan-pengaduan-workflow.index');
            }

            return view('admin.pages.laporan-pengaduan-workflow.show', compact('workflowEntry'));
        } catch (\Exception $exception) {
            Log::error("Failed to retrieve workflow entry: {$exception->getMessage()}");
            Session::flash('error', 'Gagal mengambil detail workflow entry: ' . $exception->getMessage());
            return redirect()->route('admin.laporan-pengaduan-workflow.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $workflowEntry = $this->laporanPengaduanWorkflowService->getWorkflowEntryDetail($id);

            if (!$workflowEntry) {
                Session::flash('error', 'Workflow entry tidak ditemukan.');
                return redirect()->route('admin.laporan-pengaduan-workflow.index');
            }

            return view('admin.pages.laporan-pengaduan-workflow.edit', compact('workflowEntry'));
        } catch (\Exception $exception) {
            Log::error("Failed to retrieve workflow entry for editing: {$exception->getMessage()}");
            Session::flash('error', 'Gagal mengambil detail workflow entry: ' . $exception->getMessage());
            return redirect()->route('admin.laporan-pengaduan-workflow.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:100',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $workflowEntry = $this->laporanPengaduanWorkflowService->updateWorkflowEntry(
                $request->all(),
                $id
            );

            if ($workflowEntry) {
                Session::flash('success', 'Workflow entry berhasil diperbarui.');
                return redirect()->route('admin.laporan-pengaduan-workflow.index');
            } else {
                Session::flash('error', 'Gagal memperbarui workflow entry.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $exception) {
            Log::error("Failed to update workflow entry: {$exception->getMessage()}");
            Session::flash('error', 'Gagal memperbarui workflow entry: ' . $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $result = $this->laporanPengaduanWorkflowService->deleteWorkflowEntry($id);

            if ($result) {
                Session::flash('success', 'Workflow entry berhasil dihapus.');
            } else {
                Session::flash('error', 'Gagal menghapus workflow entry.');
            }

            return redirect()->route('admin.laporan-pengaduan-workflow.index');
        } catch (\Exception $exception) {
            Log::error("Failed to delete workflow entry: {$exception->getMessage()}");
            Session::flash('error', 'Gagal menghapus workflow entry: ' . $exception->getMessage());
            return redirect()->route('admin.laporan-pengaduan-workflow.index');
        }
    }

    /**
     * Get workflow statistics
     */
    public function statistics()
    {
        try {
            $statistics = $this->laporanPengaduanWorkflowService->getWorkflowStatistics();

            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);
        } catch (\Exception $exception) {
            Log::error("Failed to retrieve workflow statistics: {$exception->getMessage()}");

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik workflow: ' . $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Get workflow entries by laporan pengaduan ID
     */
    public function getByLaporanId(string $laporanId)
    {
        try {
            $workflowEntries = $this->laporanPengaduanWorkflowService->getAllWorkflowByLaporanId($laporanId);

            return response()->json([
                'success' => true,
                'data' => $workflowEntries
            ]);
        } catch (\Exception $exception) {
            Log::error("Failed to retrieve workflow entries by laporan ID: {$exception->getMessage()}");

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data workflow entries: ' . $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Update workflow by adding new entry for laporan pengaduan
     */
    public function updateWorkflow(Request $request, string $laporanId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:100',
            'message' => 'nullable|string',
            'user_id_disposisi' => 'nullable|uuid|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'laporan_pengaduan_id' => $laporanId,
                'status' => $request->status,
                'message' => $request->message,
            ];

            // Add initiator user if status is DIPINDAHKAN
            if ($request->status === config('workflow.statuses.DIPINDAHKAN') && $request->user_id_disposisi) {
                $data['user_id'] = $request->user_id_disposisi;
            } else {
                $data['user_id'] = Auth::id();
            }

            $workflowEntry = $this->laporanPengaduanWorkflowService->addNewWorkflowEntry($data, Auth::id());

            if ($workflowEntry) {
                Session::flash('success', 'Workflow entry berhasil ditambahkan.');
                return redirect()->back();
            } else {
                Session::flash('error', 'Gagal menambahkan workflow entry.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $exception) {
            Log::error("Failed to update workflow for laporan {$laporanId}: {$exception->getMessage()}");
            Session::flash('error', 'Gagal menambahkan workflow entry: ' . $exception->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
