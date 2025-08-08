<template>
    <BaseLayout>
        <div class="p-4 mx-auto mt-20 md:w-4/6 2xl:w-4/6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 z-[999999]">
                <div class="hidden col-span-1 md:block">
                    <WalletSideMenu />
                </div>
                <div class="relative col-span-2">
                    <DepositWidget />
                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import { RouterLink } from "vue-router";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import DepositWidget from "@/Components/Widgets/DepositWidget.vue";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import {useAuthStore} from "@/Stores/Auth.js";
import {useSettingStore} from "@/Stores/SettingStore";

export default {
    props: [],
    components: {WalletSideMenu, DepositWidget, BaseLayout, RouterLink },
    data() {
        return {
            isLoading: false,

        }
    },
    setup(props) {


        return {};
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    async mounted() {
        window.scrollTo(0, 0);

        const {getSetting} = useSettingStore();
        let setting = await getSetting();
        let facebook_pixel_id = setting.setting?.facebook_pixel_id;
        // Inicializa o Pixel do Facebook e registra o evento de PageView
        if (typeof window !== "undefined") {
            !(function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod
                        ? n.callMethod.apply(n, arguments)
                        : n.queue.push(arguments);
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = "2.0";
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = "https://connect.facebook.net/en_US/fbevents.js";
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s);
            })(window, document, "script");

            fbq("init", facebook_pixel_id); // Substitua pelo ID do Pixel do Facebook
            fbq("track", "PageView"); // Marca o evento de PageView
        }
    },
    methods: {

    },
    created() {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
