<?php

namespace Database\Factories\ToDos;

use App\Models\ToDos\ToDo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToDoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ToDo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'to_do' => $this->faker->realText(50),
            'user_id' => $this->faker->randomElement([1, 2, 3]),
            'completed' => $this->faker->randomElement([true, false])
        ];
    }
}
