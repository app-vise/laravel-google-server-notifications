<?php

namespace Appvise\GooglePlayNotifications;

use Appvise\GooglePlayNotifications\Exceptions\WebhookFailed;
use Appvise\GooglePlayNotifications\Model\GoogleNotification;
use Appvise\GooglePlayNotifications\Model\NotificationType;
use Illuminate\Http\Request;

class WebhooksController
{
    public function __invoke(Request $request)
    {
        $notificationData = json_decode(base64_decode($request->json('message.data')), true);
        $notificationType = $notificationData['subscriptionNotification']['notificationType'];

        $jobConfigKey = NotificationType::JOBS[$notificationType];
        $jobClass = config("google-server-notifications.jobs.{$jobConfigKey}", null);

        GoogleNotification::storeNotification($jobConfigKey, $request->input());

        if (is_null($jobClass)) {
            throw new WebhookFailed('Job class does not exist');
        }

        $job = new $jobClass($request->input());
        dispatch($job);

        return response()->json();
    }
}
