@extends('public.layout')

@section('content')
<section
  id="hero"
  class="relative h-screen bg-cover bg-center flex items-center justify-center"
  style="background-image: url('{{ asset('hero/bgHero.jpg') }}');"
  data-aos="fade-in" data-aos-duration="1000">

  <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-black opacity-85"></div>
  <div
    class="container mx-auto h-full relative z-10 flex flex-col lg:flex-row items-center justify-center lg:justify-between px-4 text-center lg:text-left"
    data-aos="fade-up" data-aos-delay="300">

    <div class="lg:w-1/2 xl:w-3/5 space-y-6 lg:pr-10">
      <h1
        class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-100 uppercase leading-tight tracking-tight"
        data-aos="fade-right" data-aos-delay="500">
        <span class="block">Premium Hand Wash</span>
        <span class="block">&amp; Detailing</span>
        <span class="block text-sky-400">Deliver Door To Door</span>
      </h1>
      <p
        class="mt-4 text-lg md:text-xl text-slate-300 max-w-lg mx-auto lg:mx-0"
        data-aos="fade-right" data-aos-delay="700">
        At Sumacc, we bring professional car care right to your home or office.
        Using advanced techniques and premium products, your vehicle will look
        stunning without you lifting a finger.
      </p>
      <div
        class="mt-8 flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4"
        data-aos="fade-right" data-aos-delay="900">
        <a
          href="/detailing"
          class="px-8 py-3 bg-sky-500 text-white font-semibold uppercase rounded-lg shadow-lg
                 transform transition-all duration-300 ease-in-out
                 hover:bg-sky-600 hover:scale-105 hover:shadow-sky-400/50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50"
          data-aos="zoom-in" data-aos-delay="1100">
          Book Online
        </a>
        <a
          href="#services"
          class="px-8 py-3 border-2 border-sky-500 text-sky-400 font-semibold uppercase rounded-lg shadow-md
                 transform transition-all duration-300 ease-in-out
                 hover:bg-sky-500 hover:text-slate-900 hover:scale-105 hover:shadow-sky-500/30 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50"
          data-aos="zoom-in" data-aos-delay="1300">
          Our Services
        </a>
      </div>
    </div>
  </div>
</section>

<section
  id="services"
  x-data="{ activeTab: 'repair' }"
  class="py-16 md:py-24 bg-black text-slate-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-100 uppercase" data-aos="fade-up" data-aos-duration="600">
        Explore Our <span class="text-sky-400">Services</span>
      </h2>
      <p class="mt-4 text-lg text-slate-400 max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
        Choose the perfect detailing package for your vehicle's needs.
      </p>
    </div>

    <nav class="flex flex-wrap justify-center space-x-2 sm:space-x-4 border-b border-slate-700 mb-10 md:mb-12" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
      <button
        @click="activeTab = 'repair'"
        :class="activeTab === 'repair' ? 'border-sky-500 text-sky-400' : 'border-transparent text-slate-400 hover:text-sky-400 hover:border-sky-600/50'"
        class="px-4 py-3 sm:px-6 sm:py-3 uppercase font-semibold transition-all duration-200 border-b-2 focus:outline-none">
        Premium Basic Wash
      </button>
      <button
        @click="activeTab = 'maintenance'"
        :class="activeTab === 'maintenance' ? 'border-sky-500 text-sky-400' : 'border-transparent text-slate-400 hover:text-sky-400 hover:border-sky-600/50'"
        class="px-4 py-3 sm:px-6 sm:py-3 uppercase font-semibold transition-all duration-200 border-b-2 focus:outline-none">
        Full Detail (Interior + Exterior)
      </button>
      <button
        @click="activeTab = 'detailing'"
        :class="activeTab === 'detailing' ? 'border-sky-500 text-sky-400' : 'border-transparent text-slate-400 hover:text-sky-400 hover:border-sky-600/50'"
        class="px-4 py-3 sm:px-6 sm:py-3 uppercase font-semibold transition-all duration-200 border-b-2 focus:outline-none">
        Deep Interior & Exterior
      </button>
      <button
        @click="activeTab = 'diagnostic'"
        :class="activeTab === 'diagnostic' ? 'border-sky-500 text-sky-400' : 'border-transparent text-slate-400 hover:text-sky-400 hover:border-sky-600/50'"
        class="px-4 py-3 sm:px-6 sm:py-3 uppercase font-semibold transition-all duration-200 border-b-2 focus:outline-none">
        Detail + Professional Polish
      </button>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 items-start gap-10 md:gap-16">
      <div class="w-full relative" data-aos="fade-right" data-aos-duration="700" data-aos-delay="300" data-aos-offset="200">
        <template x-if="activeTab === 'repair'">
          <div
            x-show="activeTab === 'repair'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200 absolute w-full"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="bg-gray-800 border border-gray-700 rounded-xl p-6 md:p-8 shadow-xl space-y-4 text-center lg:text-left">
            <h3 class="text-2xl md:text-3xl font-bold text-slate-100">Premium Basic Wash</h3>
            <p class="text-sky-400 font-semibold mb-4 text-lg">$175 &middot; <span class="text-slate-400">approx. 80 min</span></p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
              <div class="space-y-1 bg-gray-700 p-3 rounded-md">
                <p class="font-semibold text-slate-200">Inspection</p>
                <p class="text-slate-400">10 min</p>
              </div>
              <div class="space-y-1 bg-gray-700 p-3 rounded-md">
                <p class="font-semibold text-slate-200">Exterior Wash</p>
                <p class="text-slate-400">30 min</p>
              </div>
              <div class="space-y-1 bg-gray-700 p-3 rounded-md">
                <p class="font-semibold text-slate-200">Dry & Shine</p>
                <p class="text-slate-400">25 min</p>
              </div>
              <div class="space-y-1 bg-gray-700 p-3 rounded-md">
                <p class="font-semibold text-slate-200">Interior Detail</p>
                <p class="text-slate-400">15 min</p>
              </div>
            </div>
          </div>
        </template>

        <template x-if="activeTab === 'maintenance'">
          <div
            x-show="activeTab === 'maintenance'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200 absolute w-full"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="bg-gray-800 border border-gray-700 rounded-xl p-6 md:p-8 shadow-xl space-y-4 text-center lg:text-left">
            <h3 class="text-2xl md:text-3xl font-bold text-slate-100">Full Detail (Interior + Exterior)</h3>
            <p class="text-sky-400 font-semibold mb-4 text-lg">$280 &middot; <span class="text-slate-400">approx. 160 min</span></p>
            <ul class="space-y-2 text-sm text-slate-300">
              <li class="flex items-center bg-gray-700 p-3 rounded-md"><svg class="w-4 h-4 mr-2 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>Assessment (15 min)</li>
              <li class="flex items-center bg-gray-700 p-3 rounded-md"><svg class="w-4 h-4 mr-2 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>Deep Cleaning (45 min)</li>
              <li class="flex items-center bg-gray-700 p-3 rounded-md"><svg class="w-4 h-4 mr-2 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>Protection (60 min)</li>
              <li class="flex items-center bg-gray-700 p-3 rounded-md"><svg class="w-4 h-4 mr-2 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>Interior Detail (40 min)</li>
            </ul>
          </div>
        </template>

        <template x-if="activeTab === 'detailing'">
          <div
            x-show="activeTab === 'detailing'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200 absolute w-full"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="bg-gray-800 border border-gray-700 rounded-xl p-6 md:p-8 shadow-xl space-y-4 text-center lg:text-left">
            <h3 class="text-2xl md:text-3xl font-bold text-slate-100">Deep Interior & Exterior</h3>
            <p class="text-sky-400 font-semibold mb-4 text-lg">$320 &middot; <span class="text-slate-400">approx. 210 min</span></p>
            <ul class="space-y-2 text-sm text-slate-300">
              <li class="flex items-center bg-gray-700 p-3 rounded-md"><svg class="w-4 h-4 mr-2 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>Inspection (15 min)</li>
              <li class="flex items-center bg-gray-700 p-3 rounded-md"><svg class="w-4 h-4 mr-2 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>Decontamination (60 min)</li>
              <li class="flex items-center bg-gray-700 p-3 rounded-md"><svg class="w-4 h-4 mr-2 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>Treatment (75 min)</li>
              <li class="flex items-center bg-gray-700 p-3 rounded-md"><svg class="w-4 h-4 mr-2 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>Final Detail (60 min)</li>
            </ul>
          </div>
        </template>

        <template x-if="activeTab === 'diagnostic'">
          <div
            x-show="activeTab === 'diagnostic'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200 absolute w-full"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="bg-gray-800 border border-gray-700 rounded-xl p-6 md:p-8 shadow-xl space-y-4 text-center lg:text-left">
            <h3 class="text-2xl md:text-3xl font-bold text-slate-100"> Detail + Professional Polish</h3>
            <p class="text-sky-400 font-semibold mb-4 text-lg">$390 &middot; <span class="text-slate-400">approx. 240 min</span></p>
            <div class="space-y-2 text-sm">
              <p class="font-semibold text-slate-200 bg-gray-700 p-3 rounded-md">Polish (90 min)</p>
              <p class="font-semibold text-slate-200 bg-gray-700 p-3 rounded-md">Ceramic Coat (75 min)</p>
              <p class="font-semibold text-slate-200 bg-gray-700 p-3 rounded-md">Executive Detail (60 min)</p>
            </div>
          </div>
        </template>
      </div>

      <div class="w-full flex justify-center lg:justify-end relative min-h-[250px] md:min-h-[350px]" data-aos="fade-left" data-aos-duration="700" data-aos-delay="300" data-aos-offset="200">

        <template x-if="activeTab === 'repair'">
          <img
            x-show="activeTab === 'repair'"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200 absolute"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            src="{{ asset('why/basic.png') }}" alt="Premium Wash" class="rounded-lg shadow-xl shadow-sky-900/40 max-w-md w-full object-cover" />
        </template>
        <template x-if="activeTab === 'maintenance'">
          <img
            x-show="activeTab === 'maintenance'"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200 absolute"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            src="{{ asset('media/hero-maintenance.jpg') }}" alt="Mobile Detailing" class="rounded-lg shadow-xl shadow-sky-900/40 max-w-md w-full object-cover" />
        </template>
        <template x-if="activeTab === 'detailing'">
          <img
            x-show="activeTab === 'detailing'"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200 absolute"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            src="{{ asset('media/hero-detailing.jpg') }}" alt="Deep Cleaning" class="rounded-lg shadow-xl shadow-sky-900/40 max-w-md w-full object-cover" />
        </template>
        <template x-if="activeTab === 'diagnostic'">
          <img
            x-show="activeTab === 'diagnostic'"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200 absolute"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            src="{{ asset('media/hero-polish.jpg') }}" alt="Detail + Polish" class="rounded-lg shadow-xl shadow-sky-900/40 max-w-md w-full object-cover" />
        </template>
      </div>
    </div>
  </div>
</section>

<section id="company-presentation-video" class="bg-black text-slate-200 py-16 md:py-20">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10 md:mb-16 max-w-3xl mx-auto">
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-sky-400 mb-4" data-aos="fade-up">
        Discover Our Essence
      </h2>
      <p class="text-lg sm:text-xl text-slate-400 leading-relaxed" data-aos="fade-up" data-aos-delay="100">
        Take a moment to see what drives us at SUMACC. This is a glimpse into our passion for perfection and commitment to exceptional car care.
      </p>
    </div>
    <div class="w-full max-w-2xl lg:max-w-3xl xl:max-w-4xl mx-auto" data-aos="zoom-in-up" data-aos-delay="200" data-aos-duration="800">
      <div
        class="relative aspect-video rounded-xl lg:rounded-2xl overflow-hidden shadow-2xl shadow-sky-800/40 ring-1 ring-slate-700/50"
        x-data="{ playing: false }">
        <video
          x-ref="video"
          @click="if ($event.target === $refs.video) { playing ? $refs.video.pause() : $refs.video.play() }" {{-- Solo play/pausa si se hace clic en el video, no en los controles (si se muestran) --}}
          @play="playing = true"
          @pause="playing = false"
          :controls="playing"
          src="{{ asset('media/presentation.mp4') }}"
          poster="{{ asset('media/presentation_video.png') }}" {{-- SUGERENCIA: Añade un poster --}}
          class="w-full h-full object-cover cursor-pointer"
          preload="metadata" {{-- Para cargar metadatos como duración y dimensiones --}}>
          Your browser does not support the <code>video</code> element.
        </video>

        <button
          x-show="!playing"
          @click="$refs.video.play()"
          aria-label="Play video"
          class="absolute inset-0 flex items-center justify-center w-full h-full
                 text-sky-400/90 text-6xl sm:text-7xl md:text-8xl 
                 transition-all duration-300 ease-in-out
                 hover:text-sky-300 hover:bg-black/30 focus:outline-none group">
          <svg class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 transform transition-transform duration-300 group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.625 3.125A1.125 1.125 0 0 1 9 15.125V8.875c0-.87.988-1.406 1.65-.983l5.625 3.125Z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>
    <div class="text-center mt-10 md:mt-12" data-aos="fade-up" data-aos-delay="300">
      <a href="#contact" class="inline-block px-8 py-3 bg-sky-500 text-white text-sm font-semibold uppercase rounded-lg shadow-lg shadow-sky-500/30
                                transform transition-all duration-300 ease-in-out
                                hover:bg-sky-600 hover:scale-105 active:scale-95">
        Contact Us For Details
      </a>
    </div>

  </div>
</section>

<section id="customer-reviews" class="bg-black text-slate-200 py-16 md:py-20 border-t border-slate-800" x-data="{ current: 0, reviews: 5 }" x-init="setInterval(() => { current = (current + 1) % reviews }, 7000)">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-4xl sm:text-5xl font-bold text-sky-400" data-aos="fade-up">
        What Our Clients Say
      </h2>
      <p class="mt-4 text-lg text-slate-400 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
        We take pride in providing exceptional service. Here's what some of our happy customers have to say about SUMACC.
      </p>
    </div>

    <div class="relative overflow-hidden">
      <div class="flex transition-transform duration-700 ease-in-out"
        :style="'transform: translateX(-' + (current * 100) + '%)'"
        style="width: 500%">
        <!-- Review Slide -->
        <template x-for="(review, index) in [
          {
            name: 'Marrisa Mora',
            date: '2 Weeks Ago',
            text: 'My Rav4 had needed a deep clean since I moved to Seattle six months ago. I found Sumacc this morning and reached out to ask about pricing and availability. Super happy I did!'
          },
          {
            name: 'Yung Thach',
            date: '1 Month Ago',
            text: 'I contacted Sumacc on WhatsApp and got a fast reply. He came the same day and did a great job. I just needed one area cleaned where my cat had an accident. No more smell!'
          },
          {
            name: 'Rietta S',
            date: '3 Days Ago',
            text: 'Got my car fully detailed today and it looks amazing. It was a big job and he was very thorough. He arrived on time and I’ve already scheduled our second vehicle for Friday!'
          },
          {
            name: 'H',
            date: '1 Week Ago',
            text: 'Great service! Second time I used them to hand wash my car interior and exterior (first time to get rid of vomit smell as well)... They came to my place on time and they finished in 2 hrs. Car looks and smells great both times.'
          },
          {
            name: 'Lindsay S',
            date: '1 Day Ago',
            text: 'Got me in same day. They did an excellent job restoring my car to a like-new condition despite the many crumbs and spills left by my kids.'
          }
        ]" :key="index">
          <div class="min-w-full px-4">
            <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 flex flex-col h-full">
              <div class="mb-4">
                <h5 class="font-semibold text-slate-100" x-text="review.name"></h5>
                <p class="text-xs text-slate-500" x-text="review.date"></p>
              </div>
              <div class="flex items-center mb-3">
                <template x-for="i in 5">
                  <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                </template>
              </div>
              <p class="text-slate-300 leading-relaxed text-sm flex-grow" x-text="review.text"></p>
            </div>
          </div>
        </template>
      </div>
    </div>

    <!-- Carousel Dots -->
    <div class="flex justify-center gap-2 mt-6">
      <template x-for="(dot, i) in reviews" :key="i">
        <button @click="current = i"
          class="w-3 h-3 rounded-full"
          :class="current === i ? 'bg-sky-400' : 'bg-slate-600'"></button>
      </template>
    </div>

    <div class="text-center mt-12 md:mt-16" data-aos="fade-up" data-aos-delay="500">
      <a href="https://g.co/kgs/NJo3rQr" target="_blank" rel="noopener noreferrer"
        class="inline-block px-8 py-3.5 bg-transparent border-2 border-sky-500 text-sky-400 text-sm font-semibold uppercase rounded-lg
                transform transition-all duration-300 ease-in-out
                hover:bg-sky-500 hover:text-black hover:shadow-lg hover:shadow-sky-500/30 active:scale-95">
        Read More Reviews on Google
      </a>
    </div>
  </div>
</section>


<section id="brands" class="bg-black py-16 md:py-20">
  <div class="container mx-auto px-4">
    <div class="text-center mb-10 md:mb-12">
      <h3 class="text-3xl sm:text-4xl font-semibold text-sky-400 mb-4" data-aos="fade-up" data-aos-duration="600">
        WE WORK WITH ALL BRANDS
      </h3>
      <p class="text-slate-400 text-lg max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
        From classic rides to modern marvels, we service a diverse range of automotive brands with expertise.
      </p>
    </div>

    <div
      class="relative marquee-container overflow-hidden"
      data-aos="fade-up"
      data-aos-duration="600"
      data-aos-delay="200">
      <div class="flex animate-scroll whitespace-nowrap gap-6">
        @php $brands = ['ford', 'genesis', 'lambo', 'mustang', 'tesla', 'toyota', 'wolsbagen']; @endphp

        @foreach (array_merge($brands, $brands) as $brand)
        <div class="inline-flex items-center justify-center flex-shrink-0 px-4">
          <div class="bg-white/10 border border-white/20 rounded-xl p-4 backdrop-blur-md shadow-md hover:shadow-sky-500/30 transition-all duration-300 ease-in-out">
            <img
              src="{{ asset("marcaAutos/{$brand}.png") }}"
              alt="{{ ucfirst($brand) }}"
              class="h-12 sm:h-14 md:h-16 filter opacity-80 hover:grayscale-0 hover:opacity-100 transform hover:scale-110 transition duration-300 ease-in-out" />
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>


<style>
  .marquee-container {
    -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
    mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
  }

  .animate-scroll {
    /* Ajusta la duración de la animación según la cantidad de logos y el ancho total */
    /* Por ejemplo, si tienes 9 logos + espaciado, y cada uno ocupa ~150px, total ~1350px.
       Una duración de 40s podría ser adecuada. */
    animation: scroll 40s linear infinite;
  }

  @keyframes scroll {
    0% {
      transform: translateX(0);
    }

    100% {
      /* Se mueve el 50% porque tienes dos conjuntos de logos idénticos */
      transform: translateX(-50%);
    }
  }

  /* Opcional: Pausar en hover */
  .marquee-container:hover .animate-scroll {
    animation-play-state: paused;
  }
</style>

<section id="about" class="bg-black text-slate-200 py-16 md:py-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-12 xl:px-8 flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

    <div class="lg:w-1/2 space-y-6 text-center lg:text-left" data-aos="fade-right" data-aos-duration="800">
      <h2 class="text-4xl sm:text-5xl font-bold text-sky-400">About Us</h2>
      <p class="text-lg text-slate-300 font-semibold">
        At <span class="text-slate-100 font-bold">SUMACC</span>, we offer more than just car washing. We focus on perfection and detail.
      </p>
      <p class="text-slate-400 leading-relaxed">
        We take pride in transforming every car that comes to us. Your vehicle is an extension of you, so we ensure it receives meticulous care. We use high-quality products for an exceptional clean and shine that lasts.
      </p>
    </div>

    <div class="lg:w-1/2" data-aos="fade-left" data-aos-duration="800" data-aos-delay="150">
      <img
        src="{{ asset('media/about.jpg') }}"
        alt="Technician detailing a vehicle"
        class="rounded-2xl shadow-2xl shadow-sky-900/30 w-full h-auto object-cover aspect-video lg:aspect-auto" />
    </div>
  </div>
</section>

<section id="why-us" class="bg-black text-slate-200 py-16 md:py-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-12 xl:px-8 flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-16">

    <div class="lg:w-1/2" data-aos="fade-right" data-aos-duration="800">
      <img
        src="{{ asset('intern/limpiadoInterior.jpg') }}"
        alt="On-site mobile detailing"
        class="w-full rounded-2xl shadow-2xl shadow-sky-900/30 h-auto object-cover aspect-video lg:aspect-auto" />
    </div>

    <div class="lg:w-1/2 space-y-6 text-center lg:text-left" data-aos="fade-left" data-aos-duration="800" data-aos-delay="150">
      <h2 class="text-4xl sm:text-5xl font-bold text-sky-400">
        We Make Mobile Detailing More Convenient
      </h2>
      <p class="text-slate-400 leading-relaxed">
        Our expert team brings premium hand wash and deep-clean services right to your driveway or office.
        Enjoy a flawless finish without ever leaving your home, saving you time and hassle.
      </p>

      <div class="grid grid-cols-2 gap-6 sm:gap-8 pt-4" data-aos="fade-up" data-aos-delay="300">
        <div class="text-center space-y-2 p-4 bg-gray-900/50 rounded-lg" data-aos="fade-up" data-aos-delay="400">
          <p class="text-5xl font-extrabold text-slate-100">1K+</p>
          <div class="h-1 w-16 bg-sky-500 mx-auto rounded-full"></div>
          <p class="text-slate-400 text-sm font-medium">Satisfied Customers</p>
        </div>
        <div class="text-center space-y-2 p-4 bg-gray-900/50 rounded-lg" data-aos="fade-up" data-aos-delay="500">
          <p class="text-5xl font-extrabold text-slate-100">3+</p>
          <div class="h-1 w-16 bg-sky-500 mx-auto rounded-full"></div>
          <p class="text-slate-400 text-sm font-medium">Years of Experience</p>
        </div>
      </div>
    </div>

  </div>
</section>


<section id="services" x-data="{
    activeTab: 'wheels',
    showVideoModal: false,
    currentVideoUrl: '',
    playModalVideo() {
        this.showVideoModal = true;
        this.$nextTick(() => {
            if (this.$refs.modalPlayer) { // Asegurarse que modalPlayer existe
                this.$refs.modalPlayer.src = this.currentVideoUrl;
                this.$refs.modalPlayer.load();
                this.$refs.modalPlayer.play();
            }
        });
    },
    closeVideoModal() {
        this.showVideoModal = false;
        if (this.$refs.modalPlayer) {
            this.$refs.modalPlayer.pause();
            this.$refs.modalPlayer.src = ''; 
        }
    }
}" @keydown.escape.window="closeVideoModal()" class="bg-black text-slate-200 py-16 md:py-20"> {{-- Eliminado min-h-screen --}}
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-4xl sm:text-5xl font-bold text-sky-400 mb-3" data-aos="fade-up">OUR SERVICES</h2>
      <p class="text-xl sm:text-2xl text-slate-300 mb-4" data-aos="fade-up" data-aos-delay="100">Browse our range of professional detailing services.</p>
      <p class="text-md sm:text-lg text-slate-500" data-aos="fade-up" data-aos-delay="200">Select a category to see examples of our meticulous work.</p>
    </div>

    <div class="flex justify-center flex-wrap gap-3 sm:gap-4 mb-12 md:mb-16" data-aos="fade-up" data-aos-delay="300">
      <button @click="activeTab = 'wheels'" :class="activeTab === 'wheels' ? 'bg-sky-500 text-white scale-105 shadow-lg shadow-sky-500/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-sky-300'" class="px-5 py-2.5 sm:px-6 sm:py-3 rounded-full font-semibold transition-all duration-200 ease-in-out text-sm sm:text-base">
        Wheels
      </button>
      <button @click="activeTab = 'interior'" :class="activeTab === 'interior' ? 'bg-sky-500 text-white scale-105 shadow-lg shadow-sky-500/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-sky-300'" class="px-5 py-2.5 sm:px-6 sm:py-3 rounded-full font-semibold transition-all duration-200 ease-in-out text-sm sm:text-base">
        Interior Cleaning
      </button>
      <button @click="activeTab = 'exterior'" :class="activeTab === 'exterior' ? 'bg-sky-500 text-white scale-105 shadow-lg shadow-sky-500/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-sky-300'" class="px-5 py-2.5 sm:px-6 sm:py-3 rounded-full font-semibold transition-all duration-200 ease-in-out text-sm sm:text-base">
        Exterior Cleaning
      </button>
      <button @click="activeTab = 'shampoo'" :class="activeTab === 'shampoo' ? 'bg-sky-500 text-white scale-105 shadow-lg shadow-sky-500/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-sky-300'" class="px-5 py-2.5 sm:px-6 sm:py-3 rounded-full font-semibold transition-all duration-200 ease-in-out text-sm sm:text-base">
        Full Shampoo
      </button>
      <button @click="activeTab = 'opendoors'" :class="activeTab === 'opendoors' ? 'bg-sky-500 text-white scale-105 shadow-lg shadow-sky-500/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-sky-300'" class="px-5 py-2.5 sm:px-6 sm:py-3 rounded-full font-semibold transition-all duration-200 ease-in-out text-sm sm:text-base">
        Open Doors
      </button>
    </div>

    <div class="relative">
      {{-- Contenedor para mantener altura durante transiciones, altura reducida --}}
      <div class="min-h-[360px] md:min-h-[450px] xl:min-h-[480px]"> 
        <div x-show="activeTab === 'wheels'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300 absolute inset-0" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 grid-flow-row-dense">
          <div @click="currentVideoUrl = '{{ asset('extern/weels/weels.mp4') }}'; playModalVideo()" class="col-span-2 row-span-2 relative rounded-xl overflow-hidden cursor-pointer group aspect-[16/10] shadow-lg" data-aos="zoom-in-up" data-aos-delay="100">
            <img src="{{ asset('media/presentation_video.png') }}" alt="Wheels Detailing Main Video" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
              <svg class="w-16 h-16 text-sky-300 group-hover:text-sky-200 transform group-hover:scale-110 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.625 3.125A1.125 1.125 0 0 1 9 15.125V8.875c0-.87.988-1.406 1.65-.983l5.625 3.125Z" />
              </svg>
            </div>
          </div>
          <img src="{{ asset('extern/weels/lambollanta.jpg') }}" alt="Lamborghini Wheel" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="200">
          <img src="{{ asset('extern/weels/lambofrenos.jpg') }}" alt="Lamborghini Brakes" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="300">
          <img src="{{ asset('extern/weels/llantas.jpg') }}" alt="Clean Tires" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="400">
          <img src="{{ asset('extern/weels/bmwllantas.jpg') }}" alt="BMW Wheels" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="500">
        </div>

        <div x-show="activeTab === 'interior'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300 absolute inset-0" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 grid-flow-row-dense">
          <div @click="currentVideoUrl = '{{ asset('Intern/video/aspirado.mp4') }}'; playModalVideo()" class="col-span-2 row-span-2 relative rounded-xl overflow-hidden cursor-pointer group aspect-[16/10] shadow-lg" data-aos="zoom-in-up" data-aos-delay="100">
            <img src="{{ asset('media/presentation_video.png') }}" alt="Interior Vacuuming Main Video" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
              <svg class="w-16 h-16 text-sky-300 group-hover:text-sky-200 transform group-hover:scale-110 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.625 3.125A1.125 1.125 0 0 1 9 15.125V8.875c0-.87.988-1.406 1.65-.983l5.625 3.125Z" />
              </svg>
            </div>
          </div>
          <div @click="currentVideoUrl = '{{ asset('Intern/video/limpiezainterior.mp4') }}'; playModalVideo()" class="relative rounded-xl overflow-hidden cursor-pointer group aspect-square shadow-md" data-aos="zoom-in-up" data-aos-delay="200">
            <img src="{{ asset('media/presentation_video.png') }}" alt="Interior Cleaning Sub Video" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
              <svg class="w-12 h-12 text-sky-300 group-hover:text-sky-200 transform group-hover:scale-110 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.625 3.125A1.125 1.125 0 0 1 9 15.125V8.875c0-.87.988-1.406 1.65-.983l5.625 3.125Z" />
              </svg>
            </div>
          </div>
          <img src="{{ asset('Intern/limpiadoInterior.jpg') }}" alt="Cleaned Interior" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="300">
          <img src="{{ asset('Intern/imgInterior.jpg') }}" alt="Detailed Interior Component" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="400">
          <img src="{{ asset('Intern/toyotaInterno.jpg') }}" alt="Toyota Interior" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="500">
        </div>

        <div x-show="activeTab === 'exterior'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300 absolute inset-0" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 grid-flow-row-dense">
            <div @click="currentVideoUrl = '{{ asset('extern/camioneta-enjuague.mp4') }}'; playModalVideo()" class="col-span-2 row-span-2 relative rounded-xl overflow-hidden cursor-pointer group aspect-[16/10] shadow-lg" data-aos="zoom-in-up" data-aos-delay="100">
                <img src="{{ asset('media/presentation_video.png') }}" alt="Exterior Rinsing Main Video" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                   <svg class="w-16 h-16 text-sky-300 group-hover:text-sky-200 transform group-hover:scale-110 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.625 3.125A1.125 1.125 0 0 1 9 15.125V8.875c0-.87.988-1.406 1.65-.983l5.625 3.125Z" /></svg>
                </div>
            </div>
            <img src="{{ asset('extern/lambofin.png') }}" alt="Finished Lamborghini" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="200">
            <img src="{{ asset('extern/bmwfin.png') }}" alt="Finished BMW" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="300">
            <img src="{{ asset('extern/deporivfin.png') }}" alt="Finished Sports Car" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="400">
            <img src="{{ asset('extern/mercedesfin.png') }}" alt="Finished Mercedes" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="500">
        </div>

        <div x-show="activeTab === 'shampoo'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300 absolute inset-0" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 grid-flow-row-dense">
             <div @click="currentVideoUrl = '{{ asset('extern/tesla-lavado.mp4') }}'; playModalVideo()" class="col-span-2 row-span-2 relative rounded-xl overflow-hidden cursor-pointer group aspect-[16/10] shadow-lg" data-aos="zoom-in-up" data-aos-delay="100">
                <img src="{{ asset('media/presentation_video.png') }}" alt="Tesla Washing Main Video" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                   <svg class="w-16 h-16 text-sky-300 group-hover:text-sky-200 transform group-hover:scale-110 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.625 3.125A1.125 1.125 0 0 1 9 15.125V8.875c0-.87.988-1.406 1.65-.983l5.625 3.125Z" /></svg>
                </div>
            </div>
            <img src="{{ asset('during/jeepsinbg.png') }}" alt="Jeep During Shampoo" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="200">
            <img src="{{ asset('during/fullshampoo.png') }}" alt="Full Shampoo Process" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="300">
            <img src="{{ asset('during/autoFullshampoo.png') }}" alt="Car Full Shampoo" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="400">
            <img src="{{ asset('during/shampopersona.png') }}" alt="Technician Shampooing" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="500">
        </div>

        <div x-show="activeTab === 'opendoors'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300 absolute inset-0" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 grid-flow-row-dense">
            <img src="{{ asset('openDoor/opendoor1.jpg') }}" alt="Open Door View 1" class="col-span-2 md:col-span-1 rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="100">
            <img src="{{ asset('openDoor/porcheopen.jpg') }}" alt="Porsche Open Doors" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="200">
            <img src="{{ asset('openDoor/lamboopendoor.jpg') }}" alt="Lamborghini Open Doors" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="300">
            <img src="{{ asset('openDoor/toyoyaopen.jpg') }}" alt="Toyota Open Doors" class="rounded-xl object-cover w-full aspect-square shadow-md group hover:scale-105 transition-transform duration-300" data-aos="zoom-in-up" data-aos-delay="400">
        </div>
      </div>
    </div>
  </div>

  {{-- Video Modal --}}
  <div x-show="showVideoModal" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/85 backdrop-blur-md flex items-center justify-center z-[9999] p-4" @click="closeVideoModal()">
    <div class="bg-slate-900/70 p-1.5 sm:p-2 rounded-xl shadow-2xl w-full max-w-xl lg:max-w-3xl xl:max-w-4xl border border-slate-700/80" @click.stop>
      <div class="relative aspect-video">
        <video x-ref="modalPlayer" src="" controls class="w-full h-full rounded-lg" playsinline></video>
        <button @click="closeVideoModal()" aria-label="Close video player" class="absolute -top-3.5 -right-3.5 sm:top-1.5 sm:right-1.5 md:-top-2 md:-right-2 text-slate-300 bg-slate-800 rounded-full p-1.5 hover:text-sky-400 focus:outline-none z-10 transition-all duration-200 hover:bg-slate-700">
          <svg class="w-6 h-6 sm:w-7 sm:h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</section>

<section id="Case" class="bg-black text-slate-200 py-16 md:py-20">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 md:mb-16">
      <h3 class="text-4xl sm:text-5xl font-black text-sky-400" data-aos="fade-up">OUR WORKS</h3>
      <div class="w-20 h-1.5 bg-sky-500 mx-auto mt-4 mb-6 rounded-full" data-aos="fade-up" data-aos-delay="100"></div>
      <p class="text-lg text-slate-400 max-w-xl mx-auto" data-aos="fade-up" data-aos-delay="200">
        Witness the stunning transformations we deliver. Hover over images to see the magic.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 xl:gap-10">

      {{-- Caso de Estudio 1: Piso --}}
      <div x-data="{ isAfter: false }" @mouseenter="isAfter = true" @mouseleave="isAfter = false"
        class="relative aspect-[4/3] rounded-xl overflow-hidden shadow-2xl shadow-sky-900/20 group cursor-pointer ring-1 ring-slate-700/50 hover:ring-sky-500/70 transition-shadow"
        data-aos="fade-up" data-aos-anchor-placement="top-bottom">

        <img src="{{ asset('after-before/beforePiso.jpg') }}" alt="Floor Before"
          class="w-full h-full object-cover transition-all duration-700 ease-in-out origin-center"
          :class="{ 'opacity-0 scale-105 blur-sm': isAfter, 'opacity-100 scale-100 blur-none': !isAfter }">

        <img src="{{ asset('after-before/afterPiso3.jpg') }}" alt="Floor After" {{-- Usando afterPiso3.jpg como ejemplo de 'after' --}}
          class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-in-out origin-center"
          :class="{ 'opacity-100 scale-105 blur-none': isAfter, 'opacity-0 scale-100 blur-sm': !isAfter }">

        <div class="absolute inset-0 p-5 flex flex-col justify-end bg-gradient-to-t from-black/80 via-black/30 to-transparent">
          <h4 class="text-xl font-semibold text-white mb-1 flex items-center">
            Interior Floor Revitalization
            <span class="text-xs px-2.5 py-1 rounded-full ml-3 font-bold transition-all duration-300 ease-in-out"
              :class="isAfter ? 'bg-sky-400 text-slate-900 shadow-md' : 'bg-slate-100 text-slate-700'"
              x-text="isAfter ? 'TRANSFORMED' : 'BEFORE'">
            </span>
          </h4>
          <p x-show="isAfter" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="text-sm text-sky-200">Grime and wear vanished, revealing a pristine floor.</p>
        </div>
      </div>

      {{-- Caso de Estudio 2: Exterior Frontal --}}
      <div x-data="{ isAfter: false }" @mouseenter="isAfter = true" @mouseleave="isAfter = false"
        class="relative aspect-[4/3] rounded-xl overflow-hidden shadow-2xl shadow-sky-900/20 group cursor-pointer ring-1 ring-slate-700/50 hover:ring-sky-500/70 transition-shadow"
        data-aos="fade-up" data-aos-delay="150" data-aos-anchor-placement="top-bottom">

        <img src="{{ asset('after-before/beforeExtern.jpg') }}" alt="Exterior Front Before"
          class="w-full h-full object-cover transition-all duration-700 ease-in-out origin-center"
          :class="{ 'opacity-0 scale-105 blur-sm': isAfter, 'opacity-100 scale-100 blur-none': !isAfter }">

        <img src="{{ asset('after-before/frontAfter.jpg') }}" alt="Exterior Front After"
          class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-in-out origin-center"
          :class="{ 'opacity-100 scale-105 blur-none': isAfter, 'opacity-0 scale-100 blur-sm': !isAfter }">

        <div class="absolute inset-0 p-5 flex flex-col justify-end bg-gradient-to-t from-black/80 via-black/30 to-transparent">
          <h4 class="text-xl font-semibold text-white mb-1 flex items-center">
            Frontal Shine Restoration
            <span class="text-xs px-2.5 py-1 rounded-full ml-3 font-bold transition-all duration-300 ease-in-out"
              :class="isAfter ? 'bg-sky-400 text-slate-900 shadow-md' : 'bg-slate-100 text-slate-700'"
              x-text="isAfter ? 'GLEAMING' : 'BEFORE'">
            </span>
          </h4>
          <p x-show="isAfter" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="text-sm text-sky-200">Deep gloss and clarity restored to the paintwork.</p>
        </div>
      </div>

      {{-- Caso de Estudio 3: Cabina --}}
      <div x-data="{ isAfter: false }" @mouseenter="isAfter = true" @mouseleave="isAfter = false"
        class="relative aspect-[4/3] rounded-xl overflow-hidden shadow-2xl shadow-sky-900/20 group cursor-pointer ring-1 ring-slate-700/50 hover:ring-sky-500/70 transition-shadow"
        data-aos="fade-up" data-aos-delay="300" data-aos-anchor-placement="top-bottom">

        {{-- Asumimos que tienes una imagen 'before' para la cabina, ej: 'beforeCabin.jpg' --}}
        <img src="{{ asset('after-before/beforePiso2.jpg') }}" alt="Cabin Before" {{-- Reemplaza con beforeCabin.jpg si la tienes --}}
          class="w-full h-full object-cover transition-all duration-700 ease-in-out origin-center"
          :class="{ 'opacity-0 scale-105 blur-sm': isAfter, 'opacity-100 scale-100 blur-none': !isAfter }">

        <img src="{{ asset('after-before/cabinAfter.jpg') }}" alt="Cabin After"
          class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-in-out origin-center"
          :class="{ 'opacity-100 scale-105 blur-none': isAfter, 'opacity-0 scale-100 blur-sm': !isAfter }">

        <div class="absolute inset-0 p-5 flex flex-col justify-end bg-gradient-to-t from-black/80 via-black/30 to-transparent">
          <h4 class="text-xl font-semibold text-white mb-1 flex items-center">
            Cabin Detailing
            <span class="text-xs px-2.5 py-1 rounded-full ml-3 font-bold transition-all duration-300 ease-in-out"
              :class="isAfter ? 'bg-sky-400 text-slate-900 shadow-md' : 'bg-slate-100 text-slate-700'"
              x-text="isAfter ? 'IMPECCABLE' : 'BEFORE'">
            </span>
          </h4>
          <p x-show="isAfter" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="text-sm text-sky-200">Every nook and cranny cleaned to perfection.</p>
        </div>
      </div>

      {{-- Puedes añadir más Casos de Estudio aquí siguiendo el mismo patrón --}}

    </div>

    {{-- Call to Action --}}
    <div class="text-center mt-16 md:mt-20" data-aos="fade-up" data-aos-delay="300">
      <a href="/detailing" {{-- O tu ruta de reserva --}}
        class="inline-block px-10 py-4 bg-sky-500 text-white font-semibold uppercase rounded-lg shadow-lg shadow-sky-500/40
                  transform transition-all duration-300 ease-in-out
                  hover:bg-sky-600 hover:scale-105 hover:shadow-sky-400/60 active:scale-95
                  focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-black text-base sm:text-lg">
        Book Your Transformation
      </a>
      <p class="mt-5 text-slate-400">Ready to see your vehicle shine like new? <br class="sm:hidden">Contact us today!</p>
    </div>

  </div>
</section>

<section id="pricing" class="bg-black text-slate-200 py-16 md:py-20">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-4xl sm:text-5xl font-bold text-sky-400" data-aos="fade-up">
        Our Detailing Packages
      </h2>
      <p class="mt-4 text-lg text-slate-400 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
        Choose the perfect plan for your vehicle. Quality and shine, guaranteed.
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 xl:gap-10">
      <!-- Package 1 -->
      <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 md:p-8 flex flex-col" data-aos="fade-up" data-aos-delay="200">
        <div class="flex-grow">
          <h3 class="text-3xl font-bold text-sky-400 mb-2">Premium Basic Wash</h3>
          <p class="font-bold text-sky-300 mb-4">Starting From $175</p>

          <ul class="space-y-2 text-slate-300 pl-1 mb-6">
            <li>Exterior hand wash</li>
            <li>General interior vacuuming</li>
            <li>Glass, dashboard, and door cleaning</li>
          </ul>

          <p class="text-slate-400 text-sm mb-4">
            Ideal for keeping your car clean and presentable every week.
          </p>
          <p class="text-slate-400 text-sm mb-6">
            Perfect for cars in good condition that only need basic maintenance.
          </p>

          <div>
            <h4 class="text-lg font-semibold text-slate-100 mb-3 border-t border-slate-700 pt-4">
              Prices Starting At:
            </h4>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between items-center bg-slate-700/50 px-3 py-1.5 rounded-md">
                <span>Sedan</span>
                <span class="font-semibold text-sky-300">$175</span>
              </div>
              <div class="flex justify-between items-center px-3 py-1.5 rounded-md">
                <span>SUV</span>
                <span class="font-semibold text-sky-300">$195</span>
              </div>
              <div class="flex justify-between items-center bg-slate-700/50 px-3 py-1.5 rounded-md">
                <span>Full Size Truck/Van</span>
                <span class="font-semibold text-sky-300">$215</span>
              </div>
              <div class="flex justify-between items-center px-3 py-1.5 rounded-md">
                <span>XL/Elevated Vehicle</span>
                <span class="font-semibold text-sky-300">$235</span>
              </div>
            </div>
          </div>
        </div>
        <a href="#book" class="mt-8 w-full text-center inline-block bg-sky-500 text-white uppercase font-bold rounded-lg px-6 py-3.5 hover:bg-sky-600 active:scale-95 transition-all duration-200 shadow-lg shadow-sky-500/30">
          Schedule Now
        </a>
      </div>

      <!-- Package 2 -->
      <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 md:p-8 flex flex-col" data-aos="fade-up" data-aos-delay="300">
        <div class="flex-grow">
          <h3 class="text-3xl font-bold text-sky-400 mb-2">Full Detail (Interior + Exterior)</h3>
          <p class="font-bold text-sky-300 mb-4">Starting From $280</p>

          <ul class="space-y-2 text-slate-300 pl-1 mb-6">
            <li>Hand wash with premium shampoo</li>
            <li>Pressure washer cleaning</li>
            <li>Thorough detailing by sections, including tires, nooks, and hidden corners</li>
            <li>Deep vacuuming + complete interior wipe cleaning plus ceramic exterior</li>
            <li>Plastic and glass conditioning</li>
            <li>Sparkling scent finish, like it just came from the dealership</li>
          </ul>

          <p class="text-slate-400 text-sm mb-6">
            For clients who want a real transformation inside and out.
          </p>

          <div>
            <h4 class="text-lg font-semibold text-slate-100 mb-3 border-t border-slate-700 pt-4">
              Prices Starting At:
            </h4>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between items-center bg-slate-700/50 px-3 py-1.5 rounded-md">
                <span>Sedan</span>
                <span class="font-semibold text-sky-300">$280</span>
              </div>
              <div class="flex justify-between items-center px-3 py-1.5 rounded-md">
                <span>SUV</span>
                <span class="font-semibold text-sky-300">$300</span>
              </div>
              <div class="flex justify-between items-center bg-slate-700/50 px-3 py-1.5 rounded-md">
                <span>Full Size Truck/Van</span>
                <span class="font-semibold text-sky-300">$320</span>
              </div>
              <div class="flex justify-between items-center px-3 py-1.5 rounded-md">
                <span>XL/Elevated Vehicle</span>
                <span class="font-semibold text-sky-300">$340</span>
              </div>
            </div>
          </div>
        </div>
        <a href="#book" class="mt-8 w-full text-center inline-block bg-sky-500 text-white uppercase font-bold rounded-lg px-6 py-3.5 hover:bg-sky-600 active:scale-95 transition-all duration-200 shadow-lg shadow-sky-500/30">
          Schedule Now
        </a>
      </div>

      <!-- Package 3 -->
      <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 md:p-8 flex flex-col" data-aos="fade-up" data-aos-delay="400">
        <div class="flex-grow">
          <h3 class="text-3xl font-bold text-sky-400 mb-2">Deep Interior & Exterior</h3>
          <p class="font-bold text-sky-300 mb-4">Starting From $320</p>

          <ul class="space-y-2 text-slate-300 pl-1 mb-6">
            <li>Cat/dog hair removal</li>
            <li>Removal of tough stains, vomit, or spills</li>
            <li>Disinfection and odor neutralization</li>
            <li>Deep cleaning of seats, carpets, seatbelts, and headliner</li>
          </ul>

          <p class="text-slate-400 text-sm mb-6">
            (Price may vary slightly depending on the level of dirt.)
          </p>

          <div>
            <h4 class="text-lg font-semibold text-slate-100 mb-3 border-t border-slate-700 pt-4">
              Prices Starting At:
            </h4>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between items-center bg-slate-700/50 px-3 py-1.5 rounded-md">
                <span>Sedan</span>
                <span class="font-semibold text-sky-300">$320</span>
              </div>
              <div class="flex justify-between items-center px-3 py-1.5 rounded-md">
                <span>SUV</span>
                <span class="font-semibold text-sky-300">$340</span>
              </div>
              <div class="flex justify-between items-center bg-slate-700/50 px-3 py-1.5 rounded-md">
                <span>Full Size Truck/Van</span>
                <span class="font-semibold text-sky-300">$360</span>
              </div>
              <div class="flex justify-between items-center px-3 py-1.5 rounded-md">
                <span>XL/Elevated Vehicle</span>
                <span class="font-semibold text-sky-300">$380</span>
              </div>
            </div>
          </div>
        </div>
        <a href="#book" class="mt-8 w-full text-center inline-block bg-sky-500 text-white uppercase font-bold rounded-lg px-6 py-3.5 hover:bg-sky-600 active:scale-95 transition-all duration-200 shadow-lg shadow-sky-500/30">
          Schedule Now
        </a>
      </div>

      <!-- Package 4 -->
      <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 md:p-8 flex flex-col" data-aos="fade-up" data-aos-delay="500">
        <div class="flex-grow">
          <h3 class="text-3xl font-bold text-sky-400 mb-2">Detail + Professional Polish</h3>
          <p class="font-bold text-sky-300 mb-4">Starting From $390</p>

          <ul class="space-y-2 text-slate-300 pl-1 mb-6">
            <li>Complete detailing</li>
            <li>Professional paint polishing</li>
            <li>Removal of minor scratches and scuffs</li>
            <li>Deep shine restoration</li>
          </ul>

          <p class="text-slate-400 text-sm mb-6">
            The best option for demanding cars and customers who want the best.
          </p>

          <div>
            <h4 class="text-lg font-semibold text-slate-100 mb-3 border-t border-slate-700 pt-4">
              Prices Starting At:
            </h4>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between items-center bg-slate-700/50 px-3 py-1.5 rounded-md">
                <span>Sedan</span>
                <span class="font-semibold text-sky-300">$390</span>
              </div>
              <div class="flex justify-between items-center px-3 py-1.5 rounded-md">
                <span>SUV</span>
                <span class="font-semibold text-sky-300">$410</span>
              </div>
              <div class="flex justify-between items-center bg-slate-700/50 px-3 py-1.5 rounded-md">
                <span>Full Size Truck/Van</span>
                <span class="font-semibold text-sky-300">$430</span>
              </div>
              <div class="flex justify-between items-center px-3 py-1.5 rounded-md">
                <span>XL/Elevated Vehicle</span>
                <span class="font-semibold text-sky-300">$450</span>
              </div>
            </div>
          </div>
        </div>
        <a href="#book" class="mt-8 w-full text-center inline-block bg-sky-500 text-white uppercase font-bold rounded-lg px-6 py-3.5 hover:bg-sky-600 active:scale-95 transition-all duration-200 shadow-lg shadow-sky-500/30">
          Schedule Now
        </a>
      </div>
    </div>

    <p class="mt-10 text-center text-sm text-slate-400" data-aos="fade-up" data-aos-delay="600">
      <span class="font-semibold text-sky-400">Note:</span>
      Customers can choose between gentle or strong cleaning products. We use quality shampoo for all washes.
      For more info or custom quotes, tap the WhatsApp button.
    </p>
  </div>
</section>


<section id="a-la-carte" class="bg-black text-slate-200 py-16 md:py-20 border-t border-slate-800">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
    <div class="text-center mb-10 md:mb-12">
      <h2 class="text-3xl sm:text-4xl font-bold text-sky-400" data-aos="fade-up">
        A La Carte Services
      </h2>
      <p class="mt-3 text-md text-slate-400" data-aos="fade-up" data-aos-delay="100">
        Customize your detailing package with these add-ons.
      </p>
    </div>

    <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 md:p-8" data-aos="fade-up" data-aos-delay="200">
      <h4 class="text-xl font-semibold text-slate-100 mb-6 text-center sm:text-left">
        Enhance Your Clean (Prices Starting At):
      </h4>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
        <div class="flex justify-between items-center border-b border-slate-700 py-3"><span class="text-slate-200">Aquapel Glass Treatment</span><span class="font-semibold text-sky-400">$30</span></div>
        <div class="flex justify-between items-center border-b border-slate-700 py-3"><span class="text-slate-200">Leather Treatment</span><span class="font-semibold text-sky-400">$30</span></div>
        <div class="flex justify-between items-center border-b border-slate-700 py-3"><span class="text-slate-200">Engine Dress</span><span class="font-semibold text-sky-400">$25</span></div>
        <div class="flex justify-between items-center border-b border-slate-700 py-3"><span class="text-slate-200">Spray Wax</span><span class="font-semibold text-sky-400">$15</span></div>
      </div>
    </div>

    <div class="text-center mt-10 md:mt-12" data-aos="fade-up" data-aos-delay="300">
      <a href="#book"
        class="inline-block px-8 py-3.5 bg-sky-500 text-white uppercase font-bold rounded-lg shadow-lg shadow-sky-500/30
                transform transition-all duration-300 ease-in-out
                hover:bg-sky-600 hover:scale-105 active:scale-95
                focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-black text-base">
        Add to Your Service
      </a>
    </div>
  </div>
</section>

<section id="quality-products" class="bg-black text-slate-200 py-16 md:py-20 border-t border-slate-800">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
    <div class="text-center mb-10 md:mb-12">
      <h2 class="text-3xl sm:text-4xl font-bold text-sky-400" data-aos="fade-up">
        We Use Quality Products
      </h2>
      <div class="flex items-center justify-center space-x-2 mt-3" data-aos="fade-up" data-aos-delay="100">
        <span class="text-yellow-400 text-2xl">★</span>
        <p class="text-slate-400 text-md">Premium Brands for Your Vehicle's Optimal Care</p>
      </div>
    </div>

    <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 md:p-8" data-aos="fade-up" data-aos-delay="200">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
        @php
        $products = [
        ['brand' => 'Meguiar’s', 'desc' => 'Excellent for cleaning and protection.'],
        ['brand' => 'Chemical Guys', 'desc' => 'Innovative formulas for detailing and finishes.'],
        ['brand' => 'Griot’s Garage', 'desc' => 'Quality and ease of use in waxes and polishes.'],
        ['brand' => 'Turtle Wax', 'desc' => 'Reliable and affordable with great durability.'],
        ['brand' => 'Sonax', 'desc' => 'Effective in cleaning and paint protection.'],
        ['brand' => 'Adam’s Polishes', 'desc' => 'Premium products ideal for enthusiasts.'],
        ['brand' => '3M', 'desc' => 'Solutions for surface finishing and protection.'],
        ['brand' => 'CarPro', 'desc' => 'Innovative in long-lasting ceramic protection.'],
        ['brand' => 'Gtechniq', 'desc' => 'Long-term ceramic coatings.'],
        ['brand' => 'Rupes', 'desc' => 'High-quality polishing tools.'],
        ['brand' => 'P&S Detail Products', 'desc' => 'Commercial-grade products for professionals.'],
        ['brand' => 'Zaino', 'desc' => 'Durable protection and shine for vehicles.']
        ];
        @endphp

        @foreach ($products as $index => $product)
        <div class="p-1 group" data-aos="fade-up" data-aos-delay="{{ 100 + ($index % 3) * 100 }}">
          {{-- Idealmente, aquí iría un <img src="logo_{{ $product['brand'] }}.png" class="h-10 mb-2 ..."> si tienes logos --}}
          <h5 class="text-lg font-semibold text-sky-300 group-hover:text-sky-200 transition-colors">{{ $product['brand'] }}</h5>
          <p class="text-sm text-slate-400 leading-relaxed mt-1">{{ $product['desc'] }}</p>
        </div>
        @endforeach
      </div>
    </div>

    <div class="mt-10 md:mt-12 text-center" data-aos="fade-up" data-aos-delay="300">
      <h3 class="text-2xl font-semibold text-slate-100 mb-2">
        Our Commitment to Quality
      </h3>
      <p class="text-slate-400 max-w-2xl mx-auto leading-relaxed">
        We are dedicated to using only high-quality, industry-leading products that protect your investment and enhance the beauty and shine of your vehicle for lasting results.
      </p>
    </div>
  </div>
</section>

<section id="contact" class="bg-black text-slate-200 py-16 md:py-20">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-4xl sm:text-5xl font-bold text-sky-400" data-aos="fade-up">Get In Touch</h2>
      <p class="mt-4 text-lg text-slate-400 max-w-xl mx-auto" data-aos="fade-up" data-aos-delay="100">
        We're here to answer your questions or schedule your next premium detailing service.
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 xl:gap-12 items-stretch"> {{-- items-stretch para igualar altura de contenedores hijos directos --}}

      <div class="bg-slate-800/60 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 overflow-hidden min-h-[26rem] sm:min-h-[30rem] lg:h-full flex flex-col" data-aos="fade-right" data-aos-duration="800">
        {{-- REEMPLAZA ESTE SRC CON TU URL DE GOOGLE MAPS REAL --}}
        {{-- Considera usar Google Maps Embed API para un control de estilo 'dark mode' si es posible --}}
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.9313692477837!2d-77.04840068518728!3d-12.047920991469778!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8b5d7fda2ff%3A0x20f0aaa8c7afebb!2sPlaza%20Mayor%20de%20Lima!5e0!3m2!1ses-419!2spe!4v1678886500000!5m2!1ses-419!2spe"
          class="w-full h-full border-0 flex-grow filter grayscale-[40%] invert-[95%] contrast-[90%]"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="Service Area Map"></iframe>
      </div>

      <div class="bg-slate-800/60 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 md:p-8 flex flex-col" data-aos="fade-left" data-aos-duration="800" data-aos-delay="150">
        <div>
          <h3 class="text-3xl font-bold text-sky-400 mb-2">Contact Information</h3>
          <p class="mb-6 text-slate-400">Reach out through your preferred channel or send us a message below.</p>

          <div class="space-y-4 mb-6 text-slate-300">
            <a href="mailto:customer@sumacccarwash.com" class="flex items-center group">
              <svg class="w-6 h-6 text-sky-400 group-hover:text-sky-300 mr-3 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              <span class="group-hover:text-sky-300 transition-colors">customer@sumacccarwash.com</span>
            </a>
            <a href="tel:+14258761729" class="flex items-center group">
              <svg class="w-6 h-6 text-sky-400 group-hover:text-sky-300 mr-3 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.308 1.538a11.037 11.037 0 005.334 5.334l1.538-2.308a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
              <span class="group-hover:text-sky-300 transition-colors">+1 (425) 876-1729</span>
            </a>
          </div>

          <div class="flex space-x-4 mb-8">
            <a href="https://www.facebook.com/profile.php?id=61565425006563" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-sky-400 transition-colors" title="Facebook">
              <img src="SocialNetsIcon/Facebook.png" class="h-6 w-6" alt="">

            </a>
            <a href="https://www.instagram.com/sumacc495/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-sky-400 transition-colors" title="Instagram">
              <img src="SocialNetsIcon/instagram.png" class="h-6 w-6" alt="">

            </a>
            <a href="https://wa.link/gemzk6" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-sky-400 transition-colors" title="WhatsApp">
              <img src="SocialNetsIcon/whatssapp.png" class="h-6 w-6" alt="">

            </a>
            <a href="https://www.tiktok.com/@sumaccmobiledetailing" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-sky-400 transition-colors" title="TikTok">
              <img src="SocialNetsIcon/tiktok.png" class="h-6 w-6" alt="">

            </a>
          </div>

          <div class="mb-8 pt-6 border-t border-slate-700/50">
            <h4 class="text-xl font-semibold text-slate-100 mb-3">We Proudly Serve:</h4>
            <div class="flex flex-wrap gap-2.5">
              @foreach (['Everett, WA', 'Redmond, WA', 'Seattle, WA', 'Bellevue, WA', 'Kirkland, WA', 'Lynnwood, WA'] as $area)
              <span class="bg-slate-700 text-sky-300 px-3.5 py-1.5 rounded-full text-sm font-medium hover:bg-sky-500 hover:text-white transition-colors cursor-default">{{ $area }}</span>
              @endforeach
            </div>
          </div>
        </div>
        <div class="flex-grow flex flex-col">
          <form id="contactForm" class="space-y-5 flex-grow flex flex-col" data-aos="fade-up" data-aos-delay="100">
            <div>
              <label for="contact_name" class="block text-sm font-medium text-slate-300 mb-1.5">Full Name</label>
              <input type="text" name="name" id="contact_name" placeholder="e.g., John Doe" required
                class="w-full bg-slate-700 border-slate-600 rounded-lg px-4 py-3 placeholder-slate-500 text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors">
            </div>
            <div>
              <label for="contact_email" class="block text-sm font-medium text-slate-300 mb-1.5">Email Address</label>
              <input type="email" name="email" id="contact_email" placeholder="you@example.com" required
                class="w-full bg-slate-700 border-slate-600 rounded-lg px-4 py-3 placeholder-slate-500 text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors">
            </div>
            <div>
              <label for="contact_phone" class="block text-sm font-medium text-slate-300 mb-1.5">Phone Number <span class="text-xs text-slate-500">(Optional)</span></label>
              <input type="tel" name="phone" id="contact_phone" placeholder="+1 (555) 123-4567"
                class="w-full bg-slate-700 border-slate-600 rounded-lg px-4 py-3 placeholder-slate-500 text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors">
            </div>
            <div>
              <label for="contact_message" class="block text-sm font-medium text-slate-300 mb-1.5">Your Message</label>
              <textarea name="message" id="contact_message" rows="4" placeholder="Tell us how we can help you..." required
                class="w-full bg-slate-700 border-slate-600 rounded-lg px-4 py-3 placeholder-slate-500 text-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors"></textarea>
            </div>
            <div class="mt-auto pt-2"> {{-- mt-auto para empujar el botón hacia abajo --}}
              <button type="submit"
                class="w-full mt-2 bg-sky-500 text-white uppercase font-bold rounded-lg px-6 py-3.5 hover:bg-sky-600 active:scale-95 transition-all duration-200 shadow-lg shadow-sky-500/30 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-slate-800">
                Send Message
              </button>
              <p class="text-xs text-slate-500 mt-3 text-center">Alternatively, <a href="https://wa.link/gemzk6" target="_blank" rel="noopener noreferrer" class="text-sky-400 hover:underline font-medium">chat with us on WhatsApp</a>.</p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection