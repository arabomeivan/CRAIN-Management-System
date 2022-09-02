<?php

namespace Tests\Feature;

use App\Models\Equipment;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_can_create_equipment()
    {

        //using the factory we're creating a row in users table called admin
        $admin = User::factory()
        ->for(Role::factory()->state([
            'name' => Role::ADMIN_ROLE
        ]))
        ->create();

    $params = [
        'name' => 'Laptops'

    ];

        $response = $this->actingAs($admin)
            ->post(route('equipment.store'), $params);

         $response->assertOk();

        $this->assertDatabaseCount('equipment', 1);

    }

    public function test_employee_can_not_create_equipment()
    {
        $employee = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::EMPLOYEE_ROLE
            ]))
            ->create();

        $params = [
            'name' => 'pen'
        ];

        $response = $this->actingAs($employee)
            ->post(route('equipment.store'), $params);

        $response->assertForbidden();

        $this->assertDatabaseCount('equipment', 0);
    }

    public function test_supplier_can_not_create_equipment()
    {
        $supplier = User::factory()
            ->for(Role::factory()->state([
                'name' => Role::SUPPLIER_ROLE
            ]))
            ->create();

        $params = [
            'name' => 'pen'
        ];

        $response = $this->actingAs($supplier)
            ->post(route('equipment.store'), $params);

        $response->assertForbidden();

        $this->assertDatabaseCount('equipment', 0);
    }




        public function test_admin_can_read_equipment(){

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
            ->post(route('equipment.store'), $params);


            //To read the  first record
            $equipment = Equipment::first();

            //acting as admin now try to read a department by the id
            $response = $this->actingAs($admin)
            ->get(route('equipment.show', $equipment->id));

            //check if the response after the request made was succesful
            $response->assertOk();


            //to check if the department we retrieved is the same as what we are expecting
            $response->assertSee($equipment->id);
            $response->assertSee($equipment->name);
            }
        public function test_admin_can_read_all_equipment()
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
            ->post(route('equipment.store'), $params[0]);
            $this->actingAs($admin)
            ->post(route('equipment.store'), $params[1]);

            //acting as admin now try to read a department by the id
            $response = $this->actingAs($admin)
            ->get(route('equipment.index'));

            //check if the response after the request made was succesful
            $response->assertOk();
            $response->assertSee($params[0]['name']);
            $response->assertSee($params[1]['name']);

            //to check if the department we retrieved is the same as what we are expecting
            $this->assertDatabaseCount('equipment', 2);
            }

            public function test_admin_can_update_equipment()
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
                ->post(route('equipment.store'), $params);


                //To update the  first record
                $equipment = Equipment::first();

                $updateParams = [
                'name' => 'Finance'
                ];

                //acting as admin now try to update a department by the id
                $response = $this->actingAs($admin)
                ->put(route('equipment.update', $equipment->id), $updateParams);

                //check if the response after the request made was succesful
                $response->assertOk();


                //to check if the department we retrieved is the same as what we are expecting
                $response->assertSee($updateParams['name']);
                //  $this->assertDatabaseCount('departments',1);

                }

                public function test_employee_can_not_update_equipment(){

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
                ->post(route('equipment.store'), $params);


                //To update the  first record
                $equipment = Equipment::first();

             $updateParams = [
                'name' => 'Finance'
                ];

                //acting as employee now try to update a department by the id
                $response = $this->actingAs($employee)
                ->put(route('equipment.update', $equipment->id), $updateParams);

                //check if the response after the request made was succesful
                $response->assertForbidden();

                }

                public function test_supplier_can_not_update_equipment(){

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
                    ->post(route('equipment.store'), $params);


                    //To update the  first record
                    $equipment = Equipment::first();

                 $updateParams = [
                    'name' => 'Finance'
                    ];

                    //acting as employee now try to update a department by the id
                    $response = $this->actingAs($supplier)
                    ->put(route('equipment.update', $equipment->id), $updateParams);

                    //check if the response after the request made was succesful
                    $response->assertForbidden();

                    }


                public function test_admin_can_delete_equipment()
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
                ->post(route('equipment.store'), $params);

                $this->assertDatabaseCount('equipment', 1);


                //To update the  first record
                $equipment = Equipment::first();


                //acting as an admin now try to delete a department by the id
                $response = $this->actingAs($admin)
                ->delete(route('equipment.destroy', $equipment->id));

                //check if the response after the request made was succesful
                $response->assertOk();


                //to check if department we selected was deleted
                $this->assertDatabaseCount('equipment', 0);
                }

                public function test_employee_can_not_delete_equipment()
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
                ->post(route('equipment.store'), $params);

                $this->assertDatabaseCount('equipment', 1);


                //To update the  first record
                $equipment = Equipment::first();


                //acting as employee now try to delete a department by the id
                $response = $this->actingAs($employee)
                ->delete(route('equipment.destroy', $equipment->id));

                //check if the response after the request made was succesful
                $response->assertForbidden();


    }
    public function test_supplier_can_not_delete_equipment()
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
    ->post(route('equipment.store'), $params);

    $this->assertDatabaseCount('equipment', 1);


    //To update the  first record
    $equipment = Equipment::first();


    //acting as employee now try to delete a department by the id
    $response = $this->actingAs($supplier)
    ->delete(route('equipment.destroy', $equipment->id));

    //check if the response after the request made was succesful
    $response->assertForbidden();



}
}


