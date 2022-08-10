<?php

namespace Database\Factories;

<<<<<<< HEAD
use App\Models\Role;
=======
>>>>>>> 0152b24cad519c3f30f8cf0343e1fd4076aa0668
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
<<<<<<< HEAD
        $roles = [
            Role::ADMIN_ROLE,
            Role::EMPLOYEE_ROLE,
            Role::SUPPLIER_ROLE
        ];

        return [
            'name' => fake()->randomElement($roles)
=======
        return [
            //
>>>>>>> 0152b24cad519c3f30f8cf0343e1fd4076aa0668
        ];
    }
}
