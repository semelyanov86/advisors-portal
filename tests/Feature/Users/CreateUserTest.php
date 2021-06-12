<?php

namespace Tests\Feature\Users;

use App\Http\Controllers\Admin\UsersController;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use WithFaker;
    use AdditionalAssertions;

    /**
     * @test
     * @see UsersController
     */
    public function testDisplayCreateUserPage(): void
    {
        $this->signInAsAdmin();
        $response = $this->get(route('admin.users.create'));
        $response->assertOk();
        $response->assertSee('Create User');
    }

    /**
     * @test
     * @see UsersController
     */
    public function testRestrictCreatePageForRegularUser(): void
    {
        $this->signIn();
        $response = $this->get(route('admin.users.create'));
        $response->assertForbidden();
    }

    /**
     * @test
     * @see UsersController
     */
    public function testUserSuccessfullyCreated(): void
    {
        $this->signInAsAdmin();
        $name = $this->faker->name;
        $response = $this->post(route('admin.users.store'), [
            'name' => $name,
            'email' => $this->faker->email,
            'password' => 'password',
            'roles' => [1, 2],
        ]);
        $this->assertDatabaseHas('users', ['name' => $name]);
        $response->assertRedirect(route('admin.users.index'));
    }

    /**
     * @test
     * @see StoreUserRequest
     */
    public function testValidationAttributes(): void
    {
        $this->assertActionUsesFormRequest(
            UsersController::class,
            'store',
            StoreUserRequest::class
        );
        $subject = new StoreUserRequest();
        $this->assertValidationRules([
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ], $subject->rules());
    }
}
