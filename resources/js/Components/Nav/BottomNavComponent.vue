<template>
    <div class="fixed z-40 w-full max-w-md bottom-0 left-1/2 -translate-x-1/2 lg:hidden">
        <div class="relative h-20">
            <!-- Botão de Depósito (verde) -->
            <div class="absolute z-10 left-[43%] -translate-x-1/2">
    <button @click="abrirModalDeDeposito" type="button" class="inline-flex flex-col items-center justify-center text-center group absolute top-[-10px]">
        <div 
          class="w-16 h-16 flex items-center justify-center text-white bg-[#138504] shadow-lg transform transition-transform group-hover:scale-110" 
          style="border-radius:9999px !important; overflow:hidden;"
        >
          <svg class="w-8 h-9" viewBox="0 0 30 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7853 20.3557V24.4941C16.7853 24.6757 16.988 25.1319 18.0049 25.5941C18.9413 26.0198 20.2976 26.3064 21.8434 26.3064C23.3892 26.3064 24.7454 26.0198 25.6818 25.5941C26.6987 25.1319 26.9015 24.6757 26.9015 24.4941V20.3557H28.6867V24.4941C28.6867 25.8063 27.5573 26.7026 26.4205 27.2193C25.2031 27.7727 23.584 28.0916 21.8434 28.0916C20.1027 28.0916 18.4836 27.7727 17.2662 27.2193C16.1294 26.7026 15.0001 25.8063 15.0001 24.4941V20.3557H16.7853Z" fill="white"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.8434 16.7853C20.0495 16.7853 18.3963 17.1303 17.1693 17.7145C15.9867 18.2777 15.0001 19.1719 15.0001 20.3557C15.0001 21.5395 15.9867 22.4337 17.1693 22.9969C18.3963 23.5811 20.0495 23.9261 21.8434 23.9261C23.6372 23.9261 25.2904 23.5811 26.5174 22.9969C27.7 22.4337 28.6867 21.5395 28.6867 20.3557C28.6867 19.1719 27.7 18.2777 26.5174 17.7145C25.2904 17.1303 23.6372 16.7853 21.8434 16.7853ZM19.7606 19.4631V21.2483H23.9261V19.4631H19.7606Z" fill="white"></path>
                            <path d="M28.6867 3.09863H1.31342V22.1409H13.2173C13.2163 21.548 13.2148 20.9548 13.2148 20.3557H3.09863V4.88384H26.9014V15.931C27.0319 15.9859 27.1598 16.0431 27.2849 16.1027C27.7234 16.3115 28.2191 16.5976 28.6867 16.9687V3.09863Z" fill="white"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.88385 8.45428C5.86979 8.45428 6.66906 7.65504 6.66906 6.66907H23.331C23.331 7.65504 24.1303 8.45428 25.1162 8.45428V15.361C24.0899 15.1228 22.9783 15.0001 21.8434 15.0001C19.8442 15.0001 17.9176 15.381 16.4018 16.1027C15.4662 16.5482 14.2703 17.3453 13.643 18.5705H6.66906C6.66906 17.5845 5.86979 16.7853 4.88385 16.7853V8.45428ZM15 15.5951C16.6433 15.5951 17.9754 14.263 17.9754 12.6198C17.9754 10.9765 16.6433 9.64442 15 9.64442C13.3568 9.64442 12.0247 10.9765 12.0247 12.6198C12.0247 14.263 13.3568 15.5951 15 15.5951ZM23.0335 11.7272H20.0581V13.5124H23.0335V11.7272ZM6.9666 13.5124V11.7272H9.94195V13.5124H6.9666Z" fill="white"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-white font-bold mt-1">Depósito</span>
                </button>
            </div>
            <!-- Barra Inferior -->
            <div class="absolute bottom-0 left-0 right-0 bg-[#171717] border-t border-[#171717] shadow-lg rounded-xl h-16">
                <div class="flex justify-between items-center h-full px-2 text-white">
                    <div class="flex justify-around w-2/5">
                       <RouterLink to="/" class="inline-flex flex-col items-center justify-center text-center group hover:text-white">
    <svg class="w-6 h-6 mb-1" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M416 174.74V48h-80v58.45L256 32 0 272h64v208h144V320h96v160h144V272h64z"></path>
    </svg>
    <span class="text-xs font-bold">Início</span>
</RouterLink>
                        <!-- BILHETES -->
                        <a href="#" class="inline-flex flex-col items-center justify-center text-center group hover:text-white">
                            <svg width="1em" height="1em" fill="currentColor" class="w-6 h-6 mb-1" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z"></path>
                            </svg>
                            <span class="text-xs font-bold">Bilhetes</span>
                        </a>
                    </div>
                    <div class="flex justify-around w-2/5">
    <!-- INDIQUE -->
    <a href="/profile/affiliate" class="inline-flex flex-col items-center justify-center text-center group hover:text-white">
        <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
            <circle cx="18" cy="5" r="3"></circle>
            <circle cx="6" cy="12" r="3"></circle>
            <circle cx="18" cy="19" r="3"></circle>
            <path d="M8.59 13.51l6.83 3.98M15.42 6.51l-6.83 3.98" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
        </svg>
        <span class="text-xs font-bold">Indique</span>
    </a>
                        <!-- PERFIL -->
                        <a href="/profile/wallet" class="inline-flex flex-col items-center justify-center text-center group hover:text-white">
                            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 448 512">
                                <path d="M224 256a128 128 0 1 0 0-256 128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3 0 498.7 13.3 512 29.7 512h388.6c16.4 0 29.7-13.3 29.7-29.7 0-98.5-79.8-178.3-178.3-178.3z"/>
                            </svg>
                            <span class="text-xs font-bold">Perfil</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// ...script permanece igual ao seu original!
import { sidebarStore } from "@/Stores/SideBarStore.js";
import { useSettingStore } from '@/Stores/SettingStore.js';

export default {
    // ...restante igual
    props: [],
    components: {},
    data() {
        return {
            isLoading: false,
            custom: null,
        }
    },
    computed: {
        sidebarMenuStore() {
            return sidebarStore();
        },
        sidebarMenu() {
            const sidebar = sidebarStore()
            return sidebar.getSidebarStatus;
        },
    },
    methods: {
        abrirModalDeDeposito() {
            window.dispatchEvent(new CustomEvent('abrir-o-modal-de-deposito'));
        },
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;
            if(settingData) {
                _this.setting = settingData;
            }
        },
        toggleMenu: function() {
            this.sidebarMenuStore.setSidebarToogle();
        },
    },
    created() {
        this.getSetting();
        if (typeof custom !== 'undefined') {
            this.custom = custom;
        }
    },
};
</script>

<style>
/* Fundo verde na barra inferior, retirei o .sidebar-color e apliquei inline */
@media(min-width:1025px) {
    .fixed.z-40 {
        display: none;
    }
}
  /* --- FORÇA A DIV VERDE DO BOTÃO DE DEPÓSITO FICAR SEMPRE REDONDA --- */
.deposito-botao-arredondado {
    border-radius: 9999px !important;
}
</style>
