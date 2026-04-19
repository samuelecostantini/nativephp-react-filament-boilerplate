import React from 'react';
import { motion } from 'framer-motion';

export function GameOverView({ brand, brandColor, onHome }) {
    return (
        <motion.div
            key="gameOver"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            className="w-full h-full flex flex-col items-center justify-center bg-white px-20 text-center"
        >
            <div className="mb-12 relative">
                {/* Decorative element */}
                <motion.div 
                    initial={{ scale: 0 }}
                    animate={{ scale: 1 }}
                    transition={{ delay: 0.2, type: "spring" }}
                    className="w-40 h-40 rounded-full flex items-center justify-center mb-8 mx-auto"
                    style={{ backgroundColor: `${brandColor}15` }}
                >
                    <svg className="w-20 h-20" style={{ color: brandColor }} fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </motion.div>

                <h2 className="text-8xl font-black mb-6 uppercase tracking-tighter text-slate-900 leading-none">
                    TENTATIVI <br />
                    <span style={{ color: brandColor }}>ESAURITI</span>
                </h2>
                
                <p className="text-3xl text-neutral-500 font-medium max-w-2xl mx-auto mb-16 leading-relaxed">
                    Hai terminato i tuoi tentativi a disposizione. <br />
                    Torna alla home per esplorare gli altri contenuti.
                </p>
            </div>

            <button
                onClick={onHome}
                className="w-[600px] h-32 rounded-[30px] text-white text-4xl font-bold shadow-2xl active:scale-95 transition-transform uppercase tracking-widest"
                style={{ backgroundColor: brandColor }}
            >
                TORNA ALLA HOME
            </button>
            
            {/* Subtle brand logo or name at bottom */}
            <div className="mt-20 opacity-30">
                <span className="text-2xl font-bold uppercase tracking-widest">{brand.name}</span>
            </div>
        </motion.div>
    );
}
