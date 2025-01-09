<!-- resources/views/admin/layouts/app2.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Crystal Cavern')</title>
    
    @vite('resources/css/app.css')
    
    <!-- Alpine.js untuk toggle sidebar dan dropdown -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body
    x-data="{ open: false, isProfileOpen: false }"
    class="relative min-h-screen bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('images/Background-1-Admin.png') }}');"
>
    {{-- HEADER (fixed) --}}
    <header 
        class="fixed top-0 left-0 w-full bg-gray-300 h-20 md:h-24 z-50 flex items-center"
    >
        <div class="flex justify-between w-full px-2 sm:px-4 md:px-6">
            <!-- Kiri: Hamburger + Brand -->
            <div class="flex items-center space-x-3">
                <button 
                    class="p-2 flex flex-col space-y-1 sm:space-y-2" 
                    @click="open = !open"
                >
                    <span class="block w-8 h-1 bg-[#1A2254] rounded-lg sm:w-12 sm:h-2"></span>
                    <span class="block w-8 h-1 bg-[#1A2254] rounded-lg sm:w-12 sm:h-2"></span>
                    <span class="block w-8 h-1 bg-[#1A2254] rounded-lg sm:w-12 sm:h-2"></span>
                </button>

                <h1 class="text-[#1A2254] text-xl sm:text-2xl md:text-3xl lg:text-4xl font-[IM_FELL_English]">
                    DLOR 2025
                </h1>
            </div>

            <!-- Kanan: Profile + "AUL" -->
            <div class="relative flex items-center space-x-2 sm:space-x-3 md:space-x-4">
                <button
                    @click="isProfileOpen = !isProfileOpen"
                    class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-white flex items-center justify-center border-2 border-[#1A2254]"
                >
                    {{-- SVG Profil --}}
                    <svg
                        width="28"
                        height="28"
                        class="md:w-10 md:h-10"
                        viewBox="0 0 43 43"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M29.25 10.0638C29.25 14.215 25.7531 17.9217 21.5 17.9217C17.2469 17.9217 13.75 14.215 13.75 10.0638C13.75 5.86479 17.2922 1.875 21.5 1.875C25.7078 1.875 29.25 5.86479 29.25 10.0638ZM41.125 32.4493C41.125 34.6517 39.8655 36.7759 36.7409 38.4045C33.5833 40.0504 28.6099 41.1254 21.5 41.1254C14.3901 41.1254 9.4167 40.0504 6.25909 38.4045C3.13453 36.7759 1.875 34.6517 1.875 32.4493C1.875 30.3938 3.68919 28.2257 7.34065 26.5126C10.9127 24.8368 15.9177 23.7733 21.5 23.7733C27.0823 23.7733 32.0873 24.8368 35.6594 26.5126C39.3108 28.2257 41.125 30.3938 41.125 32.4493Z"
                            stroke="#1A2254"
                            stroke-width="2"
                        />
                    </svg>
                </button>

                <!-- AUL Text -->
                <span class="hidden sm:block text-[#1A2254] text-lg sm:text-xl md:text-2xl lg:text-3xl font-[IM_FELL_English]">
                    AUL
                </span>

                <!-- Dropdown menu -->
                <div
                    class="absolute top-16 md:top-20 right-0 w-48 sm:w-56 bg-gray-300/50 p-3 sm:p-4 rounded shadow-md"
                    x-show="isProfileOpen"
                    @click.away="isProfileOpen = false"
                >
                    <button
                        class="w-full text-[#1A2254] text-base sm:text-lg md:text-xl font-[IM_FELL_English] mb-2"
                    >
                        Change Password
                    </button>
                    <button
                        class="w-full text-[#1A2254] text-base sm:text-lg md:text-xl font-[IM_FELL_English]"
                    >
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- SIDEBAR (fixed) --}}
    <aside
        class="fixed top-20 md:top-24 left-0 w-48 sm:w-56 md:w-64 h-full bg-black/40 z-40 transform transition-transform duration-300 backdrop-blur-sm"
        :class="open ? 'translate-x-0' : '-translate-x-full'"
    >
        <nav class="py-6 md:py-8 flex flex-col space-y-4 md:space-y-6">
            @foreach(['Dashboard', 'Announcement', 'Manage CaAs', 'Manage Gems'] as $item)
                <button
                    class="text-left px-4 py-2 text-white text-base sm:text-lg md:text-xl lg:text-2xl font-[IM_FELL_English]
                           hover:bg-white/10 transition-colors duration-200"
                >
                    {{ $item }}
                </button>
            @endforeach
        </nav>
    </aside>

    <!-- WRAPPER UTAMA: agar footer 'sticky' -->
<div class="pt-20 md:pt-24 flex flex-col min-h-screen">
    {{-- MAIN CONTENT (flex-grow) --}}
    <main class="flex-grow flex flex-col items-center justify-center px-4">
        @yield('content')
    </main>

    {{-- FOOTER (posisi di bawah, atau 'sticky' ketika konten sedikit) --}}
    <footer
    class="w-full h-20 md:h-24 bg-gray-300 flex items-center justify-center px-2"
>
    <p
        class="text-[#1A2254] text-base sm:text-xl md:text-2xl lg:text-3xl font-[IM_FELL_English] text-center"
    >
        ©Crystal Cavern. DLOR 2025. All Rights Reserved.
    </p>
</footer>
</div>


    @stack('scripts')
</body>
</html>
