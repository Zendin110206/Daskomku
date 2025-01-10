@extends('admin.layouts.app3')

@section('title', 'Manage Announcement - Crystal Cavern')

@push('scripts')
<script>
    function announcementData() {
        return {
            // Data untuk input
            passMessage: '',
            failMessage: '',
            link: '',
            // Toggle menampilkan preview
            showPreview: false,

            // Method "save" => tampilkan preview
            saveAnnouncement() {
                this.showPreview = true;
            }
        }
    }
</script>
@endpush

@section('content')
<div 
    class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-6"
    x-data="announcementData()"
>
    <!-- Judul Halaman -->
    <h1 
        class="text-center text-white text-3xl sm:text-4xl md:text-5xl font-im-fell-english"
    >
        Manage Announcement
    </h1>

    <!-- Container Ber-background (Announcement Input) -->
    <div 
        class="mt-8 bg-ungu-muda rounded-[30px] p-6 sm:p-8"
    >
        <!-- Title -->
        <h2 
            class="text-white text-2xl sm:text-3xl md:text-4xl font-im-fell-english mb-4"
        >
            Announcement
        </h2>
        <!-- Garis putih -->
        <hr class="border-white mb-6" />

        <!-- Pass Message -->
        <div class="mb-6">
            <label 
                for="passMessage"
                class="block text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2"
            >
                Pass Message
            </label>
            <input
                id="passMessage"
                type="text"
                x-model="passMessage"
                class="w-full bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       focus:outline-none focus:ring-2 focus:ring-biru-tua text-base sm:text-lg"
            />
        </div>

        <!-- Fail Message -->
        <div class="mb-6">
            <label 
                for="failMessage"
                class="block text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2"
            >
                Fail Message
            </label>
            <input
                id="failMessage"
                type="text"
                x-model="failMessage"
                class="w-full bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       focus:outline-none focus:ring-2 focus:ring-biru-tua text-base sm:text-lg"
            />
        </div>

        <!-- Link -->
        <div class="mb-6">
            <label 
                for="link"
                class="block text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2"
            >
                Link
            </label>
            <input
                id="link"
                type="text"
                x-model="link"
                class="w-full bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       focus:outline-none focus:ring-2 focus:ring-biru-tua text-base sm:text-lg"
            />
        </div>

        <!-- Tombol Save -->
        <button
            class="bg-white text-biru-tua px-6 sm:px-8 py-2 sm:py-3 
                   rounded-full text-base sm:text-lg md:text-xl font-im-fell-english hover:shadow-md 
                   transition-colors duration-300"
            @click="saveAnnouncement"
        >
            Save
        </button>
    </div>

    <!-- Container Preview (muncul setelah "Save") -->
    <div 
        class="mt-10 bg-biru-tua2 rounded-[30px] p-6 sm:p-8"
        x-show="showPreview"
        x-transition
    >
        <h2 
            class="text-white text-2xl sm:text-3xl md:text-4xl font-im-fell-english mb-4"
        >
            Preview Announcement
        </h2>
        <hr class="border-white mb-6" />

        <!-- Pass Message Preview -->
        <div class="mb-6">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Pass Message
            </p>
            <div
                class="bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       text-biru-tua text-base sm:text-lg"
                x-text="passMessage"
            ></div>
        </div>

        <!-- Fail Message Preview -->
        <div class="mb-6">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Fail Message
            </p>
            <div
                class="bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       text-biru-tua text-base sm:text-lg"
                x-text="failMessage"
            ></div>
        </div>

        <!-- Link Preview -->
        <div class="mb-6">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Link
            </p>
            <div
                class="bg-ungu-keputihan border border-black rounded-[30px] p-3 sm:p-4 
                       text-biru-tua text-base sm:text-lg"
                x-text="link"
            ></div>
        </div>
    </div>
</div>
@endsection
