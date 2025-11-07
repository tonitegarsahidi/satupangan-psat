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
        $dateFilter = $request->input('date_filter');
        $provinsiId = $request->input('provinsi_id');
        $tipe = $request->input('tipe');
        $komoditasId = $request->input('komoditas_id');

        // Build query for pengawasan items with filtering
        $query = PengawasanItem::with(['pengawasan', 'pengawasan.lokasiProvinsi', 'pengawasan.lokasiKota', 'komoditas'])
            ->whereHas('pengawasan', function($q) {
                $q->where('status', 'SELESAI');
            });

        // Apply date filter
        if ($dateFilter && $dateFilter !== 'all') {
            $now = Carbon::now();

            switch ($dateFilter) {
                case 'today':
                    $query->whereHas('pengawasan', function($q) use ($now) {
                        $q->whereDate('tanggal_selesai', $now->format('Y-m-d'));
                    });
                    break;

                case 'this_week':
                    $startOfWeek = $now->startOfWeek()->format('Y-m-d');
                    $endOfWeek = $now->endOfWeek()->format('Y-m-d');
                    $query->whereHas('pengawasan', function($q) use ($startOfWeek, $endOfWeek) {
                        $q->whereBetween('tanggal_selesai', [$startOfWeek, $endOfWeek]);
                    });
                    break;

                case 'this_month':
                    $startOfMonth = $now->startOfMonth()->format('Y-m-d');
                    $endOfMonth = $now->endOfMonth()->format('Y-m-d');
                    $query->whereHas('pengawasan', function($q) use ($startOfMonth, $endOfMonth) {
                        $q->whereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
                    });
                    break;

                case 'last_3_months':
                    $threeMonthsAgo = $now->subMonths(3)->format('Y-m-d');
                    $query->whereHas('pengawasan', function($q) use ($threeMonthsAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $threeMonthsAgo);
                    });
                    break;

                case 'last_6_months':
                    $sixMonthsAgo = $now->subMonths(6)->format('Y-m-d');
                    $query->whereHas('pengawasan', function($q) use ($sixMonthsAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $sixMonthsAgo);
                    });
                    break;

                case 'last_year':
                    $oneYearAgo = $now->subYear()->format('Y-m-d');
                    $query->whereHas('pengawasan', function($q) use ($oneYearAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $oneYearAgo);
                    });
                    break;
            }
        }

        // Apply province filter
        if ($provinsiId) {
            $query->whereHas('pengawasan', function($q) use ($provinsiId) {
                $q->where('lokasi_provinsi_id', $provinsiId);
            });
        }

        // Apply type filter (removed as per requirement)
        // if ($tipe) {
        //     $query->where('type', $tipe);
        // }

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
            'dateFilter',
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
