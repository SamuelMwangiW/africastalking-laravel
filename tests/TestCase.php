<?php

namespace SamuelMwangiW\Africastalking\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SamuelMwangiW\Africastalking\AfricastalkingServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            AfricastalkingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('africastalking.from-backup', $_ENV['AFRICASTALKING_BACKUP_SENDERID'] ?? null);
    }
}
