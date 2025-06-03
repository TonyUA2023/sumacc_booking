@extends('public.layout')

@section('content')

@endsection
<section
  id="hero-extra"
  class="relative h-screen w-full bg-black overflow-hidden"
  data-aos="fade-in"
  data-aos-duration="1000"
>
  <!-- ================================================
       1) Contenedor de tres paneles verticales inclinados
       Con un margen de 2cm a izquierda y derecha
       ================================================ -->
  <div class="absolute top-0 bottom-0 left-[2cm] right-[2cm] flex items-center justify-center space-x-4">
    <!-- Panel izquierdo (-6°) -->
    <div class="relative flex-1 max-w-xs overflow-hidden rounded-lg transform -rotate-6 shadow-3xl">
      <img
        src="{{ asset('why/imgRut.webp') }}"
        alt="Panel Izquierdo"
        class="w-full h-full object-cover"
      />
    </div>

    <!-- Panel central (0°) -->
    <div class="relative flex-1 max-w-xs overflow-hidden rounded-lg transform rotate-0 shadow-3xl">
      <img
        src="{{ asset('hero/bg-auto-hero.jpg') }}"
        alt="Panel Central"
        class="w-full h-full object-cover"
      />
    </div>

    <!-- Panel derecho (+6°) -->
    <div class="relative flex-1 max-w-xs overflow-hidden rounded-lg transform rotate-6 shadow-3xl">
      <img
        src="{{ asset('why/derecha.webp') }}"
        alt="Panel Derecho"
        class="w-full h-full object-cover"
      />
    </div>
  </div>

  <!-- ================================================
       2) Overlay oscuro con degradado para énfasis
       ================================================ -->
  <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-black opacity-80"></div>

  <!-- ================================================
       3) Contenedor de texto (centrado)
       ================================================ -->
  <div
    class="container mx-auto relative z-10 flex items-center justify-center h-full px-4"
    data-aos="fade-up"
    data-aos-delay="300"
  >
    <div class="bg-black bg-opacity-60 rounded-xl p-8 max-w-xl mx-auto text-center">
      <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight">
        Extra Services
      </h1>
      <p class="mt-4 text-lg md:text-xl text-slate-300">
        Discover our additional boat detailing and care services to keep your vessel in pristine condition.
        Professional, reliable, and delivered right to your dock.
      </p>
      <div class="mt-6">
        <a
          href="#services"
          class="inline-block px-6 py-3 bg-sky-500 text-white font-semibold uppercase rounded-lg shadow-lg
                 transform transition-all duration-300 ease-in-out
                 hover:bg-sky-600 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50"
          data-aos="zoom-in"
          data-aos-delay="500"
        >
          View Services
        </a>
      </div>
    </div>
  </div>
</section>



<section id="boat-cleaning" class="bg-slate-900 py-16">
  <div class="container mx-auto px-4 lg:px-8">
    <!-- Contenedor de dos columnas: imagen a la izquierda, contenido a la derecha -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
      <!-- Imagen Boat Cleaning -->
      <div class="w-full">
        <img
          src="{{ asset('why/horizontal.jpg') }}"
          alt="Boat Cleaning"
          class="rounded-lg shadow-xl  border-4 border-sky-500 max-w-md w-full h-65 object-cover"
        />
      </div>

      <!-- Contenido Boat Cleaning -->
      <div class="bg-slate-800 rounded-2xl shadow-2xl p-8">
        <!-- Etiqueta o subtítulo pequeño -->
        <p class="text-sm font-medium text-sky-400 uppercase tracking-wide mb-2">
          Premium Service
        </p>
        <!-- Título principal -->
        <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6">
          Boat Cleaning
        </h2>

        <!-- Lista de características con iconos resaltados -->
        <ul class="space-y-4 mb-8">
          <li class="flex items-start">
            <div class="flex-shrink-0">
              <div class="w-6 h-6 bg-sky-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 5 
                           11.586a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 
                           1 0 011.414 0z"
                        clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
            <p class="ml-3 text-slate-200 leading-relaxed">
              Complete exterior and interior cleaning to remove salt, grime, and other residues.
            </p>
          </li>
          <li class="flex items-start">
            <div class="flex-shrink-0">
              <div class="w-6 h-6 bg-sky-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 5 
                           11.586a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 
                           1 0 011.414 0z"
                        clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
            <p class="ml-3 text-slate-200 leading-relaxed">
              Specialized products for surface protection and enhancement.
            </p>
          </li>
          <li class="flex items-start">
            <div class="flex-shrink-0">
              <div class="w-6 h-6 bg-sky-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 5 
                           11.586a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 
                           1 0 011.414 0z"
                        clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
            <p class="ml-3 text-slate-200 leading-relaxed">
              Detailing of the hull and all surfaces for optimal condition and appearance.
            </p>
          </li>
        </ul>

        <!-- Precios dentro de un recuadro destacado -->
        <div class="bg-slate-700 rounded-lg p-6">
          <p class="text-sm text-sky-400 mb-2">Prices</p>
          <p class="text-2xl font-bold text-white">
            Starting at $199
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="carpet-cleaning" class="bg-slate-900 py-16">
  <div class="container mx-auto px-4 lg:px-8">
    <!-- Contenedor de dos columnas: contenido a la izquierda, imagen a la derecha -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
      <!-- Contenido Carpet Cleaning -->
      <div class="bg-slate-800 rounded-2xl shadow-2xl p-8">
        <!-- Subtítulo pequeño -->
        <p class="text-sm font-medium text-sky-400 uppercase tracking-wide mb-2">
          Premium Service
        </p>
        <!-- Título principal -->
        <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6">
          Carpet Cleaning
        </h2>

        <!-- Lista de características con iconos en círculo -->
        <ul class="space-y-4 mb-8">
          <li class="flex items-start">
            <div class="flex-shrink-0">
              <div class="w-6 h-6 bg-sky-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 5 
                           11.586a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 
                           1 0 011.414 0z"
                        clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
            <p class="ml-3 text-slate-200 leading-relaxed">
              Deep cleaning to remove stains, odors, and accumulated dust.
            </p>
          </li>
          <li class="flex items-start">
            <div class="flex-shrink-0">
              <div class="w-6 h-6 bg-sky-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 5 
                           11.586a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 
                           1 0 011.414 0z"
                        clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
            <p class="ml-3 text-slate-200 leading-relaxed">
              Advanced techniques to protect fibers and colors.
            </p>
          </li>
          <li class="flex items-start">
            <div class="flex-shrink-0">
              <div class="w-6 h-6 bg-sky-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 5 
                           11.586a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 
                           1 0 011.414 0z"
                        clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
            <p class="ml-3 text-slate-200 leading-relaxed">
              Eco-friendly and safe products for effective cleaning without damaging the material.
            </p>
          </li>
        </ul>

        <!-- Sección de precios dentro de un recuadro destacado -->
        <div class="bg-slate-700 rounded-lg p-6">
          <p class="text-sm text-sky-400 mb-2">Prices</p>
          <p class="text-2xl font-bold text-white">
            Starting at $99
          </p>
        </div>
      </div>

      <!-- Imagen Carpet Cleaning -->
      <div class="w-full">
        <img
          src="{{ asset('hero/bg-auto-hero.jpg') }}"
          alt="Carpet Cleaning"
          class="w-full rounded-lg shadow-xl object-cover border-4 border-sky-500"
        />
      </div>
    </div>
  </div>
</section>






