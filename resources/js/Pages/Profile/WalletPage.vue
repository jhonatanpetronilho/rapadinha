<template>
    <BaseLayout>
        <div v-if="setting != null" class="mx-auto w-full max-w-6xl p-4 sm:p-6 lg:p-8">
            <div class="relative w-full">
                <!-- Seção dos Cards de Saldo e Bônus -->
                <div v-if="!isLoadingWallet" id="wallet-cards" class="grid w-full grid-cols-1 lg:grid-cols-2 mt-3 gap-6">
                    <!-- Card de Saldo Principal -->
                    <div class="relative flex flex-col p-6 md:p-8 card-base">
                        <div class="flex items-start justify-between">
                            <div class="flex-grow">
                                <div class="flex items-center mb-2 text-text-secondary">
                                    <i class="fa-solid fa-wallet text-lg mr-3"></i>
                                    <h1 class="text-lg font-semibold">Saldo Principal</h1>
                                </div>
                                <strong id="total-balance" class="text-4xl md:text-5xl font-bold tracking-tighter text-text-primary">
                                    {{ state.currencyFormat(wallet?.total_balance, wallet?.currency) }}
                                </strong>
                            </div>
                            <img src="https://placehold.co/40x40/2EBD5C/FFFFFF?text=BRL" alt="Bandeira do Brasil" class="rounded-full w-10 h-10 border-2 border-gray-600">
                        </div>
                        <div class="mt-auto pt-8 flex gap-4">
                            <MakeDeposit :showMobile="false" :title="$t('Depositar')" class="w-full" />
                            <RouterLink :to="{ name: 'profileWithdraw' }" class="w-full py-3 rounded-lg text-base text-center btn-secondary">
                                Sacar
                            </RouterLink>
                        </div>
                    </div>

                    <!-- Card de Bônus e Rollover -->
                    <div class="w-full p-6 md:p-8 card-base flex flex-col">
                        <div class="flex w-full items-start justify-between">
                            <div class="flex-grow">
                                <div class="flex items-center mb-2 text-text-secondary">
                                    <i class="fa-solid fa-star text-lg mr-3" style="color: var(--accent-primary);"></i>
                                    <p class="text-lg font-semibold">Saldo de Bônus</p>
                                </div>
                                <strong id="bonus-balance" class="text-4xl font-bold tracking-tighter text-text-primary">
                                    B$ {{ state.currencyFormat((wallet.balance_bonus), wallet.currency) }}
                                </strong>
                            </div>
                            <div class="text-right">
                                <p class="py-1 px-3 bg-green-500/10 text-green-300 rounded-full text-sm font-bold">Rollover</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 space-y-4">
                            <div>
                                <div class="flex justify-between items-center mb-1 text-sm text-text-secondary">
                                    <span>Depósito</span>
                                    <span class="font-semibold text-text-primary">{{ state.currencyFormat(parseFloat(wallet.balance_deposit_rollover), wallet.currency) }}</span>
                                </div>
                                <div class="w-full bg-gray-700/50 rounded-full h-2.5">
                                   <div class="h-2.5 rounded-full" :style="{ width: rolloverPercentage(parseFloat(wallet.balance_deposit_rollover)) + '%', backgroundColor: 'var(--accent-primary)' }"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-1 text-sm text-text-secondary">
                                    <span>Bônus</span>
                                    <span class="font-semibold text-text-primary">{{ state.currencyFormat(parseFloat(wallet.balance_bonus_rollover), wallet.currency) }}</span>
                                </div>
                                 <div class="w-full bg-gray-700/50 rounded-full h-2.5">
                                   <div class="h-2.5 rounded-full" :style="{ width: rolloverPercentage(parseFloat(wallet.balance_bonus_rollover)) + '%', backgroundColor: 'var(--accent-primary)' }"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto pt-8">
                            <button @click="showModal = true" class="w-full py-3 rounded-lg text-base btn-secondary">
                               <i class="fa-regular fa-circle-question mr-2"></i> Dúvidas? Leia as Regras
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Seção de Transações -->
                <div class="w-full mt-6 lg:col-span-2">
                    <div class="card-base flex flex-col w-full gap-6 p-6 md:p-8">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Histórico de Transações</h3>
                            <p class="text-text-secondary">Acompanhe suas movimentações recentes.</p>
                        </div>
                        
                        <!-- Tabela de Saques -->
                        <div v-if="withdraws && wallet">
                            <p class="text-lg font-semibold mb-3 text-text-primary">Saques</p>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Status</th>
                                            <th scope="col" class="px-4 py-3">Valor</th>
                                            <th scope="col" class="px-4 py-3 text-right">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(withdraw, index) in withdraws.data" :key="index" class="border-b border-gray-800">
                                            <td class="px-4 py-3">
                                                <span v-if="withdraw.status === 1" class="py-1 px-3 rounded-full text-xs font-bold bg-green-500/10 text-green-400"><i class="fa-solid fa-circle-check mr-1.5"></i>Aprovado</span>
                                                <span v-if="withdraw.status === 0" class="py-1 px-3 rounded-full text-xs font-bold bg-yellow-500/10 text-yellow-400"><i class="fa-solid fa-clock mr-1.5"></i>Pendente</span>
                                            </td>
                                            <td class="px-4 py-3 text-white font-medium text-base">
                                                {{ state.currencyFormat(parseFloat(withdraw.amount), withdraw.currency) }}
                                            </td>
                                            <td class="px-4 py-3 text-text-secondary text-right">
                                                {{ withdraw.dateHumanReadable }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tabela de Depósitos -->
                        <div v-if="deposits && wallet">
                            <p class="text-lg font-semibold mb-3 text-text-primary">Depósitos</p>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                     <thead class="text-xs">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Status</th>
                                            <th scope="col" class="px-4 py-3">Valor</th>
                                            <th scope="col" class="px-4 py-3 text-right">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(deposit, index) in deposits.data" :key="index" class="border-b border-gray-800">
                                            <td class="px-4 py-3">
                                                <span v-if="deposit.status === 1" class="py-1 px-3 rounded-full text-xs font-bold bg-green-500/10 text-green-400"><i class="fa-solid fa-circle-check mr-1.5"></i>Aprovado</span>
                                                <span v-if="deposit.status === 0" class="py-1 px-3 rounded-full text-xs font-bold bg-yellow-500/10 text-yellow-400"><i class="fa-solid fa-clock mr-1.5"></i>Pendente</span>
                                            </td>
                                            <td class="px-4 py-3 text-white font-medium text-base">
                                                {{ state.currencyFormat(parseFloat(deposit.amount), deposit.currency) }}
                                            </td>
                                            <td class="px-4 py-3 text-text-secondary text-right">
                                                {{ deposit.dateHumanReadable }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div v-if="isLoading" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 45px; color: var(--accent-primary);"></i>
                <span class="sr-only">{{ $t('Loading') }}...</span>
            </div>
        </div>

        <!-- Modal de Regras da Raspadinha -->
        <div v-if="showModal" class="modal-overlay active" @click.self="showModal = false">
            <div class="modal-content">
                <span @click="showModal = false" class="close-button">
                    <i class="fa-solid fa-xmark text-lg text-text-secondary"></i>
                </span>
                <div class="flex items-center mb-6">
                     <i class="fa-solid fa-ticket text-3xl mr-4" style="color: var(--accent-primary);"></i>
                    <p class="font-bold text-2xl text-white">Regras da Raspadinha</p>
                </div>
                <div class="space-y-5 text-text-secondary text-base">
                    <div>
                        <h4 class="font-semibold text-text-primary mb-1">Como Jogar:</h4>
                        <p>Raspe a área indicada no cartão virtual para revelar os símbolos escondidos. Cada cartão é uma nova chance!</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-text-primary mb-1">Como Ganhar:</h4>
                        <p>Para ganhar, você precisa encontrar <strong>3 (três) símbolos iguais</strong> em uma única raspadinha. Simples assim!</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-text-primary mb-2">Tabela de Prêmios:</h4>
                        <div class="space-y-3 p-4 rounded-lg" style="background-color: rgba(0,0,0,0.3);">
                            <p class="flex items-center justify-between"><span>💎 💎 💎</span> <span class="font-bold text-white text-lg">R$ 100,00</span></p>
                            <p class="flex items-center justify-between"><span>⭐ ⭐ ⭐</span> <span class="font-bold text-white text-lg">R$ 50,00</span></p>
                            <p class="flex items-center justify-between"><span>🍒 🍒 🍒</span> <span class="font-bold text-white text-lg">R$ 10,00</span></p>
                            <p class="flex items-center justify-between"><span>🍋 🍋 🍋</span> <span class="font-bold text-white text-lg">R$ 5,00</span></p>
                        </div>
                    </div>
                     <p class="text-sm text-center pt-4">Os prêmios são creditados instantaneamente na sua carteira. Boa sorte!</p>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script>
import { RouterLink } from "vue-router";
import MakeDeposit from "@/Components/UI/MakeDeposit.vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { useToast } from "vue-toastification";
import { useAuthStore } from "@/Stores/Auth.js";
import HttpApi from "@/Services/HttpApi.js";
import { useSettingStore } from "@/Stores/SettingStore.js";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import CustomPagination from "@/Components/UI/CustomPagination.vue";

export default {
    props: [],
    components: { MakeDeposit, CustomPagination, WalletSideMenu, BaseLayout, RouterLink },
    data() {
        return {
            isLoading: false,
            showModal: false,
            isLoadingWallet: true,
            wallet: {},
            mywallets: null,
            setting: null,
            withdraws: null,
            deposits: null,
        }
    },
    setup(props) {
        return {};
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
    },
    mounted() {
        window.scrollTo(0, 0);
    },
    methods: {
        getWallet: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                    _this.isLoadingWallet = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                     _this.isLoadingWallet = false;
                });
        },
        getWithdraws: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('wallet/withdraw')
                .then(response => {
                    _this.withdraws = response.data.withdraws;
                    _this.isLoading = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        console.log(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
        getDeposits: function() {
            const _this = this;
            _this.isLoading = true;

            HttpApi.get('wallet/deposit')
                .then(response => {
                    _this.deposits = response.data.deposits;
                    _this.isLoading = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        console.log(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
        setWallet: function(id) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.post('profile/mywallet/'+ id, {})
                .then(response => {
                   _this.getMyWallet();
                    _this.isLoadingWallet = false;
                    window.location.reload();
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getMyWallet: function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('profile/mywallet')
                .then(response => {
                    _this.mywallets = response.data.wallets;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                });
        },
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;

            if(settingData) {
                _this.setting = settingData;
            }

            _this.isLoading = false;
        },
        rolloverPercentage(balance) {
            // Supondo que o rollover total venha do setting, ex: setting.rollover_total
            // Como não temos o valor total, vou usar um valor fixo para demonstração.
            // O ideal é buscar esse valor de `setting` ou `wallet`.
            const totalRollover = 10000; 
            if (totalRollover <= 0) return 0;
            const completed = totalRollover - balance;
            return Math.max(0, Math.min(100, (completed / totalRollover) * 100));
        },
    },
    created() {
        this.getWallet();
        this.getMyWallet();
        this.getSetting();
        this.getWithdraws();
        this.getDeposits();
    },
    watch: {},
};
</script>

<style>
/* Definindo variáveis de cor para combinar com a imagem (Tema RaspaZinha) */
:root {
    --bg-primary: #121212; /* Fundo escuro sólido */
    --bg-secondary: #1C1C1C; /* Fundo para cards */
    --text-primary: #FFFFFF;
    --text-secondary: #A0A0B0;
    --accent-primary: #2EBD5C; /* Verde vibrante da imagem */
    --border-color: #2A2A2A;
    --success-color: #2EBD5C;
    --warning-color: #F59E0B;
}

body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Inter', sans-serif;
}

/* Estilo base para os cards */
.card-base {
    background-color: var(--bg-secondary);
    border-radius: 12px; 
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.card-base:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

/* Estilo para botões */
.btn-primary {
    background-color: var(--accent-primary);
    border: none;
    color: white;
    font-weight: 700;
    transition: all 0.2s ease;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    text-align: center;
}
.btn-primary:hover {
    filter: brightness(1.1);
}
.btn-secondary {
    background-color: #2A2A2A;
    color: var(--text-primary);
    font-weight: 700;
    transition: all 0.2s ease;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    text-align: center;
}
.btn-secondary:hover {
    background-color: #3A3A3A;
}

/* Estilos para as tabelas */
table thead {
    background-color: transparent;
}
table th {
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.75rem;
}
table tr {
    border-color: var(--border-color);
}
table tr:last-child {
    border-bottom: none;
}
table td {
    padding-top: 1rem;
    padding-bottom: 1rem;
}
</style>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: opacity 0.3s;
}

.modal-content {
    background-color: var(--bg-secondary);
    padding: 30px;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    position: relative;
    max-width: 500px;
    width: 90%;
    transform: scale(0.95);
    transition: transform 0.3s;
}

.modal-overlay.active .modal-content {
    transform: scale(1);
}

.close-button {
    position: absolute;
    top: 15px;
    right: 15px;
    cursor: pointer;
    background-color: rgba(255, 255, 255, 0.1);
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s, transform 0.2s;
}
.close-button:hover {
    background-color: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg);
}

/* Aplicando estilo do botão primário ao componente MakeDeposit */
:deep(.btn-primary) {
    background-color: var(--accent-primary);
    border: none;
    color: white;
    font-weight: 700;
    transition: all 0.2s ease;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    width: 100%;
    display: block;
    text-align: center;
}
:deep(.btn-primary:hover) {
    filter: brightness(1.1);
}
</style>