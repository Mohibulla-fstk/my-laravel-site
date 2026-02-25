<?php

use App\Models\Notification;

if (!function_exists('notify')) {
    function notify($userId, $title, $message, $type = null, $url = null)
    {
        Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'url'     => $url,
        ]);
    }
}
