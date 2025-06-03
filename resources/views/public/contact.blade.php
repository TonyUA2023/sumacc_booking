@extends('public.layout')

@section('content')
<section id="contact" class="bg-slate-900 pt-20 pb-16">
  <div class="container mx-auto px-4 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-8 items-stretch">
      {{-- =======================================================
           1) Primer cuadro: Formulario con diseño creativo
           ======================================================= --}}
      <div class="w-full lg:w-1/2 bg-gradient-to-br from-slate-800 to-slate-900 
                  border-2 border-sky-500 rounded-lg shadow-xl p-8">
        <h2 class="text-2xl font-bold text-white mb-6 border-b-2 border-sky-500 pb-2">
          Contact Us
        </h2>
        <form class="space-y-6">
          {{-- Campo: Nombre --}}
          <div>
            <label for="name" class="block text-sm font-medium text-sky-200 mb-1">
              Name
            </label>
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Your Name"
              class="w-full bg-slate-700 text-white placeholder-slate-400 
                     border-b-2 border-transparent focus:border-sky-500 transition-colors 
                     ease-in-out duration-200 py-2 rounded-t-md"
            />
          </div>

          {{-- Campo: Correo Electrónico --}}
          <div>
            <label for="email" class="block text-sm font-medium text-sky-200 mb-1">
              Email Address
            </label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="customer@sumacccarwash.com"
              class="w-full bg-slate-700 text-white placeholder-slate-400 
                     border-b-2 border-transparent focus:border-sky-500 transition-colors 
                     ease-in-out duration-200 py-2 rounded-t-md"
            />
          </div>

          {{-- Campo: Teléfono --}}
          <div>
            <label for="phone" class="block text-sm font-medium text-sky-200 mb-1">
              Your Phone Number
            </label>
            <input
              type="tel"
              id="phone"
              name="phone"
              placeholder="10-digit phone number"
              class="w-full bg-slate-700 text-white placeholder-slate-400 
                     border-b-2 border-transparent focus:border-sky-500 transition-colors 
                     ease-in-out duration-200 py-2 rounded-t-md"
            />
          </div>

          {{-- Campo: Mensaje --}}
          <div>
            <label for="message" class="block text-sm font-medium text-sky-200 mb-1">
              How can i help you?
            </label>
            <textarea
              id="message"
              name="message"
              rows="4"
              placeholder="Feel free to get in touch!"
              class="w-full bg-slate-700 text-white placeholder-slate-400 
                     border-b-2 border-transparent focus:border-sky-500 transition-colors 
                     ease-in-out duration-200 py-2 rounded-t-md resize-none"
            ></textarea>
          </div>

          {{-- Selector: Método de envío --}}
          <div>
            <label for="method" class="block text-sm font-medium text-sky-200 mb-1">
              Send me on
            </label>
            <select
              id="method"
              name="method"
              class="w-full bg-slate-700 text-white placeholder-slate-400 
                     border-b-2 border-transparent focus:border-sky-500 transition-colors 
                     ease-in-out duration-200 py-2 rounded-t-md"
            >
              <option>WhatsApp</option>
              <option>Email</option>
              <option>SMS</option>
            </select>
          </div>

          {{-- Checkbox de consentimiento --}}
          <div class="flex items-center">
            <input
              id="consent"
              name="consent"
              type="checkbox"
              class="h-4 w-4 text-sky-500 bg-slate-700 border-sky-500 focus:ring-sky-500"
            />
            <label for="consent" class="ml-2 text-sm text-slate-200">
              I agree that my data is 
              <a href="#" class="text-sky-400 underline">collected and stored</a>.
            </label>
          </div>

          {{-- Botón de envío --}}
          <div>
            <button
              type="submit"
              class="w-full bg-sky-500 text-white font-semibold uppercase py-3 
                     rounded-lg shadow-lg hover:bg-sky-600 transition-colors duration-200 
                     focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50"
            >
              Send Message
            </button>
          </div>
        </form>
      </div>

      {{-- =======================================================
           2) Segundo cuadro: Información de Contacto con diseño diagonal
           ======================================================= --}}
      <div class="w-full lg:w-1/2 relative rounded-lg shadow-xl overflow-hidden 
                  border-2 border-sky-500">
        {{-- 2.1 Tres franjas diagonales dentro de la tarjeta --}}
        <div class="absolute inset-0 flex flex-col">
          <!-- Primera franja (parte superior) -->
          <div
            class="relative flex-1 overflow-hidden"
            style="clip-path: polygon(0 0, 100% 0, 100% 70%, 0 100%);"
          >
            <img
              src="{{ asset('hero/carCd.webp') }}"
              alt="Franja 1"
              class="absolute inset-0 w-full h-full object-cover"
            />
          </div>
          <!-- Segunda franja (parte central) -->
          <div
            class="relative flex-1 overflow-hidden"
            style="clip-path: polygon(0 15%, 100% 0, 100% 85%, 0 100%);"
          >
            <img
              src="{{ asset('hero/bg-auto-hero.jpg') }}"
              alt="Franja 2"
              class="absolute inset-0 w-full h-full object-cover"
            />
          </div>
          <!-- Tercera franja (parte inferior) -->
          <div
            class="relative flex-1 overflow-hidden"
            style="clip-path: polygon(0 15%, 100% 0, 100% 100%, 0 100%);"
          >
            <img
              src="{{ asset('hero/carDoble.webp') }}"
              alt="Franja 3"
              class="absolute inset-0 w-full h-full object-cover"
            />
          </div>
        </div>

        {{-- 2.2 Overlay oscuro para contrastar el texto --}}
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-black opacity-80"></div>

        {{-- 2.3 Contenido de texto por encima (centrado verticalmente) --}}
        <div class="relative z-10 flex flex-col justify-center h-full p-8 text-center lg:text-left">
          <h3 class="text-sm text-sky-300 uppercase mb-2">Contact Us</h3>
          <h2 class="text-3xl font-bold text-white mb-4">Have Questions? Get In Touch!</h2>
          <div class="space-y-4 text-slate-200">
            <p>United States —</p>
            <p>24003 50th Pl<br>Mountlake Terrace, WA 98043</p>
            <p class="text-sky-400 font-medium">customer@sumacccarwash.com</p>
            <p class="text-sky-500 font-semibold">(425) 332-0815</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
