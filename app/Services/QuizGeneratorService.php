<?php

namespace App\Services;

use App\Enums\Difficulty;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Collection;

class QuizGeneratorService
{
    public function generateQuiz(Difficulty $difficulty): Collection
    {
        return match ($difficulty) {
            Difficulty::Beginner => $this->getQuestionsByDifficulty(Difficulty::Beginner, 3),
            Difficulty::Intermediate => $this->getQuestionsByDifficulty(Difficulty::Intermediate, 3),
            Difficulty::Pro => $this->getRandomProQuizQuestions(),
        };
    }

    protected function getQuestionsByDifficulty(Difficulty $difficulty, int $limit): Collection
    {
        return Question::where('difficulty', $difficulty)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    protected function getRandomProQuizQuestions(): Collection
    {
        $quiz = Quiz::whereHas('questions', function ($query) {
            $query->where('difficulty', Difficulty::Pro);
        })
            ->inRandomOrder()
            ->first();

        return $quiz ? $quiz->questions()->where('difficulty', Difficulty::Pro)->get() : collect();
    }
}
