import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'larecta.truncgil.link',
            protocol: 'wss',
            clientPort: 443
        },
        watch: {
            usePolling: true
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            publicDirectory: 'public',
            buildDirectory: 'build'
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            output: {
                entryFileNames: 'assets/app.js',
                chunkFileNames: 'assets/[name].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name === 'app.css') {
                        return 'assets/app.css';
                    }
                    return 'assets/[name].[ext]';
                }
            }
        }
    },
    optimizeDeps: {
        include: ['alpinejs']
    }
});
