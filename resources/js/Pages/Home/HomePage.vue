<style>
/* Estilos Globais da Página */
@keyframes shimmer { 0% { left: -100%; } 100% { left: 100%; } }
html { font-family: Montserrat, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif; }
body { background: none; }

.carousel-banners,
.carousel-banners .carousel__item,
.carousel-banners .carousel__item a {
    background: none !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    opacity: 1 !important;
}

.btn-scroll-top {
    position: relative;
    z-index: 2;
    bottom: 2em;
    display: none;
    align-items: center;
    background-color: #0000009a;
    border: 1px solid var(--ci-primary-color);
    color: #fff;
    cursor: pointer;
    transition: opacity 0.3s;
    font-size: 13px;
    gap: 0.5em;
    padding: 3px 12px;
    border-radius: 20px;
    margin-top: -30px;
    left: 50%;
    transform: translateX(-50%);
}
.show-btn-scroll-top { display: flex; }
.search-mobile {
    box-shadow: 0px 0px 14px -22px rgba(43,43,43,1);
    background-color: var(--ci-gray-dark);
    border-radius: 3px;
    font-size: 14px;
    padding-left: 40px;
    padding-top: 10px;
    padding-bottom: 10px;
}
.placeholder-search::placeholder { color: #ACAFAF; font-size: 13px; }
.item-sombra2 { position: relative; }
.item-sombra2:after {
    content: "";
    position: absolute;
    bottom: 0;
    right: 0;
    width: 25px;
    height: 100%;
    background: linear-gradient(to right, rgb(33 36 37 / 0%), var(--carousel-banners));
}

.tournaments-page-styles .btn-subscribe {
    pointer-events: auto !important;
    cursor: pointer !important;
    margin-top: 0.5rem;
}

/* ESTILOS ISOLADOS PARA A SECÇÃO DE TORNEIOS */
.tournaments-page-styles {
    --bg-header: #0E2945;
    --bg-card: #001C31;
    --border-color: #225482;
    --text-primary: #e2e8f0;
    --text-secondary: #94a3b8;
    --text-accent: #ffffff;
    --prize-color: #facc15;
    --gradient-start: #082339;
    --gradient-end: #1567A9;
    color: var(--text-primary);
    overflow: hidden;
}
.tournaments-page-styles .horizontal-scroll-container::-webkit-scrollbar { display: none; }
.tournaments-page-styles .horizontal-scroll-container { -ms-overflow-style: none; scrollbar-width: none; }

.tournaments-page-styles .tournament-card {
    background-color: var(--bg-card);
    border-radius: 0.75rem;
    overflow: hidden;
    border: 1px solid var(--border-color);
    transition: transform 0.3s, box-shadow 0.3s;
    flex: 0 0 280px;
    display: flex;
    flex-direction: column;
}

/* >>>>> CORREÇÃO DEFINITIVA APLICADA DIRETAMENTE NO FOCO DO PROBLEMA <<<<< */
.tournaments-page-styles .card-header {
    position: relative;
    height: 10rem;
    background-size: cover;
    background-position: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0.75rem;
    text-align: center;
    /* Estas duas propriedades forçam este elemento a conter seus filhos, resolvendo o bug de sobreposição */
    isolation: isolate;
    transform: translateZ(0);
}
.tournaments-page-styles .card-header::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 28, 49, 0.95) 10%, rgba(0, 28, 49, 0.1) 70%), radial-gradient(circle, rgba(0, 28, 49, 0.4), transparent 70%);
    background-color: rgba(0, 28, 49, 0.5);
    z-index: 0;
}
.tournaments-page-styles .card-header > * {
    position: relative;
    z-index: 1;
}
.tournaments-page-styles .players-count {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    border-radius: 9999px;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
}
.tournaments-page-styles .countdown-item,
.tournaments-page-styles .btn-subscribe {
    background-image: linear-gradient(to bottom, var(--gradient-start), var(--gradient-end));
}
.tournaments-page-styles .countdown {
    display: flex;
    gap: 0.5rem;
    margin: 0.75rem 0;
}
.tournaments-page-styles .countdown-item {
    border-radius: 0.375rem;
    padding: 0.5rem;
    text-align: center;
    flex-grow: 1;
}
.tournaments-page-styles .countdown-item h5 {
    font-size: 1.25rem;
    font-weight: 700;
}
.tournaments-page-styles .countdown-item p {
    font-size: 0.625rem;
    color: var(--text-secondary);
    text-transform: uppercase;
}
.tournaments-page-styles .btn-subscribe {
    color: white;
    font-weight: 600;
    border-radius: 0.5rem;
    padding: 0.75rem;
    text-align: center;
    transition: filter 0.2s;
    border: none;
    cursor: pointer;
}
.tournaments-page-styles .btn-subscribe:hover {
    filter: brightness(1.2);
}
.tournaments-page-styles .leaderboard-table {
    width: 100%;
    font-size: 0.8rem;
}
.tournaments-page-styles .leaderboard-table th,
.tournaments-page-styles .leaderboard-table td {
    padding: 0.5rem 0.25rem;
    text-align: left;
    vertical-align: middle;
}
.tournaments-page-styles .leaderboard-table th {
    color: var(--text-secondary);
    font-weight: 500;
}
.tournaments-page-styles .leaderboard-table td {
    font-weight: 600;
}
.tournaments-page-styles .leaderboard-avatar {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    object-fit: cover;
}
.tournaments-page-styles .modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0,0,0,0.7);
    backdrop-filter: blur(4px);
    transition: opacity 0.3s ease;
}
.tournaments-page-styles .modal-content {
    background-color: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    padding: 2rem;
    text-align: center;
    width: 100%;
    max-width: 20rem;
    transform: scale(0.9);
    opacity: 0;
    transition: all 0.3s ease;
}
.tournaments-page-styles .modal-overlay.active .modal-content {
    transform: scale(1);
    opacity: 1;
}
.tournaments-page-styles .animated-check-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #10B981;
    display: flex;
    align-items: center;
    justify-content: center;
}
.tournaments-page-styles .animated-check-icon {
    color: white;
    font-size: 40px;
    animation: pop-in 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55) forwards;
}
@keyframes pop-in {
    0% { transform: scale(0); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.w-full.flex.justify-between.md\:mt-6 {
    background-color: #0E2945;
    border-radius: 0.5rem;
    padding: 0.5rem;
}

/* ###################################################### */
/* ############### Media Queries ######################## */
/* ###################################################### */

@media (max-width: 1024px) {
    .padding-mobile-banner { padding-top: 20px !important; }
    .carousel-banners .carousel__item { height: 300px; }
    .carousel-banners .carousel__item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        max-height: none;
    }
    .search-mobile { padding-left: 30px; padding-top: 8px; padding-bottom: 8px; font-size: 12px; }
    .tournaments-page-styles .tournament-card { flex: 0 0 240px; }
    .tournaments-page-styles .card-header { height: 8rem; padding: 0.5rem; }
    .tournaments-page-styles .players-count { top: 0.5rem; left: 0.5rem; padding: 0.2rem 0.5rem; font-size: 0.7rem; }
    .tournaments-page-styles .countdown { gap: 0.4rem; margin: 0.5rem 0; }
    .tournaments-page-styles .countdown-item { padding: 0.4rem; }
    .tournaments-page-styles .countdown-item h5 { font-size: 1rem; }
    .tournaments-page-styles .countdown-item p { font-size: 0.5rem; }
    .tournaments-page-styles .btn-subscribe { padding: 0.6rem; font-size: 0.9rem; margin-top: 0.4rem; }
    .tournaments-page-styles .modal-content { max-width: 18rem; padding: 1.5rem; }
    .tournaments-page-styles .animated-check-circle { width: 70px; height: 70px; }
    .tournaments-page-styles .animated-check-icon { font-size: 35px; }
    .btn-scroll-top { bottom: 3em; padding: 2px 8px; font-size: 11px; }
    .w-full.flex.justify-between.md\:mt-6 { padding: 0.4rem; }
}

@media (max-width: 768px) {
    .carousel-banners {
        margin-top: 0.5rem;
    }

    .carousel-banners .carousel__item {
        height: auto; /* Altura automática para o banner não cortar */
        max-height: 250px; /* Altura máxima pra evitar banners gigantes no mobile */
        overflow: hidden; /* Garante que nada fique estourando fora */
    }

    .carousel-banners .carousel__item img {
        width: 100%;
        height: auto; /* Mantém a proporção original da imagem */
        object-fit: contain; /* Faz a imagem caber inteira no espaço, sem cortes */
    }

    .padding-mobile-banner {
        padding-top: 48px !important;
    }
  
    .flex.justify-between.items-center,
    .w-full.flex.justify-between {
        padding-bottom: 0.5rem;
    }
    .flex.justify-between.items-center h2,
    .w-full.flex.justify-between .flex.items-center h2 {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-grow: 1;
        font-size: 0.95rem;
        font-weight: 600;
        line-height: 1.2;
    }
    .flex.justify-between.items-center a,
    .w-full.flex.justify-between a {
        flex-shrink: 0;
        padding-left: 10px;
        font-size: 0.75rem;
        color: #94a3b8;
    }
    div.mt-1 { margin-top: 0.25rem !important; }
    div.mt-3 { margin-top: 1rem !important; }
    div.mt-4 { margin-top: 1rem !important; }
    div.mb-5 { margin-bottom: 1rem !important; }

    .category-list a { min-width: 65px !important; }
    .category-list p { font-size: 0.65rem; }

    .tournaments-page-styles .tournament-card { flex: 0 0 245px; }
    .tournaments-page-styles .card-header { height: 6rem; }
    .tournaments-page-styles .players-count { font-size: 0.6rem; padding: 0.15rem 0.4rem;}
    .tournaments-page-styles .countdown { margin: 0.4rem 0; }
    .tournaments-page-styles .countdown-item h5 { font-size: 0.85rem; }
    .tournaments-page-styles .countdown-item p { font-size: 0.5rem; }
    .tournaments-page-styles .btn-subscribe { padding: 0.5rem; font-size: 0.75rem; }
}
  /* ... Adicione ao final da sua tag <style> principal ... */

.tournaments-page-styles .leaderboard-container {
    font-size: 0.8rem;
}

.tournaments-page-styles .leaderboard-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.3rem 0.2rem;
    border-radius: 0.25rem;
    background-color: rgba(0, 0, 0, 0.15);
}
  
</style>


<template>
    <BaseLayout>
        <div class="carousel-banners">
            <div class="mx-auto w-full max-w-[1240px] p-4 padding-mobile-banner">
                <div class="mx-auto w-full max-w-[1240px]" style="position: fixed; bottom: 0; height: 0px; z-index: 1;">
                    <button style="pointer-events: auto;" class="btn-scroll-top" @click="scrollToTop">
                        <div>
                            <svg height="1em" viewBox="0 0 384 512" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <div>De volta ao topo</div>
                    </button>
                </div>
                <Carousel v-bind="settings" :breakpoints="breakpoints" ref="carouselBanner">
                    <Slide v-for="(banner, index) in banners" :key="index">
                        <div class="carousel__item rounded w-full">
                            <a :href="banner.link" class="w-full h-full rounded">
                                <img :src="`/storage/`+banner.image" alt="" class="h-full w-full rounded" style="max-height: 413px">
                            </a>
                        </div>
                    </Slide>
                    <template #addons>
                        <Navigation>
                            <template #next><i class="fa-solid fa-chevron-right text-white text-2xl"></i></template>
                            <template #prev><i class="fa-solid fa-chevron-left text-white text-2xl"></i></template>
                        </Navigation>
                        <Pagination />
                    </template>
                </Carousel>
            </div>
        </div>

        <div class="mx-auto p-4 w-full max-w-[1240px]">
            <div class="w-full search-margin">
                <div class="cursor-pointer w-full margin-search md:mb-[39px] mb-4" style="background-color: #001C31; border-radius: 5px;">
                    <div class="flex" style="border-radius: 5px;">
                        <div class="relative w-full" style="border-radius: 5px;">
                            <button style="border-radius: 5px;" @click="toggleSearch" type="submit" class="absolute top-0 start-0 h-full p-2.5 text-sm font-medium text-white rounded-e-lg">
                                <svg id="svg-lupa" height="14px" viewBox="0 0 512 512" width="14px" xmlns="http://www.w3.org/2000/svg" class="text-texts w-5 p-0 m-0" style="width: 20px; height: 16px;">
                                    <path d="M500.3 443.7l-119.7-119.7c-15.03 22.3-34.26 41.54-56.57 56.57l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7z" fill="currentColor"></path>
                                    <path d="M207.1 0C93.12 0-.0002 93.13-.0002 208S93.12 416 207.1 416s208-93.13 208-208S322.9 0 207.1 0zM207.1 336c-70.58 0-128-57.42-128-128c0-70.58 57.42-128 128-128s128 57.42 128 128C335.1 278.6 278.6 336 207.1 336z" fill="currentColor" opacity="0.4"></path>
                                </svg>
                            </button>
                            <a href="/casino/provider/category">
                                <input style="cursor: pointer; background-color: #001C31; border-radius: 5px;" class="w-full placeholder-search p-2.5 lg:p-0 search-mobile" type="search" readonly placeholder="Pesquise um jogo de cassino..." required>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="categories" class="category-list">
                <div class="flex mb-5 gap-4" style="max-height: 200px; overflow-x: auto; overflow-y: hidden;">
                    <div class="flex flex-row justify-between items-center w-full" style="min-width: 100%; white-space: nowrap;">
                        <RouterLink :to="{ name: 'casinosAll', params: { provider: 'all', category: category.slug }}" v-for="category in categories" :key="category.slug" class="flex flex-col justify-center items-center min-w-[80px] text-center">
                            <div class="category-img">
                                <img :src="`/storage/`+category.image" alt="" width="35">
                            </div>
                            <p class="mt-1">{{ $t(category.name) }}</p>
                        </RouterLink>
                    </div>
                </div>
            </div>
          
          <MenuCassino />

           

<div v-if="bannersHome && bannersHome.length" class="mt-1 hidden md:block">
  <div
    class="p-2 rounded-lg mb-2"
    style="background: linear-gradient(90deg, #001c31 0%, #003c5f 100%);"
  >
    <p class="text-xl font-semibold text-white">🔥 Top Jogos no Brasil Hoje</p>
  </div>

  <Carousel
    v-bind="settingsRecommended"
    :breakpoints="breakpointsRecommended"
    ref="carouselSubBanner"
  >
    <Slide v-for="banner in bannersHome" :key="banner.id">
      <div
        class="carousel__item min-h-[60px] md:min-h-[150px] rounded-2xl w-full mr-4"
      >
        <a :href="banner.link" class="w-full h-full rounded-2xl">
          <img
            :src="'/storage/' + banner.image"
            alt=""
            class="h-full w-full rounded-2xl"
          />
        </a>
      </div>
    </Slide>
  </Carousel>
            </div>
        </div>
 <!-- MOBILE - versão à prova de quebra -->
<template v-if="bannersMobile && bannersMobile.length">
 <!-- MOBILE -->
<div v-if="bannersMobile && bannersMobile.length" class="block md:hidden px-2">
  <div
    class="p-2 rounded-lg mb-2"
    style="background: linear-gradient(90deg, #001c31 0%, #003c5f 100%);"
  >
    <p class="text-base font-semibold text-white pl-1">🔥 Top Jogos no Brasil Hoje</p>
  </div>

  <div class="overflow-x-auto whitespace-nowrap">
    <div class="flex gap-[10px] w-max">
      <div
        v-for="banner in bannersMobile"
        :key="banner.id"
        class="flex-shrink-0"
        style="width: 92px"
      >
        <a
          :href="banner.link"
          class="rounded-md shadow-md overflow-hidden flex items-center justify-center"
        >
          <img
            :src="'/storage/' + banner.image"
            alt=""
            class="object-contain object-center w-full"
          />
        </a>
      </div>
    </div>
  </div>
</div>

</template>


      

      <div class="tournaments-page-styles w-full max-w-[1240px] mx-auto flex flex-col space-y-4 my-8 px-4">
    <div v-if="showModal" ref="subscriptionModal" class="modal-overlay active">
        <div class="modal-content rounded-xl p-8 text-center w-full max-w-sm">
            <div class="animated-check-circle mx-auto">
                <i class="fas fa-check animated-check-icon"></i>
            </div>
            <h3 class="text-2xl font-bold mt-6">Inscrição Finalizada!</h3>
            <p style="color: var(--text-secondary);" class="mt-2">Você agora está participando do torneio.</p>
        </div>
    </div>

    <header class="w-full flex justify-between md:mt-6 p-3 rounded-lg">
        <h2 class="text-xl font-bold flex items-center">
            <i class="fas fa-trophy mr-3 text-yellow-400"></i>Torneios
        </h2>
        <div class="hidden md:flex items-center space-x-2">
            <button @click="scrollTournaments(-1)" class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: var(--bg-card); border: 1px solid var(--border-color);">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
            <button @click="scrollTournaments(1)" class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: var(--bg-card); border: 1px solid var(--border-color);">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>
        </div>
    </header>

    <div class="w-full relative">
        <div ref="tournamentsContainer" class="w-full flex space-x-6 overflow-x-auto pb-4 horizontal-scroll-container">
            <div v-for="torneio in tournamentsData" :key="torneio.title" class="tournament-card">
                <div class="card-header" :style="{ backgroundImage: `url('${torneio.bgImage}')` }">
                    <div class="players-count self-start">
                        <i class="fas fa-users text-xs"></i>
                        <span>{{ torneio.players }} jogadores</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <h3 class="font-bold">{{ torneio.title }}</h3>
                        <h4 class="text-sm font-semibold" style="color: var(--prize-color);">{{ torneio.prize }}</h4>
                    </div>
                </div>
                
                <div class="p-3 flex-grow flex flex-col justify-between">
                    <div>
                        <ul class="countdown">
                            <template v-if="torneio.countdown.expired">
                                <li class="text-base font-bold text-center w-full py-4" style="color: var(--text-secondary)">Torneio Encerrado</li>
                            </template>
                            <template v-else>
                                <li class="countdown-item"><h5>{{ torneio.countdown.d || '00' }}</h5><p>dias</p></li>
                                <li class="countdown-item"><h5>{{ torneio.countdown.h || '00' }}</h5><p>horas</p></li>
                                <li class="countdown-item"><h5>{{ torneio.countdown.m || '00' }}</h5><p>min.</p></li>
                                <li class="countdown-item"><h5>{{ torneio.countdown.s || '00' }}</h5><p>seg.</p></li>
                            </template>
                        </ul>

                        <div class="leaderboard-container mt-2">
                            <ul class="space-y-2">
                                <li v-for="(player, index) in torneio.leaderboard" :key="player.name" class="leaderboard-item">
                                    <div class="flex items-center space-x-2">
                                        <img v-if="rankImages[index + 1]" :src="rankImages[index + 1]" alt="Rank" class="w-6 h-6">
                                        <span v-else class="w-6 h-6 flex items-center justify-center font-bold" style="color: var(--text-secondary);">{{ index + 1 }}</span>
                                        <img :src="player.avatar" alt="Avatar" class="w-6 h-6 rounded-full">
                                        <span class="font-semibold text-sm">{{ player.name }}</span>
                                    </div>
                                    <div class="font-bold text-yellow-400 text-sm">
                                        R$ {{ player.score.toLocaleString('pt-BR') }}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <button @click="showSubscriptionModal" class="btn-subscribe w-full mt-4">Inscreva-se agora</button>
                </div>
            </div>
        </div>
    </div>
</div>
      
        <div class="mx-auto p-4 w-full max-w-[1240px]">
            <div v-if="featured_games" class="mt-3">
                <div class="w-full flex justify-between md:mt-6">
                    <div class="flex items-center">
                        <h2 class="text-lg providersNames">💸 Mais pagou hoje!</h2>
                        <button @click.prevent="fgCarousel.prev()" class="item-game px-2 py-1 rounded-lg text-[12px] ml-2 mr-2 celular-providers-setas">
                            <i class="fa-solid fa-angle-left"></i>
                        </button>
                        <button @click.prevent="fgCarousel.next()" class="item-game px-2 py-1 rounded-lg text-[12px] celular-providers-setas">
                            <i class="fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                </div>
                <Carousel class="item-sombra2" ref="fgCarousel" v-bind="settingsGames" :breakpoints="breakpointsGames">
                    <Slide v-if="loading" v-for="i in 10" :key="'loader-game-' + i">
                        <div role="status" class="w-full flex items-center justify-center h-48 mr-6 max-w-sm bg-gray-300 rounded-lg animate-pulse dark:bg-gray-700 text-4xl">
                            <i class="fa-duotone fa-gamepad-modern"></i>
                        </div>
                    </Slide>
                    <Slide v-if="featured_games && !loading" v-for="(game, providerId) in featured_games" :key="game.id || providerId" class="p-2">
                        <CassinoGameCard :index="providerId" :title="game.game_name" :cover="game.cover" :gamecode="game.game_code" :type="game.distribution" :game="game" />
                    </Slide>
                </Carousel>
            </div>
          <game-providers />
            
            <div class="mt-4">
                <ShowProviders v-for="provider in providers" :key="provider.id" :provider="provider" />
            </div>
        </div>
     

    </BaseLayout>
</template>

<script>
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel';
import { onMounted, ref } from "vue";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import MakeDeposit from "@/Components/UI/MakeDeposit.vue";
import { RouterLink } from "vue-router";
import { useAuthStore } from "@/Stores/Auth.js";
import LanguageSelector from "@/Components/UI/LanguageSelector.vue";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";
import HttpApi from "@/Services/HttpApi.js";
import ShowCarousel from "@/Pages/Home/Components/ShowCarousel.vue";
import { useSettingStore } from "@/Stores/SettingStore.js";
import ShowProviders from "@/Pages/Home/Components/ShowProviders.vue";
import { searchGameStore } from "@/Stores/SearchGameStore.js";
import CustomPagination from "@/Components/UI/CustomPagination.vue";
import LastWinnersComponent from "@/Pages/Home/Components/LastWinnersComponent.vue";

export default {
    name: "HomePage",
    components: {
        CustomPagination, Pagination, ShowProviders, ShowCarousel, CassinoGameCard, Carousel, Navigation,
        Slide, LanguageSelector, MakeDeposit, BaseLayout, RouterLink, LastWinnersComponent
    },
    data() {
        return {
            settings: { itemsToShow: 1, snapAlign: 'center', autoplay: 6000, wrapAround: true },
            breakpoints: { 700: { itemsToShow: 1 }, 1024: { itemsToShow: 1 } },
            settingsRecommended: { itemsToShow: 2, snapAlign: 'start' },
            breakpointsRecommended: { 700: { itemsToShow: 3 }, 1024: { itemsToShow: 3, snapAlign: 'start' } },
            banners: [],
            bannersHome: [],        // banners para desktop (type === 'home')
            bannersHomeMobile: [],  // banners para mobile (type === 'mobile')
            settingsRecommendedMobile: { itemsToShow: 3, snapAlign: 'start' },
            breakpointsRecommendedMobile: {
              0: { itemsToShow: 3, snapAlign: 'start' },
              480: { itemsToShow: 3, snapAlign: 'start' },
              768: { itemsToShow: 3, snapAlign: 'start' }
            },


            settingsGames: { itemsToShow: 2.5, snapAlign: 'start' },
            breakpointsGames: { 700: { itemsToShow: 3.5 }, 1024: { itemsToShow: 6, snapAlign: 'start' } },
            providers: [],
            featured_games: [],
            categories: [],
            loading: true,
            showModal: false,
            updateInterval: null,
            tournamentsData: [
                {
                    bgImage: 'https://d1qt8ake8g4imn.cloudfront.net/7ce0026f9394a6cf189408-CASSINOPIXPGSOFT.jpg',
                    title: 'Torneio Diário Pg Soft',
                    prize: 'R$ 600.000,00 EM PRÊMIOS',
                    durationInHours: 24,
                    endTime: null,
                    countdown: {},
                    leaderboard: [],
                    players: '0',
                },
                {
                    bgImage: 'https://d1qt8ake8g4imn.cloudfront.net/1a111a5b58f7b01b1cee3c-CASSINO-BLOG-895X455-TorneioMensalAVIATOR.jpg',
                    title: 'Semanal Aviator',
                    prize: 'R$ 200.000,00 EM PRÊMIOS',
                    durationInHours: 24 * 7,
                    endTime: null,
                    countdown: {},
                    leaderboard: [],
                    players: '0',
                },
                {
                    bgImage: 'https://d1qt8ake8g4imn.cloudfront.net/b441b39936a99e33d20fc4-CASSINOPIXCassinoaovivo.jpg',
                    title: 'Mensal de Cassino Ao Vivo',
                    prize: 'R$ 35.000,00 EM PRÊMIOS',
                    durationInHours: 24 * 30,
                    endTime: null,
                    countdown: {},
                    leaderboard: [],
                    players: '0',
                },
                {
                    bgImage: 'https://d1qt8ake8g4imn.cloudfront.net/7284140a4f41ec99c5e1e5-JOGAPIXBooming.jpg',
                    title: 'Semanal Booming',
                    prize: 'R$ 35.000,00 EM PRÊMIOS',
                    durationInHours: 24 * 7,
                    endTime: null,
                    countdown: {},
                    leaderboard: [],
                    players: '0',
                }
            ],
            samplePlayers: [
                { name: 'Bia', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/982' }, { name: 'Wilm', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/168510495' },
                { name: 'Raul', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/656' }, { name: 'Carlos', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/123' },
                { name: 'Julia', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/456' }, { name: 'Lucas', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/789' },
                { name: 'Mari', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/101' }, { name: 'Pedro', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/202' },
                { name: 'Ana', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/303' }, { name: 'Felipe', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/404' },
                { name: 'Sofia', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/505' }, { name: 'Gusta', avatar: 'https://d3dubbodzd2q05.cloudfront.net/avatar/606' }
            ],
            rankImages: {
                1: 'https://static.cassino.bet.br/deploy-92025ca4ae2783d6085db3d179b40e0f6488b4ee-3b67c2fb3ad2f7b62cb1/assets/gamification/t-place-1.png',
                2: 'https://static.cassino.bet.br/deploy-92025ca4ae2783d6085db3d179b40e0f6488b4ee-3b67c2fb3ad2f7b62cb1/assets/gamification/t-place-2.png',
                3: 'https://static.cassino.bet.br/deploy-92025ca4ae2783d6085db3d179b40e0f6488b4ee-3b67c2fb3ad2f7b62cb1/assets/gamification/t-place-3.png'
            },

            // NOVO: Estados para controlar o auto-scroll mobile
            autoScrollInterval: null,
            isMobile: false,
            mobileMediaQuery: null,
        }
    },
    setup() {
        const fgCarousel = ref(null);
        return { fgCarousel };
    },
    computed: {
        searchGameStore() { return searchGameStore(); },
        userData() { return useAuthStore().user; },
        isAuthenticated() { return useAuthStore().isAuth; },
        setting() { return useSettingStore().setting; },

        // Computeds para facilitar acesso aos banners separados
        bannersDesktop() {
            return this.bannersHome;
        },
        bannersMobile() {
            return this.bannersHomeMobile;
        }
    },
    methods: {
        scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); },
        toggleSearch() { this.searchGameStore.setSearchGameToogle(); },

        async initializeMethods() {
            this.loading = true;
            await Promise.all([
                this.getCasinoCategories(),
                this.getBanners(),
                this.getFeaturedGames(),
                this.getAllGames()
            ]);
            this.loading = false;
        },

        async getBanners() {
            try {
                const res = await HttpApi.get('settings/banners');
                this.banners = res.data.banners.filter(b => b.type === 'carousel');
                this.bannersHome = res.data.banners.filter(b => b.type === 'home');
                this.bannersHomeMobile = res.data.banners.filter(b => b.type === 'mobile');
            } catch (e) {
                console.error(e);
            }
        },

        async getCasinoCategories() {
            try {
                const res = await HttpApi.get('categories');
                this.categories = res.data.categories;
            } catch(e) {
                console.error(e);
            }
        },

        async getAllGames() {
            try {
                const res = await HttpApi.get('games/all');
                this.providers = res.data.providers;
            } catch(e) {
                console.error(e);
            }
        },

        async getFeaturedGames() {
            try {
                const res = await HttpApi.get('featured/games');
                this.featured_games = res.data.featured_games;
            } catch (e) {
                console.error(e);
            }
        },

        showSubscriptionModal() {
            this.showModal = true;
            setTimeout(() => { this.showModal = false; }, 2500);
        },

        scrollTournaments(direction) {
            const container = this.$refs.tournamentsContainer;
            if (container) container.scrollBy({ left: (304 * direction), behavior: 'smooth' });
        },

        checkAndResetTournaments() {
            const now = new Date();
            this.tournamentsData.forEach(tournament => {
                if (!tournament.endTime || new Date(tournament.endTime) < now) {
                    const newEndTime = new Date(now.getTime() + tournament.durationInHours * 60 * 60 * 1000);
                    tournament.endTime = newEndTime.toISOString();
                    this.generateLeaderboard(tournament);
                    tournament.players = (Math.floor(Math.random() * 70000) + 20000).toLocaleString('pt-BR');
                }
            });
        },

        generateLeaderboard(tournament) {
            const shuffledUsers = [...this.samplePlayers].sort(() => 0.5 - Math.random());
            const leaderboardSize = Math.floor(Math.random() * 5) + 3;
            const selectedUsers = shuffledUsers.slice(0, leaderboardSize);
            let currentScore = Math.floor(Math.random() * 50000) + 150000;
            tournament.leaderboard = selectedUsers.map(user => {
                const score = currentScore;
                currentScore -= Math.floor(Math.random() * 10000) + 5000;
                return { ...user, score: score };
            });
        },

        updateDynamicContent() {
            this.checkAndResetTournaments();
            this.tournamentsData.forEach(tournament => {
                if (tournament.leaderboard && tournament.leaderboard.length > 0) {
                    tournament.leaderboard.forEach(player => {
                        player.score += Math.floor(Math.random() * 150) + 10;
                    });
                    tournament.leaderboard.sort((a, b) => b.score - a.score);
                }
                const endTime = new Date(tournament.endTime).getTime();
                const now = new Date().getTime();
                const distance = endTime - now;
                if (distance < 0) {
                    tournament.countdown = { expired: true };
                } else {
                    tournament.countdown = {
                        expired: false,
                        d: String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0'),
                        h: String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0'),
                        m: String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0'),
                        s: String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0'),
                    };
                }
            });
        },

        // --- NOVOS MÉTODOS PARA O AUTO-SCROLL MOBILE ---
        setupMobileScroller() {
            this.mobileMediaQuery = window.matchMedia('(max-width: 768px)');
            this.mobileMediaQuery.addEventListener('change', this.handleResize);
            this.handleResize(this.mobileMediaQuery);
        },

        handleResize(event) {
            this.isMobile = event.matches;
            if (this.isMobile) {
                this.startAutoScroller();
            } else {
                this.stopAutoScroller();
            }
        },

        startAutoScroller() {
            if (this.autoScrollInterval) {
                clearInterval(this.autoScrollInterval);
            }
            this.autoScrollInterval = setInterval(this.autoScrollView, 3000);
        },

        stopAutoScroller() {
            clearInterval(this.autoScrollInterval);
            this.autoScrollInterval = null;
        },

        autoScrollView() {
            const container = this.$refs.tournamentsContainer;
            if (!container) return;

            const cardWidth = container.querySelector('.tournament-card')?.offsetWidth || 250;
            const scrollAmount = cardWidth + 24; // card width + gap (space-x-6 = 24px)

            if (container.scrollLeft + scrollAmount >= container.scrollWidth - container.clientWidth - 5) {
                container.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        },
    },
    mounted() {
        window.scrollTo(0, 0);
        window.addEventListener('scroll', () => {
            const btnScrollTop = document.querySelector('.btn-scroll-top');
            if (btnScrollTop) {
                if (window.scrollY > 100) btnScrollTop.classList.add('show-btn-scroll-top');
                else btnScrollTop.classList.remove('show-btn-scroll-top');
            }
        });

        this.updateDynamicContent();
        this.updateInterval = setInterval(this.updateDynamicContent, 5000);

        this.setupMobileScroller();
    },
    beforeUnmount() {
        clearInterval(this.updateInterval);
        this.stopAutoScroller();
        if (this.mobileMediaQuery) {
            this.mobileMediaQuery.removeEventListener('change', this.handleResize);
        }
    },
    async created() {
        await this.initializeMethods();
    }
}
</script>


<style scoped>
/* Estilos Scoped Existentes */
.page-content { 
    display: flex; 
    justify-content: center; 
    align-items: flex-end; 
    width: 100%; 
    height: 100vh; 
    padding-bottom: 50px; 
    position: relative; 
}
.history-container { 
    width: 100%; 
    max-width: 1800px; 
    background: rgba(0, 0, 0, 0); 
    border-radius: 12px; 
    padding: 10px; 
    overflow: hidden; 
    max-height: 350px; 
}
.history-list { 
    display: flex; 
    flex-direction: column; 
    justify-content: flex-start; 
    gap: 10px; 
    animation: scrollUp 60s linear infinite; 
}
.history-item { 
    display: flex; 
    align-items: center; 
    gap: 10px; 
    background: rgba(255, 255, 255, 0.1); 
    padding: 8px; 
    border-radius: 8px; 
    margin-bottom: 8px; 
    animation: fadeIn 1s ease-in-out; 
}
.game-image { 
    width: 40px; 
    height: 40px; 
    border-radius: 6px; 
}
.history-text { 
    color: #fff; 
    font-size: 14px; 
}
.username { 
    font-weight: bold; 
    color: #0afe68; 
}
.win-amount { 
    font-size: 13px; 
}
.game-name { 
    font-size: 12px; 
    color: #aaa; 
}
@keyframes scrollUp { 
    0% { transform: translateY(0); } 
    100% { transform: translateY(-100%); } 
}
@keyframes fadeIn { 
    from { opacity: 0; transform: translateY(10px); } 
    to { opacity: 1; transform: translateY(0); } 
}
@media (max-width: 600px) { 
    .history-container { width: 100%; max-width: none; padding: 5px; } 
}
.history-header { 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    gap: 10px; 
    background: rgba(0, 0, 0, 0); 
    padding: 15px 0; 
    border-radius: 8px; 
    margin-bottom: 10px; 
}
.history-header .header-icon { 
    width: 24px; 
    height: 24px; 
}
.history-header .title { 
    font-size: 20px; 
    font-weight: bold; 
    color: #fff; 
}
</style>