<style>
.input-wrapper {
    position: relative;
    margin: 20px 0;
}
input {
    border-radius: 4px;
    padding: 10px;
    font-size: 16px;
    width: 100%;
    box-sizing: border-box;
}
.label-formularios {
    position: absolute;
    top: 50%;
    left: 20px;
    font-size: 15px;
    color: #ADAFB0;
    pointer-events: none;
    transform: translateY(-50%);
}
input:focus + label,
input:not(:placeholder-shown) + label {
    top: 20%;
    left: 20px;
    font-size: 10px;
    color: #ADAFB0;
}
html, body {
    font-family: Montserrat, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif;
}
/* BOTÕES MENOS ARREDONDADOS GLOBAL (força para todos os botões, inclusive componentes filhos) */
button,
.ui-button-blue,
.ui-button-blue3,
.button-login-model,
.button-register-model,
.depositar-btn,
.wallet-btn,
[class*="rounded"] {
    border-radius: 7px !important;
}
.btn-primary-vue {
    background-color: var(--primary-green);
    color: var(--dark-background);
    font-weight: 700;
    text-transform: uppercase;
    border-radius: 7px !important;
    padding: 14px;
    width: 100%;
    transition: transform 0.2s, background-color 0.2s;
}
.btn-primary-vue:hover {
    transform: scale(1.03);
    background-color: #1fdf64;
}
.padding-register { padding: 0px 8%; }
.nav-indexx { z-index: 998; }
.login-register-100vh, .login-register-100vh2 {
    background-color: var(--carousel-banners-dark);
    border-radius: 20px;
    max-width: 450px;
    margin: 0 auto;
}
.x-mark-scale {
    opacity: .9;
    transition: .3s;
}
.x-mark-scale:hover { opacity: .8; }
@media (max-width:768px) {
    .button-login-model, .button-register-model { font-size: 0.75rem; }
    .imagem-logo { max-width: 140px; }
    .botao-entrar-mobile { padding: 3px 10px; }
    .nav-indexx { z-index: 1; }
    .login-register-100vh, .login-register-100vh2 {
        height: 100vh;
        border-radius:0px;
        max-width: 1000px;
        width: 100%;
    }
    .padding-register { padding: 0px 4%; }
}
@media(max-width:600px) {
    .margin-teste { margin-left: 8px }
}
:root {
    --primary-green: #3cd827;
    --dark-background: #121212;
    --input-background: #2a2a2a;
    --input-border: #727272;
    --text-primary: #ffffff;
    --text-secondary: #b3b3b3;
}
.modal-content-vue {
    background-color: var(--dark-background);
    border: 1px solid #333;
    border-radius: 12px;
}
.input-container-vue {
    position: relative;
}
.input-icon-vue {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
}
.form-input-vue {
    width: 100%;
    background-color: var(--input-background);
    border: 1px solid var(--input-border);
    border-radius: 8px;
    padding: 14px 16px 14px 48px;
    color: var(--text-primary);
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-input-vue::placeholder {
    color: var(--text-secondary);
}
.form-input-vue:focus {
    outline: none;
    border-color: var(--primary-green);
    box-shadow: 0 0 0 2px var(--primary-green);
}
.separator-vue {
    display: flex;
    align-items: center;
    text-align: center;
    color: var(--text-secondary);
    margin: 24px 0;
}
.separator-vue::before,
.separator-vue::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid var(--input-border);
}
.separator-vue:not(:empty)::before {
    margin-right: .5em;
}
.separator-vue:not(:empty)::after {
    margin-left: .5em;
}
</style>

<template>
  <nav
  style="background-color: var(--navtop-color-dark); z-index: 999; position: fixed; top: 0; left: 0; width: 100%;"
  v-if="showNavtop"
  :class="[
    'navtop-color nav-indexx',
    sidebar === true ? 'w-full' : 'w-full'
  ]"
>
    <div class="relative px-3 py-3 lg:px-5 lg:pl-3 nav-menu" style="background-image:linear-gradient(to right, var(--ci-gray-medium), var(--ci-gray-over));">
      <div :class="[ sidebar === true ? 'lg:ml-[65px] lg:mr-[65px]' : 'lg:ml-[280px] lg:mr-[280px]' ]">
        <div class="w-full mx-auto" style="max-width: 1110px">
          <div class="flex items-center justify-between" style="align-items: center">
            <div class="flex items-center justify-start" style="align-items: center">
              <a v-if="setting" href="/" class="flex md:ml-2 ml-1 md:mr-24 items-center">
                <img
                  style="max-width: 80px;"
                  :src="`/storage/`+setting.software_logo_black"
                  alt="Logo"
                  class="hidden block h-8 imagem-logo opacidade-hover"
                />
                <img
                  style="max-width: 80px;"
                  :src="`/storage/`+setting.software_logo_white"
                  alt="Logo"
                  class="md:max-h-[35px] max-h-[30px] dark:block imagem-logo opacidade-hover"
                />
              </a>
            </div>

            <div v-if="!isAuthenticated" class="flex items-center md:py-2" style="max-height: 54px">
              <div class="flex items-center py-2 ml-5 md:py-1">
                <div class="relative flex items-center" style="margin-top: 0px;">
                  <button class="relative px-4 button-register-model opacidade-hover flex items-center gap-2" @click.prevent="registerToggle">
                    <!-- Ícone SVG adicionado -->
                    <svg viewBox="0 0 640 512" fill="currentColor" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" class="size-5">
                      <path d="M96 128a128 128 0 1 1 256 0 128 128 0 1 1-256 0zM0 482.3C0 383.8 79.8 304 178.3 304h91.4c98.5 0 178.3 79.8 178.3 178.3 0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312v-64h-64c-13.3 0-24-10.7-24-24s10.7-24 24-24h64v-64c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24h-64v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                    </svg>
                    Registrar
                  </button>
                </div>
                <button @click.prevent="loginToggle" class="flex flex-row items-center px-4 ml-2 md:ml-4 botao-entrar-mobile button-login-model opacidade-hover" style="margin-top: -1px;">
                  <svg style="color: var(--ci-primary-color);" class="mr-2" height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M344.7 273.5l-144.1 136c-6.975 6.578-17.2 8.375-26 4.594C165.8 410.3 160.1 401.6 160.1 392V320H32.02C14.33 320 0 305.7 0 288V224c0-17.67 14.33-32 32.02-32h128.1V120c0-9.578 5.707-18.25 14.51-22.05c8.803-3.781 19.03-1.984 26 4.594l144.1 136C354.3 247.6 354.3 264.4 344.7 273.5z" fill="currentColor"></path><path d="M416 32h-64c-17.67 0-32 14.33-32 32s14.33 32 32 32h64c17.67 0 32 14.33 32 32v256c0 17.67-14.33 32-32 32h-64c-17.67 0-32 14.33-32 32s14.33 32 32 32h64c53.02 0 96-42.98 96-96V128C512 74.98 469 32 416 32z" fill="currentColor" opacity="0.4"></path></svg>
                  <span style="color: var(--ci-primary-color);">Entrar</span>
                </button>
              </div>
            </div>

            <div v-if="isAuthenticated" class="flex items-center">
              <MakeDeposit :showMobile="false" :title="$t('Depositar')" />
              <WalletBalance />
              
              <!-- ALTERAÇÃO 1: NOME DO USUÁRIO ADICIONADO -->
              <div class="hidden md:flex items-center ml-4">
                  <span class="text-sm font-semibold text-gray-400">Olá, {{ userData.name }}</span>
              </div>

              <div class="flex items-center ml-3 margin-teste" style="margin-top: -10px;">
                <div>
                  <button
                    type="button"
                    class="flex text-sm bg-gray-700 rounded-full w-9 h-9 items-center justify-center"
                    aria-expanded="false"
                    data-dropdown-toggle="dropdown-user2"
                  >
                    <span class="sr-only">Open user menu</span>
                    <i class="fa-solid fa-user text-lg text-white"></i>
                  </button>
                </div>
                
                <!-- ALTERAÇÃO 2: MENU DROPDOWN ATUALIZADO -->
                <div class="z-50 hidden my-4 text-base list-none divide-y rounded shadow" id="dropdown-user2" style="background-color: #1C1C1C; border: 1px solid #2A2A2A; border-radius: 8px;">
                    <div class="px-4 py-3" role="none">
                        <p class="text-sm text-white" role="none">{{ userData.name }}</p>
                        <p class="text-sm font-medium text-gray-400 truncate" role="none">{{ userData.email }}</p>
                    </div>
                    <ul class="py-1" role="none">
                        <li>
                            <RouterLink :to="{ name: 'profileIndex' }" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700/50 rounded-md mx-1" role="menuitem">
                                <i class="fa-solid fa-user-pen w-6 mr-2"></i>
                                <span class="font-semibold">Perfil</span>
                            </RouterLink>
                        </li>
                        <li>
                            <RouterLink :to="{ name: 'profileWallet' }" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700/50 rounded-md mx-1" role="menuitem">
                                <i class="fa-solid fa-wallet w-6 mr-2"></i>
                                <span class="font-semibold">Carteira</span>
                            </RouterLink>
                        </li>
                        <li>
                            <RouterLink :to="{ name: 'profileTransactions' }" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700/50 rounded-md mx-1" role="menuitem">
                                <i class="fa-solid fa-chart-line w-6 mr-2"></i>
                                <span class="font-semibold">Transações</span>
                            </RouterLink>
                        </li>
                        <li>
                            <RouterLink :to="{ name: 'profileAffiliate' }" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700/50 rounded-md mx-1" role="menuitem">
                                <i class="fa-solid fa-users w-6 mr-2"></i>
                                <span class="font-semibold">{{ $t('Painel Afiliado') }}</span>
                            </RouterLink>
                        </li>
                        <div class="border-t border-gray-600 my-1"></div>
                        <li>
                            <a @click.prevent="logoutAccount" href="#" class="flex items-center px-4 py-2 text-sm text-red-400 hover:bg-red-500/20 rounded-md mx-1" role="menuitem">
                                <i class="fa-solid fa-right-from-bracket w-6 mr-2"></i>
                                <span class="font-semibold">Sair</span>
                            </a>
                        </li>
                    </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

<!-- Modal Login -->
<div
    style="z-index: 999; background-color:rgba(0, 0, 0, 0.7);"
    id="modalElAuth"
    tabindex="-1"
    aria-hidden="true"
    class="fixed top-0 left-0 right-0 hidden items-center justify-center w-full overflow-x-hidden overflow-y-auto h-screen max-h-full"
>
    <div class="relative w-full max-w-md p-4">
        <!-- Conteúdo do Modal -->
        <div class="relative modal-content-vue shadow-lg">
            <!-- Spinner de Carregamento -->
            <div v-if="isLoadingLogin" class="absolute top-0 left-0 right-0 bottom-0 z-50 flex items-center justify-center" style="background-color: rgba(18, 18, 18, 0.8); border-radius: 12px;">
                <div role="status">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size: 45px; color: var(--primary-green);"></i>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <!-- Botão de Fechar -->
            <button @click.prevent="loginToggle" class="absolute right-4 top-4 text-gray-400 hover:text-white transition-colors z-10">
                <i class="fa-solid fa-xmark fa-lg"></i>
            </button>

            <!-- Corpo do Modal -->
            <div class="p-8">
                <!-- Título -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold mb-2 text-white">Bem vindo de volta!</h2>
                    <p class="text-md text-gray-300">Conecte-se para acompanhar seus prêmios.</p>
                </div>
                
                <!-- Formulário de Login -->
                <form @submit.prevent="loginSubmit" method="post" class="space-y-5">
                    <!-- Campo Email -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-white" for="inputFieldLoginEmail">Email</label>
                         <div class="input-container-vue">
                            <i class="fa-regular fa-envelope input-icon-vue"></i>
                            <input id="inputFieldLoginEmail" type="email" name="email" v-model="loginForm.email" class="form-input-vue" placeholder="example@site.com" required />
                        </div>
                    </div>

                    <!-- Campo Senha -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-white" for="inputFieldLoginPass">Digite sua senha</label>
                         <div class="input-container-vue">
                            <i class="fa-solid fa-lock input-icon-vue"></i>
                            <input id="inputFieldLoginPass" :type="typeInputPassword" name="password" v-model="loginForm.password" class="form-input-vue pr-20" placeholder="Insira sua senha..." required />
                            <button type="button" @click.prevent="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold hover:underline" style="color: var(--primary-green);">
                                {{ typeInputPassword === 'password' ? 'Mostrar' : 'Ocultar' }}
                            </button>
                        </div>
                    </div>
                    
                    <!-- Botão de Envio -->
                    <div class="pt-4">
                        <button type="submit" class="btn-primary-vue">
                            Entrar
                        </button>
                    </div>
                    
                    <!-- Separador -->
                    <div class="separator-vue">OU</div>

                    <!-- Link para Registro -->
                    <p class="text-center text-md text-gray-200">
                        Ainda não tem uma conta?
                        <a href="#" @click.prevent="hideLoginShowRegisterToggle" class="font-bold hover:underline" style="color: var(--primary-green);">
                            Registrar
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

  <!-- Modal Register -->
<div
    style="z-index: 999; background-color:rgba(0, 0, 0, 0.7);"
    id="modalElRegister"
    tabindex="-1"
    aria-hidden="true"
    class="fixed top-0 left-0 right-0 hidden items-center justify-center w-full overflow-x-hidden overflow-y-auto h-screen max-h-full"
>
    <div class="relative w-full max-w-md p-4">
        <!-- Conteúdo do Modal -->
        <div class="relative modal-content-vue shadow-lg">
            <!-- Spinner de Carregamento -->
            <div v-if="isLoadingRegister" class="absolute top-0 left-0 right-0 bottom-0 z-50 flex items-center justify-center" style="background-color: rgba(18, 18, 18, 0.8); border-radius: 12px;">
                <div role="status">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size: 45px; color: var(--primary-green);"></i>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <!-- Botão de Fechar -->
            <button @click.prevent="registerToggle" class="absolute right-4 top-4 text-gray-400 hover:text-white transition-colors z-10">
                <i class="fa-solid fa-xmark fa-lg"></i>
            </button>

            <!-- Corpo do Modal -->
            <div class="p-8">
                <!-- Título -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold mb-2 text-white">Crie sua conta!</h2>
                    <p class="text-md text-gray-300">Comece a concorrer a prêmios hoje!</p>
                </div>
                
                <!-- Formulário -->
                <form @submit.prevent="registerSubmit" method="post" class="space-y-5">
                    <!-- Campo Nome Completo -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-white" for="inputFieldName">Nome Completo</label>
                        <div class="input-container-vue">
                            <i class="fa-regular fa-user input-icon-vue"></i>
                            <input id="inputFieldName" type="text" name="name" v-model="registerForm.name" class="form-input-vue" placeholder="Digite o seu nome completo" required />
                        </div>
                    </div>
                    
                    <!-- Campo Email -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-white" for="inputFieldEmail">Email</label>
                         <div class="input-container-vue">
                            <i class="fa-regular fa-envelope input-icon-vue"></i>
                            <input id="inputFieldEmail" type="email" name="email" v-model="registerForm.email" class="form-input-vue" placeholder="example@site.com" required />
                        </div>
                    </div>
                    
                    <!-- Campo Telefone -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-white" for="inputFieldPhone">Telefone</label>
                         <div class="input-container-vue">
                            <i class="fa-solid fa-phone-volume input-icon-vue"></i>
                            <input id="inputFieldPhone" type="text" name="phone" v-model="registerForm.phone" v-maska data-maska="['(##) ####-####', '(##) #####-####']" class="form-input-vue" placeholder="(00) 00000-0000" required />
                        </div>
                    </div>

                    <!-- Campo Senha -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-white" for="inputFieldPassword">Escolha uma senha</label>
                         <div class="input-container-vue">
                            <i class="fa-solid fa-lock input-icon-vue"></i>
                            <input id="inputFieldPassword" :type="typeInputPassword" name="password" v-model="registerForm.password" class="form-input-vue pr-20" placeholder="Digite uma senha forte..." required />
                            <button type="button" @click.prevent="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold hover:underline" style="color: var(--primary-green);">
                                {{ typeInputPassword === 'password' ? 'Mostrar' : 'Ocultar' }}
                            </button>
                        </div>
                    </div>
                    
                    <!-- Botão de Envio -->
                    <div class="pt-4">
                        <button type="submit" class="btn-primary-vue">
                            Criar
                        </button>
                    </div>
                    
                    <!-- Separador -->
                    <div class="separator-vue">OU</div>

                    <!-- Link para Login -->
                    <p class="text-center text-md text-gray-200">
                        Já tem uma conta? 
                        <a href="#" @click.prevent="hideRegisterShowLoginToggle" class="font-bold hover:underline" style="color: var(--primary-green);">
                            Entrar
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
</template>


<script>
import { RouterLink } from "vue-router";
import { sidebarStore } from "@/Stores/SideBarStore.js";
import { Modal } from 'flowbite';
import { useAuthStore } from "@/Stores/Auth.js";
import { useToast } from "vue-toastification";
import { useRouter } from 'vue-router';
import { onMounted, watchEffect } from "vue";
import WalletBalance from "@/Components/UI/WalletBalance.vue";
import HttpApi from "@/Services/HttpApi.js";
import MakeDeposit from "@/Components/UI/MakeDeposit.vue";
import { useSettingStore } from "@/Stores/SettingStore.js";

export default {
    props: ['simple' ],
    components: { MakeDeposit, WalletBalance, RouterLink },
    data() {
        return {
            sidebar: /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) ? false : (localStorage.getItem('sidebarStatus') ? JSON.parse(localStorage.getItem('sidebarStatus')) : false),
            showNavtop: true,
            showDepositModal: false,
            isLoadingLogin: false,
            isLoadingRegister: false,
            modalAuth: null,
            modalRegister: null,
            modalcupom: null,
            typeInputPassword: 'password',
            loginForm: {
                email: '',
                password: '',
            },
            registerForm: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                phone: '',
                reference_code: '',
                agreement: false,
            },
        }
    },
    setup() {
        const router = useRouter();
        const isCasinoPlayPage = false;
        watchEffect(() => { });
        onMounted(() => { });
        return {
            router,
            isCasinoPlayPage
        };
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
        sidebarMenuStore() {
            return sidebarStore();
        },
        sidebarMenu() {
            const sidebar = sidebarStore()
            return sidebar.getSidebarStatus;
        },
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
        setting() {
            const authStore = useSettingStore();
            return authStore.setting;
        }
    },
    mounted() {
        this.modalAuth = new Modal(document.getElementById('modalElAuth'), { placement: 'center', backdrop: 'dynamic', backdropClasses: 'fixed inset-0 z-40', closable: false });
        this.modalRegister = new Modal(document.getElementById('modalElRegister'), { placement: 'center', backdrop: 'dynamic', backdropClasses: 'fixed inset-0 z-40', closable: false });
    },
    methods: {
        getSetting: function() {
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;
            if(settingData) {
                this.setting = settingData;
            }
        },
        togglePassword: function() {
            this.typeInputPassword = this.typeInputPassword === 'password' ? 'text' : 'password';
        },
        loginSubmit: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingLogin = true;
            const authStore = useAuthStore();

            HttpApi.post('auth/login', _this.loginForm)
                .then(async response => {
                    authStore.setToken(response.data.access_token);
                    authStore.setUser(response.data.user);
                    authStore.setIsAuth(true);
                    _this.loginForm = { email: '', password: '' };
                    _this.modalAuth.toggle();
                    _toast.success(_this.$t('You have been authenticated, welcome!'));
                    _this.isLoadingLogin = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingLogin = false;
                });
        },
        registerSubmit: async function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingRegister = true;
            const authStore = useAuthStore();

            await HttpApi.post('auth/register', _this.registerForm)
                .then(response => {
                    if(response.data.access_token !== undefined) {
                        authStore.setToken(response.data.access_token);
                        authStore.setUser(response.data.user);
                        authStore.setIsAuth(true);
                        _this.registerForm = { name: '', email: '', password: '', password_confirmation: '', phone: '', reference_code: '', agreement: false };
                        _this.modalRegister.toggle();
                        _this.router.push({ name: 'home' });
                        _toast.success(_this.$t('Your account has been created successfully'));
                    }
                    _this.isLoadingRegister = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingRegister = false;
                });
        },
        logoutAccount: function() {
            const authStore = useAuthStore();
            const _toast = useToast();
            HttpApi.post('auth/logout', {})
                .then(response => {
                    authStore.logout();
                    this.router.push({ name: 'home' });
                    _toast.success(this.$t('You have been successfully disconnected'));
                })
                .catch(error => { /* Lidar com erro de logout */ });
        },
        hideLoginShowRegisterToggle: function() {
            this.modalAuth.toggle();
            this.modalRegister.toggle();
        },
        hideRegisterShowLoginToggle: function() {
            this.modalRegister.toggle();
            this.modalAuth.toggle();
        },
        loginToggle: function() { this.modalAuth.toggle(); },
        registerToggle: function() { this.modalRegister.toggle(); },
    },
    created() {
        this.getSetting();
    },
    watch: {
        sidebarMenu(newVal) {
            this.sidebar = newVal;
        },
    },
};
</script>
