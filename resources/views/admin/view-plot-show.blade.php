<!-- resources/views/admin/view-plot-show.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Shift Detail - Crystal Cavern')

@section('content')
<div class="container mx-auto py-6 px-4 sm:px-6 md:px-8 text-white">
    <!-- Judul -->
    <h1 class="text-3xl sm:text-4xl font-im-fell-english mb-6">
        Shift #{{ $shift->id }} Detail
    </h1>

    <!-- Info SHIFT -->
    <div class="bg-biru-tua rounded-2xl p-4 sm:p-6 mb-6 shadow-md">
        <p><strong>Shift No:</strong> {{ $shift->shift_no }}</p>
        <p><strong>Date:</strong> {{ $shift->date }}</p>
        <p><strong>Time:</strong> {{ $shift->time_start }} - {{ $shift->time_end }}</p>
        <p><strong>Quota:</strong> {{ $shift->kuota }}</p>
    </div>

    <!-- Judul Tabel -->
    <h2 class="text-2xl sm:text-3xl font-im-fell-english mb-4">
        CAAS Who Picked This Shift
    </h2>

    <!-- Table CAAS -->
    <div class="bg-custom-gray rounded-2xl p-4 sm:p-6 shadow-md overflow-x-auto">
        <table class="min-w-full border border-black rounded-md overflow-hidden table-auto">
            <!-- Table Head -->
            <thead class="bg-white">
                <tr class="border-b border-black">
                    <th 
                        class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english
                               text-sm sm:text-base md:text-lg text-center"
                    >
                        No.
                    </th>
                    <th 
                        class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english
                               text-sm sm:text-base md:text-lg text-center"
                    >
                        NIM
                    </th>
                    <th 
                        class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english
                               text-sm sm:text-base md:text-lg text-center"
                    >
                        Name
                    </th>
                    <th 
                        class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english
                               text-sm sm:text-base md:text-lg text-center"
                    >
                        Email
                    </th>
                    <th 
                        class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english
                               text-sm sm:text-base md:text-lg text-center"
                    >
                        Major
                    </th>
                    <th 
                        class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english
                               text-sm sm:text-base md:text-lg text-center"
                    >
                        Class
                    </th>
                    <th 
                        class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english
                               text-sm sm:text-base md:text-lg text-center"
                    >
                        Gems
                    </th>
                    <th 
                        class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english
                               text-sm sm:text-base md:text-lg text-center"
                    >
                        Status
                    </th>
                    <th 
                        class="py-3 px-3 text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                    >
                        State
                    </th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="bg-white">
                @forelse($shift->plottingans as $index => $plot)
                    @php
                        $caas = $plot->caas;
                    @endphp
                    <tr class="border-b border-black last:border-b-0">
                        <!-- No -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $index + 1 }}.
                        </td>
                        <!-- NIM -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->nim ?? '-' }}
                        </td>
                        <!-- Name -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->name ?? 'Unknown CAAS Name' }}
                        </td>
                        <!-- Email -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->email ?? '-' }}
                        </td>
                        <!-- Major -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->major ?? '-' }}
                        </td>
                        <!-- Class -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->className ?? '-' }}
                        </td>
                        <!-- Gems -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->gems ?? '-' }}
                        </td>
                        <!-- Status -->
                        <td 
                            class="py-3 px-3 border-r border-black text-center font-im-fell-english"
                            @class([
                                'text-green-600 font-semibold' => isset($caas->status) && strtolower($caas->status) === 'pass',
                                'text-red-600 font-semibold' => isset($caas->status) && strtolower($caas->status) === 'fail',
                                'text-biru-tua' => !in_array(strtolower($caas->status ?? ''), ['pass', 'fail'])
                            ])
                        >
                            {{ $caas->status ?? 'unknown' }}
                        </td>
                        <!-- State -->
                        <td class="py-3 px-3 text-biru-tua text-center">
                            {{ $caas->state ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <!-- Jika tidak ada CAAS sama sekali -->
                    <tr>
                        <td colspan="9" class="py-3 px-3 text-center text-biru-tua">
                            No CAAS assigned yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tombol Back -->
    <div class="mt-6">
        <a 
            href="{{ route('admin.view-plot') }}" 
            class="inline-block bg-biru-tua text-white px-4 py-2 rounded
                   hover:opacity-90 hover:shadow-md transition"
        >
            Back to View Plot
        </a>
    </div>
</div>
@endsection
