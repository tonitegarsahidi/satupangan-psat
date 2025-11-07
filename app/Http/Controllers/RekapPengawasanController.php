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

        // Build base query for pengawasan items with filtering
        $baseQuery = PengawasanItem::with(['pengawasan', 'pengawasan.lokasiProvinsi', 'pengawasan.lokasiKota', 'komoditas'])
            ->whereHas('pengawasan', function($q) {
                $q->where('status', 'SELESAI');
            });

        // Apply date filter
        if ($dateFilter && $dateFilter !== 'all') {
            $now = Carbon::now();

            switch ($dateFilter) {
                case 'today':
                    $baseQuery->whereHas('pengawasan', function($q) use ($now) {
                        $q->whereDate('tanggal_selesai', $now->format('Y-m-d'));
                    });
                    break;

                case 'this_week':
                    $startOfWeek = $now->startOfWeek()->format('Y-m-d');
                    $endOfWeek = $now->endOfWeek()->format('Y-m-d');
                    $baseQuery->whereHas('pengawasan', function($q) use ($startOfWeek, $endOfWeek) {
                        $q->whereBetween('tanggal_selesai', [$startOfWeek, $endOfWeek]);
                    });
                    break;

                case 'this_month':
                    $startOfMonth = $now->startOfMonth()->format('Y-m-d');
                    $endOfMonth = $now->endOfMonth()->format('Y-m-d');
                    $baseQuery->whereHas('pengawasan', function($q) use ($startOfMonth, $endOfMonth) {
                        $q->whereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
                    });
                    break;

                case 'last_3_months':
                    $threeMonthsAgo = $now->subMonths(3)->format('Y-m-d');
                    $baseQuery->whereHas('pengawasan', function($q) use ($threeMonthsAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $threeMonthsAgo);
                    });
                    break;

                case 'last_6_months':
                    $sixMonthsAgo = $now->subMonths(6)->format('Y-m-d');
                    $baseQuery->whereHas('pengawasan', function($q) use ($sixMonthsAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $sixMonthsAgo);
                    });
                    break;

                case 'last_year':
                    $oneYearAgo = $now->subYear()->format('Y-m-d');
                    $baseQuery->whereHas('pengawasan', function($q) use ($oneYearAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $oneYearAgo);
                    });
                    break;
            }
        }

        // Apply province filter
        if ($provinsiId) {
            $baseQuery->whereHas('pengawasan', function($q) use ($provinsiId) {
                $q->where('lokasi_provinsi_id', $provinsiId);
            });
        }

        // Apply type filter (removed as per requirement)
        // if ($tipe) {
        //     $query->where('type', $tipe);
        // }

        // Apply commodity filter
        if ($komoditasId) {
            $baseQuery->where('komoditas_id', $komoditasId);
        }

        // Get data with pagination
        $perPage = $request->input('per_page', 10);
        $rekapData = $baseQuery->orderBy('created_at', 'desc')->paginate($perPage);

        // Get filter options
        $provinsis = MasterProvinsi::orderBy('nama_provinsi', 'asc')->get();
        $komoditas = MasterBahanPanganSegar::orderBy('nama_bahan_pangan_segar', 'asc')->get();
        $tipeOptions = ['RAPID' => 'Rapid Test', 'LAB' => 'Laboratory'];

        // Build fresh query for summary statistics (not affected by pagination)
        $summaryQuery = PengawasanItem::with(['pengawasan', 'pengawasan.lokasiProvinsi', 'pengawasan.lokasiKota', 'komoditas'])
            ->whereHas('pengawasan', function($q) {
                $q->where('status', 'SELESAI');
            });

        // Apply all the same filters to the summary query
        if ($dateFilter && $dateFilter !== 'all') {
            $now = Carbon::now();

            switch ($dateFilter) {
                case 'today':
                    $summaryQuery->whereHas('pengawasan', function($q) use ($now) {
                        $q->whereDate('tanggal_selesai', $now->format('Y-m-d'));
                    });
                    break;

                case 'this_week':
                    $startOfWeek = $now->startOfWeek()->format('Y-m-d');
                    $endOfWeek = $now->endOfWeek()->format('Y-m-d');
                    $summaryQuery->whereHas('pengawasan', function($q) use ($startOfWeek, $endOfWeek) {
                        $q->whereBetween('tanggal_selesai', [$startOfWeek, $endOfWeek]);
                    });
                    break;

                case 'this_month':
                    $startOfMonth = $now->startOfMonth()->format('Y-m-d');
                    $endOfMonth = $now->endOfMonth()->format('Y-m-d');
                    $summaryQuery->whereHas('pengawasan', function($q) use ($startOfMonth, $endOfMonth) {
                        $q->whereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
                    });
                    break;

                case 'last_3_months':
                    $threeMonthsAgo = $now->subMonths(3)->format('Y-m-d');
                    $summaryQuery->whereHas('pengawasan', function($q) use ($threeMonthsAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $threeMonthsAgo);
                    });
                    break;

                case 'last_6_months':
                    $sixMonthsAgo = $now->subMonths(6)->format('Y-m-d');
                    $summaryQuery->whereHas('pengawasan', function($q) use ($sixMonthsAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $sixMonthsAgo);
                    });
                    break;

                case 'last_year':
                    $oneYearAgo = $now->subYear()->format('Y-m-d');
                    $summaryQuery->whereHas('pengawasan', function($q) use ($oneYearAgo) {
                        $q->whereDate('tanggal_selesai', '>=', $oneYearAgo);
                    });
                    break;
            }
        }

        // Apply province filter
        if ($provinsiId) {
            $summaryQuery->whereHas('pengawasan', function($q) use ($provinsiId) {
                $q->where('lokasi_provinsi_id', $provinsiId);
            });
        }

        // Apply commodity filter
        if ($komoditasId) {
            $summaryQuery->where('komoditas_id', $komoditasId);
        }

        // Get summary statistics
        $summary = $this->getSummaryData($summaryQuery);

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
            'total_pengawasan_item' => $summaryQuery->distinct('id')->count('id'),
            'total_rapid_test' => $summaryQuery->where('type', 'rapid')->count(),
            'total_lab_test' => $summaryQuery->where('type', 'lab')->count(),
            'total_positif' => $summaryQuery->where('is_positif', true)->where('type', 'rapid')->count(),
            'total_negatif' => $summaryQuery->where('is_positif', false)->where('type', 'rapid')->count(),
            'total_memenuhi_syarat' => $summaryQuery->where('type', 'lab')->where('is_memenuhisyarat', true)->count(),
            'total_tidak_memenuhi_syarat' => $summaryQuery->where('type', 'lab')->where('is_memenuhisyarat', false)->count(),
        ];

        // Get rapid test summary data
        $rapidTestQuery = clone $query;
        $rapidTestQuery = $rapidTestQuery->where('type', 'rapid');

        // 1. Jumlah Rapid Test dilakukan (count pengawasanItem where type=rapid)
        $summary['rapid_test_count'] = $rapidTestQuery->count();

        // 2. Jumlah Sampel Rapid Test (sum jumlah_sampel)
        $summary['rapid_test_sample_count'] = $rapidTestQuery->sum('jumlah_sampel') ?? 0;

        // 3. Jumlah Sampel memenuhi syarat vs tidak memenuhi syarat
        $summary['rapid_test_memenuhi_syarat'] = $rapidTestQuery->where('is_positif', false)->count();
        $summary['rapid_test_tidak_memenuhi_syarat'] = $rapidTestQuery->where('is_positif', TRUE)->count();

        // 4. Summary Rapid Test berdasarkan test_name
        $testNameSummary = PengawasanItem::selectRaw('test_name,
            SUM(CASE WHEN is_positif = false THEN 1 ELSE 0 END) as memenuhi_syarat,
            SUM(CASE WHEN is_positif = true THEN 1 ELSE 0 END) as tidak_memenuhi_syarat')
            ->where('type', 'rapid')
            ->whereHas('pengawasan', function($q) {
                $q->where('status', 'SELESAI');
            })
            ->groupBy('test_name')
            ->orderBy('test_name', 'asc')
            ->get();
        $summary['rapid_test_by_test_name'] = $testNameSummary;

        // 5. Summary Rapid Test berdasarkan Komoditas
        $komoditasSummary = PengawasanItem::with('komoditas')
            ->selectRaw('komoditas_id,
                SUM(CASE WHEN is_positif = false THEN 1 ELSE 0 END) as memenuhi_syarat,
                SUM(CASE WHEN is_positif = true THEN 1 ELSE 0 END) as tidak_memenuhi_syarat')
            ->where('type', 'rapid')
            ->whereHas('pengawasan', function($q) {
                $q->where('status', 'SELESAI');
            })
            ->groupBy('komoditas_id')
            ->orderBy('komoditas_id', 'asc')
            ->get();
        $summary['rapid_test_by_komoditas'] = $komoditasSummary;

        $rapidTestQuery = $rapidTestQuery->orderByDesc('created_at');

        return $summary;
    }
}
