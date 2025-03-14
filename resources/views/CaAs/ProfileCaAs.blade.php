<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <!-- Preload Images -->
    <link rel="preload" href="assets/Wall2.webp" as="image">
    <link rel="preload" href="assets/Wall-Mobile.webp" as="image">
    <link rel="preload" href="assets/Crystal 3.webp" as="image">
    <link rel="preload" href="assets/Crystal 5.webp" as="image">
    <link rel="preload" href="assets/Crystal 2.webp" as="image">
    <link rel="preload" href="assets/Shine.webp" as="image">
    <link rel="preload" href="assets/Wall 3.webp" as="image">
    <link rel="preload" href="assets/Crystal 5.webp" as="image">
    <link rel="preload" href="assets/Shine.webp" as="image">
</head>

<body class="min-h-screen bg-Profile bg-cover bg-center bg-no-repeat max-w-full overflow-x-hidden">
@php
    $user = Auth::user();
    $name = $user->profile->name;
    $major = $user->profile->major;
    $class = $user->profile->class;
    $gender = $user->profile->gender;
    $nim = $user->nim;
    $words = explode(' ', $name); // Split the name into words
    $shortenedName = '';

    foreach ($words as $word) {
        // Add words if within the 25-character limit
        if (strlen($shortenedName) + strlen($word) + 1 <= 25) {
            $shortenedName .= ($shortenedName ? ' ' : '') . $word;
        } else {
            $shortenedName .= ' ' . strtoupper($word[0]) . '.'; // Convert exceeding words into initials
        }
    }
@endphp

    <!-- Background Image -->
    <canvas id="webgl-canvas" class="fixed w-screen h-screen top-0 -z-10"></canvas>
    <img src="assets/Wall2.webp" alt="Wall" class="fixed left-0 h-full w-auto">
    <img src="assets/Wall-Mobile.webp" alt="Wall" class="fixed inset-0 h-full w-full sm:hidden">
    <img src="assets/Crystal 3.webp" alt="Crystal" class="fixed bottom-0 left-0 h-96 w-auto scale-x-[-1] scale-y-[-1]">
    <img src="assets/Crystal 5.webp" alt="Crystal" class="fixed bottom-0 z-10 left-36 h-52 w-auto sm:w-20">
    <img src="assets/Crystal 2.webp" alt="Crystal" class="fixed top-0 z-10 left-0 h-full w-auto">
    <img src="assets/Shine.webp" alt="Shine" class="fixed bottom-24 z-10 left-5 h-auto w-[70px] sm:w-auto pulsing">
    <img src="assets/Shine.webp" alt="Shine" class="fixed bottom-10 z-10 left-32  h-auto w-[70px] sm:w-auto pulsing">
    <img src="assets/Wall 3.webp" alt="Wall"
        class="fixed right-0 h-full w-auto opacity-0 lg:opacity-100 md:opacity-100">
    <img src="assets/Crystal 5.webp" alt="Crystal"
        class="fixed bottom-0 -right-14 h-60 w-auto opacity-0 lg:opacity-100 md:opacity-100">
    <img src="assets/Shine.webp" alt="Shine"
        class="fixed bottom-10 right-5 w-[200px] opacity-0 lg:opacity-100 md:opacity-100 pulsing">
    <div class="fixed inset-0 z-10 w-screen h-screen bg-black bg-opacity-50">sds</div>
    <div class="fixed flex items-center justify-center w-screen h-screen z-20 scro">
        <div class="absolute inset-0 text-white text-center mt-20 h-sm:mt-14 h-xs:mt-5">
            <h2 class="font-crimson-text text-xl pb-2">Discover The Light Within</h2>
            <h1 class="font-im-fell-english text-5xl">Profile</h1>
        </div>
        <div class="relative group mt-14">
            <div class="transition-transform duration-300 group-hover:scale-105">
                <img src="assets/Profile Card {{ $gender === 'Female' ? 'Female' : 'Male' }}.webp" alt="Profile Card" class="w-[450px] relative z-10">
                <div
                    class="absolute inset-0 bg-white blur-xl opacity-0 transition-opacity duration-300 group-hover:opacity-10">
                </div>
                <div
                    class="absolute inset-0 flex items-center text-justify z-20 mx-[89px] xs:mx-[100px] sm:mx-[105px] md:mx-[105px] lg:mx-[105px] mt-[173px] sm:mt-[205px] lg:mt-[203px] md:mt-[203px] xs:mt-[196px]">
                    <div class="text-[9px] sm:text-[10px] md:text-[11px] lg:text-[11px] text-profile font-rye">
                        <p>NAMA: {{ $shortenedName }}</p>
                        <p>NIM: {{ $nim }}</p>
                        <p>JURUSAN: {{ $major }}</p>
                        <p>KELAS: {{ $class }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-sidebar></x-sidebar>
    <x-home-button></x-home-button>


</body>

</html>
