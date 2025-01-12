@extends('admin.layouts.app')

@section('title', 'Manage Announcement - Crystal Cavern')

@section('content')
<div 
    class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-6"
    x-data="{
        passMessage: '{{ $pass }}',
        failMessage: '{{ $fail }}',
        link: '{{ $link }}',
        showPreview: false,
        checkUpdate() {
            
            const oneMinuteAgo = Date.now() - 10000; // Current time minus 1 minute
            if ({{ $lastUpdated }} && {{ $lastUpdated }} * 1000 >= oneMinuteAgo) {
                
                this.showPreview = true;
            }
        }
    }"
    x-init="checkUpdate()"
>
    <!-- Page Title -->
    <h1 
        class="text-center text-white text-3xl sm:text-4xl md:text-5xl font-[IM_FELL_English]"
    >
        Manage Announcement
    </h1>

    <!-- Form Container -->
    <div 
        class="mt-8 bg-ungu-muda rounded-[30px] p-6 sm:p-8"
    >
        <!-- Title -->
        <h2 
            class="text-white text-2xl sm:text-3xl md:text-4xl font-[IM_FELL_English] mb-4"
        >
            Announcement
        </h2>
        <hr class="border-white mb-6" />

        <!-- Announcement Form -->
        <form 
            action="{{ route('admin.announcement.update', ['announcement' => 1]) }}" 
            method="POST"
        >
            @csrf
            @method('patch')

            <input 
                type="hidden" 
                name="stage_id" 
                value="1" 
            />

            <!-- Pass Message -->
            <div class="mb-6">
                <label 
                    for="passMessage"
                    class="block text-white text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2"
                >
                    Pass Message
                </label>
                <input
                    id="passMessage"
                    name="success_message"
                    type="text"
                    x-model="passMessage"
                    class="w-full bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                           focus:outline-none focus:ring-2 focus:ring-biru-tua text-base sm:text-2xl"
                    required
                />
            </div>

            <!-- Fail Message -->
            <div class="mb-6">
                <label 
                    for="failMessage"
                    class="block text-white text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2"
                >
                    Fail Message
                </label>
                <input
                    id="failMessage"
                    name="fail_message"
                    type="text"
                    x-model="failMessage"
                    class="w-full bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                           focus:outline-none focus:ring-2 focus:ring-biru-tua text-base sm:text-2xl"
                    required
                />
            </div>

            <!-- Link -->
            <div class="mb-6">
                <label 
                    for="link"
                    class="block text-white text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2"
                >
                    Link
                </label>
                <input
                    id="link"
                    name="link"
                    type="text"
                    x-model="link"
                    class="w-full bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                           focus:outline-none focus:ring-2 focus:ring-biru-tua text-base sm:text-2xl"
                />
            </div>

            <!-- Save Button -->
            <div class="text-center">
                <button
                    type="submit"
                    class="bg-white text-biru-tua px-6 sm:px-8 py-2 sm:py-3 
                           rounded-full text-base sm:text-2xl md:text-xl font-[IM_FELL_English] hover:shadow-md 
                           transition-colors duration-300"
                >
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Container -->
    <div 
        class="mt-10 bg-biru-tua2 rounded-[30px] p-6 sm:p-8"
        x-show="showPreview"
        x-transition
    >
        <h2 
            class="text-white text-2xl sm:text-3xl md:text-4xl font-[IM_FELL_English] mb-4"
        >
            Preview Announcement
        </h2>
        <hr class="border-white mb-6" />

        <!-- Pass Message Preview -->
        <div class="mb-6">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2">
                Pass Message
            </p>
            <div
                class="bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       text-biru-tua text-base sm:text-2xl"
                x-text="passMessage"
            ></div>
        </div>

        <!-- Fail Message Preview -->
        <div class="mb-6">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2">
                Fail Message
            </p>
            <div
                class="bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       text-biru-tua text-base sm:text-2xl"
                x-text="failMessage"
            ></div>
        </div>

        <!-- Link Preview -->
        <div class="mb-6">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2">
                Link
            </p>
            <div
                class="bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       text-biru-tua text-base sm:text-2xl"
                x-text="link"
            > </div>
        </div>
    </div>
</div>
@endsection
