<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationListRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    private $notificationService;
    private $mainBreadcrumbs;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Dashboard' => route('admin.dashboard'),
            'Notifications' => route('notification.index'),
        ];
    }

    /**
     * =============================================
     *      List all notifications with search/filter/sort
     * =============================================
     */
    public function index(NotificationListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'created_at'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'desc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');
        $unreadOnly = $request->input('unreadOnly', false);

        $notifications = $this->notificationService->listUserNotifications(
            auth()->id(),
            $perPage,
            $sortField,
            $sortOrder,
            $keyword,
            filter_var($unreadOnly, FILTER_VALIDATE_BOOLEAN)
        );

        $unreadCount = $this->notificationService->getUnreadNotificationsCount(auth()->id());
        $stats = $this->notificationService->getNotificationStats(auth()->id());

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.notification.index', compact(
            'notifications',
            'breadcrumbs',
            'sortField',
            'sortOrder',
            'perPage',
            'page',
            'keyword',
            'unreadOnly',
            'unreadCount',
            'stats',
            'alerts'
        ));
    }

    /**
     * =============================================
     *      Display notification detail
     * =============================================
     */
    public function show($id)
    {
        $notification = $this->notificationService->getNotificationDetail($id, auth()->id());

        if (!$notification) {
            abort(404, 'Notification not found');
        }

        // Mark as read when viewing
        $this->notificationService->markNotificationAsRead($id, auth()->id());

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.notification.detail', compact('breadcrumbs', 'notification'));
    }

    /**
     * =============================================
     *      Mark notification as read
     * =============================================
     */
    public function markAsRead($id)
    {
        $result = $this->notificationService->markNotificationAsRead($id, auth()->id());

        $alert = $result
            ? AlertHelper::createAlert('success', 'Notification marked as read')
            : AlertHelper::createAlert('danger', 'Failed to mark notification as read');

        return redirect()->back()->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Mark all notifications as read
     * =============================================
     */
    public function markAllAsRead(Request $request)
    {
        $result = $this->notificationService->markAllNotificationsAsRead(auth()->id());

        $alert = $result
            ? AlertHelper::createAlert('success', 'All notifications marked as read')
            : AlertHelper::createAlert('danger', 'Failed to mark all notifications as read');

        return redirect()->back()->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Delete notification
     * =============================================
     */
    public function destroy($id)
    {
        $result = $this->notificationService->deleteNotification($id, auth()->id());

        $alert = $result
            ? AlertHelper::createAlert('success', 'Notification deleted successfully')
            : AlertHelper::createAlert('danger', 'Failed to delete notification');

        return redirect()->route('notification.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Delete all read notifications
     * =============================================
     */
    public function deleteRead()
    {
        $result = $this->notificationService->deleteAllReadNotifications(auth()->id());

        $alert = $result
            ? AlertHelper::createAlert('success', 'All read notifications deleted')
            : AlertHelper::createAlert('danger', 'Failed to delete read notifications');

        return redirect()->back()->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Get notifications for API (AJAX)
     * =============================================
     */
    public function getNotificationsApi(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $unreadOnly = $request->input('unreadOnly', false);

        $notifications = $this->notificationService->listUserNotifications(
            auth()->id(),
            $perPage,
            null,
            null,
            null,
            filter_var($unreadOnly, FILTER_VALIDATE_BOOLEAN)
        );

        return response()->json([
            'notifications' => $notifications->items(),
            'total' => $notifications->total(),
            'unread_count' => $this->notificationService->getUnreadNotificationsCount(auth()->id()),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ]
        ]);
    }

    /**
     * =============================================
     *      Get unread notifications count for header
     * =============================================
     */
    public function getUnreadCount()
    {
        $count = $this->notificationService->getUnreadNotificationsCount(auth()->id());

        return response()->json(['count' => $count]);
    }

    /**
     * =============================================
     *      Create a system notification (admin only)
     * =============================================
     */
    public function createSystemNotification(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'sometimes|string|max:50',
            'data' => 'sometimes|array',
        ]);

        $notification = $this->notificationService->createSystemNotification(
            $validatedData['user_id'],
            $validatedData['title'],
            $validatedData['message'],
            $validatedData['type'] ?? 'system_alert',
            $validatedData['data'] ?? []
        );

        $alert = $notification
            ? AlertHelper::createAlert('success', 'Notification created successfully')
            : AlertHelper::createAlert('danger', 'Failed to create notification');

        return redirect()->back()->with('alerts', [$alert]);
    }
}
