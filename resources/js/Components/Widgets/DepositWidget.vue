<style>
    :root {
        --primary-green: #1ed760;
        --dark-background: #121212;
        --component-background: #1c1c1c;
        --input-background: rgba(74, 74, 74, 0.3);
        --input-border: #4a4a4a;
        --text-primary: #ffffff;
        --text-secondary: #a0aec0;
        --hot-yellow: #facc15;
    }

    .payment-modal-bg {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 1000;
        background: rgba(0,0,0,0.74);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: auto;
        padding: 2vw 0;
        /* Permite scroll se o conteúdo for grande */
    }

    .payment-container {
        background-color: var(--component-background);
        position: relative;
        max-width: 480px;
        width: 98vw;
        max-height: 97vh;
        min-height: 200px;
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 32px #000a;
        margin: 0 auto;
    }

    /* Maior para a tela do QRCode */
    .payment-container.qrcode-mode {
        max-width: 550px;
        width: 99vw;
        min-height: 420px;
        max-height: 99vh;
    }
    @media (max-width: 700px) {
        .payment-container.qrcode-mode {
            width: 100vw;
            max-width: 100vw;
            min-height: 90vh;
            border-radius: 0 !important;
        }
    }
    @media (max-width: 600px) {
        .payment-container {
            max-width: 100vw;
            width: 100vw;
            max-height: 100vh;
            border-radius: 0 !important;
        }
    }

    /* Cabeçalho */
    .header-image-container {
        position: relative;
        user-select: none;
        width: 100%;
        min-height: 100px;
    }
    .header-image-container img {
        width: 100%;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        object-fit: cover;
    }
    .header-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.1) 85%, var(--component-background) 100%);
        pointer-events: none;
    }

    .close-button {
        position: absolute;
        top: 1.2rem;
        right: 1.3rem;
        z-index: 10;
        color: rgba(255,255,255,0.8);
        background: none;
        border: none;
        font-size: 1.8rem;
        transition: all 0.18s;
        cursor: pointer;
    }
    .close-button:hover {
        color: white;
        transform: scale(1.12);
    }

    .payment-content-scroll {
        overflow-y: auto;
        padding: 24px;
        flex: 1 1 auto;
        min-height: 120px;
        max-height: 68vh;
    }

    /* QRCode modal: maior e com scroll para mobile */
    .qrcode-modal-content {
        overflow-y: auto;
        padding: 28px 18px 22px 18px;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: stretch;
        min-height: 200px;
        max-height: 80vh;
    }
    @media (max-width: 600px) {
        .qrcode-modal-content {
            padding: 12px 6px 10px 6px;
            max-height: 100vh;
        }
    }

    /* Input de valor */
    .amount-input {
        background-color: var(--input-background);
        border: 1px solid var(--input-border);
    }
    .amount-input:focus-visible {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(30, 215, 96, 0.5);
        outline: none;
    }

    .amount-buttons-container {
        display: flex;
        overflow-x: auto;
        padding: 0.75rem 0.25rem;
        gap: 8px;
        scrollbar-width: none;
    }
    .amount-buttons-container::-webkit-scrollbar {
        display: none;
    }
    .amount-button-v2 {
        background-color: rgba(30, 215, 96, 0.08);
        color: var(--primary-green);
        font-weight: 600;
        padding: 0.5rem 0.9rem;
        border-radius: 0.375rem;
        cursor: pointer;
        position: relative;
        white-space: nowrap;
        transition: all 0.2s;
        border: 2px solid transparent;
        font-size: 1.09rem;
    }
    .amount-button-v2:hover {
        background-color: rgba(30, 215, 96, 0.19);
    }
    .amount-button-v2.active {
        border-color: var(--primary-green);
        background: rgba(30,215,96,0.18);
    }
    .hot-button.active {
        border-color: var(--hot-yellow);
        color: var(--hot-yellow);
    }
    .hot-tag-v2 {
        position: absolute;
        top: -0.85rem;
        left: 50%;
        transform: translate(-50%, 0%);
        background-color: var(--hot-yellow);
        color: var(--component-background);
        font-size: 0.77rem;
        line-height: 1rem;
        padding: 0 0.35rem;
        border-radius: 0.45rem;
        display: inline-flex;
        align-items: center;
        font-weight: 900;
        text-transform: uppercase;
        box-shadow: 0 2px 6px #1111;
        z-index: 2;
    }

    .generate-btn {
        background-color: var(--primary-green);
        color: black;
        font-size: 1.1rem;
        font-weight: 700;
        transition: all 0.2s;
        padding: 18px 0;
    }
    .generate-btn:hover {
        background-color: #1fdf64;
    }
    .generate-btn:active {
        transform: scale(0.98);
    }

    /* QR Code fica embaixo agora */
    .qr-code-container-v2 {
        background-color: white;
        padding: 1.1rem;
        border-radius: 0.375rem;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 30px auto 0 auto;
        min-height: 220px;
        min-width: 220px;
        box-shadow: 0 2px 12px #0001;
    }
    @media (max-width:600px) {
        .qr-code-container-v2 {
            margin: 24px auto 0 auto;
            min-width: 120px;
            min-height: 120px;
            max-width: 95vw;
        }
    }
    .pix-details-box {
        border: 1px dashed var(--input-border);
        border-radius: 0.375rem;
        padding: 1.25rem 1rem 1.6rem 1rem;
        margin-bottom: 6px;
    }
    .copy-code-input {
        background-color: rgba(255,255,255,0.16);
        border-radius: 0.375rem;
        padding: 1rem 0.8rem;
        width: 100%;
        font-size: 1.11rem;
        outline: none;
        border: none;
        margin-bottom: 8px;
        font-weight: 600;
    }
    .copy-code-btn {
        background-color: rgba(30, 215, 96, 0.13);
        color: var(--primary-green);
        font-size: 1.19rem;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.18s;
    }
    .copy-code-btn:hover {
        background-color: rgba(30, 215, 96, 0.23);
    }
    .timer-progress-bar {
        background-color: rgba(255, 255, 255, 0.1);
        height: 0.26rem;
    }
    .timer-progress-bar div {
        background-color: var(--primary-green);
        height: 100%;
        transition: width 1s linear;
    }
    .final-pay-btn {
        background-color: var(--primary-green);
        color: black;
        font-size: 1.09rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .final-pay-btn:hover {
        background-color: #1fdf64;
    }
</style>

<template>
  <div
    class="payment-modal-bg"
    @mousedown.self="closeModal"
    @touchstart.self="closeModal"
    style="position: fixed; inset: 0; z-index: 50; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center;"
  >
    <div :class="['payment-container', showPixQRCode ? 'qrcode-mode' : '']">
      <!-- TELA DE DEPÓSITO -->
      <div v-if="!showPixQRCode" style="height: 100%; display: flex; flex-direction: column;">
        <button @click.prevent="closeModal" class="close-button">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
        </button>
        <div class="header-image-container">
          <img v-if="setting" :src="`/storage/`+setting.software_logo_black2" alt="Banner de depósito">
          <div class="header-gradient"></div>
        </div>
        <div class="payment-content-scroll">
          <div class="flex items-center gap-2 mb-4">
            <svg fill="none" viewBox="0 0 24 24" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" class="size-7"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 15v3m0 3v-3m0 0h-3m3 0h3"></path><path fill="currentColor" fill-rule="evenodd" d="M5 5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h7.083A6 6 0 0 1 12 18c0-1.148.322-2.22.881-3.131A3 3 0 0 1 9 12a3 3 0 1 1 5.869.881A5.97 5.97 0 0 1 18 12c1.537 0 2.939.578 4 1.528V8a3 3 0 0 0-3-3zm7 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" clip-rule="evenodd"></path></svg>
            <h1 class="text-2xl font-medium">Depositar</h1>
          </div>
          <form @submit.prevent="submitQRCode" class="space-y-3">
            <div>
              <label for="cpf-input" class="block font-medium mb-2 text-base">CPF:</label>
              <input id="cpf-input" type="text"
                v-model="deposit.cpf"
                @input="formatCpf"
                placeholder="000.000.000-00"
                maxlength="14"
                class="amount-input w-full rounded-md px-3.5 py-2.5 text-base" 
                required>
            </div>
            <div>
              <label for="amount-input" class="block font-medium mb-2 text-base">Valor:</label>
              <div class="relative">
                <span class="font-semibold opacity-80 absolute left-3 top-1/2 -translate-y-1/2">R$</span>
                <input id="amount-input" type="number" step="0.01"
                  v-model="deposit.amount"
                  :min="setting.min_deposit"
                  :max="setting.max_deposit"
                  :placeholder="$t('0,00')"
                  class="amount-input w-full rounded-md px-3.5 py-2.5 text-base !pl-11" 
                  required>
              </div>
            </div>
            <div class="amount-buttons-container">
              <button type="button" @click.prevent="setAmount(10.00)" :class="{'active': selectedAmount === 10.00}" class="amount-button-v2">R$&nbsp;10,00</button>
              <button type="button" @click.prevent="setAmount(30.00)" :class="{'active': selectedAmount === 30.00}" class="amount-button-v2 hot-button">
                <span class="hot-tag-v2">
                  <svg width="1em" height="1em" fill="currentColor" class="size-[0.64rem] inline" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16m0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15"></path></svg>
                  QUENTE
                </span>
                R$&nbsp;30,00
              </button>
              <button type="button" @click.prevent="setAmount(50.00)" :class="{'active': selectedAmount === 50.00}" class="amount-button-v2">R$&nbsp;50,00</button>
              <button type="button" @click.prevent="setAmount(100.00)" :class="{'active': selectedAmount === 100.00}" class="amount-button-v2">R$&nbsp;100,00</button>
              <button type="button" @click.prevent="setAmount(200.00)" :class="{'active': selectedAmount === 200.00}" class="amount-button-v2">R$&nbsp;200,00</button>
              <button type="button" @click.prevent="setAmount(500.00)" :class="{'active': selectedAmount === 500.00}" class="amount-button-v2">R$&nbsp;500,00</button>
            </div>
            <div class="pt-2">
              <button type="submit" class="generate-btn w-full inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-10 rounded-md px-6 !py-6">
                <svg width="1em" height="1em" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="size-5"><path d="M8 6H6v2h2zm-5-.75A2.25 2.25 0 0 1 5.25 3h3.5A2.25 2.25 0 0 1 11 5.25v3.5A2.25 2.25 0 0 1 8.75 11h-3.5A2.25 2.25 0 0 1 3 8.75zm2.25-.75a.75.75 0 0 0-.75.75v3.5c0 .414.336.75.75.75h3.5a.75.75 0 0 0 .75-.75v-3.5a.75.75 0 0 0-.75-.75zM6 16h2v2H6zm-3-.75A2.25 2.25 0 0 1 5.25 13h3.5A2.25 2.25 0 0 1 11 15.25v3.5A2.25 2.25 0 0 1 8.75 21h-3.5A2.25 2.25 0 0 1 3 18.75zm2.25-.75a.75.75 0 0 0-.75.75v3.5c0 .414.336.75.75.75h3.5a.75.75 0 0 0 .75-.75v-3.5a.75.75 0 0 0-.75-.75zM18 6h-2v2h2zm-2.75-3A2.25 2.25 0 0 0 13 5.25v3.5A2.25 2.25 0 0 0 15.25 11h3.5A2.25 2.25 0 0 0 21 8.75v-3.5A2.25 2.25 0 0 0 18.75 3zm-.75 2.25a.75.75 0 0 1 .75-.75h3.5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-.75.75h-3.5a.75.75 0 0 1-.75-.75zM13 13h2.75v2.75H13zm5.25 2.75h-2.5v2.5H13V21h2.75v-2.75h2.5V21H21v-2.75h-2.75zm0 0V13H21v2.75z"></path></svg>
                Gerar QR Code
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- TELA DO QR CODE (com layout invertido e responsivo) -->
      <div v-if="showPixQRCode && wallet" style="height: 100%; display: flex; flex-direction: column;">
        <button @click.prevent="closeModal" class="close-button">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
        </button>
        <div class="qrcode-modal-content">
          <h1 class="text-2xl font-semibold text-center mt-2">Depositar</h1>
          <div class="pix-details-box relative flex flex-col gap-3 items-center mb-2">
            <input
              :id="pixInputId"
              type="text"
              readonly
              class="copy-code-input text-center truncate"
              :value="qrcodecopypast"
            />
            <button @click.prevent="copyQRCode" class="copy-code-btn w-full rounded-md py-3 font-semibold">Copiar Código</button>
            <strong class="font-bold text-3xl text-green-400 mt-1">{{ state.currencyFormat(parseFloat(deposit.amount), wallet.currency) }}</strong>
          </div>
          <div class="flex justify-center w-full">
            <div class="qr-code-container-v2">
              <QRCodeVue3 :value="qrcodecopypast" :width="220" :height="220" />
            </div>
          </div>
          <div v-if="!isCompleted" class="mt-5">
            <strong class="text-amber-500 text-sm">O QR Code expira em:</strong>
            <strong class="text-xl mb-1 block">{{ formattedTime }}</strong>
            <div class="timer-progress-bar w-full rounded-full">
              <div class="rounded-full" :style="{ width: progressBarWidth }"></div>
            </div>
          </div>
          <div v-else class="text-center text-red-500 font-bold mt-5">
            Código PIX expirado
          </div>
          <div class="mt-6 flex justify-center">
            <button @click="refreshPage" class="final-pay-btn font-semibold rounded-md py-3 w-full">Já paguei</button>
          </div>
        </div>
      </div>
      <!-- TELA DE CARREGAMENTO -->
      <div v-if="isLoading" role="status" class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center gap-3">
        Gerando QR CODE..
        <i class="fa-solid fa-spinner fa-spin text-4xl text-green-400"></i>
      </div>
    </div>
  </div>
</template>



<!-- Template HTML -->




<script>
import { useToast } from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import QRCodeVue3 from "qrcode-vue3";
import { useAuthStore } from "@/Stores/Auth.js";
import { StripeCheckout } from '@vue-stripe/vue-stripe';
import { useSettingStore } from "@/Stores/SettingStore.js";
import CountdownTimer from "@/Pages/Home/CountdownTimer.vue";

export default {
    props: ['showMobile', 'title', 'isFull'],
    components: { QRCodeVue3, StripeCheckout, CountdownTimer },
    data() {
        return {
            showQRCode: false,
            totalTime: 5 * 60,
            timeRemaining: 5 * 60,
            intervalId: null,
            isCompleted: false,
            isModalOpen: true,
            isLoading: false,
            minutes: 15,
            seconds: 0,
            timer: null,
            setting: null,
            wallet: null,
            deposit: {
                amount: '',
                cpf: '',
                gateway: '',
                accept_bonus: true
            },
            selectedAmount: 0,
            showPixQRCode: false,
            qrcodecopypast: '',
            idTransaction: '',
            intervalId: null,
            paymentType: null,
            /// stripe
            elementsOptions: {
                appearance: {},
            },
            confirmParams: {
                return_url: null,
            },
            successURL: null,
            cancelURL: null,
            amount: null,
            currency: null,
            publishableKey: null,
            sessionId: null,
            paymentGateway: 'suitpay',
            logoDefault: '',
            // para id unico do input
            pixInputId: 'pixcopiaecola-' + Math.random().toString(36).substring(2,10),
        }
    },
    computed: {
        progressBarWidth() {
            const percentage = (this.timeRemaining / this.totalTime) * 100;
            return `${percentage}%`;
        },
        formattedTime() {
            const minutes = Math.floor(this.timeRemaining / 60);
            const seconds = this.timeRemaining % 60;
            return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        },
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {
        const { setting, getSettingData } = useSettingStore();
        this.setting = getSettingData();
        this.setPaymentMethod('pix', setting.default_gateway);
        this.startTimer();
        // Bloqueia o scroll da body quando modal estiver aberto (mobile/desktop UX)
        document.body.style.overflow = 'hidden';
    },
    beforeUnmount() {
        clearInterval(this.intervalId);
        clearInterval(this.timer);
        this.paymentType = null;
        document.body.style.overflow = '';
    },
    methods: {
        refreshPage() {
            // Redireciona para "/"
            window.location.href = '/';
        },
        startTimer() {
            this.intervalId = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining -= 1;
                } else {
                    this.isCompleted = true;
                    clearInterval(this.intervalId);
                }
            }, 1000);
        },
        // Fecha ao clicar no X ou no fundo escuro
        closeModal() {
            document.body.style.overflow = '';
            this.$emit('close');
          },
        closeByOverlay(e) {
            if (e.target === e.currentTarget) {
                this.closeModal();
            }
        },
        getSession() {
            const _this = this;
            HttpApi.post('stripe/session', { amount: _this.amount, currency: _this.currency }).then(response => {
                if (response.data.id) {
                    _this.sessionId = response.data.id;
                }
            }).catch(error => { });
        },
        checkoutStripe() {
            const _toast = useToast();
            if (this.amount <= 0 || this.amount === '') {
                _toast.error('Você precisa digitar um valor');
                return;
            }
            this.$refs.checkoutRef.redirectToCheckout();
        },
        getPublicKeyStripe() {
            const _this = this;
            HttpApi.post('stripe/publickey', {}).then(response => {
                _this.$nextTick(() => {
                    _this.publishableKey = response.data.stripe_public_key;
                    _this.elementsOptions.clientSecret = response.data.stripe_secret_key;
                    _this.confirmParams.return_url = response.data.successURL;
                });
            }).catch(error => { });
        },
        setPaymentMethod(type, gateway) {
            if (type === 'stripe') {
                this.getPublicKeyStripe();
            }
            this.paymentType = type;
            this.paymentGateway = gateway;
        },
        submitQRCode(event) {
            const _this = this;
            const _toast = useToast();
            if(_this.deposit.cpf === '' || _this.deposit.cpf === undefined) {
                _toast.error('Você precisa informar o CPF');
                return;
            }
            if(!_this.isValidCpf(_this.deposit.cpf)) {
                _toast.error('CPF inválido');
                return;
            }
            if(_this.deposit.amount === '' || _this.deposit.amount === undefined) {
                _toast.error(_this.$t('You need to enter a value'));
                return;
            }
            if(parseFloat(_this.deposit.amount) < parseFloat(_this.setting.min_deposit)) {
                _toast.error('O valor mínimo de depósito é de '+ _this.setting.min_deposit);
                return;
            }
            if(parseFloat(_this.deposit.amount) > parseFloat(_this.setting.max_deposit)) {
                _toast.error('O valor máximo de depósito é de '+ _this.setting.max_deposit);
                return;
            }
            _this.deposit.paymentType = _this.paymentType;
            _this.deposit.gateway = _this.paymentGateway;
            // Envia apenas números do CPF para o backend
            _this.deposit.cpf_numbers = _this.deposit.cpf.replace(/\D/g, '');

            _this.isLoading = true;
            HttpApi.post('wallet/deposit/payment', _this.deposit).then(response => {
                _this.showPixQRCode = true;
                _this.isLoading = false;
                _this.idTransaction = response.data.idTransaction;
                _this.qrcodecopypast = response.data.qrcode;

                _this.intervalId = setInterval(function () {
                    _this.checkTransactions(_this.idTransaction);
                }, 5000);

            }).catch(error => {
                Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                    _toast.error(`${value}`);
                });
                _this.showPixQRCode = false;
                _this.isLoading = false;
            });
        },
        checkTransactions(idTransaction) {
            const _this = this;
            const _toast = useToast();

            HttpApi.post(_this.paymentGateway+'/consult-status-transaction', { idTransaction: idTransaction }).then(response => {
                // Verifica se o status é PAID antes de redirecionar
                if (response.data && response.data.status === 'PAID') {
                    _toast.success('Pedido concluído com sucesso');
                    clearInterval(_this.intervalId);

                    // Redireciona para a home "/" apenas quando pago
                    window.location.href = '/';
                }
                // Se não for PAID, não faz nada (continua verificando)
            }).catch(error => {
                // Em caso de erro, não exibe mensagem nem redireciona
                // Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                //     _toast.error(`${value}`);
                // });
            });
        },

        // Copiar o Pix (moderno, com fallback para execCommand)
        copyQRCode() {
            const _toast = useToast();
            let pixValue = this.qrcodecopypast;
            let copied = false;

            // Tenta usar a API moderna
            if (navigator && navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(pixValue).then(() => {
                    copied = true;
                    _toast.success('Pix Copiado com sucesso');
                }).catch(() => {
                    copied = false;
                });
            }
            // Fallback se não suportado (seleciona input)
            if (!copied) {
                try {
                    // Garante que o input está no DOM, busca por ID dinâmico
                    let inputElement = document.getElementById(this.pixInputId);
                    if (!inputElement) {
                        // fallback para class ou outro id se alterar o template
                        inputElement = document.querySelector('.copy-code-input');
                    }
                    if (inputElement) {
                        inputElement.removeAttribute('readonly'); // para permitir seleção em alguns mobile
                        inputElement.select();
                        inputElement.setSelectionRange(0, 99999);
                        document.execCommand("copy");
                        inputElement.setAttribute('readonly', true);
                        _toast.success('Pix Copiado com sucesso');
                    }
                } catch (err) {
                    _toast.error('Erro ao copiar Pix');
                }
            }
        },

        setAmount(amount) {
            this.deposit.amount = amount;
            this.selectedAmount = amount;
        },
        getWallet() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;
            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                    _this.currency = response.data.wallet.currency;
                    _this.isLoadingWallet = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getSetting() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;
            if (settingData) {
                _this.setting = settingData;
                _this.amount = settingData.max_deposit;
                if (_this.paymentType === 'stripe' && settingData.stripe_is_enable) {
                    _this.getSession();
                }
            }
        },
        togglePaymentGateway() {
            this.paymentGateway = this.paymentGateway === 'suitpay' ? 'bspay' : 'suitpay';
            this.setPaymentMethod('pix', this.paymentGateway);
        },
        formatCpf(event) {
            let value = event.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            }
            this.deposit.cpf = value;
        },
        isValidCpf(cpf) {
            cpf = cpf.replace(/\D/g, '');
            if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
                return false;
            }
            let sum = 0;
            for (let i = 0; i < 9; i++) {
                sum += parseInt(cpf.charAt(i)) * (10 - i);
            }
            let remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) remainder = 0;
            if (remainder !== parseInt(cpf.charAt(9))) return false;
            
            sum = 0;
            for (let i = 0; i < 10; i++) {
                sum += parseInt(cpf.charAt(i)) * (11 - i);
            }
            remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) remainder = 0;
            return remainder === parseInt(cpf.charAt(10));
        }
    },
    created() {
        if(this.isAuthenticated) {
            this.getWallet();
            this.getSetting();
        }
    },
    watch: {
        amount(oldValue, newValue) {
            if (this.paymentType === 'stripe') {
                this.getSession();
                this.currency = 'USD';
            }
        },
        currency(oldValue, newValue) {
            if (this.paymentType === 'stripe') {
                this.getSession();
            }
        }
    },
};
</script>


<style scoped>
.timer {
    text-align: start;
}
.progress-bar {
    padding: 0px 6%;
    width: 100%;
    background-color: #323637;
    height: 4px;
    margin-bottom: 10px;
    position: relative;
    border-radius: 20px;
}
.progress-bar > div {
    height: 100%;
    background-color: #82A81B;
    position: absolute;
    top: 0;
    left: 0;
    transition: width 0.5s;
    border-radius: 20px;
}
.time-display {
    font-size: 24px;
    font-weight: bold;
}
.completed-message {
    padding: 40px 0;
    font-size: 22px;
    color: #C13A5C;
    text-align: center;
    font-weight: bold;
}
.gateway-selected {
    cursor: pointer;
    border-radius: 8px;
    border: 1px solid var(--ci-primary-color);
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #2E3131;
    max-height: 40px;
}
.gateway-selected>img {
    max-height: 20px;
    height: auto;
    filter: drop-shadow(0px 0px 1px rgb(54, 54, 54)) drop-shadow(0px 0px 1px rgb(39, 39, 39));
}
.gateway-selected-active {
    border-color: #b0f000;
    background-color: var(--ci-primary-color);
    color: black;
}
</style>
