<?php

namespace Appvise\GooglePlayNotifications\Exceptions;

use Exception;

class WebhookFailed extends Exception
{
    public static function jobClassDoesNotExist(string $jobClass)
    {
        return new static("Could not process webhook because the configured job `$jobClass` does not exist.", 501);
    }

    public function render($request)
    {
        return response(['error' => $this->getMessage()], 400);
    }
}
