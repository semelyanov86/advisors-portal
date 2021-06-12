<?php

namespace Tests\Feature\Users;

use App\Http\Controllers\Admin\UsersController;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class EditUserTest extends TestCase
{
    use AdditionalAssertions;

    /**
     * @test
     * @see UsersController
     */
    public function testShowEditUserPage(): void
    {
        $this->signInAsAdmin();
        $user = User::factory()->createOne([
            'email' => 'test@mail.ru'
        ]);
        $response = $this->get(route('admin.users.edit', ['user' => $user->id]));
        $response->assertOk();
        $response->assertSee('test@mail.ru');
    }

    /**
     * @test
     * @see UpdateUserRequest
     */
    public function testValidationAttributes(): void
    {
        $this->assertActionUsesFormRequest(
            UsersController::class,
            'update',
            UpdateUserRequest::class
        );
        $subject = new UpdateUserRequest();
        $this->assertValidationRules([
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users,email,',
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

    /**
     * @test
     * @see UpdateUserAction
     */
    public function testUserSuccessfullyUpdated(): void
    {
        $this->signInAsAdmin();
        $user = User::factory()->createOne();
        $data = $user->toArray();
        $data['email'] = 'info@prkpk.ru';
        $data['password'] = 'password';
        $data['roles'] = [2];
        $response = $this->from(route('admin.users.create'))
            ->put(route('admin.users.update', $user->id), $data);
        $response->assertRedirect(route('admin.users.index'));
        $user->refresh();
        $this->assertEquals('info@prkpk.ru', $user->email);
    }
}
