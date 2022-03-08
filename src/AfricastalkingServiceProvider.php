<?php

namespace SamuelMwangiW\Africastalking;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SamuelMwangiW\Africastalking\Commands\AfricastalkingCommand;

class AfricastalkingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('africastalking-laravel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_africastalking-laravel_table')
            ->hasCommand(AfricastalkingCommand::class);
    }
}
