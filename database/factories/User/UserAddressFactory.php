<?php

namespace Database\Factories\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'post_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'is_default' => $this->faker->boolean,
        ];
    }
}
