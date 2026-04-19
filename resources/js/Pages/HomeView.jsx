import React from 'react';
import { Head } from '@inertiajs/react';

/**
 * Boilerplate Welcome Page
 *
 * This is the starter page for your NativePHP + Filament + React application.
 * Replace this content with your project-specific components.
 */
export default function HomeView() {
    return (
        <>
            <Head title="Welcome" />

            <div className="nativephp-safe-area min-h-screen flex items-center justify-center p-8">
                <div className="max-w-2xl w-full text-center">
                    {/* Title */}
                    <h1 className="text-5xl font-bold mb-4 tracking-tight">
                        Nativephp+React+Filament Boilerplate
                    </h1>

                    {/* Subtitle */}
                    <p className="text-xl mb-8">
                        A powerful boilerplate for building mobile-first applications
                        with embedded PHP and modern React.
                    </p>

                    {/* Stack Pills */}
                    <div className="flex flex-wrap justify-center gap-3 mb-12">
                        <span className="px-4 py-2 rounded-full border text-sm font-medium">
                            Laravel 12
                        </span>
                        <span className="px-4 py-2 rounded-full border text-sm font-medium">
                            NativePHP v3
                        </span>
                        <span className="px-4 py-2 rounded-full border text-sm font-medium">
                            Filament v5
                        </span>
                        <span className="px-4 py-2 rounded-full border text-sm font-medium">
                            React 19
                        </span>
                        <span className="px-4 py-2 rounded-full border text-sm font-medium">
                            Tailwind v4
                        </span>
                        <span className="px-4 py-2 rounded-full border text-sm font-medium">
                            Inertia v2
                        </span>
                    </div>

                    {/* CTA Buttons */}
                    <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a
                            href="/admin"
                            className="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-colors"
                        >
                            Open Admin Panel
                        </a>

                        <a
                            href="https://nativephp.com"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-colors border"
                        >
                            NativePHP Docs
                        </a>
                    </div>

                    {/* Footer */}
                    <div className="mt-16 pt-8 border-t">
                        <p className="text-sm">
                            Edit this page in{' '}
                            <code className="px-2 py-1 rounded text-xs">
                                resources/js/Pages/HomeView.jsx
                            </code>
                        </p>
                    </div>
                </div>
            </div>
        </>
    );
}
