<?php

namespace App\Services;

use App\Models\Message;
use App\Models\MessageThread;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\MessageRepository;

class MessageService
{
    private $messageRepository;

    /**
     * Constructor
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * List all message threads for a user with filtering and pagination
     */
    public function listUserMessageThreads(
        $userId,
        int $limit = 10, // Renamed from perPage to limit
        string $sortField = null,
        string $sortOrder = null,
        string $keyword = null,
        bool $unreadOnly = false
    ): LengthAwarePaginator {
        return $this->messageRepository->getUserMessageThreads(
            $userId, $limit, $sortField, $sortOrder, $keyword, $unreadOnly
        );
    }

    /**
     * Get a single message thread detail
     */
    public function getMessageThreadDetail($threadId, $userId): ?MessageThread
    {
        $thread = $this->messageRepository->getMessageThreadById($threadId);

        // Ensure thread belongs to the user
        if ($thread && ($thread->initiator_id === $userId || $thread->participant_id === $userId)) {
            return $thread;
        }

        return null;
    }

    /**
     * Create a new message thread
     */
    public function createMessageThread(array $data): ?MessageThread
    {
        DB::beginTransaction();
        try {
            $thread = $this->messageRepository->createMessageThread($data);

            // Mark thread as read for the initiator
            if ($thread) {
                $this->messageRepository->markThreadAsRead($thread->id, $thread->initiator_id);
            }

            DB::commit();
            return $thread;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to create message thread: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Update a message thread
     */
    public function updateMessageThread(array $data, $threadId, $userId): ?MessageThread
    {
        DB::beginTransaction();
        try {
            // Ensure thread belongs to the user
            $thread = $this->messageRepository->getMessageThreadById($threadId);
            if (!$thread || ($thread->initiator_id !== $userId && $thread->participant_id !== $userId)) {
                throw new \Exception("Message thread not found or access denied");
            }

            $updatedThread = $this->messageRepository->updateMessageThread($threadId, $data);
            DB::commit();
            return $updatedThread;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update message thread: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Delete a message thread
     */
    public function deleteMessageThread($threadId, $userId): bool
    {
        DB::beginTransaction();
        try {
            // Ensure thread belongs to the user
            $thread = $this->messageRepository->getMessageThreadById($threadId);
            if (!$thread || ($thread->initiator_id !== $userId && $thread->participant_id !== $userId)) {
                throw new \Exception("Message thread not found or access denied");
            }

            $result = $this->messageRepository->deleteMessageThread($threadId);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete message thread: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Get messages in a thread with pagination
     */
    public function getThreadMessages(
        $threadId,
        int $perPage = 20,
        string $sortField = null,
        string $sortOrder = null,
        $userId = null
    ): LengthAwarePaginator {
        $thread = $this->messageRepository->getMessageThreadById($threadId);

        // Optional: Ensure thread belongs to the user if userId is provided
        if ($userId && (!$thread || ($thread->initiator_id !== $userId && $thread->participant_id !== $userId))) {
            throw new \Exception("Message thread not found or access denied");
        }

        return $this->messageRepository->getThreadMessages($threadId, $perPage, $sortField, $sortOrder);
    }

    /**
     * Get a single message detail
     */
    public function getMessageDetail($messageId, $userId): ?Message
    {
        $message = $this->messageRepository->getMessageById($messageId);

        // Ensure message belongs to a thread that the user is part of
        if ($message) {
            $thread = $this->messageRepository->getMessageThreadById($message->thread_id);
            if ($thread && ($thread->initiator_id === $userId || $thread->participant_id === $userId)) {
                return $message;
            }
        }

        return null;
    }

    /**
     * Send a new message in a thread
     */
    public function sendMessage(array $data, $userId): ?Message
    {
        // DEBUG: Log message service call
        Log::info("MessageService::sendMessage - Thread ID: " . ($data['thread_id'] ?? 'null') . ", User ID: {$userId}");

        DB::beginTransaction();
        try {
            // Ensure thread belongs to the user
            $thread = $this->messageRepository->getMessageThreadById($data['thread_id']);
            if (!$thread || ($thread->initiator_id !== $userId && $thread->participant_id !== $userId)) {
                throw new \Exception("Message thread not found or access denied");
            }

            // Add sender_id to data
            $data['sender_id'] = $userId;

            // DEBUG: Log data being saved
            Log::info("MessageService::sendMessage - About to save message: " . json_encode($data));

            $message = $this->messageRepository->createMessage($data);

            // DEBUG: Log message creation result
            Log::info("MessageService::sendMessage - Message created: " . ($message ? 'Yes (ID: ' . $message->id . ')' : 'No'));

            // Update thread's last message timestamp
            if ($message) {
                $this->messageRepository->updateThreadLastMessage($data['thread_id']);

                // Mark current user's messages as read (they just sent it)
                $this->messageRepository->markThreadAsRead($data['thread_id'], $userId);

                // Mark thread as UNREAD for the other participant (recipient)
                $otherUserId = ($thread->initiator_id === $userId) ? $thread->participant_id : $thread->initiator_id;
                $this->messageRepository->markThreadAsUnreadForUser($data['thread_id'], $otherUserId);
            }

            DB::commit();
            return $message;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to send message: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Update a message
     */
    public function updateMessage(array $data, $messageId, $userId): ?Message
    {
        DB::beginTransaction();
        try {
            $message = $this->messageRepository->getMessageById($messageId);

            // Ensure message exists and belongs to the user
            if (!$message || $message->sender_id !== $userId) {
                throw new \Exception("Message not found or access denied");
            }

            // Mark as edited if content changed
            if (isset($data['message']) && $data['message'] !== $message->message) {
                $data['is_edited'] = true;
                $data['edited_at'] = now();
            }

            $updatedMessage = $this->messageRepository->updateMessage($messageId, $data);
            DB::commit();
            return $updatedMessage;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update message: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Delete a message
     */
    public function deleteMessage($messageId, $userId): bool
    {
        DB::beginTransaction();
        try {
            $message = $this->messageRepository->getMessageById($messageId);

            // Ensure message exists and belongs to the user
            if (!$message || $message->sender_id !== $userId) {
                throw new \Exception("Message not found or access denied");
            }

            $result = $this->messageRepository->deleteMessage($messageId);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete message: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Mark thread as read for a user
     */
    public function markThreadAsRead($threadId, $userId): bool
    {
        try {
            // Ensure thread belongs to the user
            $thread = $this->messageRepository->getMessageThreadById($threadId);
            if (!$thread || ($thread->initiator_id !== $userId && $thread->participant_id !== $userId)) {
                throw new \Exception("Message thread not found or access denied");
            }

            return $this->messageRepository->markMessagesAsReadForUserInThread($threadId, $userId);
        } catch (\Exception $exception) {
            Log::error("Failed to mark thread as read: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * Get unread message threads count for a user
     */
    public function getUnreadThreadCount($userId): int
    {
        return $this->messageRepository->getUnreadThreadCount($userId);
    }

    /**
     * Get messages sent by a user
     */
    public function getUserMessages(
        $userId,
        int $perPage = 20,
        string $sortField = null,
        string $sortOrder = null
    ): LengthAwarePaginator {
        return $this->messageRepository->getMessagesByUser($userId, $perPage, $sortField, $sortOrder);
    }

    /**
     * Get conversation between two users
     */
    public function getConversationBetweenUsers($user1Id, $user2Id, int $perPage = 20): LengthAwarePaginator
    {
        return $this->messageRepository->getConversationBetweenUsers($user1Id, $user2Id, $perPage);
    }

    /**
     * Create a new thread with the first message
     */
    public function createThreadWithMessage(array $threadData, array $messageData, $userId): ?MessageThread
    {
        DB::beginTransaction();
        try {
            // Add initiator_id to thread data
            $threadData['initiator_id'] = $userId;

            $thread = $this->createMessageThread($threadData);

            if ($thread) {
                // Add thread_id to message data
                $messageData['thread_id'] = $thread->id;
                $message = $this->sendMessage($messageData, $userId);

                if ($message) {
                    DB::commit();
                    return $thread;
                }
            }

            DB::rollBack();
            return null;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to create thread with message: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Get message thread statistics for a user
     */
    public function getMessageThreadStats($userId): array
    {
        $total = MessageThread::where(function ($query) use ($userId) {
            $query->where('initiator_id', $userId)
                ->orWhere('participant_id', $userId);
        })->count();

        $unread = $this->getUnreadThreadCount($userId);
        $read = $total - $unread;

        return [
            'total' => $total,
            'unread' => $unread,
            'read' => $read,
        ];
    }

    /**
     * Send a message to a specific user by email
     *
     * Usage example:
     * $messageService = app(MessageService::class);
     * $thread = $messageService->sendToUserByEmail(
     *     'admin@example.com',
     *     'user@example.com',
     *     'Support Request',
     *     'I need help with my account settings.',
     *     'support_request',
     *     $initiatorUserId
     * );
     *
     * @param string $recipientEmail Email of the recipient
     * @param string $subject Thread title
     * @param string $message Content of the first message
     * @param string $initiatorId UUID of the user initiating the conversation
     * @return MessageThread|null The created thread or null if failed
     */
    public function sendToUserByEmail($recipientEmail, $subject, $message, $initiatorId)
    {
        try {
            // Find recipient by email
            $recipient = User::where('email', $recipientEmail)->first();

            if (!$recipient) {
                Log::warning("User with email {$recipientEmail} not found");
                return null;
            }

            // Check if recipient is active
            if (!$recipient->is_active) {
                Log::warning("User with email {$recipientEmail} is not active");
                return null;
            }

            // Create thread data
            $threadData = [
                'title' => $subject,
                'description' => 'Private message',
                'initiator_id' => $initiatorId,
                'participant_id' => $recipient->id,
            ];

            // Create message data
            $messageData = [
                'message' => $message,
            ];

            // Create thread with message
            return $this->createThreadWithMessage($threadData, $messageData, $initiatorId);
        } catch (\Exception $exception) {
            Log::error("Failed to send message to user {$recipientEmail}: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Send a message to a specific user by user ID
     *
     * Usage example:
     * $messageService = app(MessageService::class);
     * $thread = $messageService->sendToUserByUserId(
     *     'recipient-user-id-123',
     *     'Important Update',
     *   'Please review the new policies.',
     *   'policy_update',
     *   $initiatorUserId
     * );
     *
     * @param string $recipientId UUID of the recipient user
     * @param string $subject Thread title
     * @param string $message Content of the first message
     * @param string $initiatorId UUID of the user initiating the conversation
     * @return MessageThread|null The created thread or null if failed
     */
    public function sendToUserByUserId($recipientId, $subject, $message, $initiatorId)
    {
        try {
            // Find recipient by ID
            $recipient = User::find($recipientId);

            if (!$recipient) {
                Log::warning("User with ID {$recipientId} not found");
                return null;
            }

            // Check if recipient is active
            if (!$recipient->is_active) {
                Log::warning("User with ID {$recipientId} is not active");
                return null;
            }

            // Create thread data
            $threadData = [
                'title' => $subject,
                'description' => 'Private message',
                'initiator_id' => $initiatorId,
                'participant_id' => $recipientId,
            ];

            // Create message data
            $messageData = [
                'message' => $message,
            ];

            // Create thread with message
            return $this->createThreadWithMessage($threadData, $messageData, $initiatorId);
        } catch (\Exception $exception) {
            Log::error("Failed to send message to user ID {$recipientId}: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Send a message to all users with specific roles
     *
     * Usage example:
     * $messageService = app(MessageService::class);
     * $threads = $messageService->sendToUsersByRoles(
     *     ['ROLE_OPERATOR', 'ROLE_SUPERVISOR'],
     *     'System Maintenance',
     *     'The system will undergo maintenance tonight.',
     *     'maintenance_announcement',
     *     $initiatorUserId
     * );
     *
     * @param array $roleCodes Array of role codes to target
     * @param string $subject Thread title
     * @param string $message Content of the first message
     * @param string $initiatorId UUID of the user initiating the conversation
     * @return array Array of created MessageThread objects
     */
    public function sendToUsersByRoles(array $roleCodes, $subject, $message, $initiatorId)
    {
        $createdThreads = [];

        try {
            // Get active users with specified roles
            $recipients = User::where('is_active', true)
                ->whereHas('roles', function ($query) use ($roleCodes) {
                    $query->whereIn('role_code', $roleCodes);
                })
                ->get();

            if ($recipients->isEmpty()) {
                Log::warning("No active users found with roles: " . implode(', ', $roleCodes));
                return [];
            }

            // Create a thread for each recipient
            foreach ($recipients as $recipient) {
                $thread = $this->sendToUserByUserId(
                    $recipient->id,
                    $subject,
                    $message,
                    $initiatorId
                );

                if ($thread) {
                    $createdThreads[] = $thread;
                }
            }

            Log::info("Created " . count($createdThreads) . " message threads for roles: " . implode(', ', $roleCodes));
            return $createdThreads;
        } catch (\Exception $exception) {
            Log::error("Failed to send messages to users with roles: {$exception->getMessage()}");
            return [];
        }
    }

    /**
     * Send a broadcast message to all active users
     *
     * Usage example:
     * $messageService = app(MessageService::class);
     * $threads = $messageService->sendToAllUsers(
     *     'Happy Holidays',
     *     'Wishing you a wonderful holiday season!',
     *     'holiday_greeting',
     *     $initiatorUserId
     * );
     *
     * @param string $subject Thread title
     * @param string $message Content of the first message
     * @param string $initiatorId UUID of the user initiating the conversation
     * @return array Array of created MessageThread objects
     */
    public function sendToAllUsers($subject, $message, $initiatorId)
    {
        $createdThreads = [];

        try {
            // Get all active users
            $recipients = User::where('is_active', true)->get();

            if ($recipients->isEmpty()) {
                Log::warning("No active users found");
                return [];
            }

            // Create a thread for each recipient
            foreach ($recipients as $recipient) {
                // Skip the initiator to avoid sending to themselves
                if ($recipient->id === $initiatorId) {
                    continue;
                }

                $thread = $this->sendToUserByUserId(
                    $recipient->id,
                    $subject,
                    $message,
                    $initiatorId
                );

                if ($thread) {
                    $createdThreads[] = $thread;
                }
            }

            Log::info("Created " . count($createdThreads) . " broadcast message threads");
            return $createdThreads;
        } catch (\Exception $exception) {
            Log::error("Failed to send broadcast messages: {$exception->getMessage()}");
            return [];
        }
    }
}
