<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     * =============================================
     *      view dashboard pages
     * =============================================
     */
    public function index(Request $request){
        $user = $request->user();

        // Initialize variables
        $laporanPengaduanCount = 0;
        $registerSppbCount = 0;
        $izinEdarPlCount = 0;
        $izinEdarPdCount = 0;
        $izinEdarPdukCount = 0;
        $qrBadanPanganCount = 0;
        $unreadNotificationsCount = 0;
        $unreadMessagesCount = 0;
        $unreadEarlyWarningNotifications = collect();

        // QR Badan Pangan lists
        $qrBadanPanganPendingReviewed = collect();
        $qrBadanPanganAllPendingReviewed = collect();

        // Register SPPB lists
        $registerSppbDiajukanDiperiksa = collect();
        $registerSppbAllDiajukanDiperiksa = collect();

        // Register Izin Edar PL lists
        $registerIzinedarPlDiajukanDiperiksa = collect();
        $registerIzinedarPlAllDiajukanDiperiksa = collect();

        // Register Izin Edar PD lists
        $registerIzinedarPdDiajukanDiperiksa = collect();
        $registerIzinedarPdAllDiajukanDiperiksa = collect();

        // Register Izin Edar PDUK lists
        $registerIzinedarPdukDiajukanDiperiksa = collect();
        $registerIzinedarPdukAllDiajukanDiperiksa = collect();

        // Laporan Pengaduan lists
        $laporanPengaduanDiajukanDiperiksa = collect();
        $laporanPengaduanAllDiajukanDiperiksa = collect();

        // Check user roles
        $hasUserRole = $user->hasRole('ROLE_USER');
        $hasUserRoleBusiness = $user->hasRole('ROLE_USER_BUSINESS');
        $hasUserRoleOperator = $user->hasRole('ROLE_OPERATOR');
        $hasUserRoleSupervisor = $user->hasRole('ROLE_SUPERVISOR');

        // Get statistics for the current user
        $laporanPengaduanCount = \App\Models\LaporanPengaduan::where('user_id', $user->id)->count();

        // For tables that use business_id instead of user_id, get businesses associated with the user
        $businessIds = \App\Models\Business::where('user_id', $user->id)->pluck('id');

        // ROLE_USER_BUSINESS: Get only their own data
        if ($hasUserRoleBusiness) {
            $registerSppbCount = \App\Models\RegisterSppb::whereIn('business_id', $businessIds)
                ->whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])
                ->count();

            $izinEdarPlCount = \App\Models\RegisterIzinedarPsatpl::whereIn('business_id', $businessIds)
                ->whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])
                ->count();

            $izinEdarPdCount = \App\Models\RegisterIzinedarPsatpd::whereIn('business_id', $businessIds)
                ->whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])
                ->count();

            $izinEdarPdukCount = \App\Models\RegisterIzinedarPsatpduk::whereIn('business_id', $businessIds)
                ->whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])
                ->count();

            $qrBadanPanganCount = \App\Models\QrBadanPangan::whereIn('business_id', $businessIds)
                ->whereIn('status', ['Pending', 'Reviewed'])
                ->count();

            // Get lists for ROLE_USER_BUSINESS
            $qrBadanPanganPendingReviewed = \App\Models\QrBadanPangan::whereIn('business_id', $businessIds)
                ->whereIn('status', ['Pending', 'Reviewed'])
                ->get();

            $registerSppbDiajukanDiperiksa = \App\Models\RegisterSppb::whereIn('business_id', $businessIds)
                ->whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])
                ->get();

            $registerIzinedarPlDiajukanDiperiksa = \App\Models\RegisterIzinedarPsatpl::whereIn('business_id', $businessIds)
                ->whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])
                ->get();

            $registerIzinedarPdDiajukanDiperiksa = \App\Models\RegisterIzinedarPsatpd::whereIn('business_id', $businessIds)
                ->whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])
                ->get();

            $registerIzinedarPdukDiajukanDiperiksa = \App\Models\RegisterIzinedarPsatpduk::whereIn('business_id', $businessIds)
                ->whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])
                ->get();


        }

          // Get laporan pengaduan for ROLE_USER_BUSINESS
            $laporanPengaduanDiajukanDiperiksa = \App\Models\LaporanPengaduan::get();//where('user_id', $user->id)
                // ->where('tindak_lanjut_pertama', null)
                // ->get();
        // Get laporan pengaduan for ROLE_OPERATOR or ROLE_SUPERVISOR
            $laporanPengaduanAllDiajukanDiperiksa = \App\Models\LaporanPengaduan::where('tindak_lanjut_pertama', null)->get();

        // Get unread notifications count
        $unreadNotificationsCount = \App\Models\Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        // Get unread EARLY_WARNING notifications
        $unreadEarlyWarningNotifications = \App\Models\Notification::where('user_id', $user->id)
            ->where('type', 'EARLY_WARNING')
            ->where('is_read', false)
            ->get();

        // Get unread messages count
        $unreadMessagesCount = \App\Models\MessageThread::forUser($user->id)
            ->unreadForUser($user->id)
            ->count();

        // ROLE_OPERATOR or ROLE_SUPERVISOR: Get all data
        if ($hasUserRoleOperator || $hasUserRoleSupervisor) {
            $registerSppbCount = \App\Models\RegisterSppb::whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])->count();
            $izinEdarPlCount = \App\Models\RegisterIzinedarPsatpl::whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])->count();
            $izinEdarPdCount = \App\Models\RegisterIzinedarPsatpd::whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])->count();
            $izinEdarPdukCount = \App\Models\RegisterIzinedarPsatpduk::whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])->count();
            $qrBadanPanganCount = \App\Models\QrBadanPangan::whereIn('status', ['Pending', 'Reviewed'])->count();

            // Get lists for ROLE_OPERATOR or ROLE_SUPERVISOR
            $qrBadanPanganAllPendingReviewed = \App\Models\QrBadanPangan::whereIn('status', ['Pending', 'Reviewed'])->get();
            $registerSppbAllDiajukanDiperiksa = \App\Models\RegisterSppb::whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])->get();
            $registerIzinedarPlAllDiajukanDiperiksa = \App\Models\RegisterIzinedarPsatpl::whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])->get();
            $registerIzinedarPdAllDiajukanDiperiksa = \App\Models\RegisterIzinedarPsatpd::whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])->get();
            $registerIzinedarPdukAllDiajukanDiperiksa = \App\Models\RegisterIzinedarPsatpduk::whereIn('status', ['DIAJUKAN', 'DIPERIKSA'])->get();


        }

        return view('admin.pages.dashboard.index', [
            'user' => $user,
            'laporanPengaduanCount' => $laporanPengaduanCount,
            'registerSppbCount' => $registerSppbCount,
            'izinEdarPlCount' => $izinEdarPlCount,
            'izinEdarPdCount' => $izinEdarPdCount,
            'izinEdarPdukCount' => $izinEdarPdukCount,
            'qrBadanPanganCount' => $qrBadanPanganCount,
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'unreadMessagesCount' => $unreadMessagesCount,
            'unreadEarlyWarningNotifications' => $unreadEarlyWarningNotifications,
            'hasUserRole' => $hasUserRole,
            'hasUserRoleBusiness' => $hasUserRoleBusiness,
            'hasUserRoleOperator' => $hasUserRoleOperator,
            'hasUserRoleSupervisor' => $hasUserRoleSupervisor,
            'qrBadanPanganPendingReviewed' => $qrBadanPanganPendingReviewed,
            'qrBadanPanganAllPendingReviewed' => $qrBadanPanganAllPendingReviewed,
            'registerSppbDiajukanDiperiksa' => $registerSppbDiajukanDiperiksa,
            'registerSppbAllDiajukanDiperiksa' => $registerSppbAllDiajukanDiperiksa,
            'registerIzinedarPlDiajukanDiperiksa' => $registerIzinedarPlDiajukanDiperiksa,
            'registerIzinedarPlAllDiajukanDiperiksa' => $registerIzinedarPlAllDiajukanDiperiksa,
            'registerIzinedarPdDiajukanDiperiksa' => $registerIzinedarPdDiajukanDiperiksa,
            'registerIzinedarPdAllDiajukanDiperiksa' => $registerIzinedarPdAllDiajukanDiperiksa,
            'registerIzinedarPdukDiajukanDiperiksa' => $registerIzinedarPdukDiajukanDiperiksa,
            'registerIzinedarPdukAllDiajukanDiperiksa' => $registerIzinedarPdukAllDiajukanDiperiksa,
            'laporanPengaduanDiajukanDiperiksa' => $laporanPengaduanDiajukanDiperiksa,
            'laporanPengaduanAllDiajukanDiperiksa' => $laporanPengaduanAllDiajukanDiperiksa,
        ]);
    }
}
