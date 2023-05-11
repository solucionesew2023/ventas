import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/buttons.js',
                'resources/js/app.bundle.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
});
