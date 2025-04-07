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

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-tabler-icons', []);

            $factory->add('tabler', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

        $this->app->singleton(IconsManifest::class, function () {
            return new IconsManifest(
                new Filesystem(),
                base_path('bootstrap/cache/icons-manifest.php')
            );
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-tabler-icons.php', 'blade-tabler-icons');
    }

    public function boot(): void
    {

        $this->app->make(Factory::class)->add('tabler', [
            'path'   => __DIR__.'/../resources/svg',
            'prefix' => 'tabler',
        ]);


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
