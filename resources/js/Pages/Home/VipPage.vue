<template>
    <BaseLayout>
        <LoadingComponent :isLoading="isLoading">
            <div class="text-center">
       
            </div>
        </LoadingComponent>
       
      
   
      
            <!-- Banners carousel -->

            
    
    
        <div v-if="!isLoading" class=" mx-auto w-full sm:max-w-[690px] lg:max-w-[1110px]" style="width: 100%;height: 100vh;overflow-y: scroll;">
            <HeaderComponent>
         

            </HeaderComponent>
<div style="padding: 0 2%;">
            <div style="margin-top: 45px;">

                <div class="flex items-center w-full sm:flex-col flex-col xl:flex-row md:mt-[70px]" style="height: auto;margin-bottom: 45px;box-sizing: border-box;">
                    <div class="max-[1279px]:rounded-t-lg min-[1280px]:rounded-s-lg" style="position: relative;;background-image: linear-gradient(to top, var(--ci-primary-opacity-color), rgba(0,0,0,0.1));width: 100%;display: flex;justify-content: center;align-items: center;padding: 30px;box-sizing: border-box;height: 415px;">
                        <div style="border-radius: 100%;background-color: #17191A;padding: 10px;line-height: 10px;text-align: right;margin-top: -20px">
                                <img 
  style="min-width: 350px; width: 350px; height: 250px; min-height: 250px;" 
  :src="'/assets/images/perfilee2.png'" 
  alt="Perfil" 
  class="h-16"
>
                                 <a href="" class="text-primary pl-1" style="color: white;font-size: 14px;font-weight: 550;font-style: italic;position: absolute;right: 4%;bottom: 4%;"><p style="font-weight: 300;font-size: 12px;">Requisitos para o próximo nível</p><br> <p>Bronze - Nível {{ nextLevel?.bet_level }}</p><br><p>Aposte um total de: R${{ nextLevel?.bet_required }}</p></a>
                            </div>
                    </div>
                    <div class="flex flex-col max-[1279px]:rounded-b-lg min-[1280px]:rounded-e-lg" style="background-color: #17191A;padding: 4%;box-sizing: border-box;height: 100%;">
                       
                        <p class="titulo-vip">Bem vindo(a) à área de Níveis!</p>
                        <h2 class="texto-vip">Junte-se ao nosso Clube VIP e tenha acesso exclusivo a conquistas e benefícios personalizados! Experimente o gostinho de receber mais bônus de volta e recompensas que certamente farão você alcançar níveis mais altos!{{ vipLevel }}

                        Para participar é simples, acumule pontos VIP apostando. Quanto mais apostar, maior a nível de VIP atingirá e poderá trocar por benefícios na nossa loja e ainda te ajudar a subir de nível.
                          
                        Venha viver a melhor experiência VIP.</h2>
                            <p class="ui-button-blue2 botao-vip" >Suba de nível e aumente seus ganhos!</p>
                       
                    </div>
                </div>
                
           
            </div>
                <div class="rounded-lg w-full">
              
                   
                    <!-- Start Tabs -->
                    <div class="mb-4 mt-6">
                        <p class="flex items-center gap-2" style="color: var(--title-color);font-size: 28px;"><svg style="color: var(--ci-primary-color);" data-v-b109efcf="" fill="currentColor" height="1em" stroke="currentColor" viewBox="0 0 140.599 140.599" width="1em" xmlns="http://www.w3.org/2000/svg" class="icon"><g fill="currentColor" stroke-width="0"></g><g fill="currentColor" stroke-linecap="round" stroke-linejoin="round"></g><g fill="currentColor"><g><path d="M132.861,56.559c-4.27,0-7.742,3.473-7.742,7.741c0,1.893,0.685,3.626,1.815,4.973l-15.464,15.463 c-2.754,2.754-4.557,1.857-4.027-2l0.062-0.445c0.528-3.857-1.39-4.876-4.286-2.273l-0.531,0.479 c-2.898,2.603-5.828,1.609-6.544-2.219l-5.604-29.964c-0.717-3.828-2.129-3.886-3.156-0.129l-7.023,25.689 c-1.025,3.757-2.295,3.677-2.834-0.181L71.93,33.674c3.488-0.751,6.111-3.856,6.111-7.566c0-4.268-3.473-7.741-7.741-7.741 c-4.269,0-7.742,3.473-7.742,7.741c0,3.709,2.625,6.815,6.112,7.566l-5.592,40.019c-0.539,3.857-1.809,3.938-2.835,0.181 l-7.023-25.69c-1.027-3.757-2.44-3.699-3.156,0.129l-5.605,29.964c-0.716,3.828-3.645,4.82-6.543,2.219l-0.533-0.479 c-2.897-2.604-4.816-1.586-4.287,2.272l0.061,0.445c0.529,3.858-1.274,4.753-4.028,2L13.667,69.273 c1.132-1.347,1.816-3.08,1.816-4.973c0-4.269-3.473-7.741-7.741-7.741C3.473,56.559,0,60.032,0,64.3 c0,4.269,3.473,7.742,7.742,7.742c0.478,0,0.942-0.05,1.396-0.132l10.037,33.949c1.104,3.734,3.534,9.637,7.161,11.055 c8.059,3.153,24.72,5.318,43.964,5.318c19.245,0,35.905-2.165,43.965-5.318c3.626-1.418,6.058-7.32,7.161-11.055l10.037-33.949 c0.453,0.083,0.918,0.132,1.396,0.132c4.268,0,7.739-3.473,7.739-7.742C140.6,60.032,137.127,56.559,132.861,56.559z M11.103,66.708c-0.685,0.954-1.761,1.605-2.994,1.714c-0.121,0.011-0.243,0.019-0.367,0.019c-2.284,0-4.142-1.857-4.142-4.142 c0-2.284,1.858-4.141,4.142-4.141c2.283,0,4.141,1.857,4.141,4.141C11.883,65.2,11.592,66.031,11.103,66.708z M66.159,26.109 c0-2.283,1.858-4.141,4.142-4.141c2.283,0,4.143,1.857,4.143,4.141c0,1.892-1.276,3.488-3.014,3.981 c-0.359,0.102-0.737,0.16-1.129,0.16s-0.769-0.058-1.128-0.16C67.436,29.596,66.159,28,66.159,26.109z M70.301,115.405 l-15.36-15.361l15.36-15.36l15.359,15.359L70.301,115.405z M132.861,68.442c-0.125,0-0.248-0.008-0.369-0.019 c-1.231-0.109-2.309-0.76-2.993-1.714c-0.488-0.68-0.779-1.51-0.779-2.409c0-2.284,1.856-4.141,4.142-4.141 c2.282,0,4.142,1.857,4.142,4.141C137.001,66.583,135.143,68.442,132.861,68.442z M60.036,100.046l10.27-10.27l10.269,10.27 l-10.269,10.27L60.036,100.046z" fill="currentColor"></path></g></g></svg> <p style="font-weight: 700;color: white;">Benefícios de cada nível</p></p>
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700" id="tabs-vip" role="tablist">
                          
                            <li class="me-2" role="presentation" style="display: none;">
                                <button style="font-size: 10px;"
                                    class="inline-block rounded-t-lg border-b-2 border-transparent p-2 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                                    id="vipdefault-tab"
                                    type="button"
                                    role="tab"
                                    aria-controls="vipdefault-panel"
                                    aria-selected="false"
                                >
                                    Bônus De Aumento De Nível
                                </button>
                            </li>
                            <li class="me-2" role="presentation" style="display: none;">
                                <button style="font-size: 10px;"
                                    class="inline-block rounded-t-lg border-b-2 border-transparent p-2 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                                    id="weeklybonus-tab"
                                    type="button"
                                    role="tab"
                                    aria-controls="weeklybonus-panel"
                                    aria-selected="false"
                                >
                                    Bônus Semanal
                                </button>
                            </li>
                            <li class="me-2" role="presentation" style="display: none;">
                                <button style="font-size: 10px;"
                                    class="inline-block rounded-t-lg border-b-2 border-transparent p-2 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                                    id="monthlybonus-tab"
                                    type="button"
                                    role="tab"
                                    aria-controls="monthlybonus-panel"
                                    aria-selected="false"
                                >
                                    Bônus Mensal
                                </button>
                            </li>
                            <li class="me-2" role="presentation" style="display: none;">
                                <button
                                    class="inline-block rounded-t-lg border-b-2 border-transparent p-2 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                                    id="annualbonus-tab"
                                    type="button"
                                    role="tab"
                                    aria-controls="annualbonus-panel"
                                    aria-selected="false"
                                >
                                    Bônus Anual
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div id="tabContentExample">
                        <div
                            class="hidden rounded-lg "
                            id="vipdefault-panel"
                            role="tabpanel"
                            aria-labelledby="vipdefault-tab">
                            <div class="flex w-full">
                                <TableVip :vips="nivelToday" :vipPoints="vipPoints" />
                            </div>
                        </div>
                        <div
                            class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                            id="weeklybonus-panel"
                            role="tabpanel"
                            aria-labelledby="weeklybonus-tab">
                            <div class="flex w-full">
                                <TableVip :vips="nivelWeekly" :vipPoints="vipPoints" />
                            </div>
                        </div>
                        <div
                            class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                            id="monthlybonus-panel"
                            role="tabpanel"
                            aria-labelledby="monthlybonus-tab">
                            <div class="flex w-full">
                                <TableVip :vips="nivelMonthly" :vipPoints="vipPoints" />
                            </div>
                        </div>
                        <div
                            class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                            id="annualbonus-panel"
                            role="tabpanel"
                            aria-labelledby="annualbonus-tab">
                            <div class="flex w-full">
                                <TableVip :vips="nivelYearly" :vipPoints="vipPoints" />
                            </div>
                        </div>
                    </div>
                    <!-- End Tabs -->
                    


                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import HeaderComponent from "@/Components/UI/HeaderComponent.vue";
import HttpApi from "@/Services/HttpApi.js";
import { initFlowbite, Tabs, Modal } from 'flowbite';
import TableVip from "@/Pages/Home/Vip/TableVip.vue";

export default {
    props: ['vips', 'vipPoints'],
    components: {TableVip, HeaderComponent, LoadingComponent, BaseLayout },
    data() {
        return {
            isLoading: true,
            nivelToday: null,
            nivelWeekly: null,
            nivelMonthly: null,
            nivelYearly: null,
            nextLevel: null,
            vipPoints: 0,
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
        },
        loadingVipTab: function() {
            const tabsElement = document.getElementById('tabs-vip');
            console.log(tabsElement);
            if(tabsElement) {
                const tabElements = [
                    {
                        id: 'vipdefault',
                        triggerEl: document.querySelector('#vipdefault-tab'),
                        targetEl: document.querySelector('#vipdefault-panel'),
                    },
                    {
                        id: 'weeklybonus',
                        triggerEl: document.querySelector('#weeklybonus-tab'),
                        targetEl: document.querySelector('#weeklybonus-panel'),
                    },
                    {
                        id: 'monthlybonus',
                        triggerEl: document.querySelector('#monthlybonus-tab'),
                        targetEl: document.querySelector('#monthlybonus-panel'),
                    },
                    {
                        id: 'annualbonus',
                        triggerEl: document.querySelector('#annualbonus-tab'),
                        targetEl: document.querySelector('#annualbonus-panel'),
                    },
                ];

                const options = {
                    defaultTabId: 'vipdefault',
                    activeClasses: 'text-[var(--ci-primary-color)] hover:text-[var(--ci-primary-color)] dark:text-[var(--ci-primary-color)] dark:hover:text-[var(--ci-primary-color)] border-[var(--ci-primary-color)] dark:border-[var(--ci-primary-color)]',
                    inactiveClasses: 'text-[#7A818C] hover:text-[#7A818C] dark:text-[#7A818C] border-[#7A818C] hover:border-[#7A818C] dark:border-[#7A818C] dark:hover:text-[#7A818C]',
                    onShow: () => {

                    },
                };

                const instanceOptions = {
                    id: 'vipdefault',
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
        getVips: async function () {
            const _this = this;
            await HttpApi.get(`/profile/vip/`)
                .then(response => {

                    _this.vipPoints = response.data.vipPoints;
                    _this.nextLevel = response.data.nextLevel;
                    _this.nivelToday = response.data.nivelToday;
                    _this.nivelWeekly = response.data.nivelWeekly;
                    _this.nivelMonthly = response.data.nivelMonthly;
                    _this.nivelYearly = response.data.nivelYearly;

                    _this.isLoading = false;

                    _this.$nextTick(() => {
                        _this.loadingVipTab();
                    });
                })
                .catch(error => {
                    _this.isLoading = false;
                });
        },
    },
    async created() {
        await this.getVips();
    },
    watch: {

    },
};
</script>

<style scoped>
.titulo-vip {
    font-size: 28px;
}
.botao-vip {
    text-align: center;
    width: 100%;
    max-width: 400px;
    font-size: 18px;
    padding-bottom: 15px;
    padding-top: 15px;
}
.texto-vip {
    font-size: 18px;
    padding-top: 30px;
    padding-bottom: 15px;
}
/* Estilo para a barra de navegação */
.navbar21 {
    display: flex;
    justify-content: start;
    align-items: center;
    background-color: #151d29;
    padding: 10px;
    color: #fff;
    border-bottom: 1px solid #293548;
    position: fixed; /* Fixar no topo */
    width: 100%; /* Largura total da tela */
    top: 0; /* Alinhar no topo */
    left: 0; /* Alinhar à esquerda */
    z-index: 1000; /* Garantir que fique acima de outros elementos */
    height: 52px; /* Definindo a altura da navbar */
}


.navbar21-left {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-left: 3px; /* Ajuste a posição para a direita */
}

.navbar21-left i {
    color: #adb6c4; /* Cor da seta */
    font-size: 1em; /* Tamanho da seta */
}

.navbar21-right {
    text-align: left;
}

.navbar21-center {
    flex: 3; /* Aumenta o espaço disponível para o texto central */
    text-align: center;
}

.navbar21 p {
    margin: 0;
    line-height: 0.9; /* Ajusta a altura da linha para que a quebra de linha fique mais junta */
}

.navbar21 a {
    color: #005dfe;
    text-decoration: none;
    font-size: 1em; /* Diminuir o tamanho da fonte do link */
}

@media (max-width:768px) {
    .texto-vip {
    font-size: 12px;
}
.titulo-vip {
    font-size: 18px;
}
.botao-vip {
    font-size: 14px;
 
}
}
  
</style>
