import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/backEnd/css/app.css',   // optional normal CSS
                'resources/backEnd/js/app.js',     // JS entry imports all min.css
                'resources/css/app.css', 
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
