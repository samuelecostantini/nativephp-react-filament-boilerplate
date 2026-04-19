import React from 'react';
import { motion } from 'framer-motion';
import ChevronIcon from '../../../Components/Icons/ChevronIcon';

/**
 * Brand Selection Card
 */
const BrandCard = ({ name, slug, primary_color, logo_url, colored_logo_url, onSelect, pdf_path }) => {
    console.log('Rendering BrandCard:', { name, slug, primary_color, logo_url, colored_logo_url, pdf_path });
    return (
        <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.98 }}
            className="group w-full max-w-[28vw]"
        >
            <button
                onClick={() => onSelect()}
                className="w-full aspect-[4/5] relative flex flex-col items-center justify-center p-[2.5vw] transition-all duration-500 rounded-[3vw] shadow-xl hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] overflow-hidden bg-white border border-slate-100"
            >
                {/* Dynamic background glow */}
                <div
                    className="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity duration-700 blur-[5vw]"
                    style={{ backgroundColor: primary_color || '#E30613' }}
                ></div>

                <div className="relative z-10 flex flex-col items-center gap-[2vw] text-center w-full">
                    <motion.div
                        className="bg-slate-50 p-[1.5vw] rounded-[2vw] shadow-inner w-[12vw] h-[12vw] flex items-center justify-center border border-slate-100"
                        whileHover={{ rotate: [0, -5, 5, 0] }}
                        transition={{ duration: 0.5 }}
                    >
                        {logo_url ? (
                            <img src={logo_url} alt={name} className="max-h-full max-w-full object-contain" />
                        ) : (
                            <span className="text-[4vw] font-black italic tracking-tighter" style={{ color: primary_color }}>
                                {name.charAt(0)}
                            </span>
                        )}
                    </motion.div>

                    <div className="space-y-[1.5vh] w-full">
                        <h2 className="text-slate-900 text-[2.5vw] font-black tracking-tight uppercase truncate w-full px-[0.5vw]">
                            {name}
                        </h2>
                        <div
                            className="inline-flex items-center gap-[0.8vw] text-white font-black text-[1vw] px-[2vw] py-[1.2vh] rounded-full shadow-lg transition-all duration-300 group-hover:px-[2.5vw]"
                            style={{ backgroundColor: primary_color || '#E30613' }}
                        >
                            INIZIA ORA
                            <ChevronIcon className="w-[1.2vw] h-[1.2vw] transition-transform group-hover:translate-x-1" />
                        </div>
                    </div>
                </div>
            </button>
        </motion.div>
    );
};

export default BrandCard;
