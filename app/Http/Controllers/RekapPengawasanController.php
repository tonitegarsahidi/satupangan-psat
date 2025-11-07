<?php

namespace App\Http\Controllers;

use App\Models\Pengawasan;
use App\Models\PengawasanItem;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterProvinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RekapPengawasanController extends Controller
{
    private $mainBreadcrumbs;

    public function __construct()
    {
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Rekap Pengawasan' => null,
        ];
    }

    /**
     * Display rekap pengawasan data with filtering
     */
    public function index(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        // Get filter parameters
        $tanggalSelesaiFrom = $request->input('tanggal_selesai_from');
        $tanggalSelesaiTo = $request->input('tanggal_selesai_to');
        $provinsiId = $request->input('provinsi_id');
        $tipe = $request->input('tipe');
        $komoditasId = $request->input('komoditas_id');

        // Build query for pengawasan items with filtering
        $query = PengawasanItem::with(['pengawasan', 'pengawasan.lokasiProvinsi', 'pengawasan.lokasiKota', 'komoditas'])
            ->whereHas('pengawasan', function($q) {
                $q->where('status', 'SELESAI');
            });

        // Apply date filter
        if ($tanggalSelesaiFrom) {
            $query->whereHas('pengawasan', function($q) use ($tanggalSelesaiFrom) {
                $q->whereDate('tanggal_selesai', '>=', $tanggalSelesaiFrom);
            });
        }

        if ($tanggalSelesaiTo) {
            $query->whereHas('pengawasan', function($q) use ($tanggalSelesaiTo) {
                $q->whereDate('tanggal_selesai', '<=', $tanggalSelesaiTo);
            });
        }

        // Apply province filter
        if ($provinsiId) {
            $query->whereHas('pengawasan', function($q) use ($provinsiId) {
                $q->where('lokasi_provinsi_id', $provinsiId);
            });
        }

        // Apply type filter
        if ($tipe) {
            $query->where('type', $tipe);
        }

        // Apply commodity filter
        if ($komoditasId) {
            $query->where('komoditas_id', $komoditasId);
        }

        // Get data with pagination
        $perPage = $request->input('per_page', 10);
        $rekapData = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Get filter options
        $provinsis = MasterProvinsi::orderBy('nama_provinsi', 'asc')->get();
        $komoditas = MasterBahanPanganSegar::orderBy('nama_bahan_pangan_segar', 'asc')->get();
        $tipeOptions = ['RAPID' => 'Rapid Test', 'LAB' => 'Laboratory'];

        // Get summary statistics
        $summary = $this->getSummaryData($query);

        return view('admin.pages.rekap-pengawasan.index', compact(
            'breadcrumbs',
            'rekapData',
            'tanggalSelesaiFrom',
            'tanggalSelesaiTo',
            'provinsiId',
            'tipe',
            'komoditasId',
            'provinsis',
            'komoditas',
            'tipeOptions',
            'summary'
        ));
    }

    /**
     * Get summary data for rekap pengawasan
     */
    private function getSummaryData($query)
    {
        // Clone the query to avoid modifying the original
        $summaryQuery = clone $query;

        $summary = [
            'total_pengawasan' => $summaryQuery->distinct('pengawasan_id')->count('pengawasan_id'),
            'total_rapid_test' => $summaryQuery->where('type', 'RAPID')->count(),
            'total_lab_test' => $summaryQuery->where('type', 'LAB')->count(),
            'total_positif' => $summaryQuery->where('is_positif', true)->count(),
            'total_negatif' => $summaryQuery->where('is_positif', false)->count(),
            'total_memenuhi_syarat' => $summaryQuery->where('is_memenuhisyarat', true)->count(),
            'total_tidak_memenuhi_syarat' => $summaryQuery->where('is_memenuhisyarat', false)->count(),
        ];

        return $summary;
    }
}
