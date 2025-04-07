<?php

namespace Tests;

use BladeUI\Icons\Factory;
use BladeUI\Icons\IconsManifest;
use Illuminate\Filesystem\Filesystem;
use Orchestra\Testbench\TestCase;
use secondnetwork\TablerIcons\BladeTablerIconsServiceProvider;

class CompilesIconsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            BladeTablerIconsServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(Factory::class)->add('tabler', [
          'path'   => __DIR__.'/../resources/svg',
          'prefix' => 'tabler',
        ]);

        $this->app->bind(IconsManifest::class, function () {
            return new IconsManifest(
                new Filesystem(),
                base_path('tests/stubs/icons-manifest.php')
            );
        });
    }

    /** @test */
    public function test_compiles_a_single_anonymous_component()
    {
        $result = svg('tabler-accessible')->toHtml();

        $expected = <<<'SVG'
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-accessible" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
          <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1" />
          <circle cx="12" cy="7.5" r=".5" fill="currentColor" />
        </svg>
        SVG;

        $this->assertSame(
            $this->normalizeSvg($expected),
            $this->normalizeSvg($result)
        );
    }

    /** @test */
    public function test_can_add_classes_to_icons()
    {
        $result = svg('tabler-accessible', 'w-6 h-6 text-gray-500')->toHtml();

        $expected = <<<'SVG'
        <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-accessible" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
          <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1" />
          <circle cx="12" cy="7.5" r=".5" fill="currentColor" />
        </svg>
        SVG;

        $this->assertSame(
            $this->normalizeSvg($expected),
            $this->normalizeSvg($result)
        );
    }

    /** @test */
    public function test_can_add_styles_to_icons()
    {
        $result = svg('tabler-accessible', ['style' => 'color: #555'])->toHtml();

        $expected = <<<'SVG'
        <svg style="color: #555" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-accessible" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
          <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1" />
          <circle cx="12" cy="7.5" r=".5" fill="currentColor" />
        </svg>
        SVG;

        $this->assertSame(
            $this->normalizeSvg($expected),
            $this->normalizeSvg($result)
        );
    }

    private function normalizeSvg(string $svg): string
    {
        return preg_replace('/\s+/', ' ', trim($svg));
    }
}
