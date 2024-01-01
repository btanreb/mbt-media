import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'


export default defineConfig({
    plugins: [
        vue(),
        laravel([
            'resources/css/app.css',
            'resources/css/comments.css',
            'resources/css/project.css',

            'resources/js/app.js',
            'resources/js/project.js',
            'resources/js/client.js',
        ]),
    ],
    resolve: {
        alias: {
          'vue': 'vue/dist/vue.esm-bundler',
        },
    },
});
