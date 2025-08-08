<template>
  <div class="menu-navigation-wrapper">
    <button id="scroll-left" ref="scrollLeftBtn" class="scroll-arrow left">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
      </svg>
    </button>

    <div id="menu-container" ref="menuContainer" class="menu-scroll-container">
      <!-- Item 1: Torneio indique e Ganhe -->
      <div class="menu-item-wrapper">
        <a href="/profile/affiliate" class="menu-card">
          <div class="status-badge" style="background: linear-gradient(rgb(248, 34, 27), rgb(255, 106, 0)); color: rgb(255, 255, 255);">
            <img alt="Icone de hot" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/icons/hot.png">
            <p>Hot</p>
          </div>
          <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/refer-friend-tournament.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
          <div class="card-text-container">
            <small>Torneio indique</small>
            <p>e Ganhe</p>
          </div>
        </a>
      </div>

      <!-- Item 2: Bolão Cassino -->
      <div class="menu-item-wrapper">
        <a href="/vip" class="menu-card highlight-border-yellow">
          <div class="status-badge" style="background: linear-gradient(rgb(248, 34, 27), rgb(255, 106, 0)); color: rgb(255, 255, 255);">
            <img alt="Icone de hot" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/icons/hot.png">
            <p>Hot</p>
          </div>
          <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/jackpot.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
          <div class="card-text-container">
            <small>Cassino</small>
            <p>Bolão</p>
          </div>
        </a>
      </div>
      
      <!-- Item 3: Torneio Aviator -->
      <div class="menu-item-wrapper">
        <a href="/games/play/1420/aviator" class="menu-card highlight-border-blue">
            <div class="status-badge" style="background: linear-gradient(rgb(248, 34, 27), rgb(255, 106, 0)); color: rgb(255, 255, 255);">
            <img alt="Icone de hot" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/icons/hot.png">
            <p>Hot</p>
          </div>
          <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/aviator-tournament.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
          <div class="card-text-container">
            <small>Torneio</small>
            <p>Aviator</p>
          </div>
        </a>
      </div>

      <!-- Outros itens do menu... -->
      <div class="menu-item-wrapper">
          <a href="/casino/provider/2/category/all" class="menu-card">
              <div class="status-badge" style="background: linear-gradient(rgb(248, 185, 27), rgb(255, 230, 167)); color: rgb(10, 25, 42);">
              <img alt="Icone de new" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/icons/new.png">
              <p>Novo</p>
            </div>
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/cachorro-sortudo.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Cachorro</small>
              <p>Sortudo</p>
            </div>
          </a>
      </div>

      <div class="menu-item-wrapper">
          <a href="https://kassino.bet/" class="menu-card">
              <div class="status-badge" style="background: linear-gradient(rgb(248, 185, 27), rgb(255, 230, 167)); color: rgb(10, 25, 42);">
              <img alt="Icone de new" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/icons/new.png">
              <p>Novo</p>
            </div>
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/app.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Baixe o</small>
              <p>Aplicativo</p>
            </div>
          </a>
      </div>
      
      <div class="menu-item-wrapper">
          <a href="/vip" class="menu-card">
              <div class="status-badge" style="background: linear-gradient(rgb(248, 34, 27), rgb(255, 106, 0)); color: rgb(255, 255, 255);">
              <img alt="Icone de hot" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/icons/hot.png">
              <p>Hot</p>
            </div>
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/missions.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Cassino</small>
              <p>Missões</p>
            </div>
          </a>
      </div>
      
      <div class="menu-item-wrapper">
          <a href="/games/play/1420/aviator" class="menu-card">
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/aviator.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Jogue agora</small>
              <p>Aviator</p>
            </div>
          </a>
      </div>

      <div class="menu-item-wrapper">
          <a href="/casino/provider/23/category/all" class="menu-card">
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/roulette.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Jogue ao vivo</small>
              <p>Roleta</p>
            </div>
          </a>
      </div>

      <div class="menu-item-wrapper">
          <a href="/games/play/1422/126" class="menu-card">
              <div class="status-badge" style="background: linear-gradient(rgb(248, 34, 27), rgb(255, 106, 0)); color: rgb(255, 255, 255);">
              <img alt="Icone de hot" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/icons/hot.png">
              <p>Hot</p>
            </div>
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/fortune-tiger.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Fortune</small>
              <p>Tiger</p>
            </div>
          </a>
      </div>

      <div class="menu-item-wrapper">
          <a href="/casino/provider/1/category/all" class="menu-card">
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/pirates.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Fortune</small>
              <p>Pirates</p>
            </div>
          </a>
      </div>

      <div class="menu-item-wrapper">
          <a href="/casino/provider/1/category/all" class="menu-card">
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/fruits.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Fortune</small>
              <p>Fruits</p>
            </div>
          </a>
      </div>

      <div class="menu-item-wrapper">
          <a href="/games/play/1421/mines" class="menu-card">
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/mines.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Jogue agora</small>
              <p>Mines</p>
            </div>
          </a>
      </div>

      <div class="menu-item-wrapper">
          <a href="/vip" class="menu-card">
            <img class="menu-card-image" alt="Icone de Link" src="https://static.cassino.bet.br/deploy-8f49d8b06d13657e24811d2cfe76f7779e503261-dc4448deff25dc2d91d1/assets/images/menu-items/vip-store.png" onerror="this.onerror=null;this.src='https://placehold.co/115x100/122a44/FFFFFF?text=Imagem'">
            <div class="card-text-container">
              <small>Cassino</small>
              <p>Loja VIP</p>
            </div>
          </a>
      </div>
    </div>

    <button id="scroll-right" ref="scrollRightBtn" class="scroll-arrow right">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

// Referências aos elementos do DOM
const menuContainer = ref(null);
const scrollLeftBtn = ref(null);
const scrollRightBtn = ref(null);

// Função para verificar e atualizar a visibilidade das setas
const checkArrows = () => {
  if (!menuContainer.value) return;

  const { scrollLeft, scrollWidth, clientWidth } = menuContainer.value;

  // Oculta/mostra a seta da esquerda
  scrollLeftBtn.value.classList.toggle('hidden', scrollLeft <= 0);

  // Oculta/mostra a seta da direita
  const maxScrollLeft = scrollWidth - clientWidth;
  scrollRightBtn.value.classList.toggle('hidden', scrollLeft >= maxScrollLeft - 1);
};

// Funções de rolagem
const scrollRight = () => {
  if (!menuContainer.value) return;
  const scrollAmount = menuContainer.value.clientWidth / 2;
  menuContainer.value.scrollBy({ left: scrollAmount, behavior: 'smooth' });
};

const scrollLeft = () => {
  if (!menuContainer.value) return;
  const scrollAmount = -menuContainer.value.clientWidth / 2;
  menuContainer.value.scrollBy({ left: scrollAmount, behavior: 'smooth' });
};

// Gancho do ciclo de vida: executa quando o componente é montado
onMounted(() => {
  // Adiciona os event listeners
  scrollLeftBtn.value.addEventListener('click', scrollLeft);
  scrollRightBtn.value.addEventListener('click', scrollRight);
  menuContainer.value.addEventListener('scroll', checkArrows);
  window.addEventListener('resize', checkArrows);

  // Executa a verificação inicial
  checkArrows();
});

// Gancho do ciclo de vida: executa antes do componente ser destruído
onBeforeUnmount(() => {
  // Remove os event listeners para evitar vazamentos de memória
  window.removeEventListener('resize', checkArrows);
});
</script>

<style scoped>
/* Estilos personalizados para replicar o design da imagem */
.menu-navigation-wrapper {
  position: relative;
  width: 100%;
  max-width: 1200px;
}

/* Container com rolagem horizontal */
.menu-scroll-container {
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
  gap: 0.75rem; /* 12px */
  padding: 1.5rem 0;
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}

.menu-scroll-container::-webkit-scrollbar {
  display: none;
}

/* Wrapper para cada item para garantir que não encolham */
.menu-item-wrapper {
  flex-shrink: 0;
}

/* Estilo base para cada cartão do menu */
.menu-card {
  background-color: #122a44;
  border-radius: 0.75rem;
  width: 115px; /* Largura ajustada */
  overflow: visible;
  text-decoration: none;
  color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  border: 1px solid rgb(27, 54, 85);
  transition: transform 0.2s ease-in-out;
}

.menu-card:hover {
  transform: translateY(-4px);
}

.menu-card-image {
  width: 100%;
  height: 100px; /* Altura da imagem ajustada */
  object-fit: cover;
  border-top-left-radius: 0.75rem;
  border-top-right-radius: 0.75rem;
}

.card-text-container {
  width: 100%;
  padding: 0.5rem;
  text-align: center;
  height: 45px; /* Altura do texto ajustada */
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.card-text-container small {
  font-size: 0.7rem;
  color: #a0b3d1;
  display: block;
  line-height: 1.2;
}

.card-text-container p {
  font-weight: 700;
  font-size: 0.8rem;
  line-height: 1.2;
}

.status-badge {
  position: absolute;
  top: -8px;
  left: 8px;
  display: inline-flex;
  align-items: center;
  border-radius: 0.25rem;
  padding: 2px 6px 2px 4px;
  z-index: 10;
}

.status-badge img {
  width: 12px;
  height: 12px;
  margin-right: 4px;
}

.status-badge p {
  font-size: 8px;
  font-weight: 800;
  text-transform: uppercase;
}

.highlight-border-yellow {
  border: 2px solid #f8b91b;
}

.highlight-border-blue {
  border: 2px solid #00bfff;
}

/* Estilos para as setas de navegação */
.scroll-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(10, 25, 42, 0.8);
  border: 1px solid #1b3655;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 20;
  transition: background-color 0.2s, opacity 0.3s;
}

.scroll-arrow:hover {
  background-color: rgba(27, 54, 85, 0.9);
}

.scroll-arrow.left {
  left: -20px;
}

.scroll-arrow.right {
  right: -20px;
}

.scroll-arrow svg {
  width: 20px;
  height: 20px;
  stroke: white;
}

.scroll-arrow.hidden {
  opacity: 0;
  pointer-events: none;
}

/* --- Responsividade --- */

/* Para telas menores (dispositivos móveis) */
@media (max-width: 768px) {
  .scroll-arrow {
    /* Esconde as setas em telas pequenas, pois a rolagem por toque é mais comum */
    display: none;
  }
  
  .menu-scroll-container {
    /* Garante que o scroll com o dedo seja fluido */
    -webkit-overflow-scrolling: touch;
  }
}
</style>
