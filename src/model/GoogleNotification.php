<?php

namespace Appvise\GooglePlayNotifications\Model;

use Illuminate\Database\Eloquent\Model;

class GoogleNotification extends Model
{
    public $guarded = [];

    protected $casts = [
        'payload' => 'array',
    ];

    public static function storeNotification(string $notificationType, array $notificationPayload)
    {
        return self::create(
            [
            'type' => $notificationType,
            'payload' => $notificationPayload,
            ]
        );
    }
}
