<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>Carregando os jogos</span>
            </div>
        </LoadingComponent>


        <div class="carousel-banners">
                <div class="mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px] padding-mobile-banner"> 
                         <!-- Conteúdo da sua página aqui -->
                         <div class="mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px]" style="position: fixed;bottom: 0;z-index: 2;pointer-events: auto;height: 0px;z-index: 1;">
                         <button style="pointer-events: auto;" class="btn-scroll-top" @click="scrollToTop">
                            <div><svg height="1em" viewBox="0 0 384 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" fill="currentColor"></path></svg></div> <div>De volta ao topo</div> 
                            </button>
                        </div>
                    <div class="">
                        <Carousel v-bind="settings" :breakpoints="breakpoints" ref="carouselBanner">
                            <Slide v-for="(banner, index) in banners" :key="index">
                                <div class="carousel__item rounded w-full">
                                    <a :href="banner.link" class="w-full h-full bg-blue-800 rounded">
                                        <img :src="`/storage/`+banner.image" alt="" class="h-full w-full rounded" style="max-height: 413px">
                                    </a>
                                </div>
                            </Slide>
 

                            <template #addons>
                                <navigation>
                                    <template #next>
                                        <i class="fa-solid fa-chevron-right text-white font-arrows"></i>
                                    </template>
                                    <template #prev>
                                        <i class="fa-solid fa-chevron-left text-white font-arrows"></i>
                                    </template>
                                </navigation>
                                <Pagination />
                            </template>
                        </Carousel>
                    </div>
                </div>
            </div>

        <div v-if="!isLoading" class=" mx-auto">
            <div class="px-4">
                <HeaderComponent>
                    <template #header>
                       
                    </template>

                </HeaderComponent>


  <!-- Banners carousel -->
  

                <form class="sm:max-w-[1110px] lg:max-w-[1110px] mx-auto w-full">
                 
                    <div class="flex">
                        
                    </div>
                    <div class="flex justify-between mx-auto items-center md:mt-[30px] mb-[25px] mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px]">
                    
                       
                        <div class="flex items-center">
                              <a style="margin-right: 10px;" href="../"><svg height="1em" viewBox="0 0 448 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" fill="currentColor"></path></svg></a> <p class="text-2xl flex items-center justify-center" style="font-size: 14px;font-weight: bold;padding-right: 5px;font-weight: 700;color: white;">{{ $t('Todos os Jogos') }} <strong style="font-size: 13px;padding-left: 5px;"> </strong></p>
                            </div>
                            <div class="md:block hidden">
                                <input style="background-color: var(--input-primary);padding: 0;padding-left: 25px;padding-top: 5px;padding-bottom: 5px;border-radius: 3px;font-size: 14px;padding-right: 55px;" v-model="searchTerm" @input="searchGames" type="search" id="search"
                               class="block relative w-full"
                               :placeholder="$t('Pesquise um jogo...')"
                               required>
                            </div>
                            <div class="flex items-center gap-4 md:hidden block">
                                <svg height="1rem" width="1rem" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M505 41L320 225.93V488c0 19.51-22 30.71-37.76 19.66l-80-56A24 24 0 0 1 192 432V226L7 41C-8 25.87 2.69 0 24 0h464c21.33 0 32 25.9 17 41z" fill="currentColor" opacity="0.4"></path></svg>
                                <svg height="1rem" viewBox="0 0 512 512" width="1rem" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1a12 12 0 0 1 0 17L338 377.6a12 12 0 0 1-17 0L256 312l-65.1 65.6a12 12 0 0 1-17 0L134.4 338a12 12 0 0 1 0-17l65.6-65-65.6-65.1a12 12 0 0 1 0-17l39.6-39.6a12 12 0 0 1 17 0l65 65.7 65.1-65.6a12 12 0 0 1 17 0l39.6 39.6a12 12 0 0 1 0 17L312 256z" fill="currentColor" opacity="0.4"></path><path d="M377.6 321.1a12 12 0 0 1 0 17L338 377.6a12 12 0 0 1-17 0L256 312l-65.1 65.6a12 12 0 0 1-17 0L134.4 338a12 12 0 0 1 0-17l65.6-65-65.6-65.1a12 12 0 0 1 0-17l39.6-39.6a12 12 0 0 1 17 0l65 65.7 65.1-65.6a12 12 0 0 1 17 0l39.6 39.6a12 12 0 0 1 0 17L312 256z" fill="currentColor"></path></svg>
                            </div>
                   </div>
                
                   
                </form>
                <div class="md:hidden block w-full">
                                <input style="width: 100%;;background-color: var(--input-primary);padding: 0;padding-left: 25px;padding-top: 2px;padding-bottom: 3px;border-radius: 3px;font-size: 12px;padding-right: 55px;" v-model="searchTerm" @input="searchGames" type="search" id="search"
                               class="block relative w-full"
                               :placeholder="$t('Pesquise um jogo...')"
                               required>
                            </div>
                <div v-if="games && games?.total > 0">
                    <div class="relative w-full sm:max-w-[690px] lg:max-w-[1110px] mx-auto w-full md:mt-10 mt-6">
                        <div class="grid grid-cols-3 md:grid-cols-6 gap-4 mb-5">
                            <CassinoGameCard
                                v-for="(game, index) in games.data"
                                :index="index"
                                :title="game.game_name"
                                :cover="game.cover"
                                :gamecode="game.game_code"
                                :type="game.distribution"
                                :game="game"
                            />
                        </div>
                    </div>

                    <div class="mt-[50px] relative sm:max-w-[690px] lg:max-w-[1110px] mx-auto w-full">
                        <CustomPagination :data="games" @pagination-change-page="getGameData"/>
                        
                    </div>
                    
                </div>
                <div v-else class="empty-data flex flex-col justify-center items-center text-center mt-[50px] mb-[30px] sm:max-w-[690px] lg:max-w-[1110px] mx-auto w-full">
                    <div class="flex justify-center p-2 w-full" style="background-color: #383028;border-radius: 5px;">
                    <h3 style="color: #FF9F43;font-size: .75rem;">{{ $t('No data to show') }}</h3>
                </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import HttpApi from "@/Services/HttpApi.js";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";
import CustomPagination from "@/Components/UI/CustomPagination.vue";
import {useRoute, useRouter} from "vue-router";
import {computed, ref, watch} from "vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HeaderComponent from "@/Components/UI/HeaderComponent.vue";

export default {
    props: [],
    components: {HeaderComponent, LoadingComponent, CustomPagination, CassinoGameCard, BaseLayout},
    data() {
        return {
          /// banners settings
          settings: {
                    itemsToShow: 1,
                    snapAlign: 'center',
                    autoplay: 6000,
                    wrapAround: true
                },
                breakpoints: {
                    700: {
                        itemsToShow: 1,
                        snapAlign: 'center',
                    },
                    1024: {
                        itemsToShow: 1,
                        snapAlign: 'center',
                    },
                },

                settingsRecommended: {
                    itemsToShow: 2,
                    snapAlign: 'start',
                },
                breakpointsRecommended: {
                    700: {
                        itemsToShow: 3,
                        snapAlign: 'center',
                    },
                    1024: {
                        itemsToShow: 3,
                        snapAlign: 'start',
                    },
                },

                /// banners
                banners: null,
                bannersHome: null,

            isLoading: false,
            games: null,
            searchTerm: '',
            provider: null,
            category: null,
        }
    },
    setup(props) {
        const ckCarouselOriginals = ref(null)
        const fgCarousel = ref(null)
        const route = useRoute();

        watch(() => route.params.provider, (newProvider, oldProvider) => {

        });

        return {
            route,
            ckCarouselOriginals,
            fgCarousel
        };
    },
    computed: {},
    mounted() {
        window.scrollTo(0, 0);
    },
    beforeUnmount() {},
    methods: {
        getBanners: async function () {
                const _this = this;

                try {
                    const response = await HttpApi.get('settings/banners');
                    const allBanners = response.data.banners;

                    _this.banners = allBanners.filter(banner => banner.type === 'carousel');
                    _this.bannersHome = allBanners.filter(banner => banner.type === 'home');
                } catch (error) {
                    console.error(error);
                } finally {

                }
            },
            initializeMethods: async function () {
                await this.getBanners();
            },
            onCarouselInit(index) {

            },
            onSlideStart(index) {

            },

    
        searchGames: async function () {
            const _this = this;
            if (_this.searchTerm.length > 2) {
                await _this.getGameData(1,  false);
            }else{
                await _this.getGameData(1,  false);
            }
        },
        getGameData: async function (page = 1, loading = true) {
            const _this = this;
            _this.isLoading = loading;
            const provider = _this.route.params.provider;
            const category = _this.route.params.category;

            this.provider = provider;
            this.category = category;

            await HttpApi.get('/casinos/games?page=' + page + '&searchTerm=' + _this.searchTerm+'&category='+_this.category+'&provider='+_this.provider)
                .then(response => {
                    _this.games = response.data.games;
                    _this.isLoading = false;
                })
                .catch(error => {
                    _this.isLoading = false;
                });
        },
    },
   async created() {
        await this.initializeMethods();
        await this.getGameData(1,  false);
    },
    watch: {
        'route.params.provider'(newGame, oldGame) {
            this.getGameData(1,  true);
        },
        'route.params.category'(newGame, oldGame) {
            this.getGameData(1,  true);
        }
    },
};
</script>

<style scoped>

</style>
