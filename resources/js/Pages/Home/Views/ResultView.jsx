import React, { useEffect } from 'react';
import { useForm } from '@inertiajs/react';
import { motion } from 'framer-motion';

export function ResultView({ brand, brandColor, score }) {
    const { data, setData, post, processing, errors } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        quiz_result_score: score,
        privacy_consent: false,
    });

    const [validationErrors, setValidationErrors] = React.useState({});
    const [touched, setTouched] = React.useState({});

    useEffect(() => {
        setData('quiz_result_score', score);
    }, [score]);

    const validateField = (name, value) => {
        if (name === 'first_name') {
            return !value.trim() ? 'Il nome è obbligatorio' : '';
        }
        if (name === 'last_name') {
            return !value.trim() ? 'Il cognome è obbligatorio' : '';
        }
        if (name === 'email') {
            if (!value.trim()) return "L'email è obbligatoria";
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return "Inserisci un'email valida";
            return '';
        }
        if (name === 'privacy_consent') {
            return !value ? "Devi accettare per continuare" : '';
        }
        return '';
    };

    const handleFieldChange = (name, value) => {
        setData(name, value);
        if (touched[name]) {
            const error = validateField(name, value);
            setValidationErrors(prev => ({
                ...prev,
                [name]: error
            }));
        }
    };

    const handleBlur = (name, value) => {
        setTouched(prev => ({ ...prev, [name]: true }));
        const error = validateField(name, value);
        setValidationErrors(prev => ({
            ...prev,
            [name]: error
        }));
    };

    const validateForm = () => {
        const newErrors = {};
        const fields = ['first_name', 'last_name', 'email', 'privacy_consent'];

        fields.forEach(field => {
            const error = validateField(field, data[field]);
            if (error) {
                newErrors[field] = error;
            }
        });

        setValidationErrors(newErrors);
        setTouched({ first_name: true, last_name: true, email: true, privacy_consent: true });
        return Object.keys(newErrors).length === 0;
    };

    const handleSubmitLead = (e) => {
        if (e) e.preventDefault();

        if (!validateForm()) {
            return;
        }

        post(`/brand/${brand.slug}/quiz/lead`, {
            preserveState: true,
        });
    };

    return (
        <motion.div
            key="result"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            className="w-full h-full"
        >
            <div
                className="w-[771px] h-[1000px] px-20 py-16 left-1/2 -translate-x-1/2 top-[450px] absolute bg-white rounded-[30px] shadow-[0px_0px_100px_-40px_rgba(206,16,44,1.00)] inline-flex flex-col justify-start items-center gap-11 overflow-hidden"
                style={{ boxShadow: `0px 0px 100px -40px ${brandColor}` }}
            >
                <form onSubmit={handleSubmitLead} className="self-stretch p-12 bg-gray-50 rounded-[30px] flex flex-col justify-start items-start gap-8">
                    <div className="space-y-4 w-full">
                        <label className="justify-start text-black text-2xl font-semibold block ml-2">Nome</label>
                        <input
                            type="text"
                            required
                            placeholder="Inserisci il tuo nome"
                            className={`w-full h-24 bg-white rounded-2xl shadow-[0px_0px_2px_0px_rgba(0,0,0,0.25)] px-8 text-2xl font-bold outline-none focus:ring-4 transition-all ${validationErrors.first_name || errors.first_name ? 'ring-4 ring-red-500' : ''}`}
                            style={{ '--tw-ring-color': `${brandColor}33` }}
                            value={data.first_name}
                            onChange={e => handleFieldChange('first_name', e.target.value)}
                            onBlur={() => handleBlur('first_name', data.first_name)}
                        />
                        {(validationErrors.first_name || errors.first_name) && <div className="text-red-500 text-sm ml-2">{validationErrors.first_name || errors.first_name}</div>}
                    </div>
                    <div className="space-y-4 w-full">
                        <label className="justify-start text-black text-2xl font-semibold block ml-2">Cognome</label>
                        <input
                            type="text"
                            required
                            placeholder="Inserisci il tuo cognome"
                            className={`w-full h-24 bg-white rounded-2xl shadow-[0px_0px_2px_0px_rgba(0,0,0,0.25)] px-8 text-2xl font-bold outline-none focus:ring-4 transition-all ${validationErrors.last_name || errors.last_name ? 'ring-4 ring-red-500' : ''}`}
                            style={{ '--tw-ring-color': `${brandColor}33` }}
                            value={data.last_name}
                            onChange={e => handleFieldChange('last_name', e.target.value)}
                            onBlur={() => handleBlur('last_name', data.last_name)}
                        />
                        {(validationErrors.last_name || errors.last_name) && <div className="text-red-500 text-sm ml-2">{validationErrors.last_name || errors.last_name}</div>}
                    </div>
                    <div className="space-y-4 w-full">
                        <label className="justify-start text-black text-2xl font-semibold block ml-2">Email</label>
                        <input
                            type="email"
                            required
                            placeholder="Inserisci la tua email"
                            className={`w-full h-24 bg-white rounded-2xl shadow-[0px_0px_2px_0px_rgba(0,0,0,0.25)] px-8 text-2xl font-bold outline-none focus:ring-4 transition-all ${validationErrors.email || errors.email ? 'ring-4 ring-red-500' : ''}`}
                            style={{ '--tw-ring-color': `${brandColor}33` }}
                            value={data.email}
                            onChange={e => handleFieldChange('email', e.target.value)}
                            onBlur={() => handleBlur('email', data.email)}
                        />
                        {(validationErrors.email || errors.email) && <div className="text-red-500 text-sm ml-2">{validationErrors.email || errors.email}</div>}
                    </div>

                    <div className="w-full">
                        <div className="flex items-start gap-4 mt-4 select-none cursor-pointer" onClick={() => {
                            setTouched(prev => ({ ...prev, privacy_consent: true }));
                            const newValue = !data.privacy_consent;
                            setData('privacy_consent', newValue);
                            const error = validateField('privacy_consent', newValue);
                            setValidationErrors(prev => ({
                                ...prev,
                                privacy_consent: error
                            }));
                        }}>
                            <div
                                className={`w-10 h-10 rounded-lg border-2 flex items-center justify-center transition-all shrink-0 mt-1`}
                                style={{
                                    borderColor: brandColor,
                                    backgroundColor: data.privacy_consent ? brandColor : 'white'
                                }}
                            >
                                {data.privacy_consent && (
                                    <svg className="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                )}
                            </div>
                            <span className="text-neutral-700 text-md font-medium leading-tight">
                                Accetto l'<span className="underline">informativa
                                privacy</span> di Ariston S.p.A. relativa al trattamento dei dati personali
                                ai sensi del regolamento (UE) 2016/679 ("GDPR") resa disponibile nel corso della mia
                                partecipazione all'evento Ariston on tour 2025
                            </span>
                        </div>
                        {(validationErrors.privacy_consent || errors.privacy_consent) && (
                            <div className="text-red-500 text-sm ml-14 mt-2">
                                {validationErrors.privacy_consent || errors.privacy_consent}
                            </div>
                        )}
                    </div>
                </form>
            </div>

            <button
                onClick={handleSubmitLead}
                disabled={processing}
                className="px-24 py-10 left-1/2 -translate-x-1/2 top-[1480px] absolute rounded-2xl shadow-[0px_0px_2px_0px_rgba(0,0,0,0.25)] inline-flex justify-center items-center overflow-hidden active:scale-95 transition-transform disabled:opacity-50"
                style={{ backgroundColor: brandColor }}
            >
                <div className="justify-start text-white text-3xl font-semibold uppercase tracking-widest">
                    {processing ? 'INVIO...' : 'INVIA'}
                </div>
            </button>
        </motion.div>
    );
}
