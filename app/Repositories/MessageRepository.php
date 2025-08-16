<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\MessageThread;
use App\Models\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class MessageRepository
{
    /**
     * Get all message threads for a user with pagination
     */
    public function getUserMessageThreads(
        $userId,
        int $limit = 10, // Renamed from perPage to limit
        string $sortField = null,
        string $sortOrder = null,
        string $keyword = null,
        bool $unreadOnly = false
    ): LengthAwarePaginator {
        $queryResult = MessageThread::where(function ($query) use ($userId) {
            $query->where('initiator_id', $userId)
                ->orWhere('participant_id', $userId);
        });

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("last_message_at", "desc");
        }

        if ($unreadOnly) {
            $queryResult->where(function ($query) use ($userId) {
                $query->where('initiator_id', $userId)
                    ->where('is_read_by_initiator', false)
                    ->orWhere('participant_id', $userId)
                    ->where('is_read_by_participant', false);
            });
        }

        if (!is_null($keyword)) {
            $queryResult->where(function ($query) use ($keyword) {
                $query->whereRaw('lower(title) LIKE ?', ['%' . strtolower($keyword) . '%'])
                    ->orWhereHas('messages', function ($q) use ($keyword) {
                        $q->whereRaw('lower(message) LIKE ?', ['%' . strtolower($keyword) . '%']);
                    });
            });
        }

        $paginator = $queryResult->with(['initiator', 'participant', 'lastMessage'])
            ->paginate($limit); // Use limit here
        $paginator->withQueryString();

        return $paginator;
    }

    /**
     * Get a single message thread by ID
     */
    public function getMessageThreadById($threadId): ?MessageThread
    {
        return MessageThread::with(['initiator', 'participant', 'messages.sender'])
            ->find($threadId);
    }

    /**
     * Create a new message thread
     */
    public function createMessageThread(array $data): MessageThread
    {
        return MessageThread::create($data);
    }

    /**
     * Update a message thread
     */
    public function updateMessageThread($threadId, array $data): ?MessageThread
    {
        try {
            $thread = MessageThread::findOrFail($threadId);
            $thread->update($data);
            return $thread;
        } catch (Exception $e) {
            Log::error("Failed to update message thread: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Delete a message thread
     */
    public function deleteMessageThread($threadId): bool
    {
        try {
            $thread = MessageThread::findOrFail($threadId);
            $thread->delete();
            return true;
        } catch (Exception $e) {
            Log::error("Failed to delete message thread: {$e->getMessage()}");
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
        string $sortOrder = null
    ): LengthAwarePaginator {
        $queryResult = Message::where('thread_id', $threadId);

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "asc");
        }

        $paginator = $queryResult->with('sender')
            ->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    /**
     * Get a single message by ID
     */
    public function getMessageById($messageId): ?Message
    {
        return Message::with('sender')->find($messageId);
    }

    /**
     * Create a new message
     */
    public function createMessage(array $data): Message
    {
        return Message::create($data);
    }

    /**
     * Update a message
     */
    public function updateMessage($messageId, array $data): ?Message
    {
        try {
            $message = Message::findOrFail($messageId);
            $message->update($data);
            return $message;
        } catch (Exception $e) {
            Log::error("Failed to update message: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Delete a message
     */
    public function deleteMessage($messageId): bool
    {
        try {
            $message = Message::findOrFail($messageId);
            $message->delete();
            return true;
        } catch (Exception $e) {
            Log::error("Failed to delete message: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Mark thread as read for a user
     */
    public function markThreadAsRead($threadId, $userId): bool
    {
        try {
            $thread = MessageThread::findOrFail($threadId);

            if ($thread->initiator_id === $userId) {
                $thread->update(['is_read_by_initiator' => true]);
            } else {
                $thread->update(['is_read_by_participant' => true]);
            }

            return true;
        } catch (Exception $e) {
            Log::error("Failed to mark thread as read: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Get unread message threads count for a user
     */
    public function getUnreadThreadCount($userId): int
    {
        return MessageThread::where(function ($query) use ($userId) {
            $query->where('initiator_id', $userId)
                ->where('is_read_by_initiator', false)
                ->orWhere('participant_id', $userId)
                ->where('is_read_by_participant', false);
        })->count();
    }

    /**
     * Get messages sent by a user
     */
    public function getMessagesByUser(
        $userId,
        int $perPage = 20,
        string $sortField = null,
        string $sortOrder = null
    ): LengthAwarePaginator {
        $queryResult = Message::where('sender_id', $userId);

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        $paginator = $queryResult->with(['thread.initiator', 'thread.participant'])
            ->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    /**
     * Get conversation between two users
     */
    public function getConversationBetweenUsers($user1Id, $user2Id, int $perPage = 20): LengthAwarePaginator
    {
        $threads = MessageThread::where(function ($query) use ($user1Id, $user2Id) {
            $query->where(function ($q) use ($user1Id, $user2Id) {
                $q->where('initiator_id', $user1Id)
                    ->where('participant_id', $user2Id);
            })->orWhere(function ($q) use ($user1Id, $user2Id) {
                $q->where('initiator_id', $user2Id)
                    ->where('participant_id', $user1Id);
            });
        })->get();

        $threadIds = $threads->pluck('id');

        return Message::whereIn('thread_id', $threadIds)
            ->orderBy('created_at', 'asc')
            ->paginate($perPage);
    }

    /**
     * Update last message timestamp for a thread
     */
    public function updateThreadLastMessage($threadId): bool
    {
        try {
            $thread = MessageThread::findOrFail($threadId);
            $thread->update(['last_message_at' => now()]);
            return true;
        } catch (Exception $e) {
            Log::error("Failed to update thread last message: {$e->getMessage()}");
            return false;
        }
    }
}
