import './bootstrap'
import Alpine from 'alpinejs'
import AOS from 'aos'
import 'aos/dist/aos.css'

window.Alpine = Alpine
Alpine.start()

document.addEventListener('DOMContentLoaded', () => {
  AOS.init({
    once: true,
    duration: 800,
    easing: 'ease-in-out',
  })
})
