@extends('admin.layouts.app3')

@section('title', 'Reset Password Admin')

@section('content')
<div 
  class="flex flex-col items-center justify-center min-h-screen px-4 font-im-fell-english"
>
    <!-- Reset Password Card -->
    <div 
      class="relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg 
         rounded-[30px] p-10 mt-[-2rem] shadow-xl w-full max-w-xl mx-auto border border-white/20"
    >
        <!-- Heading -->
        <h1 
          class="text-center text-putih font-im-fell-english mb-6
                 text-3xl sm:text-4xl md:text-5xl"
        >
            Modify Your Password
        </h1>
        <p 
          class="text-center text-putih mb-4
                 text-base sm:text-lg md:text-xl"
        >
            Please enter your old password & new password (min 8 chars) below.
        </p>

        <!-- Notifikasi sukses jika ada -->
        @if (session('status'))
            <div class="mb-4 text-center text-green-400 font-semibold">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form Reset Password -->
        <form action="{{ route('admin.reset-password.update') }}" method="POST">
            @csrf

            <!-- Old Password -->
            <div class="mt-2">
                <label 
                  for="old_password" 
                  class="block text-[24px] sm:text-[30px] md:text-[36px] text-putih mb-2"
                >
                    Old Password
                </label>
                <input
                  type="password"
                  id="old_password"
                  name="old_password"
                  placeholder="Enter your old password"
                  class="block w-full h-[50px] sm:h-[55px] md:h-[60px] rounded-[30px] px-6 
                         text-biru-tua focus:outline-none focus:ring-2 
                         focus:ring-biru-tua/50 shadow-sm placeholder-gray-400 
                         transition-all text-base sm:text-lg md:text-xl"
                  required
                />
                @error('old_password')
                    <p class="text-red-300 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mt-6">
                <label
                  for="password"
                  class="block text-[24px] sm:text-[30px] md:text-[36px] text-putih mb-2"
                >
                    New Password
                </label>
                <input
                  type="password"
                  id="password"
                  name="password"
                  placeholder="Enter your new password"
                  class="block w-full h-[50px] sm:h-[55px] md:h-[60px] rounded-[30px] px-6 
                         text-biru-tua focus:outline-none focus:ring-2 
                         focus:ring-biru-tua/50 shadow-sm placeholder-gray-400 
                         transition-all text-base sm:text-lg md:text-xl"
                  required
                />
                @error('password')
                    <p class="text-red-300 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mt-6">
                <label
                  for="password_confirmation"
                  class="block text-[24px] sm:text-[30px] md:text-[36px] text-putih mb-2"
                >
                    Confirm Password
                </label>
                <input
                  type="password"
                  id="password_confirmation"
                  name="password_confirmation"
                  placeholder="Re-type your new password"
                  class="block w-full h-[50px] sm:h-[55px] md:h-[60px] rounded-[30px] px-6 
                         text-biru-tua focus:outline-none focus:ring-2 
                         focus:ring-biru-tua/50 shadow-sm placeholder-gray-400 
                         transition-all text-base sm:text-lg md:text-xl"
                  required
                />
            </div>
        
            <!-- Submit Button -->
            <div class="flex justify-center mt-8">
                <button 
                  type="submit"
                  class="w-[180px] sm:w-[200px] md:w-[220px] h-[60px] sm:h-[65px] md:h-[70px] 
                         bg-biru-tua rounded-[30px] flex items-center justify-center
                         transition duration-300 hover:bg-blue-700"
                >
                    <span 
                      class="text-white font-im-fell-english leading-[40px] sm:leading-[45px] md:leading-[51px]
                             text-xl sm:text-2xl md:text-[40px]"
                    >
                        Save
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- Footer Text -->
    <div class="mt-16 md:mt-2 lg:mt-4">
        <p 
          class="text-white text-center sm:mt-12
                 text-2xl sm:text-3xl md:text-2xl"
        >
            Discover your light within
        </p>
    </div>
</div>
@endsection
