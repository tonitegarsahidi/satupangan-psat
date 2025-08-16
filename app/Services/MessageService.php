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
        DB::beginTransaction();
        try {
            // Ensure thread belongs to the user
            $thread = $this->messageRepository->getMessageThreadById($data['thread_id']);
            if (!$thread || ($thread->initiator_id !== $userId && $thread->participant_id !== $userId)) {
                throw new \Exception("Message thread not found or access denied");
            }

            // Add sender_id to data
            $data['sender_id'] = $userId;

            $message = $this->messageRepository->createMessage($data);

            // Update thread's last message timestamp
            if ($message) {
                $this->messageRepository->updateThreadLastMessage($data['thread_id']);

                // Mark thread as unread for the other participant
                $otherUserId = ($thread->initiator_id === $userId) ? $thread->participant_id : $thread->initiator_id;
                $this->messageRepository->markThreadAsRead($data['thread_id'], $userId);
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
}
