// resources/js/app.js - CÓDIGO FINAL E CORRIGIDO COM DEBUGS NO CONSOLE

// --- ADICIONE ESTA LINHA DE DEBUG LOGO NO INÍCIO DO ARQUIVO ---
console.log("--- DEBUG: app.js loaded and starting ---");
// --- FIM DA ADIÇÃO ---

import './bootstrap';

import { createApp, markRaw } from 'vue/dist/vue.esm-bundler';
import { createRouter, createWebHistory } from 'vue-router';
import { createPinia } from 'pinia';
import { i18nVue } from 'laravel-vue-i18n';
import { vMaska } from "maska";

/**
 * LIBS
 */
import moment from 'moment';
import "vue-toastification/dist/index.css";
import '@/index.css';

import App from './App.vue';
import {useAuthStore} from "@/Stores/Auth.js";
import {useSettingStore} from "@/Stores/SettingStore.js"; // Importação garantida no topo

// 1. IMPORTE O SEU NOVO COMPONENTE AQUI
import GameProviders from './Components/GameProviders.vue';
import MenuCassino from './Components/MenuCassino.vue';

/**
 * APP
 */
const app = createApp(App);

// 2. REGISTRE O COMPONENTE GLOBALMENTE AQUI
//    Registrar aqui mantém o código organizado com os outros plugins.
app.component('game-providers', GameProviders);
app.component('MenuCassino', MenuCassino);


app.config.globalProperties.state = {
    platformName() {
        return 'VIPERPRO';
    },
    dateFormatServer(date) {
        const currentDate = new Date(date);
        const year = String(currentDate.getFullYear());
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        // --- CORREÇÃO DO ERRO DE DIGITAÇÃO: currentC para currentDate ---
        const day = String(currentDate.getDate()).padStart(2, '0');
        // --- FIM DA CORREÇÃO ---

        return `${year}-${month}-${day}`; // Remove hífens do final
    },
    formatDate(dateTimeString) {
        const date = new Date(dateTimeString);
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        const dayAfterTomorrow = new Date(today);
        dayAfterTomorrow.setDate(dayAfterTomorrow.getDate() + 2);

        const options = { hour: '2-digit', minute: '2-digit' };

        if (date.toDateString() === today.toDateString()) {
            return `Hoje às ${date.toLocaleTimeString(document.documentElement.getAttribute("lang"), options)}`;
        } else if (date.toDateString() === tomorrow.toDateString()) {
            return `Amanhã às ${date.toLocaleTimeString(document.documentElement.getAttribute("lang"), options)}`;
        } else if (date.toDateString() === dayAfterTomorrow.toDateString()) {
            const dayOfWeek = new Intl.DateTimeFormat(document.documentElement.getAttribute("lang"), { weekday: 'long' }).format(date);
            return `Na ${dayOfWeek} às ${date.toLocaleTimeString(document.documentElement.getAttribute("lang"), options)}`;
        } else {
            return `${date.toLocaleDateString(document.documentElement.getAttribute("lang"))} às ${date.toLocaleTimeString(document.documentElement.getAttribute("lang"), options)}`;
        }
    },
    generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-') // Substitui espaços por hífen
            .replace(/[^\w\-]+/g, '') // Remove caracteres especiais
            .replace(/\-\-+/g, '-') // Substitui múltiplos hífens por um único hífen
            .replace(/^-+/, '') // Remove hífens do início
            .replace(/-+$/, ''); // Remove hífens do final
    },
    timeAgo(value) {
        return moment(value).fromNow();
    },
    currencyFormat(value, currency) {
        if (value === undefined || currency === undefined) {
            currency = 'USD';
        }

        const options = {
            style: 'currency',
            currency: currency
        };

        return value.toLocaleString(document.documentElement.getAttribute("lang"), options);
    },
    currencyUSD(value) {
        if (typeof value === 'number') {
            return new Intl.NumberFormat('en-US',{
                currency: 'USD',
                minimumFractionDigits: 2,
            }).format(value);
        }else{
            return new Intl.NumberFormat('en-US',{
                currency: 'USD',
                minimumFractionDigits: 2,
            }).format(parseFloat(value));
        }
    },
    limitCharacters(value, limite) {
        if (!value) return '';
        if (value.length <= limite) return value;
        return value.slice(0, limite) + '...';
    },
};

/**
 * Axios
 */
import axios from 'axios'
import VueAxios from 'vue-axios'


app.use(VueAxios, axios)
app.provide('axios', app.config.globalProperties.axios)   // provide 'axios'

import VueFullscreen from 'vue-fullscreen'
app.use(VueFullscreen)

/**
 * Toast
 */
import Toast from "vue-toastification";
const optionsToast = { }
app.use(Toast, optionsToast)

/**
 * Router
 */
import router from './Router';
app.use(router);

/// Directive
app.directive("maska", vMaska)

/**
 * PINIA
 * @type {Pinia}
 */
const pinia = createPinia()
pinia.use(({ store }) => { store.router = markRaw(router)})
app.use(pinia);

app.use(i18nVue, {
    resolve: async lang => {
        const langs = import.meta.glob('../../lang/*.json');
        return await langs[`../../lang/${lang}.json`]();
    }
});

// --- COMEÇO DO BLOCO MODIFICADO PARA O FACEBOOK PIXEL E PAGEVIEW ---
(async () => {
    const settingStore = useSettingStore();
    try {
        const settingData = await settingStore.getSetting();
        settingStore.setSetting(settingData);
        // --- DEBUG: LOGS ADICIONADOS AQUI ---
        console.log('--- DEBUG: SettingStore data loaded:', settingData);
        if (settingData && settingData.setting && settingData.setting.facebook_pixel_id) {
            console.log('--- DEBUG: Facebook Pixel ID from settings:', settingData.setting.facebook_pixel_id);
            const facebook_pixel_id = settingData.setting.facebook_pixel_id;
            console.log('--- DEBUG: Attempting to inject Facebook Pixel with ID:', facebook_pixel_id);

            // 1. Injeta o script base do Facebook Pixel no <head> da página HTML
            const script = document.createElement('script');
            script.innerHTML = `
            !function(f,b,e,v,n,t,s) {
                if(f.fbq) return; n = f.fbq = function() {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
                };
                if(!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s);
            }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', '${facebook_pixel_id}'); // Inicializa o Pixel com seu ID único
            fbq('track', 'PageView'); // Dispara o evento PageView na carga inicial da página
            `;
            document.head.appendChild(script);
            console.log('--- DEBUG: Facebook Pixel script appended to head.'); // Confirma injeção

            // 2. Adiciona a tag <noscript> ao <body>.
            const noscript = document.createElement('noscript');
            noscript.innerHTML = `<img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=${facebook_pixel_id}&ev=PageView&noscript=1" />`;
            document.body.appendChild(noscript);
            console.log('--- DEBUG: Facebook Pixel noscript appended to body.'); // Confirma injeção

            // 3. Rastreia o evento PageView a cada *mudança de rota* no Vue Router.
            router.afterEach((to, from) => {
                if (window.fbq) { // Verifica se o objeto fbq está disponível
                    window.fbq('track', 'PageView');
                    console.log('--- DEBUG: PageView tracked via router.afterEach for route:', to.path); // Log para cada rota
                } else {
                    console.warn('--- DEBUG: fbq object not available for router.afterEach. Pixel may not be fully loaded yet.');
                }
            });
        } else {
            console.warn('--- DEBUG: Facebook Pixel ID NOT found in settings or settings data is incomplete. Pixel not injected.'); // Avisa se o ID não for encontrado
        }
    } catch (e) {
        console.error("--- DEBUG: Critical error in app.js Facebook Pixel logic:", e); // Captura erros na lógica do Pixel
    }
})();
// --- FIM DO BLOCO MODIFICADO PARA O FACEBOOK PIXEL E PAGEVIEW ---


if(localStorage.getItem('token')) {
    (async () => {
        const auth = useAuthStore();
        try {
            auth.setIsAuth(true);
            const user = await auth.checkToken();
            if(user !== undefined) {
                auth.setUser(user);
            }

            //auth.initializingEcho();
        } catch (e) {
            auth.setIsAuth(false);
            console.error("--- DEBUG: Error during AuthStore initialization:", e); // Debug para erros na inicialização do AuthStore
        }
    })()
}

app.mount('#viperpro');
