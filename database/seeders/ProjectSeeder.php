<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $index = 1;
        Project::factory()->count(10)->sequence(
            fn($sequence) => [
                'name' =>  'Demo Project ' . $sequence->index + 1
            ]
        )->create();
    }
}
