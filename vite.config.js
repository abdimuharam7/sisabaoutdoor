import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
      hmr: {
        host: 'sisabaoutdoor.local',
      },
      https: {
          key: 'D:/laragon/etc/ssl/laragon.key',
          cert: 'D:/laragon/etc/ssl/laragon.crt',
      },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
