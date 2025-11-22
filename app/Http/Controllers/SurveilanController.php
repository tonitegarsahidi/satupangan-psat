<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

        // Get notification service to query recent notifications
        $notificationService = app(\App\Services\NotificationService::class);

        // Query notifications from last 2 months
        $twoMonthsAgo = Carbon::now()->subMonths(2);
        $recentNotifications = $notificationService->getNotificationsByTypeAndDateRange(
            'notification_surveilans',
            $twoMonthsAgo
        );

        // Create lookup map for jenis and nomor from notifications
        $notificationLookup = [];
        foreach ($recentNotifications as $notification) {
            $jenis = $notification->data['jenis_dokumen'] ?? null;
            $nomor = $notification->data['nomor_dokumen'] ?? null;
            if ($jenis && $nomor) {
                $key = strtolower($jenis) . '|' . strtolower($nomor);
                $notificationLookup[$key] = true;
            }
        }

        $surveilans = collect();
        $today = Carbon::today();
        $notificationMonthLater = Carbon::today()->addMonths(2);

        // Fetch Register SPPB
        $sppbData = RegisterSppb::with('business')
            ->where('tanggal_terakhir', '<=', $notificationMonthLater)
            ->get()
            ->map(function ($item) use ($notificationLookup) {
                $jenis = 'Register SPPB';
                $nomor = $item->nomor_registrasi ?? 'N/A';
                $key = strtolower($jenis) . '|' . strtolower($nomor);
                $hasNotification = isset($notificationLookup[$key]);

                return [
                    'jenis' => $jenis,
                    'nomor' => $nomor,
                    'nama_perusahaan' => $item->business->nama_perusahaan ?? 'N/A',
                    'akhir_masa_berlaku' => $item->tanggal_terakhir,
                    'business_id' => $item->business->id ?? null,
                    'has_notification' => $hasNotification,
                    'surveilan_id' => $item->id,
                ];
            });
        $surveilans = $surveilans->concat($sppbData);

        // Fetch Izin Edar PL
        $psatplData = RegisterIzinedarPsatpl::with('business')
            ->where('tanggal_terakhir', '<=', $notificationMonthLater)
            ->get()
            ->map(function ($item) use ($notificationLookup) {
                $jenis = 'Izin Edar PL';
                $nomor = $item->nomor_izinedar_pl ?? 'N/A';
                $key = strtolower($jenis) . '|' . strtolower($nomor);
                $hasNotification = isset($notificationLookup[$key]);

                return [
                    'jenis' => $jenis,
                    'nomor' => $item->nomor_izinedar_pl ?? 'N/A',
                    'nama_perusahaan' => $item->business->nama_perusahaan ?? 'N/A',
                    'akhir_masa_berlaku' => $item->tanggal_terakhir,
                    'business_id' => $item->business->id ?? null,
                    'has_notification' => $hasNotification,
                    'surveilan_id' => $item->id,
                ];
            });
        $surveilans = $surveilans->concat($psatplData);

        // Fetch Izin Edar PD
        $psatpdData = RegisterIzinedarPsatpd::with('business')
            ->where('tanggal_terakhir', '<=', $notificationMonthLater)
            ->get()
            ->map(function ($item) use ($notificationLookup) {
                $jenis = 'Izin Edar PD';
                $nomor = $item->nomor_izinedar_pd ?? 'N/A';
                $key = strtolower($jenis) . '|' . strtolower($nomor);
                $hasNotification = isset($notificationLookup[$key]);

                return [
                    'jenis' => $jenis,
                    'nomor' => $item->nomor_izinedar_pd ?? 'N/A',
                    'nama_perusahaan' => $item->business->nama_perusahaan ?? 'N/A',
                    'akhir_masa_berlaku' => $item->tanggal_terakhir,
                    'business_id' => $item->business->id ?? null,
                    'has_notification' => $hasNotification,
                    'surveilan_id' => $item->id,
                ];
            });
        $surveilans = $surveilans->concat($psatpdData);

        // Fetch Izin Edar PDUK
        $psatpdukData = RegisterIzinedarPsatpduk::with('business')
            ->where('tanggal_terakhir', '<=', $notificationMonthLater)
            ->get()
            ->map(function ($item) use ($notificationLookup) {
                $jenis = 'Izin Edar PDUK';
                $nomor = $item->nomor_izinedar_pduk ?? 'N/A';
                $key = strtolower($jenis) . '|' . strtolower($nomor);
                $hasNotification = isset($notificationLookup[$key]);

                return [
                    'jenis' => $jenis,
                    'nomor' => $item->nomor_izinedar_pduk ?? 'N/A',
                    'nama_perusahaan' => $item->business->nama_perusahaan ?? 'N/A',
                    'akhir_masa_berlaku' => $item->tanggal_terakhir,
                    'business_id' => $item->business->id ?? null,
                    'has_notification' => $hasNotification,
                    'surveilan_id' => $item->id,
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

    /**
     * Show the form for sending notification to business owners
     */
    public function createNotification()
    {
        // Get all business owners (users with ROLE_USER_BUSINESS who have a business)
        $businessOwners = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('role_code', 'ROLE_USER_BUSINESS');
        })
            ->whereHas('business')
            ->with('business')
            ->get(['id', 'name', 'email']);

        $breadcrumbs = [
            'Admin' => 'javascript:void(0)',
            'Notifikasi Surveilan' => route('surveilan.index'),
            'Kirim Notifikasi' => null,
        ];

        return view('admin.pages.surveilan.create-notification', compact(
            'breadcrumbs',
            'businessOwners'
        ));
    }

    /**
     * Send notification to business owner
     */
    public function sendNotification(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'business_owner_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'jenis' => 'nullable|string|max:255', // Tambahan: jenis dokumen
            'nomor' => 'nullable|string|max:255', // Tambahan: nomor dokumen
            'surveilan_id' => 'nullable|string|max:255', // Tambahan: ID surveilan
        ]);

        // dd($validatedData);

        // dd($validatedData);

        // Get the business owner
        $businessOwner = \App\Models\User::findOrFail($validatedData['business_owner_id']);

        // Create message thread
        $threadData = [
            'title' => $validatedData['title'],
            'participant_id' => $businessOwner->id,
        ];

        $messageData = [
            'message' => $validatedData['message'],
        ];

        // Use the MessageService to create thread and send message
        $messageService = app(\App\Services\MessageService::class);
        $thread = $messageService->createThreadWithMessage($threadData, $messageData, Auth::id());

        if ($thread) {
            // Create notification for the business owner
            $notificationService = app(\App\Services\NotificationService::class);

            // Siapkan data tambahan untuk notifikasi
            $notificationData = [
                'thread_id' => $thread->id,
                'sender_id' => Auth::id(),
                'business_name' => $businessOwner->business->nama_perusahaan ?? 'N/A'
            ];

            // Tambahkan data surveilan jika tersedia
            if (isset($validatedData['jenis'])) {
                $notificationData['jenis_dokumen'] = $validatedData['jenis'];
            }
            if (isset($validatedData['nomor'])) {
                $notificationData['nomor_dokumen'] = $validatedData['nomor'];
            }
            if (isset($validatedData['surveilan_id'])) {
                $notificationData['surveilan_id'] = $validatedData['surveilan_id'];
            }

            $notificationService->createSystemNotification(
                $businessOwner->id,
                $validatedData['title'],
                $validatedData['message'] . '<br/>' . 'Silakan Cek Kotak Pesan Anda untuk melihat detailnya: <a href="' . route('message.show', $thread->id) . '">Lihat Pesan</a>',
                'notification_surveilans',
                $notificationData
            );

            return redirect()->route('surveilan.index')
                ->with('alerts', [
                    \App\Helpers\AlertHelper::createAlert('success', 'Pesan berhasil dikirim ke pemilik bisnis.')
                ]);
        }

        return redirect()->route('surveilan.create-notification')
            ->with('alerts', [
                \App\Helpers\AlertHelper::createAlert('danger', 'Gagal mengirim pesan. Silakan coba lagi.')
            ])
            ->withInput();
    }

    /**
     * Show the form for sending notification to a specific business owner
     */
    public function createNotificationForBusiness(Request $request, $business_id)
    {
        // Get the specific business owner
        $selectedBusinessOwner = \App\Models\User::whereHas('business', function ($query) use ($business_id) {
            $query->where('id', $business_id);
        })
            ->with('business')
            ->firstOrFail(['id', 'name', 'email']);

        // Get all business owners (users with ROLE_USER_BUSINESS who have a business)
        $businessOwners = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('role_code', 'ROLE_USER_BUSINESS');
        })
            ->whereHas('business')
            ->with('business')
            ->get(['id', 'name', 'email']);

        // Get additional parameters from request
        $jenis = $request->get('jenis');
        $nomor = $request->get('nomor');
        $surveilan_id = $request->get('surveilan_id');
        $pelaku_usaha = $request->get('pelaku_usaha');
        $akhir_masa_berlaku = $request->get('akhir_masa_berlaku');

        $breadcrumbs = [
            'Admin' => 'javascript:void(0)',
            'Notifikasi Surveilan' => route('surveilan.index'),
            'Kirim Notifikasi' => null,
        ];

        return view('admin.pages.surveilan.create-notification', compact(
            'breadcrumbs',
            'businessOwners',
            'selectedBusinessOwner',
            'jenis',
            'nomor',
            'surveilan_id',
            'pelaku_usaha',
            'akhir_masa_berlaku'
        ));
    }
}
