<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class EarlyWarningNotification extends Notification
{
    protected $earlyWarningId;
    protected $title;
    protected $message;

    public function __construct($earlyWarningId, $title, $message)
    {
        $this->earlyWarningId = $earlyWarningId;
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'EARLY_WARNING',
            'title' => $this->title,
            'message' => $this->message,
            'is_read' => false,
            'data' => [
                'earlyWarningId' => $this->earlyWarningId
            ]
        ];
    }
}
