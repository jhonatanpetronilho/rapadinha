<template>
  <footer
    class="w-full"
    :style="{ background: '#0A0D0B' }"
  >
         <section
        class="flex flex-col md:flex-row md:items-start justify-between gap-10 mx-auto max-w-7xl px-4 pt-8 pb-32"
      >


      <!-- Coluna Esquerda: Logo + direitos -->
      <div class="flex flex-col gap-4 w-full md:w-[35%] md:justify-start justify-center">
        <a href="/" class="block mb-2">
          <img
            v-if="setting && setting.software_logo_black"
            :src="'/storage/' + setting.software_logo_black"
            class="footer-logo w-[140px] min-w-[140px] block"
            alt="Logo"
          />
          <img
            v-else-if="setting && setting.software_logo_white"
            :src="'/storage/' + setting.software_logo_white"
            class="footer-logo w-[140px] min-w-[140px] block"
            alt="Logo"
          />
        </a>
        <div class="text-xxs opacity-65 text-white">
          © {{ year }} {{ setting?.software_domain || 'raspazinha.com' }}. Todos os direitos reservados.
        </div>
        <div class="text-xxs opacity-50 text-white">
          Raspadinhas e outros jogos de azar são regulamentados e cobertos pela nossa licença de jogos. Jogue com responsabilidade.
        </div>
      </div>
      <!-- Coluna Direita: Links -->
      <div class="flex flex-col w-full md:w-[65%] md:pl-12 mt-5 md:mt-0">
        <div class="flex flex-wrap gap-16 md:gap-32 justify-between w-full">
          <!-- Regulamentos -->
          <div class="flex flex-col gap-y-0.5 mb-8 md:mb-0">
            <strong class="text-left mb-2.5 text-white">Regulamentos</strong>
            <div class="flex flex-col gap-3 [&>*]:text-sm [&>*]:opacity-70">
              <a href="/#" class="footer_link text-white">Jogo responsável</a>
              <a href="/#" class="footer_link text-white">Política de Privacidade</a>
              <a href="/#" class="footer_link text-white">Termos de Uso</a>
            </div>
          </div>
          <!-- Ajuda -->
          <div class="flex flex-col gap-y-0.5">
            <strong class="text-left mb-2.5 text-white">Ajuda</strong>
            <div class="flex flex-col gap-3 [&>*]:text-sm [&>*]:opacity-70">
              <a href="/#" class="footer_link text-white">Perguntas Frequentes</a>
              <a href="/#" class="footer_link text-white">Como Jogar</a>
              <a href="/#" class="footer_link text-white">Suporte Técnico</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </footer>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useSettingStore } from '@/Stores/SettingStore.js';

const year = new Date().getFullYear();
const setting = ref(null);

onMounted(() => {
  const store = useSettingStore();
  setting.value = store.setting;
});
</script>

<style scoped>
.text-xxs {
  font-size: 13px;
}
.footer_link {
  transition: color 0.2s, opacity 0.2s;
}
.footer_link:hover {
  color: #70eb90 !important;
  opacity: 1 !important;
}
</style>
