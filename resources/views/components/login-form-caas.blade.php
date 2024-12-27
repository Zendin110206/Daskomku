<div class="w-full max-w-lg px-4 sm:px-8 md:px-12 space-y-6 flex flex-col items-center justify-center mx-auto">
  <!-- Username Input -->
  <div class="w-full">
    <label for="username" class="block text-base sm:text-lg text-white font-serif mb-2">
      Username
    </label>
    <input
      type="text"
      id="username"
      class="w-full p-3 bg-center rounded-lg shadow-md text-black text-base sm:text-lg"
      placeholder="Enter your username"
      style="background-image: url('{{ asset('images/login-placeholder.png') }}');"
    />
  </div>

  <!-- Password Input -->
  <div class="w-full">
    <label for="password" class="block text-base sm:text-lg text-white font-serif mb-2">
      Password
    </label>
    <input
      type="password"
      id="password"
      class="w-full p-3 bg-center rounded-lg shadow-md text-black text-base sm:text-lg"
      placeholder="Enter your password"
      style="background-image: url('{{ asset('images/login-placeholder.png') }}');"
    />
  </div>

  <!-- Explore Button -->
  <button  
    class="w-full max-w-[11rem] bg-center bg-no-repeat py-3 text-white rounded-lg text-base sm:text-lg font-serif relative transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95"
    style="background-image: url('{{ asset('images/Crystal2.png') }}');"
  >
    <span
      class="absolute inset-0 bg-center bg-no-repeat rounded-lg filter blur-md opacity-50 pointer-events-none"
      style="background-image: url('{{ asset('images/Crystal2.png') }}');"
    ></span>
    <span class="relative">Explore</span>
  </button>
</div>


