<?php

Route::post('/google/server/notifications', "\Appvise\GooglePlayNotifications\WebhooksController")->name('google.server.notifications');
