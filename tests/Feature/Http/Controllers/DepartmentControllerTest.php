<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_department_page_is_displayed(): void
    {
        $this->get(route('department.index'))->assertOk();
    }

    public function test_department_information_can_be_updated(): void
    {
        $department = Department::factory()->create();
        $name = fake()->name();
        $response = $this->put(route('department.update',$department->id), ['name' => $name]);

        $response->assertSessionHasNoErrors()->assertRedirect(route('home'));

        $department->refresh();

        $this->assertSame($name, $department->name);
    }

    public function test_department_information_cannot_be_updated(): void
    {
        $department = Department::factory()->create();
        $department2 = Department::factory()->create();
        $response = $this->put(route('department.update', $department->id), ['name' => $department2->name]);

        $response->assertSessionHasErrors(['name'])->assertRedirect(route('home'));
    }

    public function test_department_can_be_created(): void
    {
        $department = Department::factory()->make();
        $response = $this->post(route('department.store'), $department->toArray());

        $response->assertSessionHasNoErrors()->assertRedirect(route('home'));

        $this->assertDatabaseHas('departments', $department->toArray());
    }

    public function test_department_cannot_be_created(): void
    {
        $department = Department::factory()->create();
        $response = $this->post(route('department.store'), ['name' => $department->name]);

        $response->assertSessionHasErrors(['name'])->assertRedirect(route('home'));
    }

    public function test_department_can_be_visualized(): void
    {
        $department = Department::factory()->create();
        $this->get(route('department.show', $department->id))->assertOk();
    }

    public function test_department_can_be_deleted(): void
    {
        $department = Department::factory()->create();
        $response = $this->delete(route('department.destroy', $department->id));
        $response->assertSessionHasNoErrors()->assertRedirect(route('department.index'));
    }

    public function test_department_can_be_linked_with_another_department(): void
    {
        $department = Department::factory()->create();
        $department2 = Department::factory()->create();
        $response = $this->put(route('department.linkWithDepartment', ["department" => $department->id, "parentDepartment" => $department2->id]));

        $response->assertSessionHasNoErrors()->assertRedirect(route('home'));

        $department->refresh();
        $department2->refresh();

        $this->assertSame($department2->id, $department->parent_department_id);
    }

    public function test_department_can_be_linked_with_user(): void
    {
        $department = Department::factory()->create();
        $user = User::factory()->create();
        $response = $this->put(route('department.linkWithUser', ["department" => $department->id, "user" => $user->id]));

        $response->assertSessionHasNoErrors()->assertRedirect(route('home'));

        $department->refresh();

        $this->assertContains($user->id, $department->users()->pluck('id')->toArray());
    }

    public function test_department_can_be_unlinked_with_user(): void
    {
        $department = Department::factory()->create();
        $user = User::factory()->create();
        $response = $this->put(route('department.unlinkWithUser', ["department" => $department->id, "user" => $user->id]));

        $response->assertSessionHasNoErrors()->assertRedirect(route('home'));

        $department->refresh();

        $this->assertNotContains($user->id, $department->users()->pluck('id')->toArray());
    }
}
