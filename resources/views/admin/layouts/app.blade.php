<!-- resources/views/admin/layout.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - @yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="font-im-fell-english flex flex-col min-h-screen">
    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full bg-footer-gray py-6 mt-auto">
        <p class="mx-auto text-center text-text-color font-im-fell-english 
                   text-xl sm:text-2xl md:text-3xl lg:text-4xl">
            ©Crystal Cavern. DLOR 2025. All Rights Reserved.
        </p>
    </footer>
</body>
</html>
