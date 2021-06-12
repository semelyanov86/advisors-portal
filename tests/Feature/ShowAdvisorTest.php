<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Api\V1\Admin\AdvisorsApiController;
use App\Models\Advisor;
use Database\Seeders\PermissionsTableSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class ShowAdvisorTest
 * @package Domains\Listings\Tests\Feature
 * @see AdvisorsApiController
 */
final class ShowAdvisorTest extends TestCase
{
    use AdditionalAssertions;

    protected bool $shouldSeed = false;

    public function testShowAdvisorThroughApi(): void
    {
        /** @var Advisor $advisor */
        $advisor = Advisor::factory()->createOne();
        $user = $this->createAdminUser();
        Sanctum::actingAs($user, ['*']);
        $response = $this->getJson(route('api.advisors.show', ['advisor' => $advisor->id]));
        $response->assertOk()->assertJson([
            "data" => [
                "type" => "advisors",
                "id" => (string) $advisor->id,
                "attributes" => [
                    "name" => $advisor->name,
                    "description" => $advisor->description?->toNative(),
                    "availability" => $advisor->availability,
                    "price" => $advisor->price->toNative(),
                    "media" => null
                ],
            ]
        ]);
    }


    /**
     * @test
     */
    public function testControllerUsesMiddleware(): void
    {
        $this->assertRouteUsesMiddleware('api.advisors.show', ['auth:sanctum']);
    }
}
