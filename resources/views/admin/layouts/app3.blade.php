<!-- resources/views/admin/layouts/app.blade.php -->

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
    class="relative min-h-screen"
>
<canvas id="webgl-canvas"></canvas>


    {{-- HEADER (fixed) --}}
    <x-admin-nav/>

    <!-- WRAPPER UTAMA (z-10) agar berada di atas overlay -->
    <div class="pt-20 md:pt-24 flex flex-col min-h-screen relative z-10">
    {{-- MAIN CONTENT (flex-grow) --}}
    <main class="flex-grow flex flex-col items-center justify-center px-4">
        @yield('content')
    </main>

    {{-- FOOTER (posisi di bawah, atau 'sticky' ketika konten sedikit) --}}
    <footer
    class="w-full h-20 md:h-24 bg-biru-tua flex items-center justify-center px-2"
>
    <p
        class="text-white text-base sm:text-lg md:text-xl lg:text-2xl font-im-fell-english text-center"
    >
        ©Crystal Cavern. DLOR 2025. All Rights Reserved.
    </p>
</footer>
</div>
    <x-admin-background/>
    @stack('scripts')
</body>
</html>
