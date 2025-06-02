<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin SUMACC')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="flex h-screen bg-gray-100">
        <aside
            class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 px-4 py-7 space-y-6 overflow-y-auto transition-transform duration-300 ease-in-out transform -translate-x-full bg-gray-800 text-gray-100 md:translate-x-0 md:static md:inset-0"
            :class="{'translate-x-0': sidebarOpen}"
            aria-label="Sidebar"
            x-cloak
        >
            <div class="px-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center ">
                    {{-- <img src="logo.svg" alt="SUMACC Logo" class="w-8 h-8 mr-2"> --}}
                    <span class="text-2xl font-semibold text-white">SUMACC</span>
                </a>
            </div>

            <nav class="flex-1">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 13.5H8V18H4.5V13.5ZM4.5 6H8V10.5H4.5V6ZM9.5 18H13V12H9.5V18ZM9.5 4.5H13V10.5H9.5V4.5ZM14.5 15H18V18H14.5V15ZM14.5 6H18V12H14.5V6Z"></path></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.appointments.index') }}" class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 {{ request()->routeIs('admin.appointments.index') || request()->routeIs('admin.appointments.show') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M19 4H18V2H16V4H8V2H6V4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4ZM19 20H5V9H19V20ZM19 7H5V6H19V7ZM7 11H9V13H7V11ZM7 15H9V17H7V15ZM11 11H13V13H11V11ZM11 15H13V17H11V15ZM15 11H17V13H15V11ZM15 15H17V17H15V15Z"></path></svg>
                            <span>Appointments</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.services.index') }}" class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 text-gray-300 hover:bg-gray-700 hover:text-white">
                             <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.9999 10.8284L16.9497 15.7782L15.5355 17.1924L10.5857 12.2426L11.9999 10.8284ZM11.9999 10.8284L10.5857 9.41421L5.63599 14.364L7.0502 15.7782L11.9999 10.8284ZM13.4141 12.2426L12.707 12.9497L13.4141 13.6569L14.1212 12.9497L17.6567 9.41421L16.2425 8L12.707 11.5355L9.17149 8L7.75728 9.41421L11.2928 12.9497L11.9999 13.6569L12.707 12.9497L13.4141 12.2426ZM12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2Z"></path></svg>
                            <span>Services</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.clients.index') }}" class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 text-gray-300 hover:bg-gray-700 hover:text-white">
                           <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C15.3137 2 18 4.68629 18 8C18 12.4183 12 19 12 19C12 19 6 12.4183 6 8C6 4.68629 8.68629 2 12 2ZM12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z"></path></svg>
                            <span>Clients</span>
                        </a>
                    </li>
                     <li>
                        <a href="#" class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 text-gray-300 hover:bg-gray-700 hover:text-white">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17 17C17 14.2386 14.7614 12 12 12C9.23858 12 7 14.2386 7 17C7 17.5523 7.44772 18 8 18H16C16.5523 18 17 17.5523 17 17ZM12 2C14.7614 2 17 4.23858 17 7C17 9.76142 14.7614 12 12 12C9.23858 12 7 9.76142 7 7C7 4.23858 9.23858 2 12 2Z"></path></svg>
                            <span>Users</span>
                        </a>
                    </li>
                    {{-- Separador --}}
                    <li class="my-4 border-t border-gray-700"></li>
                    <li>
                        <a href="#" class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 text-gray-300 hover:bg-gray-700 hover:text-white">
                           <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1C11.4477 1 11 1.44772 11 2V3.05493C7.51066 3.55002 4.95201 5.81079 4.18005 8.99834C4.06225 9.45368 4.30443 9.90091 4.75977 10.0187C5.21512 10.1365 5.66235 9.89433 5.78014 9.439C6.33577 7.04444 8.38034 5.30071 10.8358 5.03818C10.9138 5.03051 11 5.02746 11 5.02746V5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V5.02746C13 5.02746 13.0862 5.03051 13.1642 5.03818C15.6197 5.30071 17.6642 7.04444 18.2199 9.439C18.3377 9.89433 18.7849 10.1365 19.2402 10.0187C19.6956 9.90091 19.9377 9.45368 19.8199 8.99834C19.048 5.81079 16.4893 3.55002 13 3.05493V2C13 1.44772 12.5523 1 12 1ZM12 23C12.5523 23 13 22.5523 13 22V20.9451C16.4893 20.45 19.048 18.1892 19.8199 15.0017C19.9377 14.5463 19.6956 14.0991 19.2402 13.9813C18.7849 13.8635 18.3377 14.1057 18.2199 14.561C17.6642 16.9556 15.6197 18.6993 13.1642 18.9618C13.0862 18.9695 13 18.9725 13 18.9725V19C13 19.5523 12.5523 20 12 20C11.4477 20 11 19.5523 11 19V18.9725C11 18.9725 10.9138 18.9695 10.8358 18.9618C8.38034 18.6993 6.33577 16.9556 5.78014 14.561C5.66235 14.1057 5.21512 13.8635 4.75977 13.9813C4.30443 14.0991 4.06225 14.5463 4.18005 15.0017C4.95201 18.1892 7.51066 20.45 11 20.9451V22C11 22.5523 11.4477 23 12 23ZM23 12C23 11.4477 22.5523 11 22 11H20.9451C20.45 7.51066 18.1892 4.95201 15.0017 4.18005C14.5463 4.06225 14.0991 4.30443 13.9813 4.75977C13.8635 5.21512 14.1057 5.66235 14.561 5.78014C16.9556 6.33577 18.6993 8.38034 18.9618 10.8358C18.9695 10.9138 18.9725 11 18.9725 11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H18.9725C18.9725 13 18.9695 13.0862 18.9618 13.1642C18.6993 15.6197 16.9556 17.6642 14.561 18.2199C14.1057 18.3377 13.8635 18.7849 13.9813 19.2402C14.0991 19.6956 14.5463 19.9377 15.0017 19.8199C18.1892 19.048 20.45 16.4893 20.9451 13H22C22.5523 13 23 12.5523 23 12ZM1 12C1 12.5523 1.44772 13 2 13H3.05493C3.55002 16.4893 5.81079 19.048 8.99834 19.8199C9.45368 19.9377 9.90091 19.6956 10.0187 19.2402C10.1365 18.7849 9.89433 18.3377 9.439 18.2199C7.04444 17.6642 5.30071 15.6197 5.03818 13.1642C5.03051 13.0862 5.02746 13 5.02746 13H5C4.44772 13 4 12.5523 4 12C4 11.4477 4.44772 11 5 11H5.02746C5.02746 11 5.03051 10.9138 5.03818 10.8358C5.30071 8.38034 7.04444 6.33577 9.439 5.78014C9.89433 5.66235 10.1365 5.21512 10.0187 4.75977C9.90091 4.30443 9.45368 4.06225 8.99834 4.18005C5.81079 4.95201 3.55002 7.51066 3.05493 11H2C1.44772 11 1 11.4477 1 12Z"></path></svg>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black bg-opacity-50 md:hidden" x-cloak></div>

        <div class="flex flex-col flex-1"> 
            <header class="sticky top-0 z-20 flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200 shadow-sm md:px-6">
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="p-1 text-gray-500 rounded-md md:hidden hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="flex-1">
                    {{-- Puedes poner un breadcrumb o un campo de búsqueda aquí si lo deseas --}}
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center text-sm transition duration-150 ease-in-out rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span class="hidden ml-2 text-sm font-medium text-gray-700 md:block">Admin Name</span> {{-- Reemplaza con nombre real --}}
                            <svg class="hidden w-5 h-5 ml-1 text-gray-500 md:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                             role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" style="display: none;"
                             x-cloak
                        >
                            <div class="py-1" role="none">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Your Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Settings</a>
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6"> {{-- Padding general para el área de contenido --}}
                <div class="max-w-full mx-auto"> {{-- Cambiado a max-w-full para que use el padding de main --}}
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900 md:text-3xl">@yield('page-title', 'Page Title')</h1>
                    </div>

                    @yield('content') {{-- La página que extienda (ej. appointments.blade.php) proveerá su propio contenedor/card --}}
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>