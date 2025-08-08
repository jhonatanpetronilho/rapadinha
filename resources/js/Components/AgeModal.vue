<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80">
    <div class="bg-[#030C16] rounded-xl shadow-lg p-0 max-w-sm w-full text-center relative overflow-hidden">
      <div class="w-full h-20 flex items-center justify-center logo-gradient absolute top-0 left-0 right-0"></div>
      <button v-if="denied" @click="denied = false" class="absolute top-2 right-5 text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none z-20" aria-label="Fechar">&times;</button>
      <div class="relative pt-6 pb-6 px-6 z-10 flex flex-col items-center justify-center">
        <img src="https://kassino.bet/storage/uploads/OY77X43u9iSP8mrlKSuhW31J1XCOU9oYw1LnDuUT.png" alt="Logo KASSINOPIX" class="mx-auto w-28 h-auto mb-2" />
        <p v-if="!denied" class="mb-4 text-white mt-4 font-semibold text-xl leading-tight">
          Você tem mais<br>
          <span class="block text-center">de 18 anos?</span>
        </p>
        <div v-if="!denied" class="flex justify-center gap-8 mt-6">
          <button @click="deny" class="border border-gray-500 text-white font-bold py-2 px-14 rounded-lg transition shadow-md text-lg bg-transparent">Não</button>
          <button @click="accept" class="sim-btn text-white font-bold py-2 px-14 rounded-lg transition shadow-md text-lg">Sim</button>
        </div>
        <div v-else class="mt-4 text-white font-bold text-base w-full flex flex-col items-center">
          Desculpe. Você é muito jovem para consumir esse conteúdo.
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AgeModal',
  data() {
    return {
      show: true,
      denied: false
    }
  },
  methods: {
    accept() {
      this.show = false;
      localStorage.setItem('ageConfirmed', 'true');
    },
    deny() {
      this.denied = true;
    }
  },
  mounted() {
    if (localStorage.getItem('ageConfirmed') === 'true') {
      this.show = false;
    }
  }
}
</script>

<style scoped>
.logo-gradient {
  background: #01081a;
  height: 80px;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  z-index: 1;
}
.sim-btn {
  background: #00bfff;
}
.sim-btn:hover {
  background: #009acd;
}
</style>
