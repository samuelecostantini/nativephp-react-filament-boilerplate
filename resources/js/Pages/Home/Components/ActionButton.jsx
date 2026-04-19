import React from 'react';
import ChevronIcon from '../../../Components/Icons/ChevronIcon';

/**
 * Main Action Button in Dashboard
 */
const ActionButton = ({ title, subtitle, onClick, icon, color }) => {
    return (
        <button
            onClick={onClick}
            className="group relative overflow-hidden rounded-[2.5vw] p-[1.5vw] transition-all duration-500 transform hover:scale-[1.02] active:scale-[0.98] bg-white border border-slate-100 shadow-xl hover:shadow-2xl flex items-center gap-[2vw] w-full min-h-[10vh] text-left"
        >
            <div
                className="flex-shrink-0 w-[6vw] h-[6vw] rounded-[1.2vw] flex items-center justify-center text-white shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500"
                style={{ backgroundColor: color }}
            >
                {React.cloneElement(icon, { className: "w-[3vw] h-[3vw]" })}
            </div>
            <div className="flex flex-col">
                <span className="text-slate-900 text-[1.8vw] font-black uppercase tracking-tight group-hover:translate-x-1 transition-transform duration-300">
                    {title}
                </span>
                {subtitle && (
                    <span className="text-slate-400 text-[0.8vw] font-bold mt-[0.5vh] uppercase tracking-widest">
                        {subtitle}
                    </span>
                )}
            </div>
            <div className="ml-auto opacity-20 group-hover:opacity-100 group-hover:translate-x-2 transition-all duration-300">
                <ChevronIcon className="w-[2vw] h-[2vw] text-slate-300" />
            </div>
        </button>
    );
};

export default ActionButton;
