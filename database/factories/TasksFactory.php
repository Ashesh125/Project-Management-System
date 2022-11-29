<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tasks>
 */
class TasksFactory extends Factory
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
        $type = $faker->randomElement(['assigned' ,'ongoing', 'completed']);

        return [
            'due_date' => $end_date,
            'status' => $type == 'completed'? rand(0,2): 0,
            'description' => Str::random(50),
            'user_id' => User::where('role', '=', 0)->get()->random()->id,
            'activity_id' => Activity::all()->random()->id,
            'type' => $type,
            'priority' =>rand(0,2)
        ];
    }
}
