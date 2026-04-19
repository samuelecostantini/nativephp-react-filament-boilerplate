import React from 'react';
import ChevronIcon from "../../../Components/Icons/ChevronIcon.jsx";

const SelectionView = ({ brands, onSelectBrand }) => {
    // Mapping brands to their specific styles/positions based on design
    const brandStyles = [
        { top: 'top-[725px]', bg: 'bg-rose-700' },
        { top: 'top-[991px]', bg: 'bg-sky-900' },
        { top: 'top-[1257px]', bg: 'bg-neutral-500' },
    ];

    //console.log(getNativePath('something'))

    return (
        <div className="w-full h-full relative overflow-hidden">
            <div className="w-full top-[240px] absolute text-center">
                <span className="text-neutral-700 text-7xl font-bold  leading-[76px]"></span>
                <span className="text-black text-7xl font-bold  leading-[76px]"> </span>
                <span className="text-rose-700 text-7xl font-bold  leading-[76px]">CONTO TERMICO 3.0</span>
            </div>

            {brands.map((brand, index) => {
                const style = brandStyles[index] || brandStyles[0];
                return (
                    <button
                        key={brand.slug}
                        onClick={() => onSelectBrand(brand)}
                        className={`w-[760px] h-60 px-14 py-16 left-1/2 -translate-x-1/2 ${style.top} absolute rounded-[30px] inline-flex justify-between items-center overflow-hidden active:scale-95 transition-transform`}
                        style={{backgroundColor: brand.primary_color}}
                    >
                        {brand.logo_url ? (
                            <img className="w-auto h-24 max-w-[400px] object-contain" src={brand.logo_url} alt={brand.name} />
                        ) : (
                            <div className="text-white text-6xl font-bold">{brand.name}</div>
                        )}
                        <div className="w-20 h-20 relative overflow-hidden">
                            <ChevronIcon className="text-white w-12 h-12 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 font-bold" />
                        </div>
                    </button>
                );
            })}

            <div className="w-full top-[600px] absolute text-center text-neutral-700 text-4xl font-normal  uppercase tracking-tight">SCEGLI IL BRAND</div>
        </div>
    );
};

export default SelectionView;
