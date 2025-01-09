@extends('admin.layouts.app3')

@section('title', 'Manage Shift - Crystal Cavern')

@section('content')
<div class="relative min-h-screen w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6">
    <!-- HEADER: Judul & Tombol Back -->
    <div 
        class="mb-8 flex flex-col gap-4 items-center 
               sm:flex-row sm:justify-between sm:items-center"
    >
        <!-- Judul Halaman -->
        <h1 
            class="text-3xl sm:text-4xl md:text-5xl font-[IM_FELL_English]
                   text-white text-center sm:text-left"
        >
            View Plot
        </h1>

        <!-- Tombol Back -->
<div>
    <a 
        href="javascript:history.back()" 
        class="bg-[#1A2254] text-white rounded-[30px] 
               px-4 py-3 sm:px-6 sm:py-4 
               hover:opacity-90 hover:shadow-lg transition
               text-lg sm:text-2xl font-[IM_FELL_English]"
    >
        Back
    </a>
</div>

    </div>

    <!-- STATISTIC CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- Card: Total Shift -->
        <div class="bg-[#D9D9D9] rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-[#1A2254] text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2">
                Total Shift
            </p>
            <p class="text-[#1A2254] text-5xl sm:text-6xl md:text-7xl font-[IM_FELL_English] leading-tight">
                20
            </p>
        </div>
        <!-- Card: Total Already Choose Shift -->
        <div class="bg-[#D9D9D9] rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-[#1A2254] text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2 text-center">
                Total Already Choose Shift
            </p>
            <p class="text-[#1A2254] text-5xl sm:text-6xl md:text-7xl font-[IM_FELL_English] leading-tight">
                100
            </p>
        </div>
        <!-- Card: Not Shifted -->
        <div class="bg-[#1A2254] rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2">
                Not Shifted
            </p>
            <p class="text-white text-5xl sm:text-6xl md:text-7xl font-[IM_FELL_English] leading-tight">
                50
            </p>
        </div>
    </div>

    <!-- TABEL PLOT SHIFT -->
    <div class="bg-[#D9D9D9] rounded-[30px] p-6 sm:p-8 shadow-lg">
        <!-- Search & Export Buttons -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-3">
            <!-- Opsi Export (Copy, Excel, PDF, Column Visibility) -->
            <div class="flex flex-wrap items-center gap-2">
                <button 
                    class="bg-[#1A2254] text-white px-4 py-1 rounded-[30px] 
                           hover:opacity-90 transition text-sm"
                    title="Salin ke Clipboard (dummy)"
                >
                    Copy
                </button>
                <button 
                    class="bg-[#1A2254] text-white px-4 py-1 rounded-[30px] 
                           hover:opacity-90 transition text-sm"
                    title="Unduh ke Excel (dummy)"
                >
                    Excel
                </button>
                <button 
                    class="bg-[#1A2254] text-white px-4 py-1 rounded-[30px] 
                           hover:opacity-90 transition text-sm"
                    title="Unduh ke PDF (dummy)"
                >
                    PDF
                </button>
                <button 
                    class="bg-[#1A2254] text-white px-4 py-1 rounded-[30px] 
                           hover:opacity-90 transition text-sm"
                    title="Atur Kolom Tabel (dummy)"
                >
                    Column Visibility
                </button>
            </div>
            <!-- Bagian Search -->
            <div class="flex items-center space-x-2">
                <label class="text-[#1A2254] text-base sm:text-lg md:text-xl font-[IM_FELL_English]">
                    Search
                </label>
                <input 
                    type="text" 
                    class="bg-white border border-[#1A2254] rounded-[30px] px-3 py-1 
                           focus:outline-none focus:ring-1 focus:ring-[#1A2254]
                           text-sm sm:text-base"
                    placeholder="Search shift..."
                >
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-black rounded-md overflow-hidden table-auto">
                <thead class="bg-white">
                    <tr class="border-b border-black">
                        <th 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg text-center"
                        >
                            No.
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg text-center"
                        >
                            Shift
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg text-center"
                        >
                            Date
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg text-center"
                        >
                            Time
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg text-center"
                        >
                            Quota
                        </th>
                        <th 
                            class="py-3 px-3 text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg text-center"
                        >
                            List
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <!-- Contoh data dummy -->
                    <tr class="border-b border-black last:border-b-0">
                        <td 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base text-center"
                        >
                            1.
                        </td>
                        <td 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base text-center"
                        >
                            Interview 1
                        </td>
                        <td 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base text-center"
                        >
                            18/12/2024
                        </td>
                        <td 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base text-center"
                        >
                            10.00 - 12.00
                        </td>
                        <td 
                            class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base text-center"
                        >
                            5
                        </td>
                        <td 
                            class="py-3 px-3 text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base text-center"
                        >
                            <!-- Tombol lihat detail -->
                            <button 
                                class="bg-[#1A2254] text-white px-3 py-1 rounded-[15px] 
                                       hover:opacity-90 hover:shadow-md transition text-sm"
                            >
                                Detail
                            </button>
                        </td>
                    </tr>
                    <!-- Tambahkan baris lain di sini jika diperlukan -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
