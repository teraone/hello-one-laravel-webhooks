<?php

namespace HelloOne\Laravel\Webhooks\Tests;


use HelloOne\Laravel\Webhooks\WebhookServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase {

    public function setUp(): void {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders( $app ) {
        return [
            WebhookServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp( $app ) {
        // perform environment setup
    }
}
