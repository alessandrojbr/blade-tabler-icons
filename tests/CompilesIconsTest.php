<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use Orchestra\Testbench\TestCase;
use secondnetwork\TablerIcons\BladeTablerIconsServiceProvider;

class CompilesIconsTest extends TestCase
{
    public function test_compiles_a_single_anonymous_component()
    {
        $result = svg('tabler-accessible')->toHtml();

        $expected = <<<'SVG'
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-accessible">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
          <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1" />
          <circle cx="12" cy="7.5" r=".5" fill="currentColor" />
        </svg>
        SVG;

        $this->assertSame(trim($expected), trim($result));
    }

    public function test_can_add_classes_to_icons()
    {
        $result = svg('tabler-accessible', 'w-6 h-6 text-gray-500')->toHtml();

        $expected = <<<'SVG'
        <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-accessible">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
          <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1" />
          <circle cx="12" cy="7.5" r=".5" fill="currentColor" />
        </svg>
        SVG;

        $this->assertSame(trim($expected), trim($result));
    }

    public function test_can_add_styles_to_icons()
    {
        $result = svg('tabler-accessible', ['style' => 'color: #555'])->toHtml();

        $expected = <<<'SVG'
        <svg style="color: #555" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-accessible">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
          <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1" />
          <circle cx="12" cy="7.5" r=".5" fill="currentColor" />
        </svg>
        SVG;

        $this->assertSame(trim($expected), trim($result));
    }

    protected function getPackageProviders($app)
    {
        return [
            BladeIconsServiceProvider::class,
            BladeTablerIconsServiceProvider::class,
        ];
    }
}
