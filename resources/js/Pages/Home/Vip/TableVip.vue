<template>
    <div class="relative overflow-x-auto w-full">
        <table class="w-full text-center" style="font-size: 12px;">
            <thead class="uppercase" style="border-radius: 12px;border: 0.1rem solid var(--carousel-banners);">
                <tr style="border-radius: 12px;">
                  
                    <th scope="col" class="py-4" style="font-size: 10px;">
                        <p style="font-size: 10px;color: white;"></p>
                    </th>
                    <th scope="col" class="" style="font-size: 10px;text-align: center;" >
                        <p style="font-size: 10px;color: white;">Level</p>
                    </th>
                    <th scope="col" class="" style="font-size: 10px;">
                        <p style="font-size: 10px;color: white;">Progresso para o <br>Próximo nível</p>
                    </th>
                    <th scope="col" class="" style="font-size: 10px;">
                        <p style="font-size: 10px;color: white;">Bônus de Recompensa</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(vip, index) in vips" :key="index" class="odd:bg-white odd:dark:bg-[#17191A]" style="background-color: #17191A;" >
                  
                    <th scope="row" class="px-2 text-gray-900 whitespace-nowrap dark:text-white" style="border-top-left-radius: 8px;border-bottom-left-radius: 8px;font-size: 10px;"> 
                        <img :src="`/storage/`+vip.bet_symbol" alt="" width="55">
                    </th>
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $t('Level') }} {{ vip.bet_level }}
                    </td>
                    <td class="px-6 py-4">
                        <p style="color: var(--title-color);"> {{ vip.bet_required }}</p>
                        <p>
                            <div class="relative w-full bg-gray-200 rounded-full h-2 dark:bg-[#17191A]">
                                <div style="background-color: #68707B;font-size: 12px;"
                                    class="bg-gray-600 h-3 rounded-lg text-center justify-center text-white"
                                    :style="{ width: getProgress(vip.bet_required) + '%' }"
                                >
                                </div>
                                <span class="absolute top-0" style="left: 30%;font-size: 9px;" >
                                    {{ vipPoints >= vip.bet_required ? 'Concluído' : `${vipPoints} / ${vip.bet_required}` }}
                                </span>
                            </div>
                        </p>
                    </td>
                    <td class="px-6 py-4" style="color:#FFAC02;border-top-right-radius: 8px;border-bottom-right-radius: 8px;">
                        {{ vip.bet_bonus }}
                    </td>
                  
                </tr>
            </tbody>
        </table>
    </div>

</template>


<script>

export default {
    props: ['vips', 'vipPoints'],
    components: {  },
    data() {
        return {
            isLoading: false,

        }
    },
    setup(props) {


        return {};
    },
    computed: {

    },
    mounted() {

    },
    methods: {
        getProgress(requiredPoints) {
            if (this.vipPoints >= requiredPoints) {
                return 100;
            }
            return (this.vipPoints / requiredPoints) * 100;
        }
    
    },
    async created() {

    },
    watch: {

    },
};
</script>

<style scoped>
 tr:nth-child(odd) {
            color: var(--title-color);;
        }
</style>
