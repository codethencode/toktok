<?php
// app/Notifications/TestPushover.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Pushover\PushoverMessage;

class TestPushover extends Notification
{
    public function via($notifiable)
    {
        return ['pushover'];
    }

    public function toPushover($notifiable)
    {
        return PushoverMessage::create('🎉 Notification test bien reçue !')
            ->title('ToqueToque.net')
            ->priority(1)
            ->sound('magic'); // sons disponibles : pushover.net/api#sounds
    }
}