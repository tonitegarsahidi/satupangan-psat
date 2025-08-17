<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageThread extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'message_threads';

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'initiator_id',
        'participant_id',
        'is_read_by_initiator',
        'is_read_by_participant',
        'last_message_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_read_by_initiator' => 'boolean',
        'is_read_by_participant' => 'boolean',
        'last_message_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the initiator of the thread.
     */
    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    /**
     * Get the participant of the thread.
     */
    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    /**
     * Get all messages in this thread.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'thread_id')->orderBy('created_at', 'asc');
    }

    /**
     * Get the last message in this thread.
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'thread_id')->latestOfMany();
    }

    /**
     * Get the unread messages count for the given user.
     */
    public function getUnreadCountForUser($userId)
    {
        if ($this->initiator_id === $userId) {
            return $this->messages()->where('sender_id', '!=', $userId)->whereNull('read_at')->count();
        } else {
            return $this->messages()->where('sender_id', '!=', $userId)->whereNull('read_at')->count();
        }
    }

    /**
     * Mark thread as read for the given user.
     */
    public function markAsReadForUser($userId)
    {
        if ($this->initiator_id === $userId) {
            $this->update(['is_read_by_initiator' => true]);
        } else {
            $this->update(['is_read_by_participant' => true]);
        }
    }

    /**
     * Check if thread is read by the given user.
     */
    public function isReadByUser($userId)
    {
        return $this->initiator_id === $userId
            ? $this->is_read_by_initiator
            : $this->is_read_by_participant;
    }

    /**
     * Scope a query to only include threads for a given user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('initiator_id', $userId)
              ->orWhere('participant_id', $userId);
        });
    }

    /**
     * Scope a query to only include unread threads for a given user.
     */
    public function scopeUnreadForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('initiator_id', $userId)
              ->where('is_read_by_initiator', false)
              ->orWhere('participant_id', $userId)
              ->where('is_read_by_participant', false);
        });
    }

    /**
     * Update last message timestamp.
     */
    public function updateLastMessageAt()
    {
        $this->update(['last_message_at' => now()]);
    }
}
