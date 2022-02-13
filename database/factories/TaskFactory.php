<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $due=$this->faker->dateTimeBetween(Carbon::now()->add('DAY',(-1)*rand(1,5))->format('Y-m-d H:i:s'),Carbon::now()->add('DAY',rand(3,30))->format('Y-m-d H:i:s') )->format('Y-m-d H:i:s');

        $completed=(rand(0,100)%4==0? Carbon::parse($due)->add('DAY',rand(1,5))->format('Y-m-d H:i:s'):null);

        return [
            'task' =>   substr( $this->faker->sentence(3),0,50),
            'comment'=> $this->faker->sentence(20),
            'due_date' => $due,
            'user_id'=>1,
            'completed_at'=>$completed,
            'deleted_at'=>(rand(1,13)%3==0?$completed:null)
        ];
    }
}
