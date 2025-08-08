<template>
    <BaseLayout>
        <div class="container mx-auto w-full max-w-4xl p-4 sm:p-6 lg:p-8 min-h-[calc(100vh-200px)]">
            <!-- Loading State Principal -->
            <div v-if="isLoading" class="flex items-center justify-center h-64">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 45px; color: var(--accent-primary);"></i>
            </div>

            <div v-if="!isLoading">
                <!-- VISTA DO AFILIADO -->
                <div v-if="isShowForm && wallet" class="card-base flex flex-col w-full">
                    <!-- Banner/Logo -->
                    <div v-if="setting && setting.software_logo_black2">
                        <img :src="`/storage/`+setting.software_logo_black2" alt="Banner Afiliados" class="block rounded-t-lg w-full" />
                    </div>

                    <div class="p-6 md:p-8 space-y-8">
                        <!-- Seção de Boas-Vindas e Link -->
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold mb-2" style="color: var(--accent-primary);">Indique um amigo e ganhe dinheiro!</h1>
                            <p class="text-text-secondary">
                                Ganhe <strong class="text-white">{{ userData.affiliate_revenue_share_fake ? userData.affiliate_revenue_share_fake : userData.affiliate_revenue_share }}%</strong> de todos os depósitos que seus indicados fizerem. Acompanhe seu progresso em tempo real.
                            </p>
                            
                            <div class="mt-6 space-y-4">
                                <div>
                                    <label for="referenceLink" class="block mb-2 text-sm font-semibold text-text-secondary">Seu link de convite:</label>
                                    <div class="relative">
                                        <input id="referenceLink" type="text" class="input pr-28" :value="referencelink" readonly>
                                        <button @click.prevent="copyLink" class="absolute inset-y-0 right-0 m-1.5 px-4 btn-secondary rounded-md text-sm">Copiar</button>
                                    </div>
                                </div>
                                <div>
                                    <label for="referenceCode" class="block mb-2 text-sm font-semibold text-text-secondary">Seu código:</label>
                                    <div class="relative">
                                        <input id="referenceCode" type="text" class="input pr-28" :value="referencecode" readonly>
                                        <button @click.prevent="copyCode" class="absolute inset-y-0 right-0 m-1.5 px-4 btn-secondary rounded-md text-sm">Copiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Seção de Estatísticas -->
                        <div>
                            <h2 class="text-2xl font-bold mb-4">Suas Estatísticas</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Stat Card: CPA -->
                                <div class="stat-card">
                                    <span class="text-sm text-text-secondary">CPA (R$)</span>
                                    <strong class="text-2xl font-bold">{{ state.currencyFormat(parseFloat(userData.affiliate_cpa), wallet.currency) }}</strong>
                                </div>
                                <!-- Stat Card: RevShare -->
                                <div class="stat-card">
                                    <span class="text-sm text-text-secondary">RevShare (%)</span>
                                    <strong class="text-2xl font-bold">{{ userData.affiliate_revenue_share_fake ? userData.affiliate_revenue_share_fake : userData.affiliate_revenue_share }}%</strong>
                                </div>
                                <!-- Stat Card: Indicados -->
                                <div class="stat-card">
                                    <span class="text-sm text-text-secondary">Indicados</span>
                                    <strong class="text-2xl font-bold">{{ indications }}</strong>
                                </div>
                                <!-- Stat Card: Depósitos Gerados (NOVO) -->
                                <div class="stat-card">
                                    <span class="text-sm text-text-secondary">Depósitos Gerados</span>
                                    <strong class="text-2xl font-bold">{{ state.currencyFormat(parseFloat(deposits_generated), wallet.currency) }}</strong>
                                </div>
                                <!-- Stat Card: Depósitos Pagos (NOVO) -->
                                <div class="stat-card">
                                    <span class="text-sm text-text-secondary">Depósitos Pagos</span>
                                    <strong class="text-2xl font-bold">{{ state.currencyFormat(parseFloat(deposits_paid), wallet.currency) }}</strong>
                                </div>
                                <!-- Stat Card: Saldo Disponível -->
                                <div class="stat-card bg-green-500/10 border-green-500/30">
                                    <span class="text-sm text-green-300">Saldo Disponível</span>
                                    <strong class="text-2xl font-bold text-white">{{ state.currencyFormat(parseFloat(wallet.refer_rewards), wallet.currency) }}</strong>
                                </div>
                            </div>
                             <div class="mt-6">
                                <button @click.prevent="opemModalWithdrawal" class="w-full py-3 rounded-lg text-base btn-primary">
                                    <i class="fa-solid fa-dollar-sign mr-2"></i> Solicitar Saque de Comissão
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VISTA PARA SE TORNAR AFILIADO -->
                <div v-else class="card-base flex flex-col items-center justify-center text-center p-10 md:p-16">
                    <div v-if="!isLoadingGenerate">
                        <i class="fa-solid fa-users text-5xl mb-4" style="color: var(--accent-primary);"></i>
                        <h2 class="text-2xl font-bold mb-2">Torne-se um Afiliado</h2>
                        <p class="text-text-secondary max-w-md mx-auto mb-6">
                            Lucre até R$20.000 por dia apenas indicando pessoas e acompanhe seus ganhos em tempo real!
                        </p>
                        <button @click.prevent="generateCode" class="px-8 py-3 rounded-lg text-base btn-primary">
                            Criar meu Link de Afiliado
                        </button>
                    </div>
                     <div v-if="isLoadingGenerate" role="status">
                        <i class="fa-solid fa-spinner fa-spin" style="font-size: 45px; color: var(--accent-primary);"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL SAQUE DE AFILIADO -->
        <div v-if="isWithdrawalModalVisible" class="modal-overlay active" @click.self="opemModalWithdrawal">
             <div class="modal-content">
                <span @click.prevent="opemModalWithdrawal" class="close-button">
                    <i class="fa-solid fa-xmark text-lg text-text-secondary"></i>
                </span>
                <div class="flex items-center mb-6">
                     <i class="fa-solid fa-dollar-sign text-3xl mr-4" style="color: var(--accent-primary);"></i>
                    <p class="font-bold text-2xl text-white">Saque de Comissão</p>
                </div>
                
                <form @submit.prevent="makeWithdrawal" class="space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-text-secondary">Valor do Saque</label>
                        <input v-model="withdrawalForm.amount" type="number" class="input" placeholder="0,00" required>
                        <span v-if="wallet" class="text-sm text-text-secondary mt-1">Saldo disponível: {{ state.currencyFormat(parseFloat(wallet?.refer_rewards), wallet?.currency) }}</span>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-text-secondary">Tipo de Chave</label>
                        <select v-model="withdrawalForm.pix_type" class="input" required>
                            <option value="" disabled>Selecione uma chave</option>
                            <option value="document">CPF</option>
                            <option value="phone">Celular</option>
                            <option value="email">E-mail</option>
                            <option value="random">Chave Aleatória</option>
                        </select>
                    </div>

                    <div v-if="withdrawalForm.pix_type">
                        <label class="block mb-2 text-sm font-semibold text-text-secondary">Chave Pix</label>
                        <input 
                            v-model="withdrawalForm.pix_key"
                            v-maska
                            :data-maska="pixKeyMask"
                            type="text" 
                            class="input" 
                            placeholder="Digite a sua Chave PIX" 
                            required
                        >
                    </div>

                    <button type="submit" class="w-full py-3 rounded-lg text-base btn-primary">
                        Confirmar Saque
                    </button>
                </form>
            </div>
        </div>
    </BaseLayout>
</template>


<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import HttpApi from "@/Services/HttpApi.js";
import { useToast } from "vue-toastification";
import { useAuthStore } from "@/Stores/Auth.js";
import { useSettingStore } from "@/Stores/SettingStore.js";
import { useRouter } from "vue-router";

export default {
    props: [],
    components: { BaseLayout },
    data() {
        return {
            isLoading: true,
            isShowForm: false,
            isLoadingGenerate: false,
            setting: null,
            referencecode: '',
            referencelink: '',
            wallet: null,
            indications: 0,
            deposits_generated: 0, // Adicionado para o valor de depósitos gerados
            deposits_paid: 0,     // Adicionado para o valor de depósitos pagos
            isWithdrawalModalVisible: false,
            withdrawalForm: {
                amount: 0,
                pix_key: '',
                pix_type: '',
            }
        }
    },
    setup(props) {
        const router = useRouter();
        return {
            router
        };
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
        pixKeyMask() {
            switch (this.withdrawalForm.pix_type) {
                case 'document': return '###.###.###-##';
                case 'phone': return '(##) # ####-####';
                default: return '';
            }
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
    methods: {
        getSetting: function() {
            const settingStore = useSettingStore();
            this.setting = settingStore.setting;
        },
        copyToClipboard(text, message) {
            const _toast = useToast();
            navigator.clipboard.writeText(text).then(() => {
                _toast.success(this.$t(message));
            }).catch(err => {
                _toast.error('Falha ao copiar.');
            });
        },
        copyCode() {
            this.copyToClipboard(this.referencecode, 'Code copied successfully');
        },
        copyLink() {
            this.copyToClipboard(this.referencelink, 'Link copied successfully');
        },
        getCode: function() {
            const _this = this;
            _this.isLoading = true;
            HttpApi.get('profile/affiliates/')
                .then(response => {
                    if (response.data.code) {
                        _this.isShowForm = true;
                        _this.referencecode = response.data.code;
                        _this.referencelink = response.data.url;
                    }
                    _this.indications = response.data.indications;
                    _this.wallet = response.data.wallet;
                    _this.withdrawalForm.amount = response.data.wallet.refer_rewards;
                    
                    // AQUI: Pegue os valores do seu backend
                    _this.deposits_generated = response.data.deposits_generated || 0; 
                    _this.deposits_paid = response.data.deposits_paid || 0;

                    _this.isLoading = false;
                })
                .catch(error => {
                    _this.isShowForm = false;
                    _this.isLoading = false;
                });
        },
        generateCode: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingGenerate = true;
            HttpApi.get('profile/affiliates/generate')
                .then(response => {
                    if (response.data.status) {
                        _this.getCode();
                        _toast.success(_this.$t('Your code was generated successfully'));
                    }
                    _this.isLoadingGenerate = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingGenerate = false;
                });
        },
        opemModalWithdrawal: function() {
            this.isWithdrawalModalVisible = !this.isWithdrawalModalVisible;
        },
        makeWithdrawal: async function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            HttpApi.post('profile/affiliates/request', _this.withdrawalForm)
                .then(response => {
                    _this.opemModalWithdrawal();
                    _toast.success(_this.$t(response.data.message));
                    _this.isLoading = false;
                    _this.router.push({ name: 'profileWallet' });
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        }
    },
    created() {
        this.getSetting();
        this.getCode();
    },
    watch: {
        'withdrawalForm.pix_type'() {
            this.withdrawalForm.pix_key = '';
        }
    },
};
</script>

<style>
/* Estilos Globais do Tema */
:root {
    --bg-primary: #121212;
    --bg-secondary: #1C1C1C;
    --input-bg: #2A2A2A;
    --text-primary: #FFFFFF;
    --text-secondary: #A0A0B0;
    --accent-primary: #2EBD5C;
    --border-color: #2A2A2A;
}

body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Inter', sans-serif;
}

.card-base {
    background-color: var(--bg-secondary);
    border-radius: 12px; 
    border: 1px solid var(--border-color);
}

.btn-primary {
    background-color: var(--accent-primary);
    border: none;
    color: white;
    font-weight: 700;
    transition: all 0.2s ease;
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
    border-radius: 0.5rem;
    text-align: center;
}
.btn-secondary:hover {
    background-color: #3A3A3A;
}

.input {
    width: 100%;
    background-color: var(--input-bg);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.input:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: 0 0 0 2px rgba(46, 189, 92, 0.3);
}
select.input {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23A0A0B0' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}
</style>

<style scoped>
/* Estilos Específicos do Componente */
.stat-card {
    background-color: var(--input-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
}

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
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s;
}
.modal-overlay.active {
    opacity: 1;
    visibility: visible;
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
</style>
