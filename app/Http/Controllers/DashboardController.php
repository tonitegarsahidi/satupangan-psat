<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * =============================================
     *      view dashboard pages
     * =============================================
     */
    public function index(Request $request){
        $user = $request->user();

        // Get statistics for the current user
        $laporanPengaduanCount = \App\Models\LaporanPengaduan::where('user_id', $user->id)->count();

        // For tables that use business_id instead of user_id, get businesses associated with the user
        $businessIds = \App\Models\Business::where('user_id', $user->id)->pluck('id');

        $registerSppbCount = \App\Models\RegisterSppb::whereIn('business_id', $businessIds)->count();
        $izinEdarPlCount = \App\Models\RegisterIzinedarPsatpl::whereIn('business_id', $businessIds)->count();
        $izinEdarPdCount = \App\Models\RegisterIzinedarPsatpd::whereIn('business_id', $businessIds)->count();
        $izinEdarPdukCount = \App\Models\RegisterIzinedarPsatpduk::whereIn('business_id', $businessIds)->count();
        $qrBadanPanganCount = \App\Models\QrBadanPangan::whereIn('business_id', $businessIds)->count();

        return view('admin.pages.dashboard.index', [
            'user' => $user,
            'laporanPengaduanCount' => $laporanPengaduanCount,
            'registerSppbCount' => $registerSppbCount,
            'izinEdarPlCount' => $izinEdarPlCount,
            'izinEdarPdCount' => $izinEdarPdCount,
            'izinEdarPdukCount' => $izinEdarPdukCount,
            'qrBadanPanganCount' => $qrBadanPanganCount,
        ]);
    }
}
