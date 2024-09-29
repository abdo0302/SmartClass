<?php

namespace App\Services;

use Ably\AblyRest;

class AblyNotificationService
{
    protected $ably;

    public function __construct()
    {
        $this->ably = new AblyRest(config('services.ably.key'));
    }

    public function sendNotification($channelName, $message)
    {
        $channel = $this->ably->channel($channelName);
        $channel->publish('notification', $message);
    }
}
