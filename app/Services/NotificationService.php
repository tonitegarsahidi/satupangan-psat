<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\NotificationRepository;

class NotificationService
{
    private $notificationRepository;

    /**
     * Constructor
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * List all notifications for a user with filtering and pagination
     */
    public function listUserNotifications(
        int $userId,
        int $perPage = 10,
        string $sortField = null,
        string $sortOrder = null,
        string $keyword = null,
        bool $unreadOnly = false
    ): LengthAwarePaginator {
        return $this->notificationRepository->getUserNotifications(
            $userId, $perPage, $sortField, $sortOrder, $keyword, $unreadOnly
        );
    }

    /**
     * Get a single notification detail
     */
    public function getNotificationDetail($notificationId, $userId): ?Notification
    {
        $notification = $this->notificationRepository->getNotificationById($notificationId);

        // Ensure notification belongs to the user
        if ($notification && $notification->user_id === $userId) {
            return $notification;
        }

        return null;
    }

    /**
     * Create a new notification
     */
    public function createNotification(array $data): ?Notification
    {
        DB::beginTransaction();
        try {
            $notification = $this->notificationRepository->createNotification($data);
            DB::commit();
            return $notification;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to create notification: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Update a notification
     */
    public function updateNotification(array $data, $notificationId, $userId): ?Notification
    {
        DB::beginTransaction();
        try {
            // Ensure notification belongs to the user
            $notification = $this->notificationRepository->getNotificationById($notificationId);
            if (!$notification || $notification->user_id !== $userId) {
                throw new \Exception("Notification not found or access denied");
            }

            $updatedNotification = $this->notificationRepository->updateNotification($notificationId, $data);
            DB::commit();
            return $updatedNotification;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update notification: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Delete a notification
     */
    public function deleteNotification($notificationId, $userId): bool
    {
        DB::beginTransaction();
        try {
            // Ensure notification belongs to the user
            $notification = $this->notificationRepository->getNotificationById($notificationId);
            if (!$notification || $notification->user_id !== $userId) {
                throw new \Exception("Notification not found or access denied");
            }

            $result = $this->notificationRepository->deleteNotification($notificationId);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete notification: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Mark a notification as read
     */
    public function markNotificationAsRead($notificationId, $userId): bool
    {
        try {
            // Ensure notification belongs to the user
            $notification = $this->notificationRepository->getNotificationById($notificationId);
            if (!$notification || $notification->user_id !== $userId) {
                throw new \Exception("Notification not found or access denied");
            }

            return $this->notificationRepository->markAsRead($notificationId);
        } catch (\Exception $exception) {
            Log::error("Failed to mark notification as read: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllNotificationsAsRead($userId): bool
    {
        try {
            return $this->notificationRepository->markAllAsRead($userId);
        } catch (\Exception $exception) {
            Log::error("Failed to mark all notifications as read: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Get unread notifications count for a user
     */
    public function getUnreadNotificationsCount($userId): int
    {
        return $this->notificationRepository->getUnreadCount($userId);
    }

    /**
     * Get notifications by type for a user
     */
    public function getNotificationsByType($userId, $type, $perPage = 10): LengthAwarePaginator
    {
        return $this->notificationRepository->getNotificationsByType($userId, $type, $perPage);
    }

    /**
     * Delete all read notifications for a user
     */
    public function deleteAllReadNotifications($userId): bool
    {
        try {
            return $this->notificationRepository->deleteReadNotifications($userId);
        } catch (\Exception $exception) {
            Log::error("Failed to delete read notifications: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Create system notification for a user
     */
    public function createSystemNotification(
        $userId,
        $title,
        $message,
        $type = 'system_alert',
        $data = []
    ): ?Notification {
        $notificationData = [
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'is_read' => false,
        ];

        return $this->createNotification($notificationData);
    }

    /**
     * Create bulk notifications for multiple users
     */
    public function createBulkNotifications(array $users, $title, $message, $type = 'system_alert', $data = []): int
    {
        $createdCount = 0;

        foreach ($users as $userId) {
            if ($this->createSystemNotification($userId, $title, $message, $type, $data)) {
                $createdCount++;
            }
        }

        return $createdCount;
    }

    /**
     * Get notifications created after a specific date
     */
    public function getRecentNotifications($userId, $date)
    {
        return $this->notificationRepository->getNotificationsAfterDate($userId, $date);
    }

    /**
     * Mark notifications as read based on type
     */
    public function markNotificationsAsReadByType($userId, $type): bool
    {
        try {
            Notification::where('user_id', $userId)
                ->where('type', $type)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return true;
        } catch (\Exception $exception) {
            Log::error("Failed to mark notifications as read by type: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Get notification statistics for a user
     */
    public function getNotificationStats($userId): array
    {
        $total = Notification::where('user_id', $userId)->count();
        $unread = $this->getUnreadNotificationsCount($userId);
        $read = $total - $unread;

        // Count by type
        $byType = Notification::where('user_id', $userId)
            ->select('type', \DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type')
            ->toArray();

        return [
            'total' => $total,
            'unread' => $unread,
            'read' => $read,
            'by_type' => $byType,
        ];
    }
}
