import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';

export default defineConfig({

    server: {
        cors: {
          origin: 'https://cliente_daniel_29012025.test', // Permite o domínio do seu frontend
          methods: ['GET', 'POST'], // Métodos permitidos
          allowedHeaders: ['Content-Type'], // Cabeçalhos permitidos
        },
      },
      define: {
        global: 'window', // Definindo o `global` como `window`
      },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                base: null,
                includeAbsolute: false
            }
        }),
        i18n(),
    ],
    resolve: {
        alias: {

        }
      }
});
