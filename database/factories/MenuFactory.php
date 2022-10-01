<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
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
            'name' => $this->faker->text(10),
            'description' => $this->faker->text(200),
            'image' => "https://media.istockphoto.com/photos/grilled-spam-burger-with-fries-picture-id1365382318?b=1&k=20&m=1365382318&s=170667a&w=0&h=L7vIkUBi8IjxkDv1Ca5xSbYLAxR1zI__wrBacQzY18g=",
            "price" => $this->faker->numberBetween(0,500),
        ];
    }
}
