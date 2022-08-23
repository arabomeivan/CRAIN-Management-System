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
}
