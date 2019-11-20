<?php

namespace Appvise\GooglePlayNotifications;

use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/google-server-notifications.php' => config_path('google-server-notifications.php'),
            ], 'config');
        }

        if (! class_exists('CreateGoogleNotificationsTable')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/../database/migrations/create_google_notifications_table.php.stub' => database_path("migrations/{$timestamp}_create_google_notifications_table.php"),
            ], 'migrations');
        }

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/google-server-notifications.php', 'google-server-notifications');
    }
}
