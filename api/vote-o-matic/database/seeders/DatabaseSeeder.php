<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $question = Question::create([
            'title' => 'Who are you voting for?',
            'description' => 'Who are you voting for in the upcoming election?',
        ]);

        $question->options()->createMany([
            ['description' => 'Candidate A'],
            ['description' => 'Candidate B'],
            ['description' => 'Candidate C'],
            ['description' => 'Candidate D'],
        ]);
    }
}
