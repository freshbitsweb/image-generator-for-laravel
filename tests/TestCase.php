<?php

namespace FreshbitsWeb\ImageGenerator\Tests;

use FreshbitsWeb\ImageGenerator\ImageGeneratorServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->useStoragePath(__DIR__.'/storage');

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'FreshbitsWeb\\ImageGenerator\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ImageGeneratorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
