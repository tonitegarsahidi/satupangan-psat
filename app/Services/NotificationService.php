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
        $userId,
        int $limit = 10, // Renamed from perPage to limit
        string $sortField = null,
        string $sortOrder = null,
        string $keyword = null,
        bool $unreadOnly = false
    ): LengthAwarePaginator {
        return $this->notificationRepository->getUserNotifications(
            $userId, $limit, $sortField, $sortOrder, $keyword, $unreadOnly
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
        $stats = [];

        $types = Notification::where('user_id', $userId)
            ->distinct()
            ->pluck('type');

        foreach ($types as $type) {
            $total = Notification::where('user_id', $userId)
                ->where('type', $type)
                ->count();

            $unread = Notification::where('user_id', $userId)
                ->where('type', $type)
                ->where('is_read', false)
                ->count();

            $read = $total - $unread;

            $stats[] = [
                'type' => $type,
                'unread_count' => $unread,
                'read_count' => $read,
                'total_count' => $total,
            ];
        }

        // Add overall totals if needed, though the request implies per-type table
        $overallTotal = Notification::where('user_id', $userId)->count();
        $overallUnread = $this->getUnreadNotificationsCount($userId);
        $overallRead = $overallTotal - $overallUnread;

        return [
            'type_stats' => $stats,
            'overall_total' => $overallTotal,
            'overall_unread' => $overallUnread,
            'overall_read' => $overallRead,
        ];
    }

    /**
     * Send notification to all users
     *
     * Usage example:
     * $notificationService = app(NotificationService::class);
     * $count = $notificationService->sendToAllUsers(
     *     'System Maintenance',
     *     'The system will undergo maintenance tonight at 2 AM.',
     *     'maintenance_alert',
     *     ['scheduled_time' => '2023-12-01 02:00:00']
     * );
     *
     * @param string $title Notification title
     * @param string $message Notification message content
     * @param string $type Notification type (default: 'system_alert')
     * @param array $data Additional data for the notification (default: [])
     * @return int Number of notifications successfully created
     */
    public function sendToAllUsers($title, $message, $type = 'system_alert', $data = []): int
    {
        try {
            // Get all active users
            $users = User::where('is_active', true)->pluck('id');

            $createdCount = 0;

            foreach ($users as $userId) {
                if ($this->createSystemNotification($userId, $title, $message, $type, $data)) {
                    $createdCount++;
                }
            }

            Log::info("Sent notifications to {$createdCount} users");
            return $createdCount;
        } catch (\Exception $exception) {
            Log::error("Failed to send notifications to all users: {$exception->getMessage()}");
            return 0;
        }
    }

    /**
     * Send notification to specific user by email
     *
     * Usage example:
     * $notificationService = app(NotificationService::class);
     * $success = $notificationService->sendToUserByEmail(
     *     'user@example.com',
     *     'Welcome to Our Platform',
     *     'Thank you for registering. Please verify your email address.',
     *     'welcome_email',
     *     ['action_url' => 'https://example.com/verify']
     * );
     *
     * @param string $email Email address of the user to receive notification
     * @param string $title Notification title
     * @param string $message Notification message content
     * @param string $type Notification type (default: 'system_alert')
     * @param array $data Additional data for the notification (default: [])
     * @return bool True if notification was sent successfully, false otherwise
     */
    public function sendToUserByEmail($email, $title, $message, $type = 'system_alert', $data = []): bool
    {
        try {
            // Find user by email
            $user = User::where('email', $email)->first();

            if (!$user) {
                Log::warning("User with email {$email} not found");
                return false;
            }

            // Check if user is active
            if (!$user->is_active) {
                Log::warning("User with email {$email} is not active");
                return false;
            }

            $notification = $this->createSystemNotification($user->id, $title, $message, $type, $data);

            if ($notification) {
                Log::info("Notification sent to user {$email}");
                return true;
            }

            return false;
        } catch (\Exception $exception) {
            Log::error("Failed to send notification to user {$email}: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Send notification to users with specific roles
     *
     * Usage example:
     * $notificationService = app(NotificationService::class);
     * $count = $notificationService->sendToUsersByRoles(
     *     ['ROLE_OPERATOR', 'ROLE_SUPERVISOR'],
     *     'New Policy Update',
     *     'Please review the updated policies in the dashboard.',
     *     'policy_update',
     *     ['policy_url' => 'https://example.com/policies']
     * );
     *
     * @param array $roleCodes Array of role codes to target
     * @param string $title Notification title
     * @param string $message Notification message content
     * @param string $type Notification type (default: 'system_alert')
     * @param array $data Additional data for the notification (default: [])
     * @return int Number of notifications successfully created
     */
    public function sendToUsersByRoles(array $roleCodes, $title, $message, $type = 'system_alert', $data = []): int
    {
        try {
            // Get users with specified roles who are active
            $users = User::where('is_active', true)
                ->whereHas('roles', function ($query) use ($roleCodes) {
                    $query->whereIn('role_code', $roleCodes);
                })
                ->pluck('id');

            $createdCount = 0;

            foreach ($users as $userId) {
                if ($this->createSystemNotification($userId, $title, $message, $type, $data)) {
                    $createdCount++;
                }
            }

            Log::info("Sent notifications to {$createdCount} users with roles: " . implode(', ', $roleCodes));
            return $createdCount;
        } catch (\Exception $exception) {
            Log::error("Failed to send notifications to users with roles: {$exception->getMessage()}");
            return 0;
        }
    }

    /**
     * Send notification to specific user by user ID
     *
     * Usage example:
     * $notificationService = app(NotificationService::class);
     * $success = $notificationService->sendToUserByUserId(
     *     '123e4567-e89b-12d3-a456-426614174000', // UUID user ID
     *     'Password Reset Request',
     *     'Click here to reset your password: https://example.com/reset',
     *     'password_reset',
     *     ['reset_token' => 'abc123xyz']
     * );
     *
     * @param string $userId UUID of the user to receive notification
     * @param string $title Notification title
     * @param string $message Notification message content
     * @param string $type Notification type (default: 'system_alert')
     * @param array $data Additional data for the notification (default: [])
     * @return bool True if notification was sent successfully, false otherwise
     */
    public function sendToUserByUserId($userId, $title, $message, $type = 'system_alert', $data = []): bool
    {
        try {
            // Find user by ID
            $user = User::find($userId);

            if (!$user) {
                Log::warning("User with ID {$userId} not found");
                return false;
            }

            // Check if user is active
            if (!$user->is_active) {
                Log::warning("User with ID {$userId} is not active");
                return false;
            }

            $notification = $this->createSystemNotification($user->id, $title, $message, $type, $data);

            if ($notification) {
                Log::info("Notification sent to user ID {$userId}");
                return true;
            }

            return false;
        } catch (\Exception $exception) {
            Log::error("Failed to send notification to user ID {$userId}: {$exception->getMessage()}");
            return false;
        }
    }
}
