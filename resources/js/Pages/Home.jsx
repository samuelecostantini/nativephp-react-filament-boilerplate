import React, { useState, useEffect, useMemo } from 'react';
import {Head, Link, router} from '@inertiajs/react';
import { motion, AnimatePresence } from 'framer-motion';

// --- Views ---
import SelectionView from './Home/Views/SelectionView';
import DashboardView from './Home/Views/DashboardView';
import InfoView from './Home/Views/InfoView';
import SimulatorView from './Home/Views/SimulatorView';
import QuizView from './Home/Views/QuizView';

/**
 * Main Page Component
 */
export default function Home({brands, quizzes, initialBrandSlug = null, initialView = 'selection' }) {
    // Initial State based on props
    const [view, setView] = useState(initialView); // selection, dashboard, info, simulator, quiz
    const [clicks, setClicks] = useState(0);
    const [lastClick, setLastClick] = useState(null)
    const [selectedBrand, setSelectedBrand] = useState(() => {
        if (initialBrandSlug) {
            return brands.find(b => b.slug === initialBrandSlug);
        }
        return null;
    });

    // Responsive Scaling Logic (ViewPort aware)
    const [scale, setScale] = useState(1);
    useEffect(() => {
        const handleResize = () => {
            const targetWidth = 1080;
            const targetHeight = 1920;

            // Get actual viewport dimensions
            const vw = window.innerWidth;
            const vh = window.innerHeight;

            const widthScale = vw / targetWidth;
            const heightScale = vh / targetHeight;

            // Use the smaller scale to ensure the 1080x1920 content fits entirely
            setScale(Math.min(widthScale, heightScale));
        };

        handleResize();
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    // Handle initial state if URL change detected via Inertia visit
    useEffect(() => {
        console.log(initialBrandSlug)
        if (initialBrandSlug) {
            const brand = brands.find(b => b.slug === initialBrandSlug);
            setSelectedBrand(brand);
            setView(initialView);
            handleBrandSelect(brand)
        } else {
            setSelectedBrand(null);
            setView('selection');
        }
    }, [initialBrandSlug, initialView, brands]);

    // Handle History/URLs for Kiosk behavior
    const navigateTo = (newView, brand = selectedBrand) => {
        setView(newView);
        if (brand) {
            setSelectedBrand(brand);
        }
    };

    const handleBack = () => {
        if (view === 'dashboard') {
            setView('selection');
            setSelectedBrand(null);
        } else {
            setView('dashboard');
        }
    };

    const handleBrandSelect = (brand) => {
        setSelectedBrand(brand);
        setView('dashboard');
    };

    // Derived theme color
    const themeColor = useMemo(() => {
        if (view === 'selection') {
            return '#be123c'; // Rose-700
        }
        return selectedBrand?.primary_color || '#be123c';
    }, [view, selectedBrand]);

    const easterEgg = () => {
        const now = Date.now();
        let newClicks = clicks;

        if (lastClick && (now - lastClick > 10000)) {
            newClicks = 0;
        }

        if (newClicks < 10) {
            setClicks(newClicks + 1);
            setLastClick(now);
        } else {
            window.location.href = '/admin';
        }
    };
    return (
        <div className="fixed inset-0 flex items-center justify-center overflow-hidden touch-none select-none">
            <Head title={view === 'selection' ? 'Benvenuto - Totem Ariston' : `${selectedBrand?.name} - Experience`} />

            {/* Global Dynamic Background - Stretches to fill WHOLE screen */}
            <div className="absolute inset-0 pointer-events-none z-0">
                <AnimatePresence>
                    <motion.div
                        key={themeColor}
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 0.05 }}
                        exit={{ opacity: 0 }}
                        transition={{ duration: 0.2 }}
                        className="absolute inset-0"
                        style={{ backgroundColor: themeColor }}
                    />
                </AnimatePresence>
                <div className="absolute inset-0 opacity-[0.03]" style={{ backgroundImage: 'radial-gradient(#000 1px, transparent 0)', backgroundSize: '40px 40px' }}></div>
            </div>

            {/* Scaled Content Wrapper */}
            <div
                className="relative flex flex-col overflow-hidden origin-center shrink-0"
                style={{
                    width: '1080px',
                    height: '1920px',
                    transform: `scale(${scale})`,
                    willChange: 'transform',
                }}
            >
                {/* Global Top Bar Overlay */}
                <div
                    className="w-[953px] h-10 left-1/2 -translate-x-1/2 top-0 absolute rounded-bl-[20px] rounded-br-[20px] z-50 pointer-events-none"
                    style={{ backgroundColor: themeColor }}
                ></div>

                <div className="relative z-10 w-full h-full flex flex-col overflow-hidden">
                    <AnimatePresence mode="wait">
                        {view === 'selection' && (
                            <motion.div
                                key="selection"
                                initial={{ opacity: 0, scale: 0.98 }}
                                animate={{ opacity: 1, scale: 1 }}
                                exit={{ opacity: 0, scale: 1.02, y: -20 }}
                                transition={{ duration: 0.25, ease: [0.25, 0.46, 0.45, 0.94] }}
                                className="h-full"
                            >
                                <SelectionView brands={brands} onSelectBrand={handleBrandSelect} />
                            </motion.div>
                        )}

                        {view === 'dashboard' && selectedBrand && (
                            <motion.div
                                key={`dashboard-${selectedBrand.slug}`}
                                initial={{ opacity: 0, scale: 1.05, y: 30 }}
                                animate={{ opacity: 1, scale: 1, y: 0 }}
                                exit={{ opacity: 0, scale: 0.95, y: -30 }}
                                transition={{ duration: 0.25, ease: [0.25, 0.46, 0.45, 0.94] }}
                                className="h-full"
                            >
                                <DashboardView brand={selectedBrand} onNavigate={navigateTo} onBack={handleBack} />
                            </motion.div>
                        )}

                        {view === 'info' && selectedBrand && (
                            <motion.div
                                key={`info-${selectedBrand.slug}`}
                                initial={{ opacity: 0, x: 100 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -100 }}
                                transition={{ duration: 0.25, ease: [0.25, 0.46, 0.45, 0.94] }}
                                className="h-full"
                            >
                                <InfoView brand={selectedBrand} onBack={handleBack} />
                            </motion.div>
                        )}

                        {view === 'simulator' && selectedBrand && (
                            <motion.div
                                key={`simulator-${selectedBrand.slug}`}
                                initial={{ opacity: 0, y: 100 }}
                                animate={{ opacity: 1, y: 0 }}
                                exit={{ opacity: 0, y: -100 }}
                                transition={{ duration: 0.25, ease: [0.25, 0.46, 0.45, 0.94] }}
                                className="h-full"
                            >
                                <SimulatorView brand={selectedBrand} onBack={handleBack} />
                            </motion.div>
                        )}

                        {view === 'quiz' && selectedBrand && (
                            <motion.div
                                key={`quiz-${selectedBrand.slug}`}
                                initial={{ opacity: 0, scale: 0.95, y: 20 }}
                                animate={{ opacity: 1, scale: 1, y: 0 }}
                                exit={{ opacity: 0, scale: 0.95, y: -20 }}
                                transition={{ duration: 0.25, ease: [0.25, 0.46, 0.45, 0.94] }}
                                className="h-full"
                            >
                                <QuizView
                                    brand={selectedBrand}
                                    quizzes={quizzes}
                                    onBack={handleBack}
                                />
                            </motion.div>
                        )}
                    </AnimatePresence>

                    {/* Global Persistent Footer */}
                    <footer className="absolute bottom-12 left-0 w-full pointer-events-none flex flex-col items-center justify-center gap-8">
                        <div className="pointer-events-auto flex flex-col items-center gap-8">
                            {/* Persistent Ariston Logo */}
                            <button onClick={easterEgg}>
                                <img
                                    src="/images/ariston-group.svg"
                                    className="w-60 h-16 object-contain"
                                    alt="Ariston Logo"
                                />
                            </button>
                        </div>
                    </footer>
                </div>
            </div>

            {/* Screen Safe-Area Class */}
            <div className="nativephp-safe-area"></div>
        </div>
    );
}
