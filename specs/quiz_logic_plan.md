# Quiz Shuffle and Global Scope Implementation Plan

## Overview
This plan outlines the transition to a global question pool and the implementation of a sophisticated quiz shuffling logic.

## 1. Database Schema Changes
- **Global Scope for Questions:**
    - Questions will be global, no longer scoped by `brand` or `quiz_id`.
    - We will add a `difficulty` field to the `questions` table (Beginner, Intermediate, Professionista).
    - We will add a `quiz_id` field (or similar identifier) to `questions` to map them to a specific "Pro" grouping (Quiz). -> this is not needed, already the questions are related to a quiz.
- **Difficulty and Pro-Grouping:**
    - Each "Quiz" entity in the database will now act as a container for questions of that difficulty.
    - "Professionista" questions will be grouped by their `quiz_id`.

## 2. Shuffle Logic
- **Selection Algorithm:**
    1. **Beginner:** Select 3 random questions from the pool of all questions with `difficulty == 'beginner'`.
    2. **Intermediate:** Select 3 random questions from the pool of all questions with `difficulty == 'intermediate'`.
    3. **Pro:** 
        - Identify all unique "Professionista" Quizzes.
        - Randomly pick one Quiz.
        - Select all questions associated with that Quiz.
- **Integration:** This logic will be implemented in a Service class (e.g., `QuizGeneratorService`).

## 3. Attempt and Time Tracking
- **Attempt Logic:** 
    - 3 attempts allowed per session.
    - On failure, the user is reset, and the `QuizGeneratorService` must perform a full re-shuffle (select new random sets).
- **Time Logic:**
    - The `time` attribute remains on the `Quiz` entity. During the session, each question will adhere to the time limit defined by the selected "Pro" Quiz (or a global default for beginner/intermediate).

## 4. Implementation Steps (using Laravel Boost MCP)
1. Define new migrations to move/add `difficulty` to the `questions` table and remove the strict `brand_id` association.
2. Update `Question` model relationships.
3. Implement `QuizGeneratorService` for the shuffle logic.
4. Implement restart/re-shuffle logic in the React session handler.
