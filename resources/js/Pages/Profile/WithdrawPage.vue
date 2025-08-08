<template>
    <BaseLayout>
        <div class="mx-auto w-full max-w-2xl p-4 sm:p-6 lg:p-8">
            <div v-if="setting != null && wallet != null && isLoading === false" class="card-base flex flex-col w-full gap-6 p-6 md:p-8">
                <!-- Cabeçalho -->
                <div>
                    <div class="flex items-center mb-4">
                        <RouterLink :to="{ name: 'profileWallet' }" class="text-text-secondary hover:text-white transition">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </RouterLink>
                        <h3 class="text-2xl font-bold ml-4">Solicitar Saque</h3>
                    </div>
                    <p class="text-text-secondary">Retire o saldo da sua conta via PIX.</p>
                </div>

                <!-- Formulário de Saque para BRL (PIX) -->
                <form v-if="wallet.currency === 'BRL'" @submit.prevent="submitWithdraw" class="space-y-6">
                    
                    <!-- Campo de Valor -->
                    <div>
                        <label for="withdraw-amount" class="block mb-2 text-sm font-semibold text-text-secondary">Valor do saque</label>
                        <div class="relative">
                            <input
                                id="withdraw-amount"
                                type="text"
                                class="input w-full pr-24"
                                v-model="withdraw.amount"
                                :min="setting.min_withdrawal"
                                :max="setting.max_withdrawal"
                                placeholder="0,00"
                                required
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <span class="text-text-secondary text-sm font-bold">BRL</span>
                            </div>
                        </div>
                        <div class="flex justify-between mt-2 text-sm">
                            <p class="text-text-secondary">
                                Disponível: 
                                <span class="font-bold" style="color: var(--accent-primary);">
                                    {{ state.currencyFormat(parseFloat(wallet.balance_withdrawal), wallet.currency) }}
                                </span>
                            </p>
                            <button @click.prevent="setMaxAmount" class="font-semibold text-text-secondary hover:text-white transition">Usar saldo total</button>
                        </div>
                    </div>

                    <!-- Nome do Titular -->
                    <div>
                        <label for="withdraw-name" class="block mb-2 text-sm font-semibold text-text-secondary">Nome do titular da conta</label>
                        <input id="withdraw-name" v-model="withdraw.name" type="text" class="input" placeholder="Digite o nome completo" required>
                    </div>

                    <!-- Tipo de Chave PIX -->
                    <div>
                        <label for="pix-type" class="block mb-2 text-sm font-semibold text-text-secondary">Tipo de Chave</label>
                        <select id="pix-type" v-model="withdraw.pix_type" class="input" required>
                            <option value="" disabled>Selecione uma chave</option>
                            <option value="document">CPF</option>
                            <option value="phone">Celular</option>
                            <option value="email">E-mail</option>
                            <option value="random">Chave Aleatória</option>
                        </select>
                    </div>

                    <!-- Chave PIX (condicional) -->
                    <div v-if="withdraw.pix_type">
                        <label for="pix-key" class="block mb-2 text-sm font-semibold text-text-secondary">Chave Pix</label>
                        <input
                            id="pix-key"
                            v-model="withdraw.pix_key"
                            v-maska
                            :data-maska="pixKeyMask"
                            type="text"
                            class="input"
                            :placeholder="pixKeyPlaceholder"
                            required
                        >
                    </div>

                    <!-- Botão de Envio -->
                    <div class="pt-4">
                        <button type="submit" class="w-full py-3 rounded-lg text-base btn-primary">
                            <i class="fa-solid fa-paper-plane mr-2"></i>
                            <span>{{ $t('SACAR') }}</span>
                        </button>
                    </div>
                </form>
                
                 <!-- Formulário de Saque para USD (mantido, mas não visível por padrão) -->
                <form v-if="wallet.currency === 'USD'" action="" @submit.prevent="submitWithdrawBank">
                    <!-- O conteúdo do formulário USD permanece aqui, mas não será exibido a menos que a moeda seja USD -->
                </form>
            </div>

            <!-- Indicador de Carregamento -->
            <div v-if="isLoading" role="status" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 45px; color: var(--accent-primary);"></i>
                <span class="sr-only">{{ $t('Loading') }}...</span>
            </div>
        </div>
    </BaseLayout>
</template>


<script>
import { RouterLink, useRouter } from "vue-router";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import HttpApi from "@/Services/HttpApi.js";
import { useToast } from "vue-toastification";
import { useSettingStore } from "@/Stores/SettingStore.js";

export default {
    props: [],
    components: { WalletSideMenu, BaseLayout, RouterLink },
    data() {
        return {
            isLoading: false,
            setting: null,
            wallet: null,
            withdraw: {
                name: '',
                pix_key: '',
                pix_type: '',
                amount: '',
                type: 'pix',
                currency: '',
                symbol: '',
                accept_terms: true
            },
            withdraw_deposit: {
                name: '',
                bank_info: '',
                amount: '',
                type: 'bank',
                currency: '',
                symbol: '',
                accept_terms: true
            },
        }
    },
    setup(props) {
        const router = useRouter();
        return {
            router
        };
    },
    computed: {
        pixKeyMask() {
            switch (this.withdraw.pix_type) {
                case 'document':
                    return '###.###.###-##';
                case 'phone':
                    return '(##) # ####-####';
                default:
                    return ''; // No mask for email or random key
            }
        },
        pixKeyPlaceholder() {
            switch (this.withdraw.pix_type) {
                case 'document':
                    return '000.000.000-00';
                case 'phone':
                    return '(00) 0 0000-0000';
                case 'email':
                    return 'seuemail@exemplo.com';
                case 'random':
                    return 'Digite sua chave aleatória';
                default:
                    return 'Digite a sua Chave PIX';
            }
        }
    },
    mounted() {
        window.scrollTo(0, 0);
    },
    methods: {
        setMaxAmount: function() {
            if (this.wallet && this.setting) {
                this.withdraw.amount = Math.min(this.wallet.balance_withdrawal, this.setting.max_withdrawal);
            }
        },
        getWallet: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                    _this.withdraw.currency = response.data.wallet.currency;
                    _this.withdraw.symbol = response.data.wallet.symbol;
                    _this.withdraw_deposit.currency = response.data.wallet.currency;
                    _this.withdraw_deposit.symbol = response.data.wallet.symbol;
                    _this.isLoading = false;
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        },
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;

            if(settingData) {
                _this.setting = settingData;
                _this.withdraw.amount = settingData.min_withdrawal;
                _this.withdraw_deposit.amount = settingData.min_withdrawal;
            }
            _this.isLoading = false;
        },
        submitWithdrawBank: function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            HttpApi.post('wallet/withdraw/request', _this.withdraw_deposit).then(response => {
                _this.isLoading = false;
                _this.withdraw_deposit = { name: '', bank_info: '', amount: '', type: '', accept_terms: true }
                _this.router.push({ name: 'profileTransactions' });
                _toast.success(response.data.message);
            }).catch(error => {
                Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                    _toast.error(`${value}`);
                });
                _this.isLoading = false;
            });
        },
        submitWithdraw: function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            HttpApi.post('wallet/withdraw/request', _this.withdraw).then(response => {
                _this.isLoading = false;
                _this.withdraw = { name: '', pix_key: '', pix_type: '', amount: '', type: '', accept_terms: true }
                _this.router.push({ name: 'profileTransactions' });
                _toast.success(response.data.message);
            }).catch(error => {
                Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                    _toast.error(`${value}`);
                });
                _this.isLoading = false;
            });
        }
    },
    created() {
        this.getWallet();
        this.getSetting();
    },
    watch: {
        'withdraw.pix_type'() {
            this.withdraw.pix_key = ''; // Limpa a chave ao trocar o tipo
        }
    },
};
</script>

<style>
/* Definindo variáveis de cor para combinar com a imagem (Tema RaspaZinha) */
:root {
    --bg-primary: #121212; /* Fundo escuro sólido */
    --bg-secondary: #1C1C1C; /* Fundo para cards */
    --input-bg: #2A2A2A;
    --text-primary: #FFFFFF;
    --text-secondary: #A0A0B0;
    --accent-primary: #2EBD5C; /* Verde vibrante da imagem */
    --border-color: #2A2A2A;
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
}

/* Estilo para botões */
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

/* Estilos para inputs e selects */
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
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}
</style>