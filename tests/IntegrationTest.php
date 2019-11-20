<?php

namespace Appvise\GooglePlayNotifications\Tests;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Route;
use Appvise\GooglePlayNotifications\Model\GoogleNotification;

class IntegrationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Queue::fake();

        Route::post('/google/server/notifications', "\Appvise\GooglePlayNotifications\WebhooksController");

        config(
            [
                'google-server-notifications.jobs' => [
                    'subscription_recovered' => DummyJob::class,
                ],
            ]
        );
    }

    /** @test */
    public function it_can_handle_a_valid_request()
    {
        $this->withExceptionHandling();
        $payload = include_once __DIR__.'/__fixtures__/request.php';

        $this
            ->postJson('/google/server/notifications', $payload)
            ->assertSuccessful();

        $this->assertCount(1, GoogleNotification::get());

        $notification = GoogleNotification::first();

        $this->assertEquals('subscription_recovered', $notification->type);
        $this->assertInstanceOf(GoogleNotification::class, $notification);

        Queue::assertPushed(DummyJob::class);
    }

    /** @test */
    public function a_request_with_an_invalid_payload_will_be_logged_but_jobs_will_not_be_dispatched()
    {
        $notification = ['payload' => 'INVALID'];

        $this
            ->postJson('/google/server/notifications', $notification)
            ->assertStatus(500);

        Queue::assertNotPushed(DummyJob::class);
    }
}
