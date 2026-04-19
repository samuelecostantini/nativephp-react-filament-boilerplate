# Plan: Re-shuffle Questions After Wrong Answer

This plan outlines the steps to implement a re-shuffling mechanism for questions in `QuizView.jsx` when a user provides a wrong answer.

## Problem Statement
Currently, when a user gives a wrong answer, they are sent back to the start of the current difficulty level, but the questions remain in the same order. To increase variety and difficulty, the questions should be re-shuffled upon failure.

## Detailed Implementation of `shuffleKey`

The `shuffleKey` is a state variable designed to act as a "cache-buster" for the `useMemo` hook that generates the `questionStack`.

### 1. The Triggering Mechanism
In React, `useMemo` only re-runs its internal logic when one of its dependencies changes. By adding `shuffleKey` to the dependency array, we can programmatically force the `questionStack` to be re-shuffled at any time by updating the state of `shuffleKey`.

```javascript
const [shuffleKey, setShuffleKey] = useState(0);

const questionStack = useMemo(() => {
    // Shuffling logic remains the same...
    // The presence of shuffleKey here ensures a re-run on every increment
    console.log('Re-shuffling question stack...');
    return [...begQuestions, ...intQuestions, ...proQuestions];
}, [beginnerQuiz, intermediateQuiz, proQuizzes, shuffleKey]);
```

### 2. Coordination with Level Resets
When a user answers incorrectly, we need to perform two distinct actions:
1.  **Re-shuffle:** Provide a new set of questions so the retry feels fresh.
2.  **Reset Progress:** Move the `currentQuestionIndex` back to the start of the current difficulty tier (Principiante, Intermedio, or Avanzato).

Because React batches state updates, calling `setShuffleKey(k => k + 1)` and `setCurrentQuestionIndex(levelStartIndex)` within the same `handleWrongAnswer` execution will result in a single render cycle. During this render:
*   `useMemo` detects the change in `shuffleKey` and generates a *new* `questionStack`.
*   `currentQuestionIndex` is updated to the start of the level.
*   The UI displays the *first question of the new shuffle* for that level.

### 3. Stability of Level Indices
The reset logic depends on `beginnerQuiz.number_of_questions` and `intermediateQuiz.number_of_questions`. Since these values are fixed based on the quiz configuration, the "boundaries" between levels remain constant even when the specific questions *within* those boundaries are re-ordered. This ensures that `levelStartIndex` always points to the correct logical starting point regardless of the shuffle.

### 4. Implementation in `handleWrongAnswer`
The `shuffleKey` should be incremented specifically when `attemptsRemaining > 0`. If the game is over, the re-shuffle happens naturally when the user clicks "RIPROVA" (Start Quiz), as `startQuiz` could also reset the `shuffleKey` if needed, although the current implementation already handles a fresh start.

```javascript
const handleWrongAnswer = useCallback(() => {
    setTimerActive(false);
    // ... timer cleanup ...

    setAttemptsRemaining(prev => {
        const newAttempts = prev - 1;
        if (newAttempts <= 0) {
            setStep('gameOver');
            return 0;
        } else {
            // Trigger the re-shuffle via dependency injection
            setShuffleKey(k => k + 1);

            // Determine the start index for the current difficulty tier
            const currentDifficulty = getDifficulty(currentQuestionIndex);
            let levelStartIndex = 0;
            if (currentDifficulty === 'Principiante') {
                levelStartIndex = 0;
            } else if (currentDifficulty === 'Intermedio') {
                levelStartIndex = beginnerQuiz.number_of_questions;
            } else {
                levelStartIndex = beginnerQuiz.number_of_questions + intermediateQuiz.number_of_questions;
            }

            setCurrentQuestionIndex(levelStartIndex);
            return newAttempts;
        }
    });
}, [currentQuestionIndex, beginnerQuiz, intermediateQuiz, getDifficulty]);
```

## Benefits
*   **Reusability:** Leverages existing `shuffleArray` and `useMemo` logic.
*   **Simplicity:** Minimal changes to the component structure.
*   **Player Experience:** Provides a fresh set of questions on each retry within a level.
