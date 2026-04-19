import React from 'react';
import ChevronIcon from '../../../Components/Icons/ChevronIcon';
import DocumentText from "../../../Components/Icons/DocumentText.jsx";
import ComputerDesktop from "../../../Components/Icons/ComputerDesktop.jsx";
import PlayCircle from "../../../Components/Icons/PlayCircle.jsx";

const DashboardView = ({ brand, onNavigate, onBack }) => {

    const brandColor = brand.primary_color || '#CE102C';
    const dashboardLogoUrl = brand.colored_logo_url || brand.logo_url;

    return (
        <div className="w-full h-full relative overflow-hidden">
            <div className="w-full top-[600px] absolute text-center text-neutral-700 text-4xl font-normal  uppercase tracking-tight">SCEGLI LA TUA PROSSIMA ATTIVITÀ</div>

            {/* Documentation Button */}
            <button
                onClick={() => onNavigate('info')}
                className="w-[771px] px-12 py-16 left-1/2 -translate-x-1/2 top-[737px] absolute rounded-[30px] inline-flex justify-between items-center overflow-hidden active:scale-95 transition-transform shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)]"
                style={{ backgroundColor: brandColor }}
            >
                <div className="flex justify-start items-center gap-6">
                    <div className="w-12 h-12 relative overflow-hidden">
                        <DocumentText className={"w-full h-full text-white"}/>
                    </div>
                    <div className="text-left text-white text-3xl font-normal uppercase tracking-wide">APPROFONDISCI IL MONDO INCENTIVI!</div>
                </div>
                <div className="w-20 h-20 relative overflow-hidden">
                    <ChevronIcon className="text-white w-12 h-12 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 font-bold" />
                </div>
            </button>

            {/* Simulator Button */}
            <button
                onClick={() => onNavigate('simulator')}
                className="w-[771px] px-12 py-16 left-1/2 -translate-x-1/2 top-[1001px] absolute rounded-[30px] inline-flex justify-between items-center overflow-hidden active:scale-95 transition-transform shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)]"
                style={{ backgroundColor: brandColor }}
            >
                <div className="flex justify-start items-center gap-6">
                    <div className="w-12 h-12 relative overflow-hidden">
                        <ComputerDesktop className={"w-full h-full text-white"}/>
                    </div>
                    <div className="text-left text-white text-3xl font-normal uppercase tracking-wide">Scopri gli incentivi!</div>
                </div>
                <div className="w-20 h-20 relative overflow-hidden">
                    <ChevronIcon className="text-white w-12 h-12 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 font-bold" />
                </div>
            </button>

            {/* Quiz Button */}
            <button
                onClick={() => onNavigate('quiz')}
                className="w-[771px] px-12 py-16 left-1/2 -translate-x-1/2 top-[1265px] absolute rounded-[30px] inline-flex justify-between items-center overflow-hidden active:scale-95 transition-transform shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)]"
                style={{ backgroundColor: brandColor }}
            >
                <div className="flex justify-start items-center gap-6">
                    <div className="w-12 h-12 relative overflow-hidden">
                        <PlayCircle className={"w-full h-full text-white"}/>
                    </div>
                    <div className="text-left text-white text-3xl font-normal uppercase tracking-wide">Gioca sul mondo incentivi!</div>
                </div>
                <div className="w-20 h-20 relative overflow-hidden">
                    <ChevronIcon className="text-white w-12 h-12 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 font-bold" />
                </div>
            </button>

            {/* Brand Logo Header */}
            <div className="w-96 h-24 left-1/2 -translate-x-1/2 top-[240px] absolute flex items-center justify-center">
                {dashboardLogoUrl ? (
                    <img src={dashboardLogoUrl} alt={brand.name} className="w-[800px] h-auto" />
                ) : (
                    <div className="text-5xl font-black" style={{ color: brandColor }}>{brand.name}</div>
                )}
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

export default DashboardView;
