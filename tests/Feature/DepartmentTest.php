<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentTest extends TestCase

{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * test if an admin can create a department
     * @return void
     */

     //test to check if an admin can create a department
    public function test_admin_can_create_department()
    {
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $params = [
            'name' => 'Exec'
        ];

        //login

        $response = $this->actingAs($admin)
            ->post(route('departments.store'), $params);

        $response->assertOk();

        $this->assertDatabaseCount('departments',1);


    }

     //test to check if an admin can read a department
     public function test_admin_can_read_department()
     {

        //Create a user with admin role
         $admin = User::factory()
             ->for(Role::factory()->state([
                 'name' => Role::ADMIN_ROLE
             ]))
            ->create();

            //values to be created in department table
            $params = [
                'name' => 'Finance'
            ];


            //logging in as an admin create a department
            $this->actingAs($admin)
                ->post(route('departments.store'), $params);


            //To read the  first record
            $department = Department::first();

            //acting as admin now try to read a department by the id
         $response = $this->actingAs($admin)
             ->get(route('departments.show', $department->id));

             //check if the response after the request made was succesful
         $response->assertOk();


         //to check if the department we retrieved is the same as what we are expecting
         $response->assertSee($department->id);
         $response->assertSee($department->name);



     }
     public function test_admin_can_update_department()
     {

        //Create a user with admin role
         $admin = User::factory()
             ->for(Role::factory()->state([
                 'name' => Role::ADMIN_ROLE
             ]))
            ->create();

            //values to be created in department table
            $params = [
                'name' => 'Marketing'
            ];


            //logging in as an admin create a department
            $this->actingAs($admin)
                ->post(route('departments.store'), $params);


            //To update the  first record
            $department = Department::first();

            $updateParams = [
                'name' => 'Finance'
            ];

            //acting as admin now try to update a department by the id
         $response = $this->actingAs($admin)
             ->put(route('departments.update', $department->id), $updateParams);

             //check if the response after the request made was succesful
         $response->assertOk();


         //to check if the department we retrieved is the same as what we are expecting
         $response->assertSee($updateParams['name']);
        //  $this->assertDatabaseCount('departments',1);

     }

     public function test_admin_can_delete_department()
     {

        //Create a user with admin role
         $admin = User::factory()
             ->for(Role::factory()->state([
                 'name' => Role::ADMIN_ROLE
             ]))
            ->create();

            //values to be created in department table
            $params = [
                'name' => 'Marketing'
            ];


            //logging in as an admin create a department
            $this->actingAs($admin)
                ->post(route('departments.store'), $params);

            $this->assertDatabaseCount('departments', 1);


            //To update the  first record
            $department = Department::first();


            //acting as admin now try to delete a department by the id
         $response = $this->actingAs($admin)
             ->delete(route('departments.destroy', $department->id));

             //check if the response after the request made was succesful
         $response->assertOk();


         //to check if department we selected was deleted
         $this->assertDatabaseCount('departments', 0);


     }
}
