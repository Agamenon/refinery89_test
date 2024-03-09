<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_page_is_displayed(): void
    {
        $this->get(route('user.index'))->assertOk();
    }

    public function test_user_information_can_be_updated(): void
    {
        $user = User::factory()->create();
        $name = fake()->name();
        $email = fake()->email();
        $response = $this->put(route('user.update', $user->id), ['name' => $name, 'email' => $email]);

        $response->assertSessionHasNoErrors()->assertRedirect(route('home'));

        $user->refresh();

        $this->assertSame($name, $user->name);
        $this->assertSame($email, $user->email);
    }

    public function test_user_name_cannot_be_updated(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->put(route('user.update', $user->id), ['name' => $user2->name]);

        $response->assertSessionHasErrors(['name'])->assertRedirect(route('home'));
    }


    public function test_user_email_cannot_be_updated(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->put(route('user.update', $user->id), ['email' => $user2->email]);

        $response->assertSessionHasErrors(['email'])->assertRedirect(route('home'));
    }

    public function test_user_can_be_created(): void
    {
        $user = User::factory()->unverified()->make();
        $response = $this->post(route('user.store'), $user->toArray());

        $response->assertSessionHasNoErrors()->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', $user->toArray());
    }

    public function test_user_cannot_be_created(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('user.store'), ['name' => $user->name]);

        $response->assertSessionHasErrors(['name'])->assertRedirect(route('home'));
    }

    public function test_user_can_be_visualized(): void
    {
        $user = User::factory()->create();
        $this->get(route('user.show', $user->id))->assertOk();
    }

    public function test_user_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $response = $this->delete(route('user.destroy', $user->id));
        $response->assertSessionHasNoErrors()->assertRedirect(route('user.index'));
    }

    public function test_user_cannot_be_deleted_assigned_to_departments(): void
    {
        $user = User::factory()->hasAttached(Department::factory()->count(3))->create();
        $response = $this->delete(route('user.destroy', $user->id));
        $response->assertSessionHasErrors(['user'])->assertRedirect(route('home'));
    }
}
