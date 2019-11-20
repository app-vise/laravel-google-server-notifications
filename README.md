# Handle Google Play server-to-server notifications for subscriptions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tag/app-vise/laravel-google-server-notifications.svg?style=flat-square&sort=semver)](https://packagist.org/packages/app-vise/laravel-google-server-notifications)
[![Build Status](https://travis-ci.org/app-vise/laravel-google-server-notifications.svg?branch=master)](https://travis-ci.org/app-vise/laravel-google-server-notifications)
[![StyleCI](https://styleci.io/repos/222896444/shield?branch=master)](https://styleci.io/repos/222896444)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/app-vise/laravel-google-server-notifications/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/app-vise/laravel-google-server-notifications/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/app-vise/laravel-google-server-notifications.svg?style=flat-square)](https://packagist.org/packages/app-vise/laravel-google-server-notifications)

## Installation
You can install this package via composer

```bash
composer require app-vise/google-server-notifications 
 ```

The service provider will register itself.
You have to publish the config file with:

```bash
php artisan vendor:publish --provider="Appvise\GooglePlayNotifications\NotificationsServiceProvider" --tag="config" 
 ```
This is the config that will be published.
```php
return [
    /*
     * All the events that should be handeled by your application.
     * Typically you should uncomment all jobs
     *
     * You can find a list of all notification types here:
     * https://developer.android.com/google/play/billing/realtime_developer_notifications
     */
    'jobs' => [
        // 'subscription_recovered' => \App\Jobs\PlayStore\HandleRecovered::class,
        // 'subscription_renewed' => \App\Jobs\PlayStore\HandleRenewed::class,
        // 'subscription_canceled' =>  \App\Jobs\PlayStore\HandleCanceled::class,
        // 'subscrip￼￼tion_purchased' => \App\Jobs\PlayStore\HandlePurchased::class,
        // 'subscription_on_hold' => \App\Jobs\PlayStore\HandleOnHold::class,
        // 'subscription_in_grace_period' => \App\Jobs\PlayStore\HandleInGracePeriod::class,
        // 'subscription_restarted' => \App\Jobs\PlayStore\HandleRestarted::class,
        // 'subscription_price_change_confirmed' => \App\Jobs\PlayStore\HandlePriceChangeConfirmed::class,
        // 'subscription_deferred' => \App\Jobs\PlayStore\HandleDeferred::class,
        // 'subscription_paused' => \App\Jobs\PlayStore\HandlePaused::class,
        // 'subscription_pause_schedule_changed' => \App\Jobs\PlayStore\HandlePauseScheduleChanged::class,
        // 'subscription_revoked' => \App\Jobs\PlayStore\HandleRevoked::class,
        // 'subscription_expired' => \App\Jobs\PlayStore\HandleExpired::class
    ],
];
```

This package logs all the incoming requests to the database so these steps are mandatory:

```bash
php artisan vendor:publish --provider="Appvise\GooglePlayNotifications\NotificationsServiceProvider" --tag="migrations"
```

You should run migrate next to create the google_notifications table:

```bash
php artisan migrate
```

This packages registers a POST route (/google/server/notifications) to the Webhookscontroller of this package

## Usage
When there is an change in one of the subscriptions Google will send a realtime notification via POST request to a configured endpoint.
[Follow this guide to setup Pub/Sub:](https://developer.android.com/google/play/billing/realtime_developer_notifications.html)

This package will send a 200 response if you configured the right Job for the right Notification Type otherwise it will send a 500 back to Google.
Google will retry a couple of times more. The incoming payload is stored in the google_notifications table.

### Handling incoming notifications via Jobs
```php
<?php

namespace App\Jobs\GooglePlayNotifications;

use App\Jobs\Job;

class HandleRecovered extends Job
{
    public $notification;

    public function __construct(array $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Do something that matches your business logic with $this->payload
    }
}
```

## Changelog

Please see CHANGELOG for more information about what has changed recently.

## Testing

```bash
composer test
```

## Security

If you discover any security related issues, please email daan@app-vise.nl instead of using the issue tracker.

## Credits

- [Daan Geurts](https://github.com/DaanGeurts)
- [All Contributors](../../contributors)

A big thanks to [Spatie's](https://spatie.be) laravel-stripe-webhooks which was a huge inspiration and starting point for this package
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
