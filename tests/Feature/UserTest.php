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

    public function test_admin_can_create_an_employee()
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

        $params = [
            'role_id' => $employeeRole->id,
            'name' => 'Ivan arabome',
            'email' => 'abc@gmail.com',
            'password' => '1234'
        ];

        $response = $this->actingAs($admin)
            ->post('/users',$params);

        $response->assertOk();

        $this->assertDatabaseCount("users", 2);
    }
    public function test_admin_can_read_employee()
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

    public function test_admin_can_read_all_employees()
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

        $params2 =
        [
            'role_id' => $employeeRole->id,
            'name' => 'Austin',
            'email' => 'abcde@gmail.com',
            'password' => '12434'
        ];

        //logging in as an admin create a department
        $this->actingAs($admin)
            ->post('/users', $params);
        $this->actingAs($admin)
            ->post('/users', $params2);

        //acting as admin now try to read a department by the id
        $response = $this->actingAs($admin)
            ->get(route('users.index'));

        //check if the response after the request made was succesful
        $response->assertOk();
        $response->assertSee($params['role_id']);
        $response->assertSee($params2['role_id']);

        //to check if the department we retrieved is the same as what we are expecting
        // $this->assertDatabaseCount('users', 2);
    }

    public function test_admin_can_update_employee()
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
                ->post('/users',$params);


                //To update the  first record
                $user = User::first();

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
                public function test_admin_can_delete_employee()
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


                    //to check if department we selected was deletedklk
                    $this->assertDatabaseCount('users', 1);
                }




}
