<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationListRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private $notificationService;
    private $mainBreadcrumbs;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            // 'Dashboard' => route('admin.dashboard'),
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
            Auth::id(),
            $perPage,
            $sortField,
            $sortOrder,
            $keyword,
            filter_var($unreadOnly, FILTER_VALIDATE_BOOLEAN)
        );

        $unreadCount = $this->notificationService->getUnreadNotificationsCount(Auth::id());
        $stats = $this->notificationService->getNotificationStats(Auth::id());

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
        $notification = $this->notificationService->getNotificationDetail($id, Auth::id());

        if (!$notification) {
            abort(404, 'Notification not found');
        }

        // Mark as read when viewing
        $this->notificationService->markNotificationAsRead($id, Auth::id());

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
        $result = $this->notificationService->markNotificationAsRead($id, Auth::id());

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
        $result = $this->notificationService->markAllNotificationsAsRead(Auth::id());

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
        $result = $this->notificationService->deleteNotification($id, Auth::id());

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
        $result = $this->notificationService->deleteAllReadNotifications(Auth::id());

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
        $limit = $request->input('limit', 10);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $unreadOnly = $request->input('unread_only', true); // Default to true for navbar

        $notifications = $this->notificationService->listUserNotifications(
            Auth::id(),
            $limit, // Use limit instead of perPage
            $sortBy,
            $sortOrder,
            null, // keyword
            filter_var($unreadOnly, FILTER_VALIDATE_BOOLEAN)
        );

        return response()->json(
            $notifications->items() // Return only the items for simplicity in navbar
        );
    }

    /**
     * =============================================
     *      Get unread notifications count for header
     * =============================================
     */
    public function getUnreadCount()
    {
        $count = $this->notificationService->getUnreadNotificationsCount(Auth::id());

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
