import React from 'react';
import { Head } from '@inertiajs/react';

/**
 * Boilerplate Welcome Page
 *
 * This is the starter page for your NativePHP + Filament + React application.
 * Replace this content with your project-specific components.
 */
export default function HomeView() {
    const techStack = [
        { name: 'Laravel 12', color: 'from-red-500 to-orange-600' },
        { name: 'NativePHP v3', color: 'from-purple-500 to-indigo-600' },
        { name: 'Filament v5', color: 'from-amber-500 to-yellow-600' },
        { name: 'React 19', color: 'from-cyan-500 to-blue-600' },
        { name: 'Tailwind v4', color: 'from-emerald-500 to-teal-600' },
        { name: 'Inertia v2', color: 'from-pink-500 to-rose-600' },
    ];

    return (
        <>
            <Head title="Welcome" />

            <div className="nativephp-safe-area min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 flex items-center justify-center p-6">
                {/* Background decoration */}
                <div className="fixed inset-0 overflow-hidden pointer-events-none">
                    <div className="absolute -top-1/2 -right-1/2 w-full h-full bg-gradient-to-bl from-indigo-100/50 via-purple-100/30 to-transparent dark:from-indigo-950/20 dark:via-purple-950/10 rounded-full blur-3xl" />
                    <div className="absolute -bottom-1/2 -left-1/2 w-full h-full bg-gradient-to-tr from-cyan-100/50 via-blue-100/30 to-transparent dark:from-cyan-950/20 dark:via-blue-950/10 rounded-full blur-3xl" />
                </div>

                <div className="relative max-w-3xl w-full">
                    {/* Main card */}
                    <div className="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-slate-200/50 dark:shadow-slate-950/50 border border-white/20 dark:border-slate-800/50 p-8 sm:p-12">
                        {/* Title */}
                        <div className="text-center mb-8">
                            <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 text-sm font-medium mb-6">
                                <span className="w-2 h-2 rounded-full bg-indigo-500 animate-pulse" />
                                Now Available
                            </div>
                            <h1 className="text-4xl sm:text-6xl font-bold bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 dark:from-white dark:via-indigo-300 dark:to-white bg-clip-text text-transparent tracking-tight leading-tight">
                                NativePHP + React + Filament
                            </h1>
                            <p className="text-xl sm:text-2xl font-semibold text-slate-700 dark:text-slate-300 mt-4">
                                Boilerplate
                            </p>
                        </div>

                        {/* Subtitle */}
                        <p className="text-center text-slate-600 dark:text-slate-400 text-lg leading-relaxed max-w-xl mx-auto mb-10">
                            A powerful boilerplate for building mobile-first applications
                            with embedded PHP and modern React.
                        </p>

                        {/* Tech Stack Grid */}
                        <div className="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-10">
                            {techStack.map((tech) => (
                                <div
                                    key={tech.name}
                                    className="group relative overflow-hidden rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/10"
                                >
                                    <div className={`absolute inset-0 bg-gradient-to-br ${tech.color} opacity-0 group-hover:opacity-10 transition-opacity duration-300`} />
                                    <div className="relative px-4 py-3 text-center">
                                        <span className="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                            {tech.name}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* CTA Buttons */}
                        <div className="flex flex-col sm:flex-row items-center justify-center gap-4 mb-10">
                            <a
                                href="/admin"
                                className="group relative w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 transition-all duration-300 hover:-translate-y-0.5"
                            >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Open Admin Panel
                            </a>

                            <a
                                href="https://nativephp.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="group w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all duration-300"
                            >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Documentation
                                <svg className="w-4 h-4 ml-1 opacity-50 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>

                        {/* Footer */}
                        <div className="pt-8 border-t border-slate-200 dark:border-slate-800">
                            <p className="text-center text-slate-500 dark:text-slate-500 text-sm">
                                Edit this page in{' '}
                                <code className="px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-mono text-xs">
                                    resources/js/Pages/HomeView.jsx
                                </code>
                            </p>
                        </div>
                    </div>

                    {/* Bottom text */}
                    <p className="text-center text-slate-400 dark:text-slate-600 text-xs mt-6">
                        Built with ❤️ using NativePHP
                    </p>
                </div>
            </div>
        </>
    );
}
