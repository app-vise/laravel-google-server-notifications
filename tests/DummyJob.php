<?php

namespace Appvise\GooglePlayNotifications\Tests;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DummyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notification;

    public function __construct(array $notification)
    {
        $this->notification = $notification;
    }

    public function handle()
    {
    }
}
