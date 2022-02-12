<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $max = 10;
        $this->command->line('User generator.');
        $this->command->getOutput()->progressStart($max);
        for ($i = 0; $i < $max; $i++) {
            $user = User::factory()->create();

            Task::factory(['user_id'=>$user->id])->count(rand(5,5+$max))->create();

            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
    }
}
