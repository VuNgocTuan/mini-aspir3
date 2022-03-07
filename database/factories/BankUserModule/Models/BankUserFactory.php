<?php

namespace Database\Factories\BankUserModule\Models;

use BankUserModule\Models\BankUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BankUserFactory extends Factory
{
    protected $model = BankUser::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
}
