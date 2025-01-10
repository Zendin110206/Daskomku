<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body 
    class="bg-cover bg-center bg-no-repeat font-im-fell-english-english flex flex-col items-center justify-center min-h-screen px-4 sm:px-8"
    style="background-image: url('{{ asset('images/Background_1.png') }}');"
>
    <!-- Greeting Section -->
    <header class="text-center mb-10 px-4">
        <h1 class="text-3xl sm:text-3xl md:text-5xl text-white font-serif mb-4 text-shadow-md">
            Greeting, Wanderer!
        </h1>
        <p class="text-base sm:text-sm md:text-xl text-white font-serif max-w-2xl mx-auto leading-relaxed text-shadow-sm">
            Your journey begins here. Please enter your login details and password below to continue your adventure.
        </p>
    </header>

    <!-- Login Form Component -->
    <x-login-form-caas></x-login-form-caas>
    <!-- Footer Text -->
    <div class="mt-10 text-center px-4">
        <p class="text-sm sm:text-base md:text-lg text-white font-serif text-shadow-sm">
        Discover your light within
        </p>
    </div>
</body>
</html>
