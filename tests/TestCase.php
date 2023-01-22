<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Laravel\SaloonServiceProvider;
use SamuelMwangiW\Africastalking\AfricastalkingServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            AfricastalkingServiceProvider::class,
            SaloonServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('africastalking.from-backup', $_ENV['AFRICASTALKING_BACKUP_SENDERID'] ?? null);
        config()->set('africastalking.premium-shortcode', $_ENV['AFRICASTALKING_PREMIUM_SHORTCODE'] ?? '9804');
    }
}
