import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import './bootstrap';

createInertiaApp({
    id: 'totem-ariston',

    // Using Laravel's helper for automatic code-splitting/lazy-loading
    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.jsx`,
        import.meta.glob('./Pages/**/*.jsx')
    ),

    setup({ el, App, props }) {
        createRoot(el).render(<App
            {...props} />);
    },

    defaults: {
        form: {
            recentlySuccessfulDuration: 1000,
        },
        prefetch: {
            cacheFor: '5m',
            hoverDelay: 150,
        },
        future: {
            useScriptElementForInitialPage: true,
        },
        visitOptions: (href, options) => {
            return {
                headers: {
                    ...options.headers,
                    "X-Custom-Header": "value",
                },
            };
        },
    },
});

// Note: You can still import `config` from '@inertiajs/react' and use
// `config.set()` anywhere else in your app if you need to mutate these at runtime!
