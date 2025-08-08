import { defineStore } from 'pinia'

export const sidebarStore = defineStore('sidebar', {
    
    state() {
        // Tente obter o status da barra lateral do localStorage, se não estiver disponível, retorne false
        const savedStatus = localStorage.getItem('sidebarStatus');
        return {
            sidebarStatus: savedStatus ? JSON.parse(savedStatus) : false,
        };
    },

    actions: {
        setSidebarToogle() {
            // Alterna o status da barra lateral
            this.sidebarStatus = !this.sidebarStatus;
            // Salva o novo status no localStorage
            localStorage.setItem('sidebarStatus', JSON.stringify(this.sidebarStatus));
        },
        setSidebarStatus(status) {
            // Define o status da barra lateral
            this.sidebarStatus = status;
            // Salva o novo status no localStorage
            localStorage.setItem('sidebarStatus', JSON.stringify(this.sidebarStatus));
        },
    },

    getters: {
        getSidebarStatus() {
            // Retorna o status da barra lateral
            return this.sidebarStatus;
        },
    },
})
