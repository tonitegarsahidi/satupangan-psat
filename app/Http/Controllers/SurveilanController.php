<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\RegisterSppb;
use App\Models\RegisterIzinedarPsatpl;
use App\Models\RegisterIzinedarPsatpd;
use App\Models\RegisterIzinedarPsatpduk;
use App\Models\Business;

class SurveilanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $keyword = $request->input('keyword');
        $sortField = $request->input('sort_field', 'akhir_masa_berlaku');
        $sortOrder = $request->input('sort_order', 'asc');
        $page = $request->input('page', 1);

        $surveilans = collect();
        $today = Carbon::today();
        $notificationMonthLater = Carbon::today()->addMonths(2);

        // Fetch Register SPPB
        $sppbData = RegisterSppb::with('business')
            ->where('tanggal_terakhir', '<=', $notificationMonthLater)
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Register SPPB',
                    'nama_perusahaan' => $item->business->nama_perusahaan ?? 'N/A',
                    'akhir_masa_berlaku' => $item->tanggal_terakhir,
                ];
            });
        $surveilans = $surveilans->concat($sppbData);

        // Fetch Izin Edar PL
        $psatplData = RegisterIzinedarPsatpl::with('business')
            ->where('tanggal_terakhir', '<=', $notificationMonthLater)
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Izin Edar PL',
                    'nama_perusahaan' => $item->business->nama_perusahaan ?? 'N/A',
                    'akhir_masa_berlaku' => $item->tanggal_terakhir,
                ];
            });
        $surveilans = $surveilans->concat($psatplData);

        // Fetch Izin Edar PD
        $psatpdData = RegisterIzinedarPsatpd::with('business')
            ->where('tanggal_terakhir', '<=', $notificationMonthLater)
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Izin Edar PD',
                    'nama_perusahaan' => $item->business->nama_perusahaan ?? 'N/A',
                    'akhir_masa_berlaku' => $item->tanggal_terakhir,
                ];
            });
        $surveilans = $surveilans->concat($psatpdData);

        // Fetch Izin Edar PDUK
        $psatpdukData = RegisterIzinedarPsatpduk::with('business')
            ->where('tanggal_terakhir', '<=', $notificationMonthLater)
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'Izin Edar PDUK',
                    'nama_perusahaan' => $item->business->nama_perusahaan ?? 'N/A',
                    'akhir_masa_berlaku' => $item->tanggal_terakhir,
                ];
            });
        $surveilans = $surveilans->concat($psatpdukData);

        // Filter by keyword
        if ($keyword) {
            $surveilans = $surveilans->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item['jenis']), strtolower($keyword)) ||
                       str_contains(strtolower($item['nama_perusahaan']), strtolower($keyword));
            });
        }

        // Sort the collection
        $surveilans = $surveilans->sortBy($sortField, SORT_REGULAR, $sortOrder === 'desc')->values();

        // Manual pagination
        $total = $surveilans->count();
        $items = $surveilans->forPage($page, $perPage);
        $surveilans = new \Illuminate\Pagination\LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        $breadcrumbs = [
            'Admin' => 'javascript:void(0)',
            'Notifikasi Surveilan' => route('surveilan.index'),
        ];

        return view('admin.pages.surveilan.index', compact(
            'breadcrumbs',
            'surveilans',
            'perPage',
            'keyword',
            'sortField',
            'sortOrder',
            'page'
        ));
    }
}
