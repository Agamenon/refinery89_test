<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(100)->create();

        Department::all()->each(function ($department) use ($users){
            $users->random(rand(1, 10))->each(function ($user) use ($department) {
                $user->departments()->attach($department->id);
            });
        });
    }
}
