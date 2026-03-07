<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CotisationFactory extends Factory
{
    public function definition(): array
    {
        return [

            'user_id' => User::inRandomOrder()->first()->id ?? 1,

            'montant' => $this->faker->numberBetween(5000, 50000),

            'description' => $this->faker->sentence(),

            'justificatif' => 'justificatifs/test.pdf',

            'date_cotisation' => $this->faker->dateTimeBetween('-12 months', 'now'),

        ];
    }
}