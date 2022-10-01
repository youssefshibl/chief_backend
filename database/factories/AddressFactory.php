<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber,
            'adress' => $this->faker->address,
            'Postal_Code' => $this->faker->postcode,
            'state' => $this->faker->state

        ];
    }
}
