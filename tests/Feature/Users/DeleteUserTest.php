<?php

namespace Tests\Feature\Users;

use App\Http\Controllers\Admin\UsersController;
use App\Models\User;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use AdditionalAssertions;

    /**
     * @test
     * @see UsersController
     */
    public function testUserSuccessfullyDeleted(): void
    {
        $this->signInAsAdmin();
        $user = User::factory()->createOne();
        $response = $this->from(route('admin.users.index'))
            ->delete(route('admin.users.destroy', ['user' => $user->id]));
        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * @test
     */
    public function testNotAuthUserCanNotDelete(): void
    {
        $user = User::factory()->createOne();
        $response = $this->delete(route('admin.users.destroy', ['user' => $user->id]));
        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /**
     * @test
     * @psalm-suppress MixedMethodCall
     */
    public function testMassDestroySucceed(): void
    {
        $this->signInAsAdmin();
        /** @var User[] $users */
        $users = User::factory(3)->create()->pluck('id')->toArray();
        $response = $this->from(route('admin.users.index'))
            ->delete(route('admin.users.massDestroy', ['ids' => $users]));
        $response->assertNoContent();
        $this->assertDatabaseMissing('users', ['id' => $users[0]]);
        $this->assertDatabaseMissing('users', ['id' => $users[1]]);
        $this->assertDatabaseMissing('users', ['id' => $users[2]]);
    }
}
