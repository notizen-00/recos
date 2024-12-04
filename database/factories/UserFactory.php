<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        static $index = 1;

        $detail_department_id = $index++;

        return [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
            'password' => bcrypt('recos123'),
            'detail_department_id' => $detail_department_id,
        ];
    }

}
