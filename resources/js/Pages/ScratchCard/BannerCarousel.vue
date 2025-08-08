<template>
  <div class="relative w-full max-w-2xl mx-auto rounded-2xl overflow-hidden shadow-lg">
    <Carousel v-if="banners.length" :autoplay="true" :interval="3000">
      <Slide v-for="(banner, index) in banners" :key="index">
        <div class="carousel__item rounded w-full">
          <a :href="banner.link || '#'" target="_blank" rel="noopener" class="w-full h-full rounded">
            <img
              :src="`/storage/${banner.image}`"
              alt=""
              class="h-full w-full rounded"
              style="max-height: 413px"
            />
          </a>
        </div>
      </Slide>
    </Carousel>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
// Se estiver usando um componente Carousel de biblioteca (ex: vue3-carousel)
import { Carousel, Slide } from 'vue3-carousel'

const banners = ref([])

onMounted(async () => {
  // Troque para o endpoint correto da sua API de banners
  const response = await axios.get('/api/banners')
  banners.value = response.data
})
</script>

<style scoped>
/* Adapte ou remova se já usa Tailwind */
.carousel__item {
  height: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff3;
}
</style>
