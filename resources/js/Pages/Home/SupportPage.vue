<template>
    <div class="registration-success">
      <h1>{{ $t('Registration Successful') }}</h1>
      <p>{{ $t('Your account has been created successfully') }}</p>
    </div>
  </template>

  <script>
  import { useAuthStore } from "@/Stores/Auth.js"; // Supondo que você tenha uma store para a autenticação.
  import { useSettingStore } from "@/Stores/SettingStore"; // Supondo que você tenha uma store para a autenticação.

  export default {
    name: 'RegistrationSuccess',
    async mounted() {
        const {getSetting} = useSettingStore();
        let setting = await getSetting();
        setting = setting.setting;
        let facebook_pixel_id = setting.facebook_pixel_id;
      // Redireciona o usuário para a página /home assim que a página for carregada
      this.$router.push('/profile/deposit');

      // Carrega o Pixel do Facebook se não estiver carregado ainda
      if (typeof window !== 'undefined' && !window.fbq) {
        // Meta Pixel Code
        (function(f, b, e, v, n, t, s) {
          if (f.fbq) return;
          n = f.fbq = function() {
            n.callMethod ? n.callMethod.apply(n, arguments) :
              n.queue.push(arguments);
          };
          if (!f._fbq) f._fbq = n;
          n.push = n;
          n.loaded = !0;
          n.version = '2.0';
          n.queue = [];
          t = b.createElement(e);
          t.async = !0;
          t.src = v;
          s = b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t, s);
        })(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', facebook_pixel_id);  // Seu Pixel ID aqui
        fbq('track', 'PageView');  // Registra a visualização da página
      }

      // Obtém o email do usuário da store de autenticação (ou outro lugar onde o email esteja guardado)
      const authStore = useAuthStore();
      const userEmail = authStore.user?.email;

      // Dispara o evento "CompleteRegistration" com dados personalizados no Facebook Pixel
      if (typeof window !== 'undefined' && typeof fbq !== 'undefined' && userEmail) {
        fbq('track', 'CompleteRegistration', {
          email: userEmail
        });
      } else {
        console.warn('Facebook Pixel event tracking might not be set up correctly.');
      }

      // Carrega o TikTok Pixel e dispara o evento "CompleteRegistration"
  if (typeof window !== 'undefined') {
    !function(w, d, t) {
      w.TiktokAnalyticsObject=t;
      var ttq=w[t]=w[t]||[];
      ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"];
      ttq.setAndDefer=function(t,e){t[e]=function(){
          t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};
      for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);
      ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e};
      ttq.load=function(e,n){
          var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;
          ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};
          n=document.createElement("script");n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;
          e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};ttq.load('CSUITS3C77U7NIODBUL0');

      // Marca o evento "CompleteRegistration" no TikTok Pixel
      ttq.track('CompleteRegistration', {
        content_name: 'User Registration Completed',
        content_category: 'User Registration',
        content_ids: [userEmail] // Pode incluir o email ou outro identificador único
      });
    }(window, document, 'ttq');
  }

    }
  }
  </script>

  <style scoped>
  .registration-success {
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
