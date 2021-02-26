<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'barcode' => $this->faker->isbn13(),
            'datetime_start' => $this->faker->dateTime('now',null),
            'datetime_end' => $this->faker->dateTime('now',null),
            'plate' => $this->faker->word(),
            'user_id' => User::all()->random()->id
        ];
    }
}
