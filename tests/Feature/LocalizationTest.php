<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Class LocalizationTest
 * @package Feature
 */
class LocalizationTest extends TestCase
{
    /**
     * @test
     * @psalm-suppress MixedMethodCall
     */
    public function testLanguageChangedFromRequest(): void
    {
        $this->signInAsAdmin();
        $response = $this->get(route('admin.home', ['change_language' => 'en']));
        $response->assertOk();
        $this->assertEquals('en', app()->getLocale());
        $response->assertSessionHas('language', 'en');
    }
    /**
     * @test
     * @psalm-suppress MixedMethodCall
     */
    public function testSessionAcceptLanguage(): void
    {
        $this->signInAsAdmin();
        $response = $this->withSession(['language' => 'en'])
        ->get(route('admin.home'));
        $response->assertOk();
        $this->assertEquals('en', app()->getLocale());
    }

}
