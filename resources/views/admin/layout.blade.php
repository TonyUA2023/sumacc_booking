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

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
