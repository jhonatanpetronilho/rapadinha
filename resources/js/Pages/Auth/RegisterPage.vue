<style>
/* Estilos originais da página */
@media (max-width:600px) {
    .register-afiliado {
        margin-top: -67px;
        height: 100vh;
        background-color:var(--carousel-banners-dark);;
        width: 100%;
        z-index: 9999;
    }
}

/* Estilos copiados do Navtop.vue para replicar o visual do modal */
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
    box-shadow: 0 0 0 2px rgba(60, 216, 39, 0.5);
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
    <AuthLayout :showSidebar="false">
        <LoadingComponent :isLoading="isLoading || isLoadingLogin || isLoadingRegister" />

        <div v-if="!isLoading" class="flex items-center justify-center min-h-screen py-8">
            <div class="relative w-full max-w-md p-4">

                <div v-if="showRegisterForm" class="relative modal-content-vue shadow-lg">
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold mb-2 text-white">Crie sua conta!</h2>
                            <p class="text-md text-gray-300">Comece a concorrer a prêmios hoje!</p>
                        </div>
                        <form @submit.prevent="registerSubmit" method="post" class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-white" for="inputFieldName">Nome Completo</label>
                                <div class="input-container-vue">
                                    <i class="fa-regular fa-user input-icon-vue"></i>
                                    <input id="inputFieldName" type="text" v-model="registerForm.name" class="form-input-vue" placeholder="Digite o seu nome completo" required />
                                </div>
                            </div>
                             <div>
                                <label class="block text-sm font-medium mb-2 text-white" for="inputFieldEmail">Email</label>
                                <div class="input-container-vue">
                                    <i class="fa-regular fa-envelope input-icon-vue"></i>
                                    <input id="inputFieldEmail" type="email" v-model="registerForm.email" class="form-input-vue" placeholder="example@site.com" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-white" for="inputFieldPassword">Escolha uma senha</label>
                                <div class="input-container-vue">
                                    <i class="fa-solid fa-lock input-icon-vue"></i>
                                    <input id="inputFieldPassword" :type="typeInputPassword" v-model="registerForm.password" class="form-input-vue pr-20" placeholder="Digite uma senha forte..." required />
                                    <button type="button" @click.prevent="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold hover:underline" style="color: var(--primary-green);">
                                        {{ typeInputPassword === 'password' ? 'Mostrar' : 'Ocultar' }}
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-white" for="inputFieldPhone">Telefone</label>
                                <div class="input-container-vue">
                                    <i class="fa-solid fa-phone-volume input-icon-vue"></i>
                                    <input id="inputFieldPhone" type="text"
                                         name="phone"
                                         v-maska data-maska="['(##) ####-####', '(##) #####-####']"
                                         v-model="registerForm.phone"
                                         class="form-input-vue"
                                         placeholder="(00) 00000-0000"
                                         required>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn-primary-vue">Criar Conta</button>
                            </div>
                            <p class="text-center text-md text-gray-200">
                                Já tem uma conta?
                                <a href="#" @click.prevent="toggleView" class="font-bold hover:underline" style="color: var(--primary-green);">
                                    Entrar
                                </a>
                            </p>
                        </form>
                    </div>
                </div>

                <div v-else class="relative modal-content-vue shadow-lg">
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold mb-2 text-white">Bem vindo de volta!</h2>
                            <p class="text-md text-gray-300">Conecte-se para acompanhar seus prêmios.</p>
                        </div>
                        <form @submit.prevent="loginSubmit" method="post" class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-white" for="inputFieldLoginEmail">Email</label>
                                <div class="input-container-vue">
                                    <i class="fa-regular fa-envelope input-icon-vue"></i>
                                    <input id="inputFieldLoginEmail" type="email" v-model="loginForm.email" class="form-input-vue" placeholder="example@site.com" required />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-white" for="inputFieldLoginPass">Digite sua senha</label>
                                <div class="input-container-vue">
                                    <i class="fa-solid fa-lock input-icon-vue"></i>
                                    <input id="inputFieldLoginPass" :type="typeInputPassword" v-model="loginForm.password" class="form-input-vue pr-20" placeholder="Insira sua senha..." required />
                                    <button type="button" @click.prevent="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold hover:underline" style="color: var(--primary-green);">
                                        {{ typeInputPassword === 'password' ? 'Mostrar' : 'Ocultar' }}
                                    </button>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn-primary-vue">Entrar</button>
                            </div>
                            <p class="text-center text-md text-gray-200">
                                Ainda não tem uma conta?
                                <a href="#" @click.prevent="toggleView" class="font-bold hover:underline" style="color: var(--primary-green);">
                                    Registrar
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<script>
import { useToast } from "vue-toastification";
import { useAuthStore } from "@/Stores/Auth.js";
import HttpApi from "@/Services/HttpApi.js";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { useRouter } from "vue-router";
import { onMounted, reactive } from "vue";
import { useSettingStore } from "@/Stores/SettingStore.js";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import { Modal } from 'flowbite';

export default {
    props: [],
    components: { LoadingComponent, AuthLayout },
    data() {
        return {
            isLoading: false,
            isLoadingLogin: false,
            isLoadingRegister: false,
            showRegisterForm: true,
            typeInputPassword: 'password',
            loginForm: {
                email: '',
                password: '',
            },
            registerForm: {
                name: '',
                email: '',
                password: '',
                phone: '',
                reference_code: '',
                term_a: false,
                agreement: false,
                spin_data: null
            },
            facebook_pixel_id: null,
            isReferral: false,
        }
    },
    setup() {
        const router = useRouter();
        const routeParams = reactive({ code: null });
        onMounted(() => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('code')) {
                routeParams.code = params.get('code');
            }
        });
        return { routeParams, router };
    },
    computed: {
        setting() {
            const authStore = useSettingStore();
            return authStore.setting;
        },
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
            mounted() {
                if (this.isAuthenticated) {
                    this.router.push({ name: 'home' });
                    return;
                }

                const { ['getSetting']: gS } = useSettingStore();
                gS();

                // PEGAR O CÓDIGO NA QUERY STRING DIRETO
                const params = new URLSearchParams(window.location.search);
                if (params.has('code')) {
                    this.registerForm.reference_code = params.get('code');
                    this.isReferral = true;
                }
            },

    methods: {
        toggleView() {
            this.showRegisterForm = !this.showRegisterForm;
        },
        togglePassword() {
            this.typeInputPassword = this.typeInputPassword === 'password' ? 'text' : 'password';
        },
        loginSubmit() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingLogin = true;
            const authStore = useAuthStore();

            HttpApi.post('auth/login', _this.loginForm)
                .then(response => {
                    authStore.setToken(response.data.access_token);
                    authStore.setUser(response.data.user);
                    authStore.setIsAuth(true);
                    _this.router.push({ name: 'home' });
                    _toast.success('Você foi autenticado, bem-vindo!');
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingLogin = false;
                });
        },
        registerSubmit: async function (event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingRegister = true;
            _this.isLoading = true;

          	console.log("DADOS QUE VÃO PRO BACKEND:", _this.registerForm);
          
            const authStore = useAuthStore();
            await HttpApi.post('auth/register', _this.registerForm)
                .then(response => {
                    if (response.data.access_token !== undefined) {
                        authStore.setToken(response.data.access_token);
                        authStore.setUser(response.data.user);
                        authStore.setIsAuth(true);

                        if (window.fbq) {
                            window.fbq('track', 'CompleteRegistration', {});
                        }
                        
                         _this.router.push({ name: 'support' }); 
                        _toast.success('Sua conta foi criada com sucesso');

                        setTimeout(() => {
                            if (typeof Modal !== 'undefined' && document.getElementById('modalElDeposit')) {
                                const modalDeposit = new Modal(document.getElementById('modalElDeposit'), {});
                                modalDeposit.toggle();
                            }
                        }, 2000);

                    } else {
                        _toast.error('Ocorreu um erro ao tentar fazer login automaticamente.');
                    }
                    _this.isLoadingRegister = false;
                    _this.isLoading = false;
                })
                .catch(error => {
                     Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingRegister = false;
                    _this.isLoading = false;
                });
        },
    },
    created() {
        const settingStore = useSettingStore();
        if(!settingStore.setting) {
            settingStore.getSetting();
        }
    },
};
</script>