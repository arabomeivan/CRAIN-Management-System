<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Test if an admin can create a department.
     *
     * @return void
     */
    public function test_admin_can_create_department()
    {
        // login as an admin
        // visit the create department page
        // fill the form
        // submit
        // check if the department is created

        // create an admin user
        $user = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $params = [
            'name' => 'Exec'
        ];

        // log in as user
        $response = $this->actingAs($user)

            // submit a request to create the department
            ->post(route('departments.store'), $params);

        $response->assertOk();

        $this->assertDatabaseCount('departments', 1);
    }




    //Test if We can read departments (basically)

    public function test_admin_can_read_department()
    {

        //first we make a get request to the server since we're trying to read
        // submit a request to create the department


    }
}
