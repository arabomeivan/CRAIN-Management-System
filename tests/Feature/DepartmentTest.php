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

        $response = $this->actingAs($admin)
            ->post(route('departments.store'), $params);

        $response->assertOk();

        $this->assertDatabaseCount('departments', 1);
    }

    public function test_supplier_can_not_create_department()
    {
        $supplier = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ]))
            ->create();

        $params = [
            'name' => 'Exec'
        ];

        $response = $this->actingAs($supplier)
            ->post(route('departments.store'), $params);

        $response->assertForbidden();

        $this->assertDatabaseCount('departments', 0);
    }

    public function test_employee_can_not_create_department()
    {
        $employee = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ]))
            ->create();

        $params = [
            'name' => 'Exec'
        ];

        $response = $this->actingAs($employee)
            ->post(route('departments.store'), $params);

        $response->assertForbidden();

        $this->assertDatabaseCount('departments', 0);
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

    public function test_employee_can_not_read_department()
    {

        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();
        $employee = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
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

        //acting as employee now try to read a department by the id
        $response = $this->actingAs($employee)
            ->get(route('departments.show', $department->id));

        //check if the response after the request made was succesful
        $response->assertForbidden();
    }

    public function test_supplier_can_not_read_department()
    {

        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();
        $supplier = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
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

        //acting as employee now try to read a department by the id
        $response = $this->actingAs($supplier)
            ->get(route('departments.show', $department->id));

        //check if the response after the request made was succesful
        $response->assertForbidden();
    }


    public function test_admin_can_read_all_departments()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        //values to be created in department table
        $params = [
            ['name' => 'accounting'],
            ['name' => 'cleaning']
        ];

        //logging in as an admin create a department
        $this->actingAs($admin)
            ->post(route('departments.store'), $params[0]);
        $this->actingAs($admin)
            ->post(route('departments.store'), $params[1]);

        //acting as admin now try to read a department by the id
        $response = $this->actingAs($admin)
            ->get(route('departments.index'));

        //check if the response after the request made was succesful
        $response->assertOk();
        $response->assertSee($params[0]['name']);
        $response->assertSee($params[1]['name']);

        //to check if the department we retrieved is the same as what we are expecting
        $this->assertDatabaseCount('departments', 2);
    }

    public function test_employee_can_not_read_all_departments()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $employee = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ]))
            ->create();

        //values to be created in department table
        $params = [
            ['name' => 'accounting'],
            ['name' => 'cleaning']
        ];

        //logging in as an admin create a department
        $this->actingAs($admin)
            ->post(route('departments.store'), $params[0]);
        $this->actingAs($admin)
            ->post(route('departments.store'), $params[1]);

        //acting as admin now try to read a department by the id
        $response = $this->actingAs($employee)
            ->get(route('departments.index'));

        //check if the response after the request made was succesful
        $response->assertForbidden();
    }

    public function test_supplier_can_not_read_all_departments()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $supplier = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
            ]))
            ->create();

        //values to be created in department table
        $params = [
            ['name' => 'accounting'],
            ['name' => 'cleaning']
        ];

        //logging in as an admin create a department
        $this->actingAs($admin)
            ->post(route('departments.store'), $params[0]);
        $this->actingAs($admin)
            ->post(route('departments.store'), $params[1]);

        //acting as admin now try to read a department by the id
        $response = $this->actingAs($supplier)
            ->get(route('departments.index'));

        //check if the response after the request made was succesful
        $response->assertForbidden();
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

    public function test_employee_can_not_update_department()
    {

        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $employee = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
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

        //acting as employee now try to update a department by the id
        $response = $this->actingAs($employee)
            ->put(route('departments.update', $department->id), $updateParams);

        //check if the response after the request made was succesful
        $response->assertForbidden();

    }

    public function test_supplier_can_not_update_department()
    {

        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $supplier = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
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

        //acting as employee now try to update a department by the id
        $response = $this->actingAs($supplier)
            ->put(route('departments.update', $department->id), $updateParams);

        //check if the response after the request made was succesful
        $response->assertForbidden();

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

    public function test_employee_can_not_delete_department()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

            $employee = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
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


        //acting as employee now try to delete a department by the id
        $response = $this->actingAs($employee)
            ->delete(route('departments.destroy', $department->id));

        //check if the response after the request made was succesful
        $response->assertForbidden();


        // //to check if department we selected was deleted
        // $this->assertDatabaseCount('departments', 0);
    }

    public function test_supplier_can_not_delete_department()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

            $supplier = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
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


        //acting as employee now try to delete a department by the id
        $response = $this->actingAs($supplier)
            ->delete(route('departments.destroy', $department->id));

        //check if the response after the request made was succesful
        $response->assertForbidden();


        // //to check if department we selected was deleted
        // $this->assertDatabaseCount('departments', 0);
    }


    public function test_must_create_department_with_unique_name()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $params = [
            'name' => 'Marketing'
        ];

        $this->actingAs($admin)
            ->post(route('departments.store'), $params);

        $response = $this->actingAs($admin)
            ->post(route('departments.store'), $params);

        $response->assertSessionHasErrors([
            'name'
        ]);
    }



    public function test_must_update_department_with_unique_name()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $params = [
            'name' => 'Marketing'
        ];


        $this->actingAs($admin)
            ->post(route('departments.store'), $params);

        $updateParams = [
            'name' => 'Marketing'
        ];
        //To update the  first record
        $department = Department::first();


        $response = $this->actingAs($admin)
            ->put(route('departments.update', $department->id),  $updateParams);

        $response->assertSessionHasErrors([
            'name'
        ]);
    }
}
