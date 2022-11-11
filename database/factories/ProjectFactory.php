<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition()
    {

        $faker = Faker::create();
        $start_date = Carbon::instance($faker->dateTimeBetween('-1 months','+1 months'));
        $end_date = (clone $start_date)->addDays(random_int(20,60));


        return [
            'name' => $faker->name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'description' => Str::random(50),
            'user_id' => 1
        ];
    }
}
