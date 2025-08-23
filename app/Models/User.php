<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Jobs\SendEmailVerifyEmailJob;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanTindakanPic;
use App\Models\RoleMaster;
use App\Models\Business;
use App\Models\Petugas;
use App\Models\UserProfile;
use App\Models\MessageThread;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasUuids;

    protected $table = 'users';


	public $sortable = ['id', 'name', 'email','phone_number', 'status'];

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles' => 'array',
    ];

    public function roles()
    {
        return $this->belongsToMany(RoleMaster::class, 'role_user', 'user_id', 'role_id');
    }

    public function hasRole($roleCode)
    {
        return $this->roles()->where('role_code', $roleCode)->exists();
    }

    public function hasAnyRole($roleCodes)
    {
        return $this->roles()->whereIn('role_code', $roleCodes)->exists();
    }

    public function printRoles()
    {
        return $this->roles()->pluck('role_name')->implode(', ');
    }

    // Define the one-to-one relationship with UserProfile
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    // Define the one-to-one relationship with Petugas
    public function petugas()
    {
        return $this->hasOne(Petugas::class);
    }

    // Define the one-to-one relationship with Business
    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function listRoles()
    {
        return $this->roles()->pluck('role_name');
    }

    public function sendEmailVerificationNotification()
    {
        SendEmailVerifyEmailJob::dispatch($this);
    }

    // Notification relationships

    /**
     * Get all notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    /**
     * Get unread notifications for the user.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    /**
     * Get read notifications for the user.
     */
    public function readNotifications()
    {
        return $this->notifications()->where('is_read', true);
    }

    // Message relationships

    /**
     * Get all message threads initiated by the user.
     */
    public function initiatedMessageThreads()
    {
        return $this->hasMany(\App\Models\MessageThread::class, 'initiator_id');
    }

    /**
     * Get all message threads where the user is a participant.
     */
    public function participatedMessageThreads()
    {
        return $this->hasMany(\App\Models\MessageThread::class, 'participant_id');
    }

    /**
     * Get all message threads for the user (both initiated and participated).
     */
    public function messageThreads()
    {
        return $this->initiatedMessageThreads()->union($this->participatedMessageThreads());
    }

    /**
     * Get all messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'sender_id');
    }

    /**
     * Get unread message threads for the user.
     */
    public function unreadMessageThreads()
    {
        return $this->messageThreads()
            ->where(function ($query) {
                $query->where('initiator_id', $this->id)
                    ->where('is_read_by_initiator', false)
                    ->orWhere('participant_id', $this->id)
                    ->where('is_read_by_participant', false);
            });
    }
    /**
     * Get all pengawasan tindakan PIC assignments for this user
     */
    public function picTindakans()
    {
        return $this->hasMany(PengawasanTindakanPic::class, 'pic_id');
    }

    /**
     * Get all pengawasan tindakan lanjutan assignments for this user as PIC
     */
    public function tindakanLanjutans()
    {
        return $this->hasMany(PengawasanTindakanLanjutan::class, 'user_id_pic');
    }
}
