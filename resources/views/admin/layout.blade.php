<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin SUMACC')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />

<<<<<<< HEAD
=======
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
>>>>>>> e4c35a997968a6d16322236953a65c25718c23d4

    <!-- Vite-compiled CSS/JS -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <!-- Tailwind custom styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
<<<<<<< HEAD

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.43/builds/moment-timezone-with-data.min.js"></script>
=======
>>>>>>> e4c35a997968a6d16322236953a65c25718c23d4
</head>

<body class="bg-white text-gray-800 antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Off-canvas backdrop (mobile) -->
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
            @click="sidebarOpen = false"
            aria-hidden="true"
        ></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 overflow-y-auto bg-blue-600 text-white transform transition-transform duration-300 ease-in-out
                   lg:static lg:translate-x-0"
            :class="{ '-translate-x-full': !sidebarOpen }"
            x-cloak
        >
            <div class="flex items-center justify-between px-4 py-5 bg-blue-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <svg
                        class="w-8 h-8 text-white mr-2"
                        xmlns="https://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10l1.5-3m0 0L6 4m-1.5 3H9m5-3l1.5 3m0 0L18 10m-1.5-3H15m-6 8v6m0 0l-3-3m3 3l3-3" />
                    </svg>
                    <span class="text-2xl font-bold tracking-wide">SUMACC</span>
                </a>
                <!-- Close button (mobile) -->
                <button
                    @click="sidebarOpen = false"
                    class="text-blue-200 hover:text-white lg:hidden focus:outline-none"
                >
                    <svg class="w-6 h-6" xmlns="https://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

<<<<<<< HEAD
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

                    @if(Auth::guard('admin')->check())
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 text-gray-300 hover:bg-gray-700 hover:text-white">
                                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17 17C17 14.2386 14.7614 12 12 12C9.23858 12 7 14.2386 7 17C7 17.5523 7.44772 18 8 18H16C16.5523 18 17 17.5523 17 17ZM12 2C14.7614 2 17 4.23858 17 7C17 9.76142 14.7614 12 12 12C9.23858 12 7 9.76142 7 7C7 4.23858 9.23858 2 12 2Z"></path></svg>
                                <span>Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.extra-services.index') }}"
                            class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 {{ request()->routeIs('admin.extra-services.*') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    {{-- Ícono genérico (por ejemplo, un signo “+” dentro de un círculo) --}}
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Extra Services</span>
                            </a>
                        </li>
                    @endif

                    {{-- Separador --}}
                    <li class="my-4 border-t border-gray-700"></li>
                    <li>
                        <a href="{{ route('admin.settings.edit') }}"  class="flex items-center px-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150 text-gray-300 hover:bg-gray-700 hover:text-white">
                           <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1C11.4477 1 11 1.44772 11 2V3.05493C7.51066 3.55002 4.95201 5.81079 4.18005 8.99834C4.06225 9.45368 4.30443 9.90091 4.75977 10.0187C5.21512 10.1365 5.66235 9.89433 5.78014 9.439C6.33577 7.04444 8.38034 5.30071 10.8358 5.03818C10.9138 5.03051 11 5.02746 11 5.02746V5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V5.02746C13 5.02746 13.0862 5.03051 13.1642 5.03818C15.6197 5.30071 17.6642 7.04444 18.2199 9.439C18.3377 9.89433 18.7849 10.1365 19.2402 10.0187C19.6956 9.90091 19.9377 9.45368 19.8199 8.99834C19.048 5.81079 16.4893 3.55002 13 3.05493V2C13 1.44772 12.5523 1 12 1ZM12 23C12.5523 23 13 22.5523 13 22V20.9451C16.4893 20.45 19.048 18.1892 19.8199 15.0017C19.9377 14.5463 19.6956 14.0991 19.2402 13.9813C18.7849 13.8635 18.3377 14.1057 18.2199 14.561C17.6642 16.9556 15.6197 18.6993 13.1642 18.9618C13.0862 18.9695 13 18.9725 13 18.9725V19C13 19.5523 12.5523 20 12 20C11.4477 20 11 19.5523 11 19V18.9725C11 18.9725 10.9138 18.9695 10.8358 18.9618C8.38034 18.6993 6.33577 16.9556 5.78014 14.561C5.66235 14.1057 5.21512 13.8635 4.75977 13.9813C4.30443 14.0991 4.06225 14.5463 4.18005 15.0017C4.95201 18.1892 7.51066 20.45 11 20.9451V22C11 22.5523 11.4477 23 12 23ZM23 12C23 11.4477 22.5523 11 22 11H20.9451C20.45 7.51066 18.1892 4.95201 15.0017 4.18005C14.5463 4.06225 14.0991 4.30443 13.9813 4.75977C13.8635 5.21512 14.1057 5.66235 14.561 5.78014C16.9556 6.33577 18.6993 8.38034 18.9618 10.8358C18.9695 10.9138 18.9725 11 18.9725 11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H18.9725C18.9725 13 18.9695 13.0862 18.9618 13.1642C18.6993 15.6197 16.9556 17.6642 14.561 18.2199C14.1057 18.3377 13.8635 18.7849 13.9813 19.2402C14.0991 19.6956 14.5463 19.9377 15.0017 19.8199C18.1892 19.048 20.45 16.4893 20.9451 13H22C22.5523 13 23 12.5523 23 12ZM1 12C1 12.5523 1.44772 13 2 13H3.05493C3.55002 16.4893 5.81079 19.048 8.99834 19.8199C9.45368 19.9377 9.90091 19.6956 10.0187 19.2402C10.1365 18.7849 9.89433 18.3377 9.439 18.2199C7.04444 17.6642 5.30071 15.6197 5.03818 13.1642C5.03051 13.0862 5.02746 13 5.02746 13H5C4.44772 13 4 12.5523 4 12C4 11.4477 4.44772 11 5 11H5.02746C5.02746 11 5.03051 10.9138 5.03818 10.8358C5.30071 8.38034 7.04444 6.33577 9.439 5.78014C9.89433 5.66235 10.1365 5.21512 10.0187 4.75977C9.90091 4.30443 9.45368 4.06225 8.99834 4.18005C5.81079 4.95201 3.55002 7.51066 3.05493 11H2C1.44772 11 1 11.4477 1 12Z"></path></svg>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
=======
            <nav class="flex flex-col px-4 py-6 space-y-2">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                           {{ request()->routeIs('admin.dashboard') ? 'bg-blue-200 text-blue-800' : 'bg-blue-600 hover:bg-blue-500' }}"
                >
                    <svg class="w-5 h-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                    </svg>
                    <span class="{{ request()->routeIs('admin.dashboard') ? 'text-blue-800' : 'text-white' }}">Dashboard</span>
                </a>

                <a
                    href="{{ route('admin.appointments.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                           {{ request()->routeIs('admin.appointments.index') || request()->routeIs('admin.appointments.show') ? 'bg-blue-200 text-blue-800' : 'bg-blue-600 hover:bg-blue-500' }}"
                >
                    <svg class="w-5 h-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10m-11 4h12a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v11a1 1 0 001 1z" />
                    </svg>
                    <span class="{{ request()->routeIs('admin.appointments.index') || request()->routeIs('admin.appointments.show') ? 'text-blue-800' : 'text-white' }}">Appointments</span>
                </a>

                <a
                    href=""
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                           {{ request()->routeIs('admin.appointments.calendar') ? 'bg-blue-200 text-blue-800' : 'bg-blue-600 hover:bg-blue-500' }}"
                >
                    <svg class="w-5 h-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10m-11 4h12a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v11a1 1 0 001 1z" />
                    </svg>
                    <span class="{{ request()->routeIs('admin.appointments.calendar') ? 'text-blue-800' : 'text-white' }}">Calendar</span>
                </a>

                <a
                    href="{{ route('admin.services.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                           {{ request()->routeIs('admin.services.index') ? 'bg-blue-200 text-blue-800' : 'bg-blue-600 hover:bg-blue-500' }}"
                >
                    <svg class="w-5 h-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zM7 12a5 5 0 0110 0v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6z" />
                    </svg>
                    <span class="{{ request()->routeIs('admin.services.index') ? 'text-blue-800' : 'text-white' }}">Services</span>
                </a>

                <a
                    href="{{ route('admin.clients.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                           {{ request()->routeIs('admin.clients.index') ? 'bg-blue-200 text-blue-800' : 'bg-blue-600 hover:bg-blue-500' }}"
                >
                    <svg class="w-5 h-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 01-8 0 4 4 0 018 0zM12 14c4.418 0 8 1.79 8 4v1H4v-1c0-2.21 3.582-4 8-4z" />
                    </svg>
                    <span class="{{ request()->routeIs('admin.clients.index') ? 'text-blue-800' : 'text-white' }}">Clients</span>
                </a>

                <a
                    href=""
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                           {{ request()->routeIs('admin.users.index') ? 'bg-blue-200 text-blue-800' : 'bg-blue-600 hover:bg-blue-500' }}"
                >
                    <svg class="w-5 h-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5.121 17.804A13.937 13.937 0 0112 15c2.528 0 4.9.68 6.879 1.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                    </svg>
                    <span class="{{ request()->routeIs('admin.users.index') ? 'text-blue-800' : 'text-white' }}">Users</span>
                </a>

                <div class="border-t border-blue-500 my-4"></div>

                <a
                    href=""
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                           {{ request()->routeIs('admin.settings') ? 'bg-blue-200 text-blue-800' : 'bg-blue-600 hover:bg-blue-500' }}"
                >
                    <svg class="w-5 h-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.364 6.364l-1.414-1.414M6.05 6.05L4.636 4.636m0 14.728l1.414-1.414M18.364 6.364l-1.414 1.414" />
                    </svg>
                    <span class="{{ request()->routeIs('admin.settings') ? 'text-blue-800' : 'text-white' }}">Settings</span>
                </a>
>>>>>>> e4c35a997968a6d16322236953a65c25718c23d4
            </nav>
        </aside>

        <!-- Main content area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between flex-shrink-0 px-6 py-4 bg-white border-b border-blue-200 shadow-sm">
                <div class="flex items-center">
                    <!-- Hamburger (mobile) -->
                    <button
                        @click="sidebarOpen = true"
                        class="text-blue-600 lg:hidden focus:outline-none focus:ring-2 focus:ring-blue-400 rounded-md"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Page title (desktop) -->
                    <h1 class="ml-4 text-2xl font-semibold text-blue-700 hidden lg:block">
                        @yield('page-title', 'Page Title')
                    </h1>
                </div>

                <!-- Search bar & user menu -->
                <div class="flex items-center space-x-4">
                    <!-- Search input (desktop) -->
                    <div class="relative hidden md:block">
                        <input
                            type="text"
                            placeholder="Search..."
                            class="w-64 px-4 py-2 text-sm bg-blue-50 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                        />
                        <span class="absolute inset-y-0 right-3 flex items-center text-blue-400">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                    </div>

                    <!-- User menu -->
                    <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                        <button
                            @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center space-x-2 focus:outline-none"
                        >
                            <img
                                src="{{ asset('images/avatar-placeholder.png') }}"
                                alt="User avatar"
                                class="w-8 h-8 rounded-full object-cover border-2 border-blue-300"
                            />
                            <span class="hidden text-sm font-medium text-blue-700 md:block">
                                Admin Name
                            </span>
                            <svg class="w-4 h-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- User dropdown -->
                        <div
                            x-show="userMenuOpen"
                            x-transition.origin.top.right
                            class="absolute right-0 w-48 mt-2 bg-white border border-blue-200 rounded-md shadow-lg overflow-hidden"
                            style="display: none;"
                        >
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-blue-700 hover:bg-blue-50"
                            >
                                Your Profile
                            </a>
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-blue-700 hover:bg-blue-50"
                            >
                                Settings
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-50"
                                >
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-6 bg-blue-50">
                <!-- Mobile page title -->
                <div class="block mb-6 lg:hidden">
                    <h1 class="text-xl font-semibold text-blue-700">
                        @yield('page-title', 'Page Title')
                    </h1>
                </div>

                <div class="max-w-full mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
