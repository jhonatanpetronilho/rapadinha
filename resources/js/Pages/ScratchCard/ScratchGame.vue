<template>
  <BaseLayout>
    <div class="mx-auto w-full max-w-[1240px] px-4 mt-8 mb-4">
      <WinnersCarousel />
    </div>

    <div class="game-wrapper max-w-lg mx-auto bg-[#181a20] p-4 rounded-xl shadow-lg">

      <div class="scratch-area" :style="{ width: scratchDimensions.width + 'px', height: scratchDimensions.height + 'px' }">

        <div v-if="!gameStarted" class="pre-game-overlay">
          <div v-if="isUserLoggedIn" class="buy-modal">
            <svg fill="currentColor" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg" class="size-24 text-white mb-4"><path d="M198.51 56.09C186.44 35.4 169.92 24 152 24h-48c-17.92 0-34.44 11.4-46.51 32.09C46.21 75.42 40 101 40 128s6.21 52.58 17.49 71.91C69.56 220.6 86.08 232 104 232h48c17.92 0 34.44-11.4 46.51-32.09C209.79 180.58 216 155 216 128s-6.21-52.58-17.49-71.91Zm1.28 63.91h-32a152.8 152.8 0 0 0-9.68-48h30.59c6.12 13.38 10.16 30 11.09 48Zm-20.6-64h-28.73a83 83 0 0 0-12-16H152c10 0 19.4 6 27.19 16ZM152 216h-13.51a83 83 0 0 0 12-16h28.73C171.4 210 162 216 152 216Zm36.7-32h-30.58a152.8 152.8 0 0 0 9.68-48h32c-.94 18-4.98 34.62-11.1 48Z"></path></svg>
            <span class="text-white font-semibold mb-2">Comprar por R$ {{ scratch?.price }}</span>
            <button class="buy-button-main" @click="startGame">
              <section class="flex gap-2 justify-between items-center">
                <div class="flex gap-1 items-center font-semibold"> Comprar </div>
                <div class="price-tag"><span>R$</span> {{ scratch?.price }}</div>
              </section>
            </button>
          </div>
          <div v-else class="buy-modal">
             <svg fill="currentColor" viewBox="0 0 256 256" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" class="size-24 text-white mb-4"><path d="M230.92 212c-15.23-26.33-38.7-45.21-66.09-54.16a72 72 0 1 0-73.66 0C63.78 166.78 40.31 185.66 25.08 212a8 8 0 1 0 13.85 8c18.84-32.56 52.14-52 89.07-52s70.23 19.44 89.07 52a8 8 0 1 0 13.85-8ZM72 96a56 56 0 1 1 56 56a56.06 56.06 0 0 1-56-56Zm148.69 88h-29.4a8 8 0 0 0 0 16h29.4a8 8 0 0 0 0-16Zm-12.29-28.29a8 8 0 0 0-11.32 0l-29.39 29.4a8 8 0 0 0 11.31 11.31l29.4-29.39a8 8 0 0 0 0-11.32Zm-1.41-56.57a8 8 0 0 0-11.32-11.31l-29.39 29.4a8 8 0 0 0 11.31 11.31l29.4-29.4Z"></path></svg>
             <span class="text-white font-semibold mb-2">Faça login para jogar</span>
             <button class="buy-button-main" @click="redirectToLogin">Registrar</button>
          </div>
          <div class="background-text">RASPE AQUI!</div>
        </div>

        <div v-if="gameStarted" class="scratch-grid-wrapper">
          <div class="scratch-grid">
            <div v-for="(card, idx) in cards" :key="idx" class="card-item">
              <img v-if="card.image" :src="card.image" class="card-image" />
              <span class="card-name">{{ card.name }}</span>
              <span v-if="card.value > 0" class="card-value">R$ {{ card.value }}</span>
            </div>
          </div>
          <canvas ref="scratchCanvas" @mousedown="handleMouseDown" @mousemove="handleMouseMove" @mouseup="handleMouseUp" @touchstart.prevent="handleMouseDown" @touchmove.prevent="handleMouseMove" @touchend="handleMouseUp"></canvas>
        </div>

      </div>

      <div v-if="gameFinished" class="result-modal-overlay">
        <div class="result-modal">
            <div v-if="win" class="flex flex-col items-center">
                <span class="text-yellow-300 text-sm font-bold">VOCÊ GANHOU</span>
                <span class="text-white text-4xl font-bold my-2">R$ {{ winPrize.value }}</span>
                <p class="text-gray-400 text-center">O valor foi adicionado à sua carteira.</p>
            </div>
            <div v-else class="flex flex-col items-center">
                <span class="text-white text-2xl font-bold mb-2">Não foi dessa vez!</span>
                <p class="text-gray-400 text-center">Não desanime, a sorte acompanha você na próxima!</p>
            </div>
            <button class="play-again-button" @click="resetGame">
                Jogar Novamente
            </button>
        </div>
      </div>

      <div class="bottom-controls">
        <button class="buy-button-bottom" @click="startGame" :disabled="loading || gameStarted">
            Comprar
            <span class="price-tag-bottom">R$ {{ scratch?.price }}</span>
        </button>
        <button class="control-button" @click="toggleTurbo" :class="{ 'active': isTurboMode }">
            <svg viewBox="0 0 24 24" fill="currentColor" class="size-5"><path d="M7 2v11h3v9l7-12h-4l4-8z"></path></svg>
            Turbo
        </button>
        <button class="control-button" @click="toggleAutoPlay" :class="{ 'active': isAutoPlay }">
            <svg viewBox="0 0 24 24" fill="currentColor" class="size-5"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"></path></svg>
            Auto
        </button>
      </div>
    </div>

    <div class="extra-info-wrapper max-w-lg mx-auto mt-8 px-4">
        <div class="instructions-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-gray-400 shrink-0"><path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" /></svg>
            <div>
                <h3 class="text-white font-bold">Reúna 3 imagens iguais e conquiste seu prêmio!</h3>
                <p class="text-gray-400 text-sm mt-1">
                    O valor correspondente será creditado automaticamente na sua conta.
                    Se preferir receber o produto físico, basta entrar em contato com o nosso suporte.
                </p>
            </div>
        </div>

        <h2 class="text-white text-2xl font-bold mt-8 mb-4">
            Prêmios da Raspadinha:
        </h2>

        <div v-if="scratch && scratch.prizes" class="prizes-grid">
            <div v-for="prize in scratch.prizes" :key="prize.id" class="prize-card">
                <img :src="'/storage/' + prize.image" :alt="prize.name" class="prize-image">
                <span class="prize-name">{{ prize.name }}</span>
                <span class="prize-value">R$ {{ parseFloat(prize.value).toFixed(2).replace('.', ',') }}</span>
            </div>
        </div>
    </div>

  </BaseLayout>
</template>

<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import WinnersCarousel from "@/Components/WinnersCarousel.vue";
import axios from 'axios';
import confetti from 'canvas-confetti';

export default {
  name: "ScratchGame",
  components: { BaseLayout, WinnersCarousel },
  data() {
    return {
      scratch: null,
      loading: false,
      gameStarted: false,
      gameFinished: false,
      win: false,
      winPrize: {},
      cards: [],
      gameKey: 0,
      scratchDimensions: { width: 432, height: 434 },
      isDrawing: false,
      canvasContext: null,
      isTurboMode: false,
      isAutoPlay: false,
      isUserLoggedIn: false,
    }
  },
  mounted() {
    const id = this.$route.params.id;
    axios.get(`/api/scratch/card/${id}`).then(res => {
        this.scratch = res.data;
    }).catch(error => {
        console.error("Erro ao carregar dados da raspadinha:", error);
        alert("Não foi possível carregar os dados do jogo. Tente recarregar a página.");
    });
    this.checkLoginStatus();
    this.updateDimensions();
    window.addEventListener('resize', this.updateDimensions);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.updateDimensions);
  },
  methods: {
    checkLoginStatus() {
        const token = localStorage.getItem('token');
        this.isUserLoggedIn = !!token;
    },
    redirectToLogin() {
        this.$router.push({ name: 'register' }); // ou 'login'
    },
    updateDimensions() {
      if (window.innerWidth <= 768) { this.scratchDimensions = { width: 352, height: 354 } }
      else { this.scratchDimensions = { width: 432, height: 434 } }
    },
    async startGame() {
      if (!this.isUserLoggedIn) {
          this.redirectToLogin();
          return;
      }
      if (this.gameStarted) return;
      this.loading = true;
      this.gameFinished = false;
      try {
        const token = localStorage.getItem('token');
        const res = await axios.post(`/api/scratch/draw/${this.scratch.id}`, {}, { headers: { Authorization: 'Bearer ' + token } });
        this.cards = res.data.cards;
        this.win = res.data.win;
        this.winPrize = res.data.prize || {};
        this.gameStarted = true;
        this.loading = false;
        this.$nextTick(() => {
          if (this.isTurboMode) {
            this.revealAllInstantly();
          } else {
            this.setupCanvas();
          }
        });
      } catch (error) {
        this.loading = false;
        if(error.response && error.response.status === 401) {
            this.isUserLoggedIn = false;
        } else if(error.response && error.response.status === 403) {
            alert('Saldo insuficiente para jogar!');
        } else {
            alert('Erro ao tentar jogar. Tente novamente!');
        }
      }
    },
    setupCanvas() {
        const canvas = this.$refs.scratchCanvas;
        if (!canvas) return;
        this.canvasContext = canvas.getContext('2d', { willReadFrequently: true });
        canvas.width = this.scratchDimensions.width;
        canvas.height = this.scratchDimensions.height;
        const coverImage = new Image();
        coverImage.src = '/images/raspadinha_frente.png';
        coverImage.onload = () => {
            this.canvasContext.drawImage(coverImage, 0, 0, canvas.width, canvas.height);
        };
    },
    getMousePos(canvas, evt) {
        const rect = canvas.getBoundingClientRect();
        const touch = evt.touches ? evt.touches[0] : evt;
        return {
            x: touch.clientX - rect.left,
            y: touch.clientY - rect.top
        };
    },
    handleMouseDown(evt) {
        this.isDrawing = true;
        const pos = this.getMousePos(this.$refs.scratchCanvas, evt);
        this.erase(pos.x, pos.y);
    },
    handleMouseMove(evt) {
        if (!this.isDrawing) return;
        const pos = this.getMousePos(this.$refs.scratchCanvas, evt);
        this.erase(pos.x, pos.y);
    },
    handleMouseUp() {
        this.isDrawing = false;
        this.checkRevealed();
    },
    erase(x, y) {
        if (!this.canvasContext) return;
        this.canvasContext.globalCompositeOperation = 'destination-out';
        this.canvasContext.beginPath();
        this.canvasContext.arc(x, y, 25, 0, 2 * Math.PI);
        this.canvasContext.fill();
    },
    checkRevealed() {
        if (this.gameFinished || !this.canvasContext) return;
        const canvas = this.$refs.scratchCanvas;
        const imageData = this.canvasContext.getImageData(0, 0, canvas.width, canvas.height);
        const data = imageData.data;
        let transparentPixels = 0;
        for (let i = 3; i < data.length; i += 4) {
            if (data[i] === 0) {
                transparentPixels++;
            }
        }
        const totalPixels = data.length / 4;
        const percent = (transparentPixels / totalPixels) * 100;
        if (percent > 70) {
            this.finishGame();
        }
    },
    finishGame() {
        this.gameFinished = true;
        if (this.win) {
            this.triggerCoinAnimation();
        }
    },
    revealAllInstantly() {
        this.finishGame();
    },
    toggleTurbo() {
        this.isTurboMode = !this.isTurboMode;
    },
    toggleAutoPlay() {
        this.isAutoPlay = !this.isAutoPlay;
        if (this.isAutoPlay) {
            console.log("Autoplay ativado (lógica a ser implementada)");
        } else {
            console.log("Autoplay desativado");
        }
    },
    triggerCoinAnimation() {
        const canvas = this.$refs.scratchCanvas;
        if (!canvas) return;
        const rect = canvas.getBoundingClientRect();
        const x = (rect.left + rect.right) / 2 / window.innerWidth;
        const y = rect.top / window.innerHeight;
        confetti({
            particleCount: 150,
            spread: 90,
            origin: { x: x, y: y - 0.1 },
            angle: 90,
            gravity: 1,
            drift: 0,
            colors: ['#FFD700', '#FFA500', '#FFC400', '#FFBF00', '#B8860B']
        });
    },
    resetGame() {
      this.gameStarted = false;
      this.cards = [];
      this.gameFinished = false;
      this.win = false;
      this.winPrize = {};
      this.gameKey++;
    }
  }
}
</script>

<style scoped>
/* DEFINIÇÃO DA COR PRIMÁRIA */
:root {
    --primary-green: #22c55e;
}

/* ESTILOS GERAIS */
.game-wrapper { display: flex; flex-direction: column; align-items: center; }
.scratch-area { position: relative; display: flex; justify-content: center; align-items: center; background-color: #1f2937; border-radius: 1rem; overflow: hidden; margin-bottom: 1rem; border: 1px solid #374151; }
.pre-game-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 10; }
.buy-modal { display: flex; flex-direction: column; align-items: center; }
.buy-button-main { display: flex; align-items: center; justify-content: center; padding: 0.5rem; background-color: var(--primary-green, #22c55e); color: white; font-weight: bold; border-radius: 0.5rem; cursor: pointer; transition: transform 0.1s; border: none; min-width: 200px; }
.buy-button-main:active { transform: scale(0.95); }
.price-tag { background-color: rgba(0, 0, 0, 0.4); border-radius: 0.375rem; padding: 0.5rem; text-align: center; }
.price-tag span { color: var(--primary-green, #22c55e); }
.background-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 4rem; font-weight: 900; color: rgba(255, 255, 255, 0.05); z-index: -1; text-transform: uppercase; white-space: nowrap; }
.scratch-grid-wrapper { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
.scratch-grid-wrapper canvas { position: absolute; top: 0; left: 0; cursor: crosshair; }
.bottom-controls { display: flex; justify-content: space-between; align-items: center; width: 100%; background-color: #1f2937; padding: 0.5rem; border-radius: 9999px; }
.buy-button-bottom { display: flex; align-items: center; gap: 0.5rem; background-color: var(--primary-green, #22c55e); color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 9999px; flex-grow: 1; justify-content: center; border: none; cursor: pointer; }
.buy-button-bottom:disabled { background-color: #4b5563; cursor: not-allowed; }
.price-tag-bottom { background-color: rgba(0,0,0,0.2); color: white; padding: 0.1rem 0.5rem; border-radius: 9999px; font-size: 0.8rem; }
.control-button { display: flex; flex-direction: column; align-items: center; font-size: 0.7rem; color: #a0aec0; background: none; border: none; padding: 0.5rem; margin-left: 0.5rem; cursor: pointer; }
.control-button.active { color: var(--primary-green, #22c55e); }
.scratch-grid { display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: repeat(3, 1fr); gap: 10px; width: 100%; height: 100%; padding: 15px; box-sizing: border-box; }
.card-item { display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: #4a5568; border-radius: 8px; padding: 5px; color: white; text-align: center; overflow: hidden; }
.card-image { width: 80%; max-width: 80px; aspect-ratio: 1 / 1; object-fit: contain; margin-bottom: 0.5rem; }
.card-name { font-size: 0.75rem; font-weight: bold; line-height: 1; }
.card-value { font-size: 0.7rem; color: #facc15; }
.result-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); backdrop-filter: blur(5px); display: flex; justify-content: center; align-items: center; z-index: 50; }
.result-modal { background-color: #2d3748; padding: 2rem; border-radius: 1rem; border: 1px solid #4a5568; display: flex; flex-direction: column; align-items: center; gap: 1.5rem; width: 90%; max-width: 350px; }
.play-again-button { width: 100%; padding: 0.75rem; font-weight: bold; color: white; background-color: var(--primary-green, #22c55e); border: none; border-radius: 0.5rem; cursor: pointer; }

/* NOVOS ESTILOS */
.extra-info-wrapper { width: 100%; }
.instructions-box { display: flex; gap: 1rem; background-color: #2d3748; padding: 1rem; border-radius: 0.75rem; }
.prizes-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
@media (min-width: 640px) { .prizes-grid { grid-template-columns: repeat(3, 1fr); } }
.prize-card { background-color: #2d3748; border-radius: 0.75rem; padding: 1rem; display: flex; flex-direction: column; align-items: center; text-align: center; }
.prize-image { width: 80%; max-width: 120px; aspect-ratio: 1 / 1; object-fit: contain; margin-bottom: 1rem; }
.prize-name { font-weight: bold; color: white; margin-bottom: 0.5rem; }
.prize-value { background-color: white; color: #1a202c; font-weight: bold; padding: 0.25rem 1rem; border-radius: 9999px; font-size: 0.9rem; }
</style>