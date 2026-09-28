import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { defineConfig, loadEnv } from 'vite';

const env = loadEnv('development', process.cwd());

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/css/app.css', 'resources/js/blade.js'], refresh: true }),
        tailwindcss(),
    ],
    server: {
        port: 3000,
        host: '127.0.0.1',
        cors: true,
        hmr: env.VITE_SECURE_HMR ? {
            port: parseInt(process.env.VITE_HMR_PORT || '3000'),
            host: process.env.VITE_HMR_HOST || 'vite.ap7ool.com',
            protocol: process.env.VITE_HMR_PROTO || 'wss',
            clientPort: parseInt(process.env.VITE_HMR_CLIENT_PORT || '443'),
        } : undefined,
    },
});
