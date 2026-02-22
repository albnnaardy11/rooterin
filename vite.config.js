import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                {
                    paths: ['resources/views/**'],
                    config: { delay: 500 } // Add throttle to avoid rapid reloads
                }
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: [
                '**/storage/**',
                '**/public/sitemap.xml'
            ],
        },
    },
});
