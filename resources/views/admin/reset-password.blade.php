<!-- resources/views/admin/reset-password.blade.php -->
@extends('admin.layouts.app2')

@section('title', 'Login Admin')

@section('content')
<div 
  class="flex flex-col items-center justify-center min-h-screen bg-cover bg-center px-4"
  style="background-image: url('{{ asset('images/Background-1-Admin.png') }}');"
>
    <!-- Kartu Loginnya -->
    <div 
      class="relative bg-[#D9D9D9] rounded-[30px] p-10 shadow-lg w-full max-w-xl mx-auto"
    >
        <!-- Tulisan selamat datang -->
        <h1 
          class="text-center text-[#1A2254] font-im-fell mb-6
                 text-3xl sm:text-4xl md:text-5xl"
        >
            Modify Your Password
        </h1>
        <p 
          class="text-center text-[#1A2254] mb-8
                 text-base sm:text-lg md:text-xl"
        >
            Please enter the Old Password & New Password for minimum 8 characters
        </p>

        <!-- Old Password -->
        <div class="mt-4">
          <label 
            for="old-password" 
            class="block text-[24px] sm:text-[30px] md:text-[36px] text-[#1A2254] mb-2"
          >
            Old Password
          </label>
          <input
            type="text"
            id="old-password"
            name="old-password"
            placeholder="Enter your old password"
            class="block w-full h-[50px] sm:h-[55px] md:h-[60px] rounded-[30px] px-6 
                   text-[#1A2254] focus:outline-none focus:ring-2 
                   focus:ring-[#1A2254]/50 shadow-sm placeholder-gray-400 
                   transition-all text-base sm:text-lg md:text-xl"
          />
        </div>

        <!-- New Password -->
        <div class="mt-6">
          <label
            for="password"
            class="block text-[24px] sm:text-[30px] md:text-[36px] text-[#1A2254] mb-2"
          >
            New Password
          </label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your new password"
            class="block w-full h-[50px] sm:h-[55px] md:h-[60px] rounded-[30px] px-6 
                   text-[#1A2254] focus:outline-none focus:ring-2 
                   focus:ring-[#1A2254]/50 shadow-sm placeholder-gray-400 
                   transition-all text-base sm:text-lg md:text-xl"
          />
        </div>
    
        <!-- Start Button -->
        <div class="flex justify-center mt-8">
            <button 
              class="w-[180px] sm:w-[200px] md:w-[220px] h-[60px] sm:h-[65px] md:h-[70px] 
                     bg-[#1A2254] rounded-[30px] flex items-center justify-center
                     transition duration-300 hover:bg-blue-700"
            >
                <span 
                  class="text-white font-im-fell leading-[40px] sm:leading-[45px] md:leading-[51px]
                         text-xl sm:text-2xl md:text-[40px]"
                >
                    Save
                </span>
            </button>
        </div>
    </div>

    <!-- Footer Text -->
    <div class="mt-8">
        <p 
          class="text-white text-center sm:mt-12
                 text-2xl sm:text-3xl md:text-5xl"
        >
            Discover your light within
        </p>
    </div>
</div>
@endsection
