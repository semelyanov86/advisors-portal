<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionRoleTableSeeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\RoleUserTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    public bool $seed = false;

    protected function signIn(): self
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(PermissionsTableSeeder::class);
        $this->seed(PermissionRoleTableSeeder::class);
        $this->seed(RoleUserTableSeeder::class);
        /** @var User $user */
        $user = $this->createUser();
        $this->actingAs($user);
        return $this;
    }

    protected function createUser(): \Illuminate\Database\Eloquent\Model
    {
        return User::factory()->createOne([
            'email' => 'test@test.com'
        ]);
    }

    protected function createAdminUser(): \Illuminate\Database\Eloquent\Model
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(PermissionsTableSeeder::class);
        $this->seed(PermissionRoleTableSeeder::class);
        $this->seed(RoleUserTableSeeder::class);
        return User::first();
    }

    protected function signInAsAdmin(): self
    {
        /** @var User $user */
        $user = $this->createAdminUser();
        if (!$user->is_admin) {
            $user->roles()->sync([1]);
        }
        $this->actingAs($user);
        return $this;
    }

    public function getJson($uri, array $headers = []): \Illuminate\Testing\TestResponse
    {
        if (empty($headers)) {
            $headers = [
                'accept' => 'application/vnd.api+json',
                'content-type' => 'application/vnd.api+json'
            ];
        }
        return parent::getJson($uri, $headers);
    }

    public function setUp(): void
    {
        parent::setUp();
        if (Role::count() < 2) {
            $this->seed(RolesTableSeeder::class);
        }
    }

}
