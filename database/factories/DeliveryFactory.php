<?php

namespace Database\Factories;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Factories\Factory;


class DeliveryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'city_id' => \App\Models\City::factory()->create()->id,
            'address' => $this->faker->address,
            'delivery_date' => $this->faker->dateTimeBetween('+1 day', '+1 week'),
            'client_name' => $this->faker->name,
            'client_phone' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['новый', 'доставлен', 'отменён']),
        ];
    }
}
