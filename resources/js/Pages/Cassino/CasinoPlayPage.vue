<template>
    <GameLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
                <span>{{ $t('Loading game information') }}</span>
            </div>
        </LoadingComponent>

        <div v-if="!isLoading && game" :class="{ 'w-full': modeMovie, 'lg:w-2/3': !modeMovie }" class="mx-auto pr-4 px-2 lg:px-4 py-2 lg:py-6 relative mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px]">
         

            <div class="game-screen" id="game-screen">
                <fullscreen v-model="fullscreen" :page-only="pageOnly">
                    <div v-if="showButton && game.game_type === 'live' && game.distribution === 'evergame'" class="game-full fullscreen-wrapper flex items-center justify-center">
                        <button @click.prevent="openModal(gameUrl)" type="button" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Clique para começar
                        </button>
                    </div>
                    <iframe v-else :src="gameUrl" class="game-full fullscreen-wrapper"></iframe>
                </fullscreen>
            </div>

            <div class="flex justify-between items-center w-full px-4 py-4 bg-gray-300/20 dark:bg-gray-800 game-footer">
                <div class="flex flex-col">
                <div>
                    <p style="text-transform: capitalize;font-weight: bold;">{{ game.game_name }}</p>
                </div>
                <div>
                    <p>{{ game?.provider.name }}</p>
                </div>
                 </div>
            
                <div class="text-gray-500 flex items-center gap-3">
                    
                       
                       
                    <div class="flex items-center gap-2">
                    <div>
                    <button @click.prevent="toggleLike" :class="{ 'text-[var(--ci-primary-color)]': game.hasLike }"><svg data-v-2e78989b="" height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"><path d="M512 224.112C512 197.608 490.516 176.133 464 176.133H317.482C340.25 138.226 352.005 95.257 352.005 80.11C352.005 56.523 333.495 32 302.54 32C239.411 32 276.176 108.148 194.312 173.618L178.016 186.644C166.23 196.06 160.285 209.903 160.215 223.897C160.191 223.921 160 224.112 160 224.112V384.042C160 399.146 167.113 413.368 179.198 422.427L213.336 448.02C241.027 468.779 274.702 480 309.309 480H368C394.516 480 416 458.525 416 432.021C416 428.386 415.52 424.878 414.754 421.475C434 415.228 448 397.37 448 376.045C448 366.897 445.303 358.438 440.861 351.164C463.131 347.002 480 327.547 480 304.077C480 291.577 475.107 280.298 467.275 271.761C492.234 270.051 512 249.495 512 224.112Z" fill="currentColor"></path><path d="M128 448V224C128 206.328 113.674 192 96 192H32C14.326 192 0 206.328 0 224V448C0 465.674 14.326 480 32 480H96C113.674 480 128 465.674 128 448Z" fill="currentColor" opacity="0.4"></path></svg> </button></div>
                    <div>
                        <p style="font-weight: 700;color: #727576;margin-top: -5px;font-size: 12px;">{{ game.totalLikes }}</p>
                    </div>
                    <div>
                        <svg style="transform: scaleX(-1);cursor: pointer;" data-v-2e78989b="" height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"><path d="M467.275 240.239C475.107 231.702 480 220.423 480 207.923C480 184.453 463.131 164.998 440.861 160.836C445.303 153.562 448 145.103 448 135.955C448 114.63 434 96.772 414.754 90.525C415.52 87.122 416 83.614 416 79.979C416 53.475 394.516 32 368 32H309.309C274.702 32 241.027 43.221 213.336 63.98L179.198 89.573C167.113 98.632 160 112.854 160 127.958V287.888C160 287.888 160.191 288.079 160.215 288.103C160.285 302.097 166.23 315.94 178.016 325.356L194.312 338.382C276.176 403.852 239.411 480 302.54 480C333.495 480 352.005 455.477 352.005 431.89C352.005 416.743 340.25 373.774 317.482 335.867H464C490.516 335.867 512 314.392 512 287.888C512 262.505 492.234 241.949 467.275 240.239Z" fill="currentColor"></path><path d="M96 32H32C14.326 32 0 46.326 0 64V288C0 305.672 14.326 320 32 320H96C113.674 320 128 305.672 128 288V64C128 46.326 113.674 32 96 32Z" fill="currentColor" opacity="0.4"></path></svg>
                    </div>
                    </div>
                    <div>
                        <button data-tooltip-target="tooltip-mode-expand" type="button" @click.prevent="togglefullscreen">
                            <svg data-v-c36db917="" height="1em" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M128 64H32C14.31 64 0 78.31 0 96v96c0 17.69 14.31 32 32 32s32-14.31 32-32V128h64c17.69 0 32-14.31 32-32S145.7 64 128 64zM480 288c-17.69 0-32 14.31-32 32v64h-64c-17.69 0-32 14.31-32 32s14.31 32 32 32h96c17.69 0 32-14.31 32-32v-96C512 302.3 497.7 288 480 288z" fill="currentColor"></path><path d="M480 64h-96c-17.69 0-32 14.31-32 32s14.31 32 32 32h64v64c0 17.69 14.31 32 32 32s32-14.31 32-32V96C512 78.31 497.7 64 480 64zM128 384H64v-64c0-17.69-14.31-32-32-32s-32 14.31-32 32v96c0 17.69 14.31 32 32 32h96c17.69 0 32-14.31 32-32S145.7 384 128 384z" fill="currentColor" opacity="0.4"></path></svg>
                        </button>
                        <div id="tooltip-mode-expand" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Modo Fullscreen
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Start Tabs -->
            
            <div id="tabContentExample">
                <div
                    class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                    id="default-panel"
                    role="tabpanel"
                    aria-labelledby="default-tab">
                    <div class="flex w-full">
                        <div class="w-full flex flex-col lg:flex-row justify-between">
                            <div class="w-full flex">
                                <div class="flex">
                                    <div v-if="game.distribution === 'kagaming'">
                                        <img :src="game.cover" alt="" class="w-full h-32 rounded-xl">
                                    </div>
                                    <div v-else>
                                        <img :src="`/storage/`+game.cover" alt="" class="w-full h-32 rounded-xl">
                                    </div>
                                </div>
                                <div class="p-4">
                                    <p class="text-2xl">{{ game.game_name }}</p>
                                    <p class="text-[12px]">{{ $t('by') }} <a href="" v-if="game.provider" class="font-bold text-white">{{ game?.provider.name }}</a></p>
                                    <p>{{ game.dateHumanReadable }}</p>
                                </div>
                            </div>
                            <div class="w-full mt-0 lg:mt-5">
                                <h2>{{ $t('Game Info') }}</h2>
                                <div class="mt-3 grid grid-cols-2 gap-1">
                                    <div class="p-3 bg-gray-700 flex justify-between">
                                        <p>RTP ({{ $t('Return to Player') }})</p>
                                        <p class="text-green-500">95%</p>
                                    </div>
                                    <div class="p-3 bg-gray-700 flex justify-between">
                                        <p>Provider</p>
                                        <p class="text-green-500">{{ game.provider.name }}</p>
                                    </div>
                                    <div class="p-3 bg-gray-700 flex justify-between">
                                        <p>Max Win</p>
                                        <p class="text-green-500">1000x</p>
                                    </div>
                                    <div class="p-3 bg-gray-700 flex justify-between">
                                        <p>Type</p>
                                        <p class="text-green-500">{{ game.game_type }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                    id="description-panel"
                    role="tabpanel"
                    aria-labelledby="description-tab"
                >
                    <div v-html="game.description"></div>
                </div>
                <div
                    class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                    id="reviews-panel"
                    role="tabpanel"
                    aria-labelledby="reviews-tab"
                >

                </div>
            </div>
            <!-- End Tabs -->
        </div>
        <div v-if="undermaintenance" class="flex flex-col items-center justify-center text-center py-24">
            <h1 class="text-2xl mb-4">JOGO EM MANUTENÇÃO</h1>
            <img :src="`/assets/images/work-in-progress.gif`" alt="" width="400">
        </div>
    </GameLayout>
</template>

<script>
import { initFlowbite, Tabs, Modal } from 'flowbite';
import { RouterLink, useRoute, useRouter } from "vue-router";
import { useAuthStore } from "@/Stores/Auth.js";
import { component } from 'vue-fullscreen';
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import GameLayout from "@/Layouts/GameLayout.vue";
import HttpApi from "@/Services/HttpApi.js";

import {
    defineComponent,
    toRefs,
    reactive,
} from 'vue';

export default {
    props: [],
    components: {
        GameLayout,
        LoadingComponent,
        RouterLink,
        component
    },
    data() {
        return {
            isLoading: true,
            game: null,
            modeMovie: false,
            gameUrl: null,
            token: null,
            gameId: null,
            tabs: null,
            undermaintenance: false,
        }
    },
    setup() {
        const router = useRouter();
        const state = reactive({
            fullscreen: false,
            pageOnly: false,
        })
        function togglefullscreen() {
            console.log("CLICOU");
            state.fullscreen = !state.fullscreen
        }

        return {
            ...toRefs(state),
            togglefullscreen,
            router
        }
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {

        const userAgent = navigator.userAgent.toLowerCase();
        const isSafari = userAgent.includes('safari') && !userAgent.includes('chrome');
        const isSamsungInternet = userAgent.includes('samsung') && userAgent.includes('safari') && !userAgent.includes('chrome');
        const isIOS = userAgent.includes('iphone') || userAgent.includes('ipad');

        if (isSafari || isSamsungInternet || isIOS) {
            this.showButton = true;
        }
    },
    methods: {
        loadingTab: function() {
            const tabsElement = document.getElementById('tabs-info');
            if(tabsElement) {
                const tabElements = [
                    {
                        id: 'default',
                        triggerEl: document.querySelector('#default-tab'),
                        targetEl: document.querySelector('#default-panel'),
                    },
                    {
                        id: 'descriptions',
                        triggerEl: document.querySelector('#description-tab'),
                        targetEl: document.querySelector('#description-panel'),
                    },
                    {
                        id: 'reviews',
                        triggerEl: document.querySelector('#reviews-tab'),
                        targetEl: document.querySelector('#reviews-panel'),
                    },
                ];

                const options = {
                    defaultTabId: 'default',
                    activeClasses: 'text-green-600 hover:text-green-600 dark:text-green-500 dark:hover:text-green-400 border-green-600 dark:border-green-500',
                    inactiveClasses: 'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
                    onShow: () => {

                    },
                };

                const instanceOptions = {
                    id: 'default',
                    override: true
                };

                /*
                * tabElements: array of tab objects
                * options: optional
                * instanceOptions: optional
                */
                this.tabs = new Tabs(tabsElement, tabElements, options, instanceOptions);
            }
        },
        openModal(gameUrl) {
            window.open(gameUrl);
        },

        getGame: async function() {
            const _this = this;

            return await HttpApi.get('games/single/'+ _this.gameId)
                .then(async response =>  {
                    if(response.data?.action === 'deposit') {
                        _this.$nextTick(() => {
                            _this.router.push({ name: 'profileDeposit' });
                        });

                    }

                    const game = response.data.game;
                    _this.game = game;

                    // if(game.distribution == 'evergame') {
                    //     window.open(response.data.gameUrl)
                    // }

                    _this.gameUrl = response.data.gameUrl;
                    _this.token = response.data.token;
                    _this.isLoading = false;

                    _this.$nextTick(() => {
                        _this.loadingTab();
                    });
                })
                .catch(error => {

                    _this.isLoading = false;
                    _this.undermaintenance = true;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

                    });
                });
        },
        toggleFavorite: function() {
            const _this = this;
            return HttpApi.post('games/favorite/'+ _this.game.id, {})
                .then(response =>  {
                    _this.getGame();
                    _this.isLoading = false;
                })
                .catch(error => {
                    _this.isLoading = false;
                });
        },
        toggleLike: async function() {
            const _this = this;
            return await HttpApi.post('games/like/'+ _this.game.id, {})
                .then(async response =>  {
                    await _this.getGame();
                    _this.isLoading = false;
                })
                .catch(error => {
                    _this.isLoading = false;
                });
        }
    },
    async created() {
        if(this.isAuthenticated) {
            const route = useRoute();
            this.gameId = route.params.id;


            await this.getGame();
        }else{
            this.router.push({ name: 'home', params: { action: 'openlogin' } });
        }
    },
    watch: {


    },
};
</script>

<style>
.game-screen{
    margin-top: 30px;
    width: 100%;
    min-height: 650px;
}

.game-screen .game-full{
    width: 100%;
    min-height: 650px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
.game-footer{
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}
</style>
