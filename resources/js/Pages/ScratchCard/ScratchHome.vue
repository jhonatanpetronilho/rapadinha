<template>
  <BaseLayout>
    <div class="carousel-banners mt-2">
      <div class="mx-auto w-full max-w-[1240px] p-4 padding-mobile-banner">
        <Carousel v-bind="settings" :breakpoints="breakpoints" ref="carouselBanner" v-if="banners.length">
          <Slide v-for="(banner, index) in banners" :key="index">
            <div class="carousel__item rounded w-full">
              <a :href="banner.link" class="w-full h-full rounded" target="_blank" rel="noopener">
                <img :src="`/storage/${banner.image}`" alt="" />
              </a>
            </div>
          </Slide>
        </Carousel>
      </div>
    </div>

    <div class="mx-auto w-full max-w-[1240px] px-4 mt-8 mb-4">
      <WinnersCarousel />
    </div>

    <div class="max-w-[1240px] mx-auto p-4 mt-8">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
          <svg width="1em" height="1em" fill="currentColor" class="bi bi-fire text-green-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16m0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15"></path></svg>
          Destaques
        </h2>
        <a href="#" class="text-sm text-gray-400 hover:text-white flex items-center gap-1">
          Ver mais
          <svg width="1em" height="1em" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="size-4"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 4 8 8-8 8"></path></svg>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div
          v-for="(scratch, index) in scratchCards"
          :key="scratch.id"
          class="scratch-card-item group"
          :style="{ '--animation-delay': (index * 100) + 'ms' }"
        >
          <div class="w-full aspect-[5/1] overflow-hidden rounded-t-lg">
            <img :src="scratch.banner ? '/storage/' + scratch.banner : '/imagens/placeholder.jpg'" :alt="scratch.name" class="w-full h-full object-cover">
          </div>

          <div class="flex justify-between items-center mt-4">
            <h1 class="font-semibold text-white">{{ scratch.name }}</h1>
            <h2 class="text-xs text-amber-400 font-medium opacity-90 uppercase">PRÊMIOS DE ATÉ R$&nbsp;{{ scratch.max_prize }}</h2>
          </div>

          <div class="flex items-center justify-between mt-4">
            <button class="play-button" @click="goToGame(scratch.id)">
              <section class="flex gap-2 justify-between items-center">
                <div class="flex gap-1 items-center font-semibold">
                  <svg fill="currentColor" viewBox="0 0 256 256" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" class="size-5"><path d="M198.51 56.09C186.44 35.4 169.92 24 152 24h-48c-17.92 0-34.44 11.4-46.51 32.09C46.21 75.42 40 101 40 128s6.21 52.58 17.49 71.91C69.56 220.6 86.08 232 104 232h48c-17.92 0-34.44-11.4-46.51-32.09C209.79 180.58 216 155 216 128s-6.21-52.58-17.49-71.91Zm1.28 63.91h-32a152.8 152.8 0 0 0-9.68-48h30.59c6.12 13.38 10.16 30 11.09 48Zm-20.6-64h-28.73a83 83 0 0 0-12-16H152c10 0 19.4 6 27.19 16ZM152 216h-13.51a83 83 0 0 0 12-16h28.73C171.4 210 162 216 152 216Zm36.7-32h-30.58a152.8 152.8 0 0 0 9.68-48h32c-.94 18-4.98 34.62-11.1 48Z"></path></svg>
                  <span class="font-semibold">Jogar</span>
                </div>
                <div class="play-button-price">
                  <span class="text-green-400">R$</span> {{ scratch.price }}
                </div>
              </section>
            </button>
            <a @click="goToGame(scratch.id)" class="view-prizes-link">
              <svg viewBox="0 0 512 512" fill="currentColor" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" class="group-hover:animate-wiggle size-4"><path d="m190.5 68.8 34.8 59.2H152c-22.1 0-40-17.9-40-40s17.9-40 40-40h2.2c14.9 0 28.8 7.9 36.3 20.8zM64 88c0 14.4 3.5 28 9.6 40H32c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32h448c17.7 0 32-14.3 32-32v-64c0-17.7-14.3-32-32-32h-41.6c6.1-12 9.6-25.6 9.6-40 0-48.6-39.4-88-88-88h-2.2c-31.9 0-61.5 16.9-77.7 44.4L256 85.5l-24.1-41C215.7 16.9 186.1 0 154.2 0H152c-48.6 0-88 39.4-88 88zm336 0c0 22.1-17.9 40-40 40h-73.3l34.8-59.2c7.6-12.9 21.4-20.8 36.3-20.8h2.2c22.1 0 40 17.9 40 40zM32 288v176c0 26.5 21.5 48 48 48h144V288zm256 224h144c26.5 0 48-21.5 48-48V288H288z"></path></svg>
              <span>VER PRÊMIOS</span>
              <svg width="1em" height="1em" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="size-3"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 4 8 8-8 8"></path></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<script>
// A SEÇÃO SCRIPT NÃO PRECISA DE NENHUMA ALTERAÇÃO
import { Carousel, Slide, Navigation, Pagination } from 'vue3-carousel'
import BaseLayout from "@/Layouts/BaseLayout.vue";
import HttpApi from "@/Services/HttpApi.js";
import WinnersCarousel from "@/Components/WinnersCarousel.vue";
import axios from 'axios';

export default {
  name: "ScratchHome",
  components: {
    BaseLayout, Carousel, Slide, Navigation, Pagination, WinnersCarousel
  },
  data() {
    return {
      banners: [],
      bannersMobile: [],
      scratchCards: [],
      settings: { itemsToShow: 1, snapAlign: 'center', autoplay: 3000, wrapAround: true },
      breakpoints: { 700: { itemsToShow: 1 }, 1024: { itemsToShow: 1 } }
    }
  },
  async created() {
    await this.getBanners();
    await this.getScratchCards();
  },
  methods: {
    async getBanners() {
      try {
        const res = await HttpApi.get('settings/banners');
        this.banners = res.data.banners.filter(b => b.type === 'carousel');
        this.bannersMobile = res.data.banners.filter(b => b.type === 'mobile');
      } catch (e) {
        console.error(e);
      }
    },
    async getScratchCards() {
      try {
        const res = await axios.get('/api/scratch/cards');
        this.scratchCards = res.data;
      } catch (e) {
        console.error(e);
      }
    },
    goToGame(id) {
      this.$router.push({ name: 'scratch-game', params: { id } });
    }
  }
}
</script>

<style scoped>
/* DEFINIÇÃO DA COR PRIMÁRIA */
:root {
    --primary-green: #22c55e;
}

/* ESTILOS PARA OS CARDS DE DESTAQUE */
.scratch-card-item {
    --border-color: linear-gradient(327deg, #1f2937, var(--primary-green, #22c55e));
    --bg-color: #1f2937;

    background: var(--bg-color);
    background: padding-box var(--bg-color), border-box var(--border-color);
    border: 2px solid transparent;
    border-radius: 0.75rem;
    padding: 1rem;
    transition: all 0.4s;
    
    /* ANIMAÇÃO DE ENTRADA */
    opacity: 0;
    transform: translateY(20px);
    animation: fade-in-up 0.5s ease forwards;
    animation-delay: var(--animation-delay);
}

.scratch-card-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
}

.play-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background-color: var(--primary-green, #22c55e);
    color: white;
    font-weight: bold;
    border-radius: 0.5rem;
    padding: 0.5rem;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.play-button:hover {
    background-color: #16a34a;
}

.play-button-price {
    background-color: #374151;
    border-radius: 0.375rem;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}

.view-prizes-link {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #9ca3af;
    cursor: pointer;
    transition: all 0.2s;
}

.view-prizes-link:hover {
    color: var(--primary-green, #22c55e);
    transform: scale(1.05);
}

/* ANIMAÇÕES VISUAIS ADICIONAIS */

/* 1. Ícone de Fogo Pulsando */
.bi-fire {
    animation: pulse-glow 2s infinite ease-in-out;
}

@keyframes pulse-glow {
    0%, 100% {
        transform: scale(1);
        filter: drop-shadow(0 0 3px var(--primary-green, #22c55e));
    }
    50% {
        transform: scale(1.1);
        filter: drop-shadow(0 0 8px var(--primary-green, #22c55e));
    }
}

/* 2. Efeito de Brilho no Banner do Card */
.scratch-card-item .w-full.aspect-\[5\/1\] {
    position: relative;
    overflow: hidden;
}

.scratch-card-item:hover .w-full.aspect-\[5\/1\]::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
    transform: skewX(-25deg);
    animation: shine 1.2s forwards; /* Alterado para não repetir infinitamente */
}

@keyframes shine {
    100% {
        left: 150%;
    }
}

/* 3. Animação de Entrada dos Cards */
@keyframes fade-in-up {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* Estilos antigos do carrossel (não mudam) */
.carousel-banners .carousel__item,
.carousel-banners .carousel__item a {
    background: none !important;
    backdrop-filter: none !important;
    opacity: 1 !important;
}
.carousel__item {
  min-height: 180px;
  max-height: 413px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff3;
}
.carousel__item img {
  width: 100%;
  height: auto;
  max-height: 413px;
  object-fit: contain;
  border-radius: 16px;
}
@media (max-width: 1024px) {
  .carousel-banners .carousel__item {
    min-height: 140px;
    max-height: 300px;
  }
  .carousel-banners .carousel__item img {
    max-height: 300px;
  }
}
@media (max-width: 768px) {
  .carousel-banners {
    margin-top: 0.5rem;
  }
  .carousel-banners .carousel__item {
    height: auto;
    max-height: 250px;
    overflow: hidden;
  }
  .carousel-banners .carousel__item img {
    width: 100%;
    height: auto;
    object-fit: contain;
  }
  .padding-mobile-banner {
    padding-top: 48px !important;
  }
}
</style>