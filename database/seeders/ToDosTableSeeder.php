<?php

namespace Database\Seeders;

use App\Models\ToDos\ToDo;
use Illuminate\Database\Seeder;

class ToDosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ToDo::factory()->times(100)->create();
    }
}
