<template>
  <div class="max-w-[1240px] mx-auto p-0 md:p-0">
    
    <!-- Cabeçalho da seção de provedores -->
    <div class="flex justify-between items-center bg-[#0E2945] p-3 rounded-lg mb-4">
      <h2 class="text-lg font-semibold flex items-center gap-3">
        <span>🎰 Provedores de Jogos</span>
        <!-- Botões de navegação para mobile -->
        <span class="flex items-center gap-2 md:hidden">
          <button @click="prev" :disabled="isPrevDisabled" class="arrow-glow disabled:opacity-25 disabled:cursor-not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
          </button>
          <button @click="next" :disabled="isNextDisabled" class="arrow-glow disabled:opacity-25 disabled:cursor-not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </button>
        </span>
      </h2>
      <a href="/casino/provider/23/category/all" class="text-sm text-gray-200 bg-[#0B2540] hover:bg-gray-800 px-4 py-1.5 rounded-full transition-colors">
        Ver todos
      </a>
    </div>

    <!-- Contêiner do Carrossel para Mobile -->
    <div class="md:hidden overflow-hidden">
      <div class="flex transition-transform duration-300 ease-in-out" :style="carouselStyle">
        <!-- O v-for agora está dentro do carrossel mobile -->
        <div v-for="provider in providers" :key="provider.name" class="w-1/3 flex-shrink-0 p-1.5">
          <a :href="provider.href" class="group block aspect-video w-full rounded-lg transition-all duration-300 bg-[#1A2C3D] hover:bg-gray-700/40">
            <div class="flex items-center justify-center h-full w-full p-3">
              <img 
                :alt="provider.name" 
                :src="provider.imgSrc" 
                @error="handleImageError"
                class="max-h-full max-w-full object-contain"
              >
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- Grade Padrão para Desktop -->
    <div class="hidden md:flex flex-wrap -m-1.5 md:-m-2">
      <div v-for="provider in providers" :key="`desktop-${provider.name}`" class="w-1/3 md:w-1/6 p-1.5 md:p-2">
        <a :href="provider.href" class="group block aspect-video w-full rounded-lg transition-all duration-300 bg-[#1A2C3D] hover:bg-gray-700/40">
          <div class="flex items-center justify-center h-full w-full p-3">
            <img 
              :alt="provider.name" 
              :src="provider.imgSrc" 
              @error="handleImageError"
              class="max-h-full max-w-full object-contain"
            >
          </div>
        </a>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Array de objetos contendo os dados de cada provedor.
const providers = ref([
  { name: "PG Soft", href: "/casino/provider/1/category/all", imgSrc: "https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/929f095d-2fbd-4268-6caf-d3c24ff08700/w=160" },
  { name: "Evolution Gaming", href: "/casino/provider/23/category/all", imgSrc: "https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/431ef7dd-3837-449c-bfdd-690f1ddc0500/w=160" },
  { name: "Pragmatic Play", href: "/casino/provider/2/category/all", imgSrc: "https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/0b77b2e0-fca0-4d89-457b-887c4c2e7300/w=160" },
  { name: "Galaxys", href: "/casino/provider/4/category/all", imgSrc: "https://raw.githubusercontent.com/ZEDDEV1/meu-cdn/refs/heads/main/GALAXSYS.webp" },
  { name: "Playson", href: "/casino/provider/9/category/all", imgSrc: "https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/48a2d7bf-7f5d-45c7-daee-c42567afc300/w=160" },
  { name: "Spribe", href: "/casino/provider/3/category/all", imgSrc: "https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/4bf9a0ad-268b-463e-4019-dfec32722f00/w=160" },
]);

// --- Lógica do Carrossel para Mobile ---
const currentIndex = ref(0);
const providersPerPage = 3; // Mostrar 3 por vez no mobile

// Calcula o número total de "páginas" no carrossel
const totalPages = computed(() => {
  return Math.ceil(providers.value.length / providersPerPage);
});

// Funções para navegar
const next = () => {
  if (currentIndex.value < totalPages.value - 1) {
    currentIndex.value++;
  }
};

const prev = () => {
  if (currentIndex.value > 0) {
    currentIndex.value--;
  }
};

// Propriedades computadas para desabilitar os botões
const isPrevDisabled = computed(() => currentIndex.value === 0);
const isNextDisabled = computed(() => currentIndex.value >= totalPages.value - 1);

// Estilo dinâmico para mover o carrossel
const carouselStyle = computed(() => ({
  transform: `translateX(-${currentIndex.value * 100}%)`,
}));

/**
 * Função para lidar com erros de carregamento de imagem.
 * Se a URL original falhar, ela é substituída por uma imagem de placeholder.
 * @param {Event} event - O evento de erro da imagem.
 */
const handleImageError = (event) => {
  event.target.src = 'https://placehold.co/200x100/1A2C3D/FFFFFF?text=Logo';
};
</script>

<style scoped>
/* Estilos específicos para este componente */
.arrow-glow {
    color: #4ade80; /* Cor verde brilhante (Tailwind green-400) */
    filter: drop-shadow(0 0 4px #4ade80); /* Efeito de brilho */
    transition: all 0.2s ease-in-out;
}
.arrow-glow:hover:not(:disabled) {
    color: #86efac; /* Cor verde mais clara no hover (Tailwind green-300) */
    filter: drop-shadow(0 0 8px #86efac);
}
</style>
