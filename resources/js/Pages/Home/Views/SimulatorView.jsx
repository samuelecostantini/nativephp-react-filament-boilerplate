import React from 'react';
import ChevronIcon from "../../../Components/Icons/ChevronIcon.jsx";

const SimulatorView = ({ brand, onBack }) => {
    const brandColor = brand.primary_color || '#CE102C';

    return (
        <div className="w-full h-full relative overflow-hidden">

            {/* Browser Address Bar */}
            <div className="w-227.75 h-14 left-1/2 -translate-x-1/2 top-114 absolute bg-white rounded-[100px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)] flex items-center justify-center">
                 <div className="text-center text-black text-xl font-normal ">{brand.simulator_url}</div>
            </div>

            {/* Iframe Container */}
            <div className="w-227.75 h-300 left-1/2 -translate-x-1/2 top-132.75 absolute rounded-[40px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)] overflow-hidden bg-white">
                <iframe
                    className="w-full h-full border-none"
                    src={brand.simulator_url}
                    title="Contenuto Esterno"
                    loading="lazy"
                    allowFullScreen
                />
            </div>

            {/* Header Title */}
            <div className="w-full top-[240px] absolute text-center">
                <span className="text-neutral-700 text-6xl font-bold  uppercase tracking-tight">SCOPRI IL </span>
                <span className="text-6xl font-bold  uppercase tracking-tight" style={{ color: brandColor }}>SIMULATORE</span>
            </div>

            {/* Back Button */}
            <button
                onClick={onBack}
                className="left-[63px] top-[58px] absolute inline-flex items-center gap-4 group active:scale-95 transition-transform"
            >
                <div className="w-12 h-12 relative overflow-hidden">
                    <ChevronIcon
                        className="w-8 h-8 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 rotate-180 font-bold"
                        style={{ color: brandColor }}
                    />
                </div>
                <div className="text-center text-3xl font-semibold " style={{ color: brandColor }}>Indietro</div>
            </button>
        </div>
    );
};

export default SimulatorView;
