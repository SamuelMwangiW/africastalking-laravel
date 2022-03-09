<?php

namespace SamuelMwangiW\Africastalking;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AfricastalkingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('africastalking-laravel')
            ->hasConfigFile();
    }
}
