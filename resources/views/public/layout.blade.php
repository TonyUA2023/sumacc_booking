<!DOCTYPE html>
<html lang="es" class="scroll-smooth"> {{-- Idioma cambiado a Español --}}

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- SEO Esencial y Título --}}
    <title>SUMACC | Detallado Automotriz Profesional a Domicilio en Lima</title> {{-- Título optimizado --}}
    <meta name="description" content="SUMACC ofrece servicios expertos de detallado y lavado automotriz de alta calidad a domicilio en Lima, Perú. Transformamos tu vehículo con atención al detalle y productos premium." />
    <meta name="keywords" content="Detallado Automotriz Lima, Lavado de Autos a Domicilio, Limpieza de Vehiculos, Car Detailing Peru, SUMACC, Pulido de Autos, Protección Cerámica, Lavado de Lujo" />
    <meta name="author" content="SUMACC Auto Mobile Detailing" />
    <meta name="robots" content="index,follow" />
    <link rel="canonical" href="{{ url('/') }}" /> {{-- URL Canónica --}}

    {{-- Verificación Google y Analytics --}}
    <meta name="google-site-verification" content="Uz0FLA-2Da98lnyutgJL_-oyJL_SCQfd09Jq4eboAJA" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7B9M1NKRDG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-7B9M1NKRDG');
    </script>

    {{-- Open Graph / Facebook Meta Tags --}}
    <meta property="og:title" content="SUMACC | Detallado Automotriz de Lujo a Domicilio" />
    <meta property="og:description" content="Servicios premium de detallado automotriz que llegan a tu puerta. Calidad y perfección para tu vehículo en Lima." />
    <meta property="og:image" content="{{ asset('og-image.jpg') }}" /> {{-- Crea y sube una imagen og-image.jpg (1200x630px) a tu carpeta public --}}
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="SUMACC Mobile Detailing" />
    <meta propertyog:locale" content="es_PE" />


    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="SUMACC | Detallado Automotriz de Lujo a Domicilio" />
    <meta name="twitter:description" content="Servicios premium de detallado automotriz que llegan a tu puerta. Calidad y perfección para tu vehículo en Lima." />
    <meta name="twitter:image" content="{{ asset('twitter-card-image.jpg') }}" /> {{-- Crea y sube una imagen twitter-card-image.jpg (similar a OG image) --}}
    {{-- <meta name="twitter:site" content="@tuUsuarioTwitter"> --}}

    {{-- Favicon y Theme Color --}}
    <link rel="icon" href="{{ asset('logo/favicon.ico') }}" type="image/ico" />
    {{-- Considera añadir más favicons para compatibilidad: apple-touch-icon, etc. --}}
    <meta name="theme-color" content="#0F172A"> {{-- Un color oscuro de tu paleta (ej. slate-900) --}}

    {{-- Alpine.js --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    {{-- AOS CSS (Animaciones en Scroll) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-GY2DksJJ/Qh+VMG3ahYA4MKedbYGScBoqIlCShjWz+zXkQgcdwipb4ldz5l/nnP5u0mCJ6kx+16u9VIZoYQpZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Vite Assets (Tu CSS y JS principal) --}}
    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

    {{-- Estilos para animaciones personalizadas si es necesario --}}
    <style>
        .animate-custom-pulse {
            animation: custom-pulse 2s infinite cubic-bezier(0.4, 0, 0.6, 1);
        }

        @keyframes custom-pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        /* Si tienes animate-bounce-custom, defínelo aquí o en tu app.css */
        .animate-bounce-custom {
            animation: bounce-custom 1.5s infinite;
        }

        @keyframes bounce-custom {

            0%,
            100% {
                transform: translateY(-8%);
                animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
            }

            50% {
                transform: translateY(0);
                animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
            }
        }
    </style>
</head>

<body class="bg-black text-slate-300 font-['Lexend_Deca'] antialiased">

    @include('components.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('components.footer')

    {{-- Botones Flotantes de Acción (FABs) --}}
    <div class="fixed bottom-5 right-5 md:bottom-8 md:right-8 flex flex-col items-center space-y-4 z-[990]">

        {{-- WhatsApp --}}
        <div class="relative group" data-aos="fade-left" data-aos-delay="500" data-aos-offset="0">
            <a href="https://wa.link/gemzk6" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp"
                class="flex items-center justify-center p-3 bg-[#25D366] rounded-full shadow-xl hover:shadow-2xl hover:bg-green-500 transition-all duration-300 transform hover:scale-110 active:scale-95 animate-bounce-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-black focus:ring-green-400">
                <img src="{{ asset('SocialNetsIcon/whatssapp.png') }}" alt="WhatsApp" class="w-11 h-11">
            </a>
            <span class="absolute right-full top-1/2 -translate-y-1/2 mr-3 px-3 py-1.5 bg-slate-700 text-white text-xs font-semibold rounded-md shadow-lg 
                       opacity-0 group-hover:opacity-100 transition-all duration-200 ease-in-out whitespace-nowrap pointer-events-none 
                       hidden md:block"> {{-- Tooltip para escritorio --}}
                Chat on WhatsApp
            </span>
        </div>
        {{-- SMS --}}
        <div class="relative group" data-aos="fade-left" data-aos-delay="700" data-aos-offset="0">
            <a href="sms:+14258761729?body=I’m interested in getting a mobile detailing service for my vehicle. Could you provide more details on your services and pricing?" aria-label="Send SMS"
                class="flex items-center justify-center p-3 bg-orange-500 rounded-full shadow-xl hover:shadow-2xl hover:bg-orange-600 transition-all duration-300 transform hover:scale-110 active:scale-95 animate-bounce-custom"
                style="animation-delay: 0.3s;">
                <img src="{{ asset('SocialNetsIcon/sms.png') }}" alt="SMS" class="w-11 h-11">
            </a>
            <span class="absolute right-full top-1/2 -translate-y-1/2 mr-3 px-3 py-1.5 bg-slate-700 text-white text-xs font-semibold rounded-md shadow-lg 
                       opacity-0 group-hover:opacity-100 transition-all duration-200 ease-in-out whitespace-nowrap pointer-events-none 
                       hidden md:block"> {{-- Tooltip para escritorio --}}
                Send an SMS
            </span>
        </div>
    </div>
    {{-- AOS JS (Animaciones en Scroll) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-1K+0+UY4KmLzwuZUbN2hxTASJ7fplfGMlEO1vuzWc6gWdDxPkEo3pkw0V+G1PdIY0BiPOaXQJ6YBvdQ6K+H0JQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true, // Animar solo una vez
                duration: 700, // Duración un poco más corta para sensación de rapidez
                easing: 'ease-out-cubic', // Un easing más suave
                offset: 50, // Disparar animación un poco antes
            });
        });
    </script>

</body>

</html>