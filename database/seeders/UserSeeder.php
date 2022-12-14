<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10).'@gmail.com',
        //     'password' => Hash::make(Str::random(10))
        // ]);
        User::factory()->count(20)->sequence(
            fn($sequence) => [

                'image' =>  'file-' . rand(1,49) . ".jpg",
                'role' => $sequence->index % 5 == 0 ? 1 : 0
            ]
        )->create();
    }
}
