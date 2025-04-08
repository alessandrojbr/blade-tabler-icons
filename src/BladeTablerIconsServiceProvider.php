<?php

declare(strict_types=1);

namespace secondnetwork\TablerIcons;

use BladeUI\Icons\Factory;
use BladeUI\Icons\IconsManifest;
use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

final class BladeTablerIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    public function boot(): void
    {
        $this->bootIcons();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-tabler-icons.php', 'blade-tabler-icons');
    }

    private function bootIcons(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('tabler', [
                'path' => __DIR__.'/../resources/svg',
                'prefix' => 'tabler',
            ]);
        });

        $this->app->singleton(IconsManifest::class, function () {
            return new IconsManifest(
                new Filesystem(),
                base_path('bootstrap/cache/icons-manifest.php')
            );
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-tabler-icons'),
            ], 'blade-tabler-icons');

            $this->publishes([
                __DIR__.'/../config/blade-tabler-icons.php' => $this->app->configPath('blade-tabler-icons.php'),
            ], 'blade-tabler-icons-config');
        }
    }
}
