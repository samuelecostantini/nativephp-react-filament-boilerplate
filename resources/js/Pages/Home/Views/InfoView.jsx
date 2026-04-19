import React, { useState } from 'react';
import ChevronIcon from "../../../Components/Icons/ChevronIcon.jsx";
import { Document, Page, pdfjs } from 'react-pdf';
import { motion, AnimatePresence } from 'framer-motion';

// Configure pdfjs worker using a static path in public
// Using window.location.origin to ensure absolute URL in all environments (local, shared, native)
pdfjs.GlobalWorkerOptions.workerSrc = `${window.location.origin}/js/pdf.worker.min.js`;

const InfoView = ({ brand, onBack }) => {
    const brandColor = brand.primary_color || '#CE102C';
    const [numPages, setNumPages] = useState(null);
    const [pageNumber, setPageNumber] = useState(1);
    const [direction, setDirection] = useState(0);

    const onDocumentLoadSuccess = ({ numPages }) => {
        setNumPages(numPages);
    };

    const changePage = (offset) => {
        const newPage = pageNumber + offset;
        if (newPage >= 1 && newPage <= numPages) {
            setDirection(offset);
            setPageNumber(newPage);
        }
    };

    const swipeConfidenceThreshold = 10000;
    const swipePower = (offset, velocity) => {
        return Math.abs(offset) * velocity;
    };

    const variants = {
        enter: (direction) => ({
            x: direction > 0 ? 1000 : -1000,
            opacity: 0
        }),
        center: {
            zIndex: 1,
            x: 0,
            opacity: 1
        },
        exit: (direction) => ({
            zIndex: 0,
            x: direction < 0 ? 1000 : -1000,
            opacity: 0
        })
    };

    return (
        <div className="w-full h-full relative overflow-hidden bg-transparent">

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

            {/* PDF Viewer */}
            <div className="w-full h-full pt-[120px] pb-[200px] flex flex-col items-center justify-center">
                {!brand.pdf_url ? (
                    <div className="text-slate-400 text-2xl">Documentazione non disponibile per questo brand.</div>
                ) : (
                    <>
                        <div className="relative w-full h-full flex items-center justify-center overflow-hidden px-10">
                            <Document
                                file={brand.pdf_url}
                                onLoadSuccess={onDocumentLoadSuccess}
                                className="flex justify-center items-center"
                                loading={
                                    <div className="text-slate-400 text-2xl animate-pulse">Caricamento documento...</div>
                                }
                                error={
                                    <div className="text-red-500 text-2xl">Impossibile caricare il documento.</div>
                                }
                            >
                                <AnimatePresence initial={false} custom={direction}>
                                    <motion.div
                                        key={pageNumber}
                                        custom={direction}
                                        variants={variants}
                                        initial="enter"
                                        animate="center"
                                        exit="exit"
                                        transition={{
                                            x: { type: "spring", stiffness: 300, damping: 30 },
                                            opacity: { duration: 0.2 }
                                        }}
                                        drag="x"
                                        dragConstraints={{ left: 0, right: 0 }}
                                        dragElastic={1}
                                        onDragEnd={(e, { offset, velocity }) => {
                                            const swipe = swipePower(offset.x, velocity.x);

                                            if (swipe < -swipeConfidenceThreshold) {
                                                changePage(1);
                                            } else if (swipe > swipeConfidenceThreshold) {
                                                changePage(-1);
                                            }
                                        }}
                                        className="absolute flex items-center justify-center w-full"
                                    >
                                        <Page
                                            pageNumber={pageNumber}
                                            height={1400}
                                            renderTextLayer={false}
                                            renderAnnotationLayer={false}
                                            className="shadow-2xl bg-white rounded-[40px] overflow-hidden"
                                        />
                                    </motion.div>
                                </AnimatePresence>
                            </Document>
                        </div>

                        {/* Page Indicator - Positioned above the global footer logo */}
                        {numPages && (
                            <div
                                className="absolute bottom-40 left-1/2 -translate-x-1/2 flex items-center gap-10 z-50 px-12 py-6 rounded-[30px] shadow-[0px_0px_15px_0px_rgba(0,0,0,0.3)] border border-white/20 backdrop-blur-sm"
                                style={{ backgroundColor: brandColor }}
                            >
                                <button
                                    onClick={() => changePage(-1)}
                                    disabled={pageNumber <= 1}
                                    className="w-16 h-16 rounded-full flex items-center justify-center bg-white shadow-lg disabled:opacity-20 active:scale-90 transition-all group"
                                >
                                    <ChevronIcon className="w-10 h-10 rotate-180 group-active:-translate-x-1 transition-transform" style={{ color: brandColor }} />
                                </button>

                                <div className="text-3xl font-black text-white min-w-[280px] text-center uppercase tracking-tight">
                                    Pagina {pageNumber} <span className="opacity-60 font-normal">di</span> {numPages}
                                </div>

                                <button
                                    onClick={() => changePage(1)}
                                    disabled={pageNumber >= numPages}
                                    className="w-16 h-16 rounded-full flex items-center justify-center bg-white shadow-lg disabled:opacity-20 active:scale-90 transition-all group"
                                >
                                    <ChevronIcon className="w-10 h-10 group-active:translate-x-1 transition-transform" style={{ color: brandColor }} />
                                </button>
                            </div>
                        )}
                    </>
                )}
            </div>
        </div>
    );
};

export default InfoView;
