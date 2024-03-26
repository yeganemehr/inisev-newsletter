<?php

use Illuminate\Support\Facades\Route;
use Inisev\Newsletter\Http\Controllers\PostController;
use Inisev\Newsletter\Http\Controllers\SubscriberController;
use Inisev\Newsletter\Http\Controllers\WebsiteController;

Route::apiResources([
    'websites' => WebsiteController::class,
    'websites.posts' => PostController::class,
    'websites.subscribers' => SubscriberController::class,
]);
