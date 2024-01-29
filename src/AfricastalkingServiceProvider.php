<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking;

use Composer\InstalledVersions;
use Exception;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\App;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AfricastalkingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('africastalking')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        AboutCommand::add('Africastalking', [
            'SDK Version' => fn() => InstalledVersions::getPrettyVersion('samuelmwangiw/africastalking-laravel'),
            'Username' => config('africastalking.username'),
            'SenderID' => config('africastalking.sms.from', 'AFRICASTKNG'),
            'Voice Phone #' => config('africastalking.voice.from'),
            'Payment Product' => config('africastalking.payment.product-name'),
            'App Balance' => function () {
                try {
                    $balance = africastalking()->app()->balance();

                    return $balance->currency->value.' '.number_format($balance->amount);
                } catch (Exception) {
                    return '<fg=red>FAILED</>';
                }
            },
            'Payments Product Balance' => function () {
                if ( ! config('africastalking.payment.product-name')) {
                    return '<fg=yellow>Not setup</>';
                }

                try {
                    $balance = africastalking()->wallet()->balance();

                    return $balance->currency->value.' '.number_format($balance->amount);
                } catch (Exception) {
                    return '<fg=red>FAILED</>';
                }
            },
        ]);

        if ( ! App::runningUnitTests()) {
            $this->app->singleton(
                abstract: AfricastalkingConnector::class,
                concrete: fn() => new AfricastalkingConnector(),
            );

            config()->set('saloon.integrations_path','vendor/samuelmwangiw/africastalking-laravel/src/Saloon');
        }
    }
}
