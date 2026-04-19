<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Brand;
use App\Models\Lead;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Answer::truncate();
        Question::truncate();
        Quiz::truncate();
        Lead::truncate();
        Brand::truncate();
        User::truncate();

        Schema::enableForeignKeyConstraints();

        $path = database_path('data/sync.json');

        if (! file_exists($path)) {
            $this->command?->error("Sync file not found at {$path}. Run: php artisan data:export");

            return;
        }

        $data = json_decode(file_get_contents($path), true);

        foreach ($data['brands'] as $brandData) {
            Brand::create($brandData);
        }

        foreach ($data['quizzes'] as $quizData) {
            Quiz::create($quizData);
        }

        foreach ($data['questions'] as $questionData) {
            Question::create($questionData);
        }

        foreach ($data['answers'] as $answerData) {
            Answer::create($answerData);
        }

        foreach ($data['users'] as $userData) {
            User::create($userData);
        }
    }
}
