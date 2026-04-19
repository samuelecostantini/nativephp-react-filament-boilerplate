import React, { useState, useEffect, useMemo, useRef, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ResultView } from "./ResultView.jsx";
import { GameOverView } from "./GameOverView.jsx";
import ChevronIcon from "../../../Components/Icons/ChevronIcon.jsx";

function shuffleArray(quiz, limit) {
    if (!quiz || quiz.length === 0) return [];
    const actualLimit = Math.min(limit, quiz.length);

    let randomNumbers = new Set();
    while (randomNumbers.size < actualLimit) {
        randomNumbers.add(
            Math.floor(Math.random() * quiz.length )
        );
    }
    let questions = [];
    [...randomNumbers].map(number => {
        questions.push(quiz[number]);
    });

    return questions;
}

const QuizView = ({ brand, quizzes, onBack }) => {
    const brandColor = brand.primary_color || '#CE102C';

    const [step, setStep] = useState('start'); // start, question, result, gameOver
    const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);
    const [score, setScore] = useState(0);
    const [selectedAnswerId, setSelectedAnswerId] = useState(null);
    const [showFeedback, setShowFeedback] = useState(false);
    const [attemptsRemaining, setAttemptsRemaining] = useState(3);
    const [shuffleKey, setShuffleKey] = useState(0);
    const [timeRemaining, setTimeRemaining] = useState(0);
    const [timerActive, setTimerActive] = useState(false);
    const timerIntervalRef = useRef(null);

    const beginnerQuiz = useMemo(() => quizzes.find(quiz => quiz.difficulty === 'beginner'), [quizzes]);
    const intermediateQuiz = useMemo(() => quizzes.find(quiz => quiz.difficulty === 'intermedio'), [quizzes]);
    const proQuizzes = useMemo(() => quizzes.filter(quiz => quiz.difficulty === 'pro'), [quizzes]);

    const questionStack = useMemo(() => {
        if (!beginnerQuiz || !intermediateQuiz || proQuizzes.length === 0) return [];

        const begQuestionsRaw = (beginnerQuiz.questions || []).map(q => ({ ...q, timeLimit: beginnerQuiz.time }));
        const intQuestionsRaw = (intermediateQuiz.questions || []).map(q => ({ ...q, timeLimit: intermediateQuiz.time }));

        const selectedProQuiz = proQuizzes[Math.floor(Math.random() * proQuizzes.length)];
        const proQuestionsRaw = (selectedProQuiz.questions || []).map(q => ({ ...q, timeLimit: selectedProQuiz.time }));

        const begQuestions = shuffleArray(begQuestionsRaw, beginnerQuiz.number_of_questions);
        const intQuestions = shuffleArray(intQuestionsRaw, intermediateQuiz.number_of_questions);
        const proQuestions = shuffleArray(proQuestionsRaw, selectedProQuiz.number_of_questions);

        return [...begQuestions, ...intQuestions, ...proQuestions];
    }, [beginnerQuiz, intermediateQuiz, proQuizzes, shuffleKey]);

    const getDifficulty = useCallback((index) => {
        if (!beginnerQuiz || !intermediateQuiz) return '';
        if (index < (beginnerQuiz.number_of_questions || 0)) return 'Principiante';
        if (index < ((beginnerQuiz.number_of_questions || 0) + (intermediateQuiz.number_of_questions || 0))) return 'Intermedio';
        return 'Avanzato';
    }, [beginnerQuiz, intermediateQuiz]);

    const activeLevel = useMemo(() => {
        if (!beginnerQuiz || !intermediateQuiz) return 1;
        if (currentQuestionIndex < beginnerQuiz.number_of_questions) return 1;
        if (currentQuestionIndex < (beginnerQuiz.number_of_questions + intermediateQuiz.number_of_questions)) return 2;
        return 3;
    }, [currentQuestionIndex, beginnerQuiz, intermediateQuiz]);

    const levelsProgress = useMemo(() => {
        if (!beginnerQuiz || !intermediateQuiz) return 0;

        const n1 = beginnerQuiz.number_of_questions;
        const n2 = intermediateQuiz.number_of_questions;

        if (currentQuestionIndex < n1) {
            return (currentQuestionIndex / n1) * 50;
        } else if (currentQuestionIndex < n1 + n2) {
            return 50 + ((currentQuestionIndex - n1) / n2) * 50;
        } else {
            return 100;
        }
    }, [currentQuestionIndex, beginnerQuiz, intermediateQuiz]);

    const currentQuestion = questionStack[currentQuestionIndex];

    const handleWrongAnswer = useCallback(() => {
        setTimerActive(false);

        if (timerIntervalRef.current) {
            clearInterval(timerIntervalRef.current);
            timerIntervalRef.current = null;
        }

        setAttemptsRemaining(prev => {
            const newAttempts = prev - 1;
            if (newAttempts <= 0) {
                setStep('gameOver');
                return 0;
            } else {
                setShuffleKey(k => k + 1);

                let levelStartIndex = 0;
                const currentDifficulty = getDifficulty(currentQuestionIndex);

                if (currentDifficulty === 'Principiante') {
                    levelStartIndex = 0;
                } else if (currentDifficulty === 'Intermedio') {
                    levelStartIndex = beginnerQuiz.number_of_questions;
                } else { // Pro
                    levelStartIndex = beginnerQuiz.number_of_questions + intermediateQuiz.number_of_questions;
                }
                setCurrentQuestionIndex(levelStartIndex);
                return newAttempts;
            }
        });
    }, [currentQuestionIndex, beginnerQuiz, intermediateQuiz, getDifficulty]);

    useEffect(() => {
        if (step === 'question' && timerActive) {
            timerIntervalRef.current = setInterval(() => {
                setTimeRemaining(prev => {
                    if (prev <= 1) {
                        clearInterval(timerIntervalRef.current);
                        handleWrongAnswer();
                        return 0;
                    }
                    return prev - 1;
                });
            }, 1000);
        }

        return () => {
            if (timerIntervalRef.current) {
                clearInterval(timerIntervalRef.current);
            }
        };
    }, [step, timerActive, handleWrongAnswer]);

    useEffect(() => {
        if (step === 'question' && currentQuestion) {
            setTimeRemaining(currentQuestion.timeLimit || 30);
            setTimerActive(true);
        }
    }, [currentQuestionIndex, step, currentQuestion]);

    const handleAnswer = (answer) => {
        if (showFeedback) return;

        setTimerActive(false);
        setSelectedAnswerId(answer.id);
        setShowFeedback(true);

        if (answer.is_correct) {
            setScore(prev => prev + 1);
            setTimeout(() => {
                setShowFeedback(false);
                setSelectedAnswerId(null);

                if (currentQuestionIndex + 1 < questionStack.length) {
                    setCurrentQuestionIndex(prev => prev + 1);
                } else {
                    setStep('result');
                }
            }, 500);
        } else {
            setTimeout(() => {
                setShowFeedback(false);
                setSelectedAnswerId(null);
                handleWrongAnswer();
            }, 1000);
        }
    };

    const startQuiz = () => {
        setCurrentQuestionIndex(0);
        setScore(0);
        setAttemptsRemaining(3);
        setShuffleKey(0);
        setStep('question');
    };

    return (
        <div className="w-full h-full relative overflow-hidden">
            {/* Back Button */}
            <button
                onClick={onBack}
                className="left-[63px] top-[58px] absolute inline-flex items-center gap-4 group active:scale-95 transition-transform z-50"
            >
                <div className="w-12 h-12 relative overflow-hidden">
                    <ChevronIcon
                        className="w-8 h-8 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 rotate-180 font-bold"
                        style={{ color: brandColor }}
                    />
                </div>
                <div className="text-center text-3xl font-semibold " style={{ color: brandColor }}>Indietro</div>
            </button>

            <AnimatePresence mode="wait">
                {step === 'start' && (
                    <motion.div
                        key="start"
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        className="w-full h-full flex flex-col items-center justify-center"
                    >
                        <div className="text-center mb-20">
                            <span className="text-neutral-700 text-6xl font-bold uppercase tracking-tight">GIOCA AL </span>
                            <span className="text-6xl font-bold uppercase tracking-tight" style={{ color: brandColor }}>QUIZ</span>

                            <div
                                className="mt-8 w-[780px] rounded-[28px] border-2 bg-white/90 px-10 py-8 text-left shadow-[0px_10px_30px_rgba(0,0,0,0.08)] backdrop-blur-sm"
                                style={{ borderColor: brandColor }}
                            >
                                <p className="text-2xl font-semibold uppercase tracking-wide" style={{ color: brandColor }}>
                                    Alcune regole prima di iniziare
                                </p>

                                <ul className="mt-6 space-y-5 text-neutral-700 text-2xl font-normal ">
                                    <li className="flex items-start gap-4">
                                        <span
                                            className="mt-1 inline-flex size-9 shrink-0 items-center justify-center rounded-full text-lg font-bold text-white"
                                            style={{ backgroundColor: brandColor }}
                                        >
                                            1
                                        </span>
                                        <span>Hai <strong>3 tentativi</strong> disponibili.</span>
                                    </li>
                                    <li className="flex items-start gap-4">
                                        <span
                                            className="mt-1 inline-flex size-9 shrink-0 items-center justify-center rounded-full text-lg font-bold text-white"
                                            style={{ backgroundColor: brandColor }}
                                        >
                                            2
                                        </span>
                                        <span>Hai un tempo limitato per ogni domanda.</span>
                                    </li>
                                    <li className="flex items-start gap-4">
                                        <span
                                            className="mt-1 inline-flex size-9 shrink-0 items-center justify-center rounded-full text-lg font-bold text-white"
                                            style={{ backgroundColor: brandColor }}
                                        >
                                            3
                                        </span>
                                        <span>Se rispondi in modo errato, ripartirai dall'ultimo livello raggiunto.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button
                            onClick={startQuiz}
                            className="w-[500px] h-32 rounded-[30px] text-white text-4xl font-bold shadow-2xl active:scale-95 transition-transform uppercase tracking-widest"
                            style={{ backgroundColor: brandColor }}
                        >
                            INIZIA ORA
                        </button>
                    </motion.div>
                )}

                {step === 'question' && (
                    <motion.div
                        key="question"
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        className="w-full h-full"
                    >
                        <div className="w-full top-[240px] absolute text-center">
                            <span className="text-neutral-700 text-6xl font-bold uppercase tracking-tight">GIOCA AL </span>
                            <span className="text-6xl font-bold uppercase tracking-tight" style={{ color: brandColor }}>QUIZ</span>
                        </div>

                        {/* Level Indicators */}
                        <div className="w-[469px] h-3 left-1/2 -translate-x-1/2 top-[465px] absolute bg-white rounded-[30px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)] overflow-hidden">
                            <div
                                className="h-3 left-0 top-0 absolute rounded-[30px] transition-all duration-500"
                                style={{ width: `${levelsProgress}%`, backgroundColor: brandColor }}
                            ></div>
                        </div>

                        {/* Dots for levels */}
                        <div className="w-7 h-7 left-[291.5px] top-[456px] absolute rounded-full transition-colors" style={{ backgroundColor: brandColor }}></div>
                        <div className={`w-7 h-7 left-[526px] top-[456px] absolute rounded-full transition-colors`} style={{ backgroundColor: currentQuestionIndex >= (beginnerQuiz?.number_of_questions || 0) ? brandColor : '#d4d4d4' }}></div>
                        <div className={`w-7 h-7 left-[760.5px] top-[456px] absolute rounded-full transition-colors`} style={{ backgroundColor: currentQuestionIndex >= ((beginnerQuiz?.number_of_questions || 0) + (intermediateQuiz?.number_of_questions || 0)) ? brandColor : '#d4d4d4' }}></div>

                        <div className="w-[200px] left-[205px] top-[522px] absolute text-center">
                            <div className={` transition-all ${activeLevel === 1 ? 'text-4xl font-black' : 'text-2xl font-bold text-neutral-700'}`} style={{ color: activeLevel === 1 ? brandColor : undefined }}>Livello 1</div>
                            <div className={` tracking-tight transition-all ${activeLevel === 1 ? 'text-2xl font-bold' : 'text-xl font-light text-neutral-700'}`} style={{ color: activeLevel === 1 ? brandColor : undefined }}>Principiante</div>
                        </div>

                        <div className="w-[200px] left-[440px] top-[522px] absolute text-center">
                            <div className={` transition-all ${activeLevel === 2 ? 'text-4xl font-black' : 'text-2xl font-bold text-neutral-700'}`} style={{ color: activeLevel === 2 ? brandColor : undefined }}>Livello 2</div>
                            <div className={` tracking-tight transition-all ${activeLevel === 2 ? 'text-2xl font-bold' : 'text-xl font-light text-neutral-700'}`} style={{ color: activeLevel === 2 ? brandColor : undefined }}>Intermedio</div>
                        </div>

                        <div className="w-[200px] left-[675px] top-[522px] absolute text-center">
                            <div className={` transition-all ${activeLevel === 3 ? 'text-4xl font-black' : 'text-2xl font-bold text-neutral-700'}`} style={{ color: activeLevel === 3 ? brandColor : undefined }}>Livello 3</div>
                            <div className={` tracking-tight transition-all ${activeLevel === 3 ? 'text-2xl font-bold' : 'text-xl font-light text-neutral-700'}`} style={{ color: activeLevel === 3 ? brandColor : undefined }}>Avanzato</div>
                        </div>

                        {/* Progress Bar and Status */}
                        <div className="left-[154px] top-[706px] absolute text-center justify-start flex items-baseline gap-2">
                            <span className="text-4xl font-bold " style={{ color: brandColor }}>{currentQuestionIndex + 1}</span>
                            <span className="text-black text-2xl font-normal "> di {questionStack.length}</span>
                        </div>
                        <div className="right-[154px] top-[731px] absolute text-right justify-start text-black text-xl font-normal ">
                            {Math.round(((currentQuestionIndex) / questionStack.length) * 100)}% completato
                        </div>

                        <div className="w-[771px] h-6 left-1/2 -translate-x-1/2 top-[765px] absolute bg-white rounded-[30px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)] overflow-hidden">
                             <div
                                className="h-full rounded-[30px] transition-all duration-500"
                                style={{ width: `${((currentQuestionIndex) / questionStack.length) * 100}%`, backgroundColor: brandColor }}
                             ></div>
                        </div>

                        {/* Question Card */}
                        <div className="w-[771px] px-20 py-16 left-1/2 -translate-x-1/2 top-[818px] absolute rounded-[30px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)] flex flex-col justify-start items-start gap-12 overflow-hidden" style={{ backgroundColor: brandColor }}>
                            <div className="w-full justify-start text-white text-4xl font-semibold leading-[1.2]">
                                {currentQuestion.text}
                            </div>
                            <div className="self-stretch flex flex-col justify-start items-start gap-7">
                                {currentQuestion.answers.map((answer) => (
                                    <button
                                        key={answer.id}
                                        onClick={() => handleAnswer(answer)}
                                        disabled={showFeedback}
                                        className={`self-stretch px-16 py-12 bg-white rounded-[20px] inline-flex justify-start items-center active:scale-[0.98] transition-all ${showFeedback && answer.is_correct ? 'ring-8 ring-green-400' : ''} ${showFeedback && !answer.is_correct && selectedAnswerId === answer.id ? 'ring-8 ring-red-400' : ''}`}
                                    >
                                        <div className="justify-start text-4xl font-semibold " style={{ color: brandColor }}>{answer.text}</div>
                                    </button>
                                ))}
                            </div>
                        </div>

                        {/* Timer and Attempts */}
                        <div className="absolute top-[706px] right-[154px] flex items-center gap-4">
                             <div className="text-black text-2xl font-bold tabular-nums">
                                 {String(Math.floor(timeRemaining / 60)).padStart(2, '0')}:{String(timeRemaining % 60).padStart(2, '0')}
                             </div>
                             <div className="flex gap-1">
                                 {[...Array(3)].map((_, i) => (
                                     <div key={i} className={`w-4 h-4 rounded-full ${i < attemptsRemaining ? '' : 'bg-neutral-200'}`} style={{ backgroundColor: i < attemptsRemaining ? brandColor : '#e5e5e5' }}></div>
                                 ))}
                             </div>
                        </div>
                    </motion.div>
                )}

                {step === 'result' && (
                   <ResultView
                       brand={brand}
                       brandColor={brandColor}
                       score={score}
                   />
                )}

                {step === 'gameOver' && (
                    <GameOverView
                        brand={brand}
                        brandColor={brandColor}
                        onHome={onBack}
                    />
                )}
            </AnimatePresence>
        </div>
    );
};

export default QuizView;
