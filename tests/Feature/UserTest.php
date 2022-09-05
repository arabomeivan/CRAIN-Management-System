<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_user()
    {
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $employeeRole = Role::factory()->state([
            'name' => Role::EMPLOYEE_ROLE
        ])
            ->create();

        $supplierRole = Role::factory()->state([
            'name' => Role::SUPPLIER_ROLE
        ])
            ->create();

        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];

        $params2 = [
            'role_id' => $supplierRole->id,
            'name' => 'Chukwumsi',
            'email' => 'abcd@gmail.com',
            'password' => 'dmannn'
        ];

        $params3 = [
            'role_id' => $admin->id,
            'name' => 'rans g',
            'email' => 'abcde@gmail.com',
            'password' => 'dmannn'
        ];

        $response = $this->actingAs($admin)
            ->post('/users', $params);

            $response->assertOk();

        $response = $this->actingAs($admin)
            ->post('/users', $params2);

            $response->assertOk();

        $response = $this->actingAs($admin)
            ->post('/users', $params3);

        $response->assertOk();

        $this->assertDatabaseCount("users", 4);
    }

    public function test_employee_can_not_create_user()
    {
        $employee = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ]))
            ->create();

            $employeeRole = Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ])
                ->create();

            $supplierRole = Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
            ])
                ->create();

            $admin = Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ])
                ->create();


        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];

        $params2 = [
            'role_id' => $supplierRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abcd@gmail.com',
            'password' => '1234'
        ];

        $params3 = [
            'role_id' => $admin->id,
            'name' => 'Ivan arabome',
            'email' => 'abce@gmail.com',
            'password' => '1234'
        ];

        $response = $this->actingAs($employee)
            ->post('/users', $params);
        $response->assertForbidden();

        $response = $this->actingAs($employee)
            ->post('/users', $params2);
            $response->assertForbidden();

            $response = $this->actingAs($employee)
            ->post('/users', $params3);
            $response->assertForbidden();

        $this->assertDatabaseCount('users', 1);
    }

    public function test_supplier_can_not_create_user()
    {
        $supplier = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
            ]))
            ->create();

            $employeeRole = Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ])
                ->create();

            $supplierRole = Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
            ])
                ->create();

            $admin = Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ])
                ->create();

        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];

        $params2 = [
            'role_id' => $supplierRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abcd@gmail.com',
            'password' => '1234'
        ];

        $params3 = [
            'role_id' => $admin->id,
            'name' => 'Ivan arabome',
            'email' => 'abce@gmail.com',
            'password' => '1234'
        ];

        $response = $this->actingAs($supplier)
            ->post('/users', $params);
        $response->assertForbidden();

        $response = $this->actingAs($supplier)
            ->post('/users', $params2);
            $response->assertForbidden();

            $response = $this->actingAs($supplier)
            ->post('/users', $params3);
            $response->assertForbidden();

        $this->assertDatabaseCount('users', 1);
    }

    public function test_admin_can_read_a_user()
    {

        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $employeeRole = Role::factory()->state([
            'name' => Role::EMPLOYEE_ROLE
        ])
            ->create();

        //values to be created in department table

        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];


        //logging in as an admin create a department
        $this->actingAs($admin)
            ->post('/users', $params);


        //To read the  first record
        $user = User::first();

        //acting as admin now try to read a department by the id
        $response = $this->actingAs($admin)
            ->get(route('users.show', $user->id));

        //check if the response after the request made was succesful
        $response->assertOk();


        //to check if the department we retrieved is the same as what we are expecting
        $response->assertSee($user->id);
        $response->assertSee($user->name);
    }

    public function test_admin_can_read_all_users()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $employeeRole = Role::factory()->state([
            'name' => Role::EMPLOYEE_ROLE
        ])
            ->create();

        $supllierRole = Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
        ])
            ->create();


        $adminRole = Role::factory()->state([
                    'name' => Role::ADMIN_ROLE
        ])
            ->create();


        //values to be created in users table
        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'

        ];

        $params2 =
            [
                'role_id' => $supllierRole->id,
                'name' => 'Austin',
                'email' => 'abcde@gmail.com',
                'password' => '12434'
            ];

            $params3 =
            [
                'role_id' => $adminRole->id,
                'name' => 'Austin',
                'email' => 'abcdef@gmail.com',
                'password' => '12434'
            ];

        //logging in as an admin create a department
        $this->actingAs($admin)
            ->post('/users', $params);
        $this->actingAs($admin)
            ->post('/users', $params2);
            $this->actingAs($admin)
            ->post('/users', $params3);

        //acting as admin now try to read a department by the id
        $response = $this->actingAs($admin)
            ->get(route('users.index'));

        //check if the response after the request made was succesful
        $response->assertOk();
        $response->assertSee($params3['role_id']);
        $response->assertSee($params['role_id']);
        $response->assertSee($params2['role_id']);
        $response->assertSee($params3['role_id']);

    }

    public function test_admin_can_update_a_user()
    {

        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $employeeRole = Role::factory()->state([
            'name' => Role::EMPLOYEE_ROLE
        ])
            ->create();

        //values to be created in department table

        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];

        //logging in as an admin create a department
        $response = $this->actingAs($admin)
            ->post('/users', $params);


        //To update the  first record
        $user = User::where('email', 'abc@gmail.com')->first();

        $updateParams = [
            'role_id' => $employeeRole->id,
            'name' => 'Yay',
            'email' => 'adbc@gmail.com',
            'password' => '12234'

        ];

        //acting as admin now try to update a department by the id
        $response = $this->actingAs($admin)
            ->put(route('users.update', $user->id), $updateParams);

        //check if the response after the request made was succesful
        $response->assertOk();


        //to check if the department we retrieved is the same as what we are expecting
        $response->assertSee($updateParams['name']);
        //  $this->assertDatabaseCount('departments',1);

    }

    public function test_user_can_not_update_a_user()
    {

        //Create a user with admin role
        $supplier = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
            ]))
            ->create();

            $employeeRole = Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ])
                ->create();

        //values to be created in department table
        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];

        //logging in as an admin create a department
        $this->actingAs($supplier)
            ->post('/users', $params);


        //To update the  first record
        $users = User::first();

        $updateParams = [
            'role_id' => $employeeRole->id,
            'name' => 'Yay',
            'email' => 'adbc@gmail.com',
            'password' => '12234'

        ];

        //acting as employee now try to update a department by the id
        $response = $this->actingAs($supplier)
            ->put(route('users.update', $users->id), $updateParams);

        //check if the response after the request made was succesful
        $response->assertForbidden();
    }

    public function test_admin_can_delete_user()
    {
        //Create a user with admin role
        $admin = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        $employeeRole = Role::factory()->state([
            'name' => Role::EMPLOYEE_ROLE
        ])
            ->create();

        //values to be created in department table

        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];


        //logging in as an admin create a department
        $this->actingAs($admin)
            ->post('/users', $params);


        $this->assertDatabaseCount('users', 2);


        //To update the  first record
        $user = User::first();


        //acting as admin now try to delete a department by the id
        $response = $this->actingAs($admin)
            ->delete(route('users.destroy', $user->id));

        //check if the response after the request made was succesful
        $response->assertOk();


        //to check if department we selected was deleted
        $this->assertDatabaseCount('users', 1);
    }

    public function test_user_can_not_delete_user()
    {
        //Create a user with admin role
        $employee = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ]))
            ->create();

        $adminRole = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::ADMIN_ROLE
            ]))
            ->create();

        //values to be created in department table
        $params = [
            'role_id' => $adminRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];


        //logging in as an admin create a department
        $this->actingAs($employee)
            ->post('/users', $params);

        $this->assertDatabaseCount('users', 2);


        //To update the  first record
        $user = User::first();


        //acting as employee now try to delete a department by the id
        $response = $this->actingAs($employee)
            ->delete(route('users.destroy', $user->id));

        //check if the response after the request made was succesful
        $response->assertForbidden();
    }
}
