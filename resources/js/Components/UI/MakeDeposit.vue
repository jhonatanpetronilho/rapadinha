<!-- Arquivo: /components/UI/MakeDeposit.vue -->

<style>
/* SEUS ESTILOS ORIGINAIS - CORRIGIDOS */
.container-deposit {
    margin: 4%;
}
.ui-button-blue2 {
    font-size: .875rem;
    font-weight: 700;
    line-height: 1.25rem;
    border-radius: 5px;
    -webkit-box-shadow: 0px 2px 11px 0px var(--ci-primary-color);
    -moz-box-shadow: 0px 2px 11px 0px var(--ci-primary-color);
    box-shadow: 0px 2px 11px 0px var(--ci-primary-color);
    background-color: var(--ci-primary-color);
    color: var(--sub-text-color);
    width: auto;
    padding: 9px 15px;
    -webkit-flex: none;
    -ms-flex: none;
    flex: none;
    display: flex;
    align-items: center;
    gap: 8px;
}
.ui-button-blue2:hover {
    opacity: .9;
}
.pixFont {
    color: black;
    font-size: 10px;
    font-weight: bold
}
@media(max-width:768px) {
    .pixFont {
        font-size: 8px;
    }
    .container-deposit {
        margin: 0;
        width: 100vw;
        padding-bottom: 50px;
        height: 100vh;
    }
    .ui-button-blue2 {
        font-size: .775rem;
        font-weight: 700;
        line-height: 1.25rem;
        padding: 5px 8px;
    }
}
@media(max-width:376px) {
    .container-deposit {
        margin: 0;
        width: 100vw;
        height: calc(auto + 160px);
    }
}
/* NOVOS ESTILOS PARA O MODAL REATIVO - CORRIGIDOS */
.payment-modal-bg {
    position: fixed;
    inset: 0;
    z-index: 50;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<template>
    <div class="relative flex items-center opacidade-hover">
        <button
            style="background-color: var(--ci-primary-color); border-radius: 5px;"
            class="md:py-[6px] md:px-[20px] py-[5px] px-[13px] md:text-base text-xs ui-button-blue2"
            @click.prevent="openModal"
            type="button"
            :class="[showMobile === true ? 'hidden md:block' : '', isFull ? 'w-full' : '']"
        >
            <svg fill="none" viewBox="0 0 24 24" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" class="size-5">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 15v3m0 3v-3m0 0h-3m3 0h3"></path>
                <path fill="currentColor" fill-rule="evenodd" d="M5 5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h7.083A6 6 0 0 1 12 18c0-1.148.322-2.22.881-3.131A3 3 0 0 1 9 12a3 3 0 1 1 5.869.881A5.97 5.97 0 0 1 18 12c1.537 0 2.939.578 4 1.528V8a3 3 0 0 0-3-3zm7 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" clip-rule="evenodd"></path>
            </svg>
            <strong class="md:text-base text-xs" style="color: var(--sub-text-color);">Depositar</strong>
        </button>
    </div>

    <div
        v-if="isModalOpen"
        class="payment-modal-bg"
        @mousedown.self="closeModal"
        @touchstart.self="closeModal"
    >
        <DepositWidget @close="closeModal" />
    </div>
</template>

<script>
    import {useAuthStore} from "@/Stores/Auth.js";
    import DepositWidget from "@/Components/Widgets/DepositWidget.vue";
    import {onMounted, ref, watchEffect} from "vue";
    import HttpApi from "@/Services/HttpApi.js";
    import { useRouter } from 'vue-router';

    export default {
        props: ['showMobile', 'title', 'isFull'],
        components: { DepositWidget },
        data() {
            return {
                isModalOpen: false, 
                isLoading: false,
                isLoadingWallet: true,
                wallet: null,
            }
        },
        setup(props) {
            onMounted(() => {});
            const router = useRouter();
            const isCasinoPlayPage = ref(false);

            watchEffect(() => {
                checkRoute();
            });

            onMounted(() => {
                checkRoute();
            });

            function checkRoute() {
                isCasinoPlayPage.value = router.currentRoute._value.name === 'casinoPlayPage';
            }

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
        },
        
        // --- INÍCIO DA CORREÇÃO ---
        mounted() {
            window.scrollTo(0, 0);
            
            // Adiciona o "ouvinte" que fica esperando o sinal para chamar o método openModal
            window.addEventListener('abrir-o-modal-de-deposito', this.openModal);
        },
        beforeUnmount() {
            // Remove o "ouvinte" quando o componente é destruído para evitar vazamentos de memória
            window.removeEventListener('abrir-o-modal-de-deposito', this.openModal);
        },
        // --- FIM DA CORREÇÃO ---

        methods: {
            openModal() {
                this.isModalOpen = true;
            },
            closeModal() {
                this.isModalOpen = false;
            },
            getWallet: async function() {
                const _this = this;
                await HttpApi.get('profile/wallet')
                    .then(response => {
                        _this.wallet = response.data.wallet;
                        _this.isLoadingWallet = false;
                    })
                    .catch(error => {
                        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                            if(value == 'unauthenticated') {
                                localStorage. clear();
                                clearInterval(this.processInterval);
                            }
                        });
                        _this.isLoadingWallet = false;
                    });
            },
        },
        async created() {
            await this.getWallet(); 
        },
        watch: {
            isModalOpen(isOpen) {
              if (isOpen) {
                document.body.style.overflow = 'hidden';
              } else {
                document.body.style.overflow = 'auto';
              }
            }
        },
    };
</script>
