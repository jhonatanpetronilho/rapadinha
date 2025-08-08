<template>
     <div v-if="isLoading">

      <div class="">
       
      </div>
     
   
  </div>

</template>

<script>
import {useSettingStore} from "@/Stores/SettingStore.js";

export default {
    props: ['isLoading'],
    components: {},
    data() {
        return {

        }
    },
    setup(props) {


        return {};
    },
    computed: {
      setting() {
            const authStore = useSettingStore();
            return authStore.setting;
        }
    },
    mounted() {

    },
    methods: {
      getSetting: function() {
                const _this = this;
                const settingStore = useSettingStore();
                const settingData = settingStore.setting;

                if(settingData) {
                    _this.setting = settingData;
                }
            },
    },
    created() {
        this.getSetting();
       
    },
    watch: {

    },
};
</script>

<style>



</style>
