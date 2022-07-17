<?php

namespace SamuelMwangiW\Africastalking;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
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
            'sdk Version' => InstalledVersions::getPrettyVersion('samuelmwangiw/africastalking-laravel'),
            'username' => config('africastalking.username'),
            'SenderID' => config('africastalking.from'),
            'API Key' => config('africastalking.api-key'),
            'Voice Phone #' => config('africastalking.voice.from')
        ]);
    }
}
