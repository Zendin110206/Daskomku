<!-- resources/views/admin/view-plot.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Manage Shift - Crystal Cavern')

@section('content')
<div 
    class="relative min-h-screen w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6"
>
    <!-- HEADER: Judul & Tombol Back -->
    <div 
        class="mb-8 flex flex-col gap-4 items-center 
               sm:flex-row sm:justify-between sm:items-center"
    >
        <!-- Judul Halaman -->
        <h1 
            class="text-3xl sm:text-4xl md:text-5xl font-im-fell-english
                   text-white text-center sm:text-left"
        >
            View Plots
        </h1>

        <!-- Tombol Back -->
        <div>
            <a 
                href="javascript:history.back()" 
                class="bg-biru-tua text-white rounded-[30px] 
                       px-4 py-3 sm:px-6 sm:py-4 
                       hover:opacity-90 hover:shadow-lg transition
                       text-lg sm:text-2xl font-im-fell-english"
            >
                Back
            </a>
        </div>
    </div>

    <!-- STATISTIC CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- Card: Total Shifts -->
        <div class="bg-custom-gray rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Total Shifts
            </p>
            <p class="text-biru-tua text-5xl sm:text-6xl md:text-7xl font-im-fell-english leading-tight">
                {{ $totalShifts }}
            </p>
        </div>
        <!-- Card: Taken Shifts -->
        <div class="bg-custom-gray rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2 text-center">
                Taken Shifts
            </p>
            <p class="text-biru-tua text-5xl sm:text-6xl md:text-7xl font-im-fell-english leading-tight">
                {{ $takenShifts }}
            </p>
        </div>
        <!-- Card: Haven't Picked -->
        <div class="bg-biru-tua rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Haven't Picked
            </p>
            <p class="text-white text-5xl sm:text-6xl md:text-7xl font-im-fell-english leading-tight">
                {{ $havenTPicked }}
            </p>
        </div>
    </div>

    <!-- TABEL PLOT SHIFT -->
    <div class="bg-custom-gray rounded-[30px] p-6 sm:p-8 shadow-lg">
        <!-- Search & Export Buttons -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-3">
            <!-- Opsi Export (Copy, Excel, PDF, Column Visibility) -->
            <div class="flex flex-wrap items-center gap-2">
                <button 
                    class="bg-biru-tua text-white px-4 py-1 rounded-[30px] 
                           hover:opacity-90 transition text-sm"
                    title="Salin ke Clipboard (dummy)"
                >
                    Copy
                </button>
                <button 
                    class="bg-biru-tua text-white px-4 py-1 rounded-[30px] 
                           hover:opacity-90 transition text-sm"
                    title="Unduh ke Excel (dummy)"
                >
                    Excel
                </button>
                <button 
                    class="bg-biru-tua text-white px-4 py-1 rounded-[30px] 
                           hover:opacity-90 transition text-sm"
                    title="Unduh ke PDF (dummy)"
                >
                    PDF
                </button>
                <button 
                    class="bg-biru-tua text-white px-4 py-1 rounded-[30px] 
                           hover:opacity-90 transition text-sm"
                    title="Atur Kolom Tabel (dummy)"
                >
                    Column Visibility
                </button>
            </div>
            <!-- Bagian Search (manual / JS) -->
            <div class="flex items-center space-x-2">
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Search
                </label>
                <input 
                    type="text" 
                    class="bg-white border border-biru-tua rounded-[30px] px-3 py-1 
                           focus:outline-none focus:ring-1 focus:ring-biru-tua
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
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            No.
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Shift
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Date
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Time
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Quota
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Taken
                        </th>
                        <th 
                            class="py-3 px-3 text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Detail
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($shifts as $index => $shift)
                        <tr class="border-b border-black last:border-b-0">
                            <!-- No. -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $index + 1 }}.
                            </td>
                            <!-- Shift No. -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->shift_no }}
                            </td>
                            <!-- Date -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->date }}
                            </td>
                            <!-- Time -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->time_start }} - {{ $shift->time_end }}
                            </td>
                            <!-- Quota -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->kuota }}
                            </td>
                            <!-- Taken (jumlah CAAS yang milih shift ini) -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->plottingans_count }}
                            </td>
                            <!-- Detail (lihat daftar CAAS) -->
                            <td 
                                class="py-3 px-3 text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                <a 
                                    href="{{ route('admin.view-plot.show', $shift->id) }}"
                                    class="bg-biru-tua text-white px-3 py-1 rounded-[15px] 
                                           hover:opacity-90 hover:shadow-md transition text-sm"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
