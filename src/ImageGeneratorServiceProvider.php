<?php

namespace FreshbitsWeb\ImageGenerator;

use FreshbitsWeb\ImageGenerator\Commands\ImageGeneratorCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ImageGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('image-generator-for-laravel')
            ->hasConfigFile('image-generator')
            ->hasViews()
            ->hasCommand(ImageGeneratorCommand::class);
    }
}
