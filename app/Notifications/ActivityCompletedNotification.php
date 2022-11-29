<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityCompletedNotification extends Notification
{
    use Queueable;

    public $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'activity' => $this->activity
        ];
    }
}
