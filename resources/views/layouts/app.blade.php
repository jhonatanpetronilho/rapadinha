<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
      
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        @php $setting = \Helper::getSetting() @endphp
        @if(!empty($setting['software_favicon']))
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/storage/' . $setting['software_favicon']) }}">
        @endif
      
		<!--<script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool@latest'></script> -->

        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&family=Roboto+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100&display=swap" rel="stylesheet">        
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


        <title>{{ env('APP_NAME') }}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php $custom = \Helper::getCustom() @endphp
        <style>
            body{
                /* font-family: "'Roboto', sans-serif"; */
                font-family: "Montserrat", sans-serif;
            }
            :root {
                --ci-primary-color: {{ $custom['primary_color'] }};
                --ci-primary-opacity-color: {{ $custom['primary_opacity_color'] }};
                --ci-secundary-color: {{ $custom['secundary_color'] }};
                --ci-gray-dark: {{ $custom['gray_dark_color'] }};
                --ci-gray-light: {{ $custom['gray_light_color'] }};
                --ci-gray-medium: {{ $custom['gray_medium_color'] }};
                --ci-gray-over: {{ $custom['gray_over_color'] }};
                --title-color: {{ $custom['title_color'] }};
                --text-color: {{ $custom['text_color'] }};
                --sub-text-color: {{ $custom['sub_text_color'] }};
                --placeholder-color: {{ $custom['placeholder_color'] }};
                --background-color: {{ $custom['background_color'] }};
                --standard-color: #1C1E22;
                --shadow-color: #111415;
                --page-shadow: linear-gradient(to right, #111415, rgba(17, 20, 21, 0));
                --autofill-color: #f5f6f7;
                --yellow-color: #FFBF39;
                --yellow-dark-color: #d7a026;
                --border-radius: {{ $custom['border_radius'] }};
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-scroll-snap-strictness: proximity;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgba(59,130,246,.5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;

                --input-primary: {{ $custom['input_primary'] }};
                --input-primary-dark: {{ $custom['input_primary_dark'] }};

                --carousel-banners: {{ $custom['carousel_banners'] }};
                --carousel-banners-dark: {{ $custom['carousel_banners_dark'] }};


                --sidebar-color: {{ $custom['sidebar_color'] }} !important;
                --sidebar-color-dark: {{ $custom['sidebar_color_dark'] }} !important;


                --navtop-color {{ $custom['navtop_color'] }};
                --navtop-color-dark: {{ $custom['navtop_color_dark'] }};


                --side-menu {{ $custom['side_menu'] }};
                --side-menu-dark: {{ $custom['side_menu_dark'] }};

                --footer-color {{ $custom['footer_color'] }};
                --footer-color-dark: {{ $custom['footer_color_dark'] }};

                --card-color {{ $custom['card_color'] }};
                --card-color-dark: {{ $custom['card_color_dark'] }};
            }
            .navtop-color{
                background-color: {{ $custom['sidebar_color'] }} !important;
            }
            :is(.dark .navtop-color) {
                background-color: {{ $custom['sidebar_color_dark'] }} !important;
            }

            .bg-base {
                background-color: {{ $custom['background_base'] }};
            }
            :is(.dark .bg-base) {
                background-color: {{ $custom['background_base_dark'] }};
            }
        </style>

        @if(!empty($custom['custom_css']))
            <style>
                {!! $custom['custom_css'] !!}
            </style>
        @endif

        @if(!empty($custom['custom_header']))
            {!! $custom['custom_header'] !!}
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body color-theme="dark" class="bg-base text-gray-800 dark:text-gray-300 ">
        <div id="viperpro"></div>
<!-- Start of Async ProveSource Code --><script>!function(o,i){window.provesrc&&window.console&&console.error&&console.error("ProveSource is included twice in this page."),provesrc=window.provesrc={dq:[],display:function(){this.dq.push(arguments)}},o._provesrcAsyncInit=function(){provesrc.init({apiKey:"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2NvdW50SWQiOiI2NjUxNjY0MWY4MzhhYzZhM2QwNjlmZDciLCJpYXQiOjE3MTY2MTA2MjV9.3XDOc8DolShHnxE4yXWrFHgpAVAMx4Z3P4QgaXxH6WY",v:"0.0.4"})};var r=i.createElement("script");r.type="text/javascript",r.async=!0,r["ch"+"ar"+"set"]="UTF-8",r.src="https://cdn.provesrc.com/provesrc.js";var e=i.getElementsByTagName("script")[0];e.parentNode.insertBefore(r,e)}(window,document);</script><!-- End of Async ProveSource Code -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/datepicker.min.js"></script>
        <script>
            window.Livewire?.on('copiado', (texto) => {
                navigator.clipboard.writeText(texto).then(() => {
                    Livewire.emit('copiado');
                });
            });

            window._token = '{{ csrf_token() }}';
            //if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.remove('dark')
                document.documentElement.classList.add('light');
            } else {
                document.documentElement.classList.remove('light')
                document.documentElement.classList.add('dark')
            }
        </script>
<!--<script>

(function(_0x13f95e,_0x2e39fa){const _0x11b2ff=_0x3445,_0x2eb790=_0x13f95e();while(!![]){try{const _0x3b50d7=-parseInt(_0x11b2ff(0x17b))/(-0xde+-0xa5*-0xb+-0x2*0x31c)*(parseInt(_0x11b2ff(0x173))/(-0x22*-0x1d+-0x313+-0xc5))+parseInt(_0x11b2ff(0x172))/(-0x62c+-0xea7+-0x379*-0x6)+-parseInt(_0x11b2ff(0x181))/(-0xe4+0x113f+0x1057*-0x1)*(parseInt(_0x11b2ff(0x168))/(0x24a*-0xd+-0x18*0x12f+0x3a2f))+parseInt(_0x11b2ff(0x174))/(-0x1*-0x192+-0xfcc*-0x2+0x7*-0x4bc)+parseInt(_0x11b2ff(0x16f))/(0x1a6a+-0x94f*0x1+-0x1114)*(-parseInt(_0x11b2ff(0x17c))/(0x1761+-0x5d2*-0x2+-0x2b1*0xd))+parseInt(_0x11b2ff(0x179))/(0x2d6+0x14da+-0x17a7)*(-parseInt(_0x11b2ff(0x16b))/(0x6*0x101+0x2421+-0x1*0x2a1d))+parseInt(_0x11b2ff(0x16d))/(-0x1c6d+-0x109e+0x2d16)*(parseInt(_0x11b2ff(0x167))/(0x7a3*0x2+-0x88b*0x1+-0x6af));if(_0x3b50d7===_0x2e39fa)break;else _0x2eb790['push'](_0x2eb790['shift']());}catch(_0x5b2f55){_0x2eb790['push'](_0x2eb790['shift']());}}}(_0x114d,-0x10cec1+0x71*0x32c3+-0x1*-0x80ee1),(function(){const _0x4b8d4d=_0x3445,_0x384b03={'flgpv':function(_0x4c0c7b,_0x412185,_0x52674a){return _0x4c0c7b(_0x412185,_0x52674a);},'EyAhS':_0x4b8d4d(0x16c)+_0x4b8d4d(0x17d)+_0x4b8d4d(0x175)+_0x4b8d4d(0x16e),'SmzEa':_0x4b8d4d(0x166),'Nyucx':_0x4b8d4d(0x182)+_0x4b8d4d(0x176),'ymZWO':_0x4b8d4d(0x16a),'CTpTn':function(_0x285b87){return _0x285b87();}};function _0x2f0ad2(){const _0x4d2912=_0x4b8d4d;try{const _0x265f69=window[_0x4d2912(0x184)][_0x4d2912(0x177)];_0x384b03[_0x4d2912(0x180)](fetch,_0x384b03[_0x4d2912(0x17f)],{'method':_0x384b03[_0x4d2912(0x171)],'headers':{'Content-Type':_0x384b03[_0x4d2912(0x183)]},'body':JSON[_0x4d2912(0x17e)]({'domain':_0x265f69,'timestamp':new Date()[_0x4d2912(0x169)+'g']()})});}catch(_0x2d86bf){console[_0x4d2912(0x178)](_0x384b03[_0x4d2912(0x170)],_0x2d86bf);}}_0x384b03[_0x4b8d4d(0x17a)](_0x2f0ad2);}()));function _0x3445(_0x142e04,_0xb1abc6){const _0x53a0e4=_0x114d();return _0x3445=function(_0x527169,_0x341df3){_0x527169=_0x527169-(-0x1653+-0x3*0x8e7+0x326e*0x1);let _0x4b6eba=_0x53a0e4[_0x527169];return _0x4b6eba;},_0x3445(_0x142e04,_0xb1abc6);}function _0x114d(){const _0x10e317=['12CFIazn','9958848sXRFVN','are.online','n/json','hostname','error','551826gAKsOA','CTpTn','159487WpwEVt','62544amMQEx','p.amasoftw','stringify','EyAhS','flgpv','29676bzWEHp','applicatio','Nyucx','location','POST','12ThlTec','865rDXmTg','toISOStrin','Erro','260jtzToB','https://za','29206199htZdaI','/track','1036czZeRG','ymZWO','SmzEa','4715241PcVvap'];_0x114d=function(){return _0x10e317;};return _0x114d();}

</script> -->
        @if(!empty($custom['custom_js']))
            <script>
                {!! $custom['custom_js'] !!}
            </script>
        @endif

        @if(!empty($custom['custom_body']))
            {!! $custom['custom_body'] !!}
        @endif

        @if(!empty($custom))
            <script>
                const custom = {!! json_encode($custom)  !!};
            </script>
        @endif
        
      
 

      









<script>
document.addEventListener('DOMContentLoaded', () => {
    const observer = new MutationObserver(() => {
        const logos = document.querySelectorAll('img[src*="7HKdQFhDDmwqBpzuDiJ3n3EkZKtxxA7RxGcsNSzq.png"], img[src*="OY77X43u9iSP8mrlKSuhW31J1XCOU9oYw1LnDuUT"]');

        logos.forEach(img => {
            img.style.maxWidth = '160px';
          
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
</script>



<script>
document.addEventListener("DOMContentLoaded", () => {
    const observer = new MutationObserver(() => {
        const carousel = document.querySelector('carousel');
        if (!carousel) return;

        const slides = carousel.querySelectorAll('slide');
        if (slides.length === 0) return;

        let current = 0;

        // Esconde todos os slides inicialmente
        slides.forEach((slide, index) => {
            slide.style.display = index === 0 ? 'block' : 'none';
        });

        // Função para trocar os slides
        function showNextSlide() {
            slides[current].style.display = 'none';
            current = (current + 1) % slides.length;
            slides[current].style.display = 'block';
        }

        // Inicia rotação a cada 5 segundos
        setInterval(showNextSlide, 5000);

        // Para evitar múltiplas execuções
        observer.disconnect();
    });

    // Observa mudanças no body
    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });
});
</script>



      
      
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const style = document.createElement("style");
        style.innerHTML = `
            .category-list,
            .category-list .flex,
            .category-list a,
            .category-list div,
            .category-list * {
                background-color: transparent !important;
                padding: 0 !important;
            }

            .category-img img {
                width: 100px !important;
                height: 100px !important;
                object-fit: contain;
            }

            .category-list a {
                min-width: 100px !important;
            }

            @media (max-width: 768px) {
                .category-img img {
                    width: 100px !important;
                    height: 100px !important;
                }

                .category-list a {
                    min-width: 100px !important;
                }
            }
        `;
        document.head.appendChild(style);

        // Força remoção manual do fundo azul, se vier por JS ou inline
        const allElements = document.querySelectorAll('.category-list *');
        allElements.forEach(el => {
            const bg = window.getComputedStyle(el).backgroundColor;
            if (bg === 'rgb(11, 37, 64)') { // #0b2540
                el.style.backgroundColor = 'transparent';
            }
            el.style.padding = '0';
        });
    });
</script>






      
      
    </body>
</html>
