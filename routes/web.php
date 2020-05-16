<?php


\Route::post('webhook', [\HelloOne\Laravel\Webhooks\WebhookController::class, 'webhook'])->name('hello-one.webhook');
