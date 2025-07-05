import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'node:path';
import { defineConfig, HmrOptions, loadEnv } from 'vite';

const env = loadEnv('development', process.cwd());
const hmrOpts: HmrOptions = {
    port: parseInt(process.env.VITE_HMR_PORT || '3000'),
    host: process.env.VITE_HMR_HOST || 'vite.ap7ool.com',
    protocol: process.env.VITE_HMR_PROTO || 'wss',
    clientPort: parseInt(process.env.VITE_HMR_CLIENT_PORT || '443'),
};

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.tsx', 'resources/js/cc.js', 'resources/js/billing.js'],
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
    server: {
        port: 3000,
        host: '127.0.0.1',
        cors: true,
        hmr: env.VITE_SECURE_HMR ? hmrOpts : undefined,
    },
    esbuild: {
        jsx: 'automatic',
    },
    resolve: {
        alias: {
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },
});
