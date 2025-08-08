<template>
    <div class="pix-success">
      <h1>{{ $t('PIX Payment Completed') }}</h1>
      <p>{{ $t('Your PIX payment has been successfully processed') }}</p>
    </div>
  </template>

  <script>
  import { useAuthStore } from "@/Stores/Auth.js"; // Supondo que você tenha uma store para a autenticação.
  import { useSettingStore } from "@/Stores/SettingStore"; // Supondo que você tenha uma store para a autenticação.

  export default {
    name: "PixSuccess",
    async mounted() {

        const {getSetting} = useSettingStore();
        let setting = await getSetting();
        let facebook_pixel_id = setting.setting.facebook_pixel_id;
      // Redireciona o usuário para a página /home assim que a página for carregada
      this.$router.push("/home");

      // Inicializa o Pixel do Facebook e dispara o evento "Purchase"
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

        fbq("init", facebook_pixel_id); // Substitua pelo ID do seu Pixel do Facebook

        // Obtém o email do usuário da store de autenticação
        const authStore = useAuthStore();
        const userEmail = authStore.user?.email;

        // Obtém o valor da compra da URL
        const urlParams = new URLSearchParams(window.location.search);
        const purchaseValue = urlParams.get("value"); // O valor do depósito

        // Marca o evento "Purchase" no Pixel do Facebook (com valor)
        fbq("track", "Purchase", {
          content_name: "PIX Payment",
          content_category: "Payment",
          content_ids: [userEmail], // Pode incluir o email ou outro identificador único
          value: purchaseValue, // Passa o valor da compra
          currency: "BRL", // Apenas para registrar a moeda, se necessário
        });
      }
    },
  };
  </script>

  <style scoped>
  .pix-success {
    text-align: center;
    padding: 50px;
  }

  h1 {
    font-size: 24px;
    margin-bottom: 20px;
  }

  p {
    font-size: 18px;
  }
  </style>
