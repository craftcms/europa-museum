import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Under DDEV, the dev server runs in the web container and is exposed on port 5173.
const ddevUrl = process.env.DDEV_PRIMARY_URL;

export default defineConfig({
    plugins: [
        laravel({
            input: ['src/css/site.scss', 'src/js/site.js'],
            refresh: true,
        }),
    ],
    server: ddevUrl ? {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        origin: `${ddevUrl.replace(/:\d+$/, '')}:5173`,
        cors: { origin: /https?:\/\/([A-Za-z0-9\-\.]+)?(\.ddev\.site)(?::\d+)?$/ },
    } : {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
