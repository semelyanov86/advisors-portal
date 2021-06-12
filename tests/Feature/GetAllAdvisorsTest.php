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
 * Class GetAllAdvisorsTest
 * @package Domains\Listings\Tests\Feature
 * @see AdvisorsApiController
 */
final class GetAllAdvisorsTest extends TestCase
{
    use AdditionalAssertions;

    protected bool $shouldSeed = false;

    public function testGettingAllProductsThroughApi(): void
    {
        $advisors = Advisor::factory()->count(5)->create();
        $user = $this->createAdminUser();
        Sanctum::actingAs($user, ['*']);
        $response = $this->getJson(route('api.advisors.index'));
        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data', 5, fn(AssertableJson $json) =>
            $json
                ->where('type', 'advisors')
                ->hasAll([
                    'id',
                    'attributes',
                    'type',
                    'attributes.name',
                    'attributes.description',
                    'attributes.availability',
                    'attributes.price',
                    'attributes.media',
                    'meta'
                ])->etc())->hasAll(['meta', 'links']));
    }

    public function testGettingProductsRestrictedWithoutPermissions(): void
    {
        $user = $this->createUser();
        Sanctum::actingAs($user, ['*']);
        $response = $this->getJson(route('api.advisors.index'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function testControllerUsesMiddleware(): void
    {
        $this->assertRouteUsesMiddleware('api.advisors.index', ['auth:sanctum']);
    }
}
