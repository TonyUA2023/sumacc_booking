<header
  x-data="{ scrolled: false, open: false, activeSection: '', hoveredLink: '' }"
  x-init="
    window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 50 });
    {{-- Lógica básica para activeSection (simplificada, idealmente usar IntersectionObserver) --}}
    let sections = document.querySelectorAll('section[id]');
    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(section => {
        const sectionTop = section.offsetTop - 100; // Ajustar offset según altura del header
        if (pageYOffset >= sectionTop) {
          current = '#' + section.getAttribute('id');
        }
      });
      activeSection = current;
    }, { passive: true });
  "
  :class="scrolled ? 'bg-black/80 shadow-xl backdrop-blur-lg py-3' : 'bg-transparent py-4'"
  class="fixed top-0 w-full z-[999] transition-all duration-300 ease-in-out"
  data-aos="fade-down" data-aos-duration="700"
>
  <div class="container mx-auto flex items-center justify-between px-4 sm:px-6  transition-all duration-300 ease-in-out">
    
{{-- Logo --}}
<a
  href="{{ route('public.home') }}#home"
  class="flex items-center gap-2"
  data-aos="fade-right"
  data-aos-delay="100"
  data-aos-duration="700"
>
  <img
    src="{{ asset('logo/logoSumacc.png') }}"
    alt="SUMACC Logo"
    class="h-6 w-6 md:h-10 md:w-10 transition-all duration-300"
  />
  <div class="flex flex-col leading-tight">
    <span class="text-xl md:text-2xl font-extrabold text-sky-500">SUMACC</span>
    <span
      class="text-xs font-medium text-slate-300 mt-0"
      :class="scrolled ? 'text-slate-400' : 'text-slate-300'"
    >
      Luxe Mobile Wash LLC
    </span>
  </div>
</a>

    {{-- Nav Desktop --}}
    <nav class="hidden md:flex items-center gap-6 lg:gap-8 uppercase font-medium tracking-wider">
      @php
        $navItems = [
          ['/#home','Home', true],
          ['/services','Services', true],
          ['/contact','Contact', true]
        ];
      @endphp
      @foreach ($navItems as $index => $item)
        <a 
          href="{{ $item[2] ? (route('public.home').$item[0]) : url($item[0]) }}"
          @mouseenter="hoveredLink = '{{ $item[0] }}'"
          @mouseleave="hoveredLink = ''"
          class="relative text-sm group transition-colors duration-200"
          :class="scrolled 
            ? (activeSection === '{{ $item[0] }}' ? 'text-sky-400' : 'text-slate-200 hover:text-sky-300')
            : (activeSection === '{{ $item[0] }}' ? 'text-sky-400' : 'text-slate-100 hover:text-white')"
          data-aos="fade-down" data-aos-duration="700" data-aos-delay="{{ 200 + ($index * 50) }}"
        >
          <span>{{ $item[1] }}</span>
          <span
            class="absolute left-0 -bottom-1.5 h-0.5 bg-sky-400 transition-all duration-300 ease-out"
            :style="(activeSection === '{{ $item[0] }}' || hoveredLink === '{{ $item[0] }}') ? 'width: 100%' : 'width: 0%'"
          ></span>
        </a>
      @endforeach
    </nav>

    {{-- CTA Desktop --}}
    <a 
      href="https://wa.link/gemzk6" target="_blank" rel="noopener noreferrer"
      class="hidden lg:inline-block py-2.5 px-7 rounded-full text-sm font-bold transition-all transform duration-300 ease-in-out shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-black"
      :class="scrolled 
        ? 'bg-sky-500 hover:bg-sky-400 text-white hover:scale-105 ring-sky-500' 
        : 'bg-sky-500/90 hover:bg-sky-500 text-white hover:scale-105 ring-sky-500/90'"
      data-aos="fade-left" data-aos-duration="700" data-aos-delay="{{ 200 + (count($navItems) * 50) }}"
    >
      Contact Us
    </a>

    {{-- Hamburger Mobile --}}
    <button 
      @click="open = !open"
      class="md:hidden focus:outline-none z-20"
      :class="open || !scrolled ? 'text-white' : 'text-slate-200'"
      aria-label="Open menu"
    >
      <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" :d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
      </svg>
    </button>
  </div>

  {{-- Mobile Menu --}}
  <div 
    x-show="open" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform -translate-y-full"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-full"
    class="md:hidden absolute top-0 inset-x-0 min-h-screen bg-black/95 backdrop-blur-lg pt-[calc(var(--header-height,4rem)+2rem)] pb-8" {{-- Ajustar pt según altura del header --}}
    @click.away="open = false"
    style="--header-height: 4rem;" {{-- Define una altura base para el header --}}
  >
    <ul class="flex flex-col items-center gap-y-5 text-center uppercase text-base tracking-wider">
      @php
        $mobileNavItems = [
          ['/#home','Home', true],
          ['/services','Services', true],
          ['/contact','Contact', true]
        ];
      @endphp
      <template x-for="(item, index) in {{ json_encode($mobileNavItems) }}" :key="index">
        <li x-show="open" 
            x-transition:enter="transition ease-out duration-300"
            :style="{ transitionDelay: `${50 + index * 75}ms` }"
            x-transition:enter-start="opacity-0 transform translate-y-3"
            x-transition:enter-end="opacity-100 transform translate-y-0">
          <a 
            :href="item[2] ? '{{ route('public.home') }}' + item[0] : item[0]"
            class="font-medium py-2 transition-colors duration-200"
            :class="activeSection === item[0] ? 'text-sky-400' : 'text-slate-200 hover:text-sky-300'"
            @click="open = false"
          >
            <span x-text="item[1]"></span>
          </a>
        </li>
      </template>
      <li x-show="open" 
          x-transition:enter="transition ease-out duration-300"
          :style="{ transitionDelay: `${50 + count($mobileNavItems) * 75}ms` }"
          x-transition:enter-start="opacity-0 transform translate-y-3"
          x-transition:enter-end="opacity-100 transform translate-y-0"
          class="pt-4">
        <a 
          href="https://wa.link/gemzk6" target="_blank" rel="noopener noreferrer"
          class="py-3 px-8 rounded-full font-bold bg-sky-500 hover:bg-sky-400 text-white transition-all transform hover:scale-105 duration-300 ease-in-out"
        >
          Contact Us
        </a>
      </li>
    </ul>
  </nav>
</header>