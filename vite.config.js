import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',   // CSS global
                'resources/css/upload.css', // CSS para a página de upload
                'resources/css/search.css',  // CSS para a página de busca
                'resources/js/app.js',      // JS global
            ],
            refresh: true,
        }),
    ],
});
