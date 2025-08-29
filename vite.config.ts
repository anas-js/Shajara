import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vuePlugin from '@vitejs/plugin-vue';

import { PrimeVueResolver } from '@primevue/auto-import-resolver';

import Components from 'unplugin-vue-components/vite';

export default defineConfig({
    plugins: [
        vuePlugin(),
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.ts'],
            refresh: true,

        }),
        Components({
            resolvers: [PrimeVueResolver()]
        })

    ],
});
