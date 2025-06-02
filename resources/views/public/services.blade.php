@extends('public.layout')

@section('content')
  <!-- ==============================
       Hero Section for "Services"
       ============================== -->
  <section
    id="services-hero"
    class="relative h-screen bg-cover bg-center flex items-center justify-center"
    style="background-image: url('{{ asset('hero/bgHero.jpg') }}');"
    data-aos="fade-in" data-aos-duration="1000">

    {{-- Dark gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-black opacity-85"></div>

    <div
      class="container mx-auto h-full relative z-10 flex flex-col items-center justify-center text-center px-4"
      data-aos="fade-up" data-aos-delay="300">

      <h1
        class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-100 uppercase leading-tight tracking-tight"
        data-aos="fade-right" data-aos-delay="500">
        <span class="block">Choose One Of</span>
        <span class="block text-sky-400">Our Services</span>
      </h1>
      <p
        class="mt-4 text-lg md:text-xl text-slate-300 max-w-2xl mx-auto"
        data-aos="fade-right" data-aos-delay="700">
        Browse our premium detailing packages below and pick the perfect one for your vehicle.
      </p>
      <div
        class="mt-8 flex space-x-4"
        data-aos="fade-right" data-aos-delay="900">
        <a
          href="/"
          class="px-8 py-3 bg-slate-700 text-slate-100 font-semibold uppercase rounded-lg shadow-lg
                 transform transition-all duration-300 ease-in-out
                 hover:bg-slate-800 hover:scale-105 hover:shadow-slate-600/50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50"
          data-aos="zoom-in" data-aos-delay="1100">
          Go Back Home
        </a>
      </div>
    </div>
  </section>

  <!-- ==============================
       All Services Grid
       ============================== -->
  <section id="all-services" class="bg-black text-slate-200 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12 md:mb-16">
        <h2
          class="text-3xl sm:text-4xl font-extrabold text-slate-100 uppercase"
          data-aos="fade-up" data-aos-duration="600">
          Our <span class="text-sky-400">Detailing Packages</span>
        </h2>
        <p
          class="mt-4 text-lg text-slate-400 max-w-2xl mx-auto"
          data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
          Select from any of our specialized services—each tailored to give your vehicle the shine it deserves.
        </p>
      </div>

      <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 xl:gap-10"
        data-aos="fade-up" data-aos-delay="200">

        @foreach($services as $service)
          <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-2xl shadow-2xl shadow-sky-900/20 p-6 flex flex-col h-full"
               data-aos="zoom-in-up" data-aos-delay="{{ 100 + ($loop->index % 3) * 100 }}">
            <div class="flex-grow">
              {{-- Service name & category --}}
              <h3 class="text-2xl md:text-3xl font-bold text-sky-400 mb-2">{{ $service->name }}</h3>
              <p class="text-slate-400 italic mb-2">
                Category: <span class="text-slate-100 font-semibold">{{ $service->category->name }}</span>
              </p>

              {{-- Tagline (if available) --}}
              @if(!empty($service->tagline))
                <p class="text-sky-300 mb-4">{{ $service->tagline }}</p>
              @endif

              {{-- Description --}}
              @if(!empty($service->description))
                <p class="text-slate-300 text-sm mb-4">{{ $service->description }}</p>
              @endif

              {{-- Price table by vehicle type --}}
              <h4 class="text-lg font-semibold text-slate-100 mb-3">Prices Starting At:</h4>
              <div class="space-y-2 text-sm">
                @foreach($service->serviceVehiclePrices as $svp)
                  <div class="flex justify-between items-center {{ $loop->odd ? 'bg-slate-700/50' : '' }} px-3 py-1.5 rounded-md">
                    <span>{{ $svp->vehicleType->name }}</span>
                    <span class="font-semibold text-sky-300">${{ number_format($svp->price, 2) }}</span>
                  </div>
                @endforeach
              </div>
            </div>

            {{-- “Choose Service” button --}}
            <a href="{{ route('services.book', ['service' => $service->id]) }}"
              class="mt-6 w-full text-center inline-block bg-sky-500 text-white uppercase font-bold rounded-lg px-6 py-3.5
                     hover:bg-sky-600 active:scale-95 transition-all duration-200 shadow-lg shadow-sky-500/30
                     focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-black">
              Choose Service
            </a>
          </div>
        @endforeach

      </div>
    </div>
  </section>
@endsection
