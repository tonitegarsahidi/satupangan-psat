<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class NotificationRepository
{
    /**
     * Get all notifications for a user with pagination
     */
    public function getUserNotifications(
        $userId,
        int $limit = 10, // Renamed from perPage to limit
        string $sortField = null,
        string $sortOrder = null,
        string $keyword = null,
        bool $unreadOnly = false
    ): LengthAwarePaginator {
        $queryResult = Notification::where('user_id', $userId);

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        if ($unreadOnly) {
            $queryResult->where('is_read', false);
        }

        if (!is_null($keyword)) {
            $queryResult->where(function ($query) use ($keyword) {
                $query->whereRaw('lower(title) LIKE ?', ['%' . strtolower($keyword) . '%'])
                    ->orWhereRaw('lower(message) LIKE ?', ['%' . strtolower($keyword) . '%'])
                    ->orWhereRaw('lower(type) LIKE ?', ['%' . strtolower($keyword) . '%']);
            });
        }

        $paginator = $queryResult->paginate($limit); // Use limit here

        // Manually append query parameters to ensure proper URL encoding
        $paginator = $paginator->withPath('notification');
        if ($keyword) {
            $paginator = $paginator->appends('keyword', e($keyword));
        }
        if ($sortField) {
            $paginator = $paginator->appends('sort_field', e($sortField));
        }
        if ($sortOrder) {
            $paginator = $paginator->appends('sort_order', e($sortOrder));
        }
        if ($unreadOnly !== false) {
            $paginator = $paginator->appends('unreadOnly', e($unreadOnly));
        }

        return $paginator;
    }

    /**
     * Get a single notification by ID
     */
    public function getNotificationById($notificationId): ?Notification
    {
        return Notification::find($notificationId);
    }

    /**
     * Create a new notification
     */
    public function createNotification(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Update a notification
     */
    public function updateNotification($notificationId, array $data): ?Notification
    {
        try {
            $notification = Notification::findOrFail($notificationId);
            $notification->update($data);
            return $notification;
        } catch (Exception $e) {
            Log::error("Failed to update notification: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Delete a notification
     */
    public function deleteNotification($notificationId): bool
    {
        try {
            $notification = Notification::findOrFail($notificationId);
            $notification->delete();
            return true;
        } catch (Exception $e) {
            Log::error("Failed to delete notification: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId): bool
    {
        $result = $this->updateNotification($notificationId, ['is_read' => true]);
        return (bool) $result;
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead($userId): bool
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * Get unread notifications count for a user
     */
    public function getUnreadCount($userId): int
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get notifications by type for a user
     */
    public function getNotificationsByType($userId, $type, $perPage = 10): LengthAwarePaginator
    {
        return Notification::where('user_id', $userId)
            ->where('type', $type)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Delete all read notifications for a user
     */
    public function deleteReadNotifications($userId): bool
    {
        try {
            Notification::where('user_id', $userId)
                ->where('is_read', true)
                ->delete();
            return true;
        } catch (Exception $e) {
            Log::error("Failed to delete read notifications: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Get notifications created after a specific date
     */
    public function getNotificationsAfterDate($userId, $date): \Illuminate\Database\Eloquent\Collection
    {
        return Notification::where('user_id', $userId)
            ->where('created_at', '>', $date)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
