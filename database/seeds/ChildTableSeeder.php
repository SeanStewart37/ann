<?php

use Illuminate\Database\Seeder;
use App\Child;
use Carbon\Carbon;

class ChildTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('children')->delete();

        $children = [
            ['gender' => 'male', 'age' => 1, 'toy_id' => 1],
            ['gender' => 'male', 'age' => 2, 'toy_id' => 1],
            ['gender' => 'male', 'age' => 3, 'toy_id' => 1],
            ['gender' => 'male', 'age' => 4, 'toy_id' => 1],
            ['gender' => 'male', 'age' => 5, 'toy_id' => 2],
            ['gender' => 'male', 'age' => 6, 'toy_id' => 3],
            ['gender' => 'male', 'age' => 7, 'toy_id' => 3],
            ['gender' => 'male', 'age' => 8, 'toy_id' => 4],
            ['gender' => 'male', 'age' => 9, 'toy_id' => 4],
            ['gender' => 'male', 'age' => 10, 'toy_id' => 5],
            ['gender' => 'male', 'age' => 11, 'toy_id' => 5],
            ['gender' => 'male', 'age' => 12, 'toy_id' => 6],
            ['gender' => 'female', 'age' => 1, 'toy_id' => 1],
            ['gender' => 'female', 'age' => 2, 'toy_id' => 1],
            ['gender' => 'female', 'age' => 3, 'toy_id' => 7],
            ['gender' => 'female', 'age' => 4, 'toy_id' => 8],
            ['gender' => 'female', 'age' => 5, 'toy_id' => 8],
            ['gender' => 'female', 'age' => 6, 'toy_id' => 8],
            ['gender' => 'female', 'age' => 7, 'toy_id' => 9],
            ['gender' => 'female', 'age' => 8, 'toy_id' => 9],
            ['gender' => 'female', 'age' => 9, 'toy_id' => 6],
            ['gender' => 'female', 'age' => 10, 'toy_id' => 6],
            ['gender' => 'female', 'age' => 11, 'toy_id' => 6],
            ['gender' => 'female', 'age' => 12, 'toy_id' => 6],
        ];

        Child::insert($children);
    }
}
