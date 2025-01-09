@extends('admin.layouts.app3')

@section('title', 'Manage Shift - Crystal Cavern')

@push('scripts')
<script>
    function manageShift() {
        return {
            // ----------------------
            // Data & Pagination
            // ----------------------
            shiftList: [
                // Contoh data (dummy)
                { 
                    id: 1, 
                    shiftNo: '1', 
                    date: '2025-03-10', 
                    timeStart: '08:30', 
                    timeEnd: '10:30', 
                    quota: 20 
                },
                { 
                    id: 2, 
                    shiftNo: '2', 
                    date: '2025-03-11', 
                    timeStart: '13:00', 
                    timeEnd: '15:00', 
                    quota: 15 
                },
                { 
                    id: 3, 
                    shiftNo: '3', 
                    date: '2025-03-12', 
                    timeStart: '09:00', 
                    timeEnd: '11:00', 
                    quota: 25 
                },
            ],
            showEntries: 10,
            searchTerm: '',
            currentPage: 1,

            // ----------------------
            // Modal flags
            // ----------------------
            isResetPlotOpen: false,
            isResetShiftOpen: false,
            isViewPlotOpen: false,

            isAddOpen: false,
            isViewOpen: false,
            isEditOpen: false,
            isDeleteOpen: false,

            // Form input "Add Shift"
            addShiftNo: '',
            addDate: '',
            addTimeStart: '',
            addTimeEnd: '',
            addQuota: '',

            // Data terpilih (untuk View/Edit/Delete)
            selectedShift: null,

            // ----------------------
            // Computed / Getter
            // ----------------------
            get filteredList() {
                // Filter data sesuai kata kunci
                const term = this.searchTerm.toLowerCase().trim();
                if (!term) return this.shiftList;
                return this.shiftList.filter(item =>
                    item.date.toLowerCase().includes(term) ||
                    item.shiftNo.toLowerCase().includes(term) ||
                    item.timeStart.toLowerCase().includes(term) ||
                    item.timeEnd.toLowerCase().includes(term)
                );
            },
            get totalPages() {
                // Total halaman (pagination)
                return Math.ceil(this.filteredList.length / this.showEntries);
            },
            get paginatedData() {
                // Data yang ditampilkan per halaman
                const start = (this.currentPage - 1) * this.showEntries;
                const end = start + this.showEntries;
                return this.filteredList.slice(start, end);
            },
            get showingText() {
                // Teks "Showing x to y of z entries"
                if (this.filteredList.length === 0) {
                    return 'Showing 0 to 0 of 0 entries';
                }
                const start = (this.currentPage - 1) * this.showEntries + 1;
                const end = Math.min(this.currentPage * this.showEntries, this.filteredList.length);
                return `Showing ${start} to ${end} of ${this.filteredList.length} entries`;
            },

            // ----------------------
            // Methods: Pagination
            // ----------------------
            goToPage(page) {
                if (page >= 1 && page <= this.totalPages) {
                    this.currentPage = page;
                }
            },
            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage++;
                }
            },
            prevPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                }
            },

            // ----------------------
            // Methods: Add Shift
            // ----------------------
            resetAddForm() {
                this.addShiftNo = '';
                this.addDate = '';
                this.addTimeStart = '';
                this.addTimeEnd = '';
                this.addQuota = '';
            },
            saveAddShift() {
                const newId = this.shiftList.length
                    ? this.shiftList[this.shiftList.length - 1].id + 1
                    : 1;

                // Tambah data baru ke shiftList
                this.shiftList.push({
                    id: newId,
                    shiftNo: this.addShiftNo || '',
                    date: this.addDate || '2025-01-01',
                    timeStart: this.addTimeStart || '00:00',
                    timeEnd: this.addTimeEnd || '00:00',
                    quota: parseInt(this.addQuota) || 0
                });

                alert(`New Shift #${newId} added.`);
                this.isAddOpen = false;
                this.resetAddForm();
            },

            // ----------------------
            // Methods: Reset
            // ----------------------
            confirmResetPlot() {
                alert('All Plot has been reset (dummy).');
                this.isResetPlotOpen = false;
            },
            confirmResetShift() {
                alert('All Shift data has been reset (dummy).');
                this.isResetShiftOpen = false;
            },

            // ----------------------
            // Methods: View/Edit/Delete
            // ----------------------
            viewShift(shift) {
                this.selectedShift = JSON.parse(JSON.stringify(shift));
                this.isViewOpen = true;
            },
            editShift(shift) {
                this.selectedShift = JSON.parse(JSON.stringify(shift));
                this.isEditOpen = true;
            },
            saveEditShift() {
                // Cari shift di array
                const index = this.shiftList.findIndex(s => s.id === this.selectedShift.id);
                if (index !== -1) {
                    this.shiftList[index] = { ...this.selectedShift };
                    alert(`Shift #${this.selectedShift.id} updated.`);
                }
                this.isEditOpen = false;
                this.selectedShift = null;
            },
            confirmDelete(shift) {
                this.selectedShift = JSON.parse(JSON.stringify(shift));
                this.isDeleteOpen = true;
            },
            deleteShift() {
                // Hapus shift di array
                this.shiftList = this.shiftList.filter(s => s.id !== this.selectedShift.id);
                alert(`Shift #${this.selectedShift.id} erased.`);
                this.isDeleteOpen = false;
                this.selectedShift = null;
            },

            // ----------------------
            // Methods: View Plot (dummy)
            // ----------------------
            viewPlot() {
                alert('View Plot (dummy).');
                this.isViewPlotOpen = false;
            },
        }
    }
</script>
@endpush

@section('content')
<div 
    class="relative w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6"
    x-data="manageShift()"
>
    <!-- Judul Halaman -->
    <h1 class="text-center text-white text-3xl sm:text-4xl md:text-5xl font-[IM_FELL_English] mt-4">
        Manage Shift
    </h1>

    <!-- Tombol utama (4 dalam 1 baris) -->
    <div 
    class="mt-8 bg-[#BAC5E9] rounded-2xl p-6 sm:p-8 w-full px-4"
>
    <!-- Flex: kolom di mobile, baris di layar md+ -->
    <div class="flex flex-col md:flex-row gap-4">
        
        <!-- Reset Plot -->
        <button
            class="flex-1 bg-[#541A1A] text-white font-[IM_FELL_English]
                   rounded-[30px] py-4 sm:py-6 md:py-6
                   text-lg sm:text-2xl md:text-3xl text-center
                   hover:opacity-90 hover:shadow-lg transition"
            @click="isResetPlotOpen = true"
        >
            Reset Plot
        </button>

        <!-- Reset Shift -->
        <button
            class="flex-1 bg-[#1A2254] text-white font-[IM_FELL_English]
                   rounded-[30px] py-4 sm:py-6 md:py-6
                   text-lg sm:text-2xl md:text-3xl text-center
                   hover:opacity-90 hover:shadow-lg transition"
            @click="isResetShiftOpen = true"
        >
            Reset Shift
        </button>

        <!-- View Plot -->
        <button
            class="flex-1 bg-[#1A5421] text-white font-[IM_FELL_English]
                   rounded-[30px] py-4 sm:py-6 md:py-6
                   text-lg sm:text-2xl md:text-3xl text-center
                   hover:opacity-90 hover:shadow-lg transition"
            @click="isViewPlotOpen = true"
        >
            View Plot
        </button>

        <!-- Add Shift -->
        <button
            class="flex-1 bg-custom-green text-white font-[IM_FELL_English]
                   rounded-[30px] py-4 sm:py-6 md:py-6
                   text-lg sm:text-2xl md:text-3xl text-center
                   hover:opacity-90 hover:shadow-lg transition"
            @click="isAddOpen = true"
        >
            Add Shift
        </button>
    </div>
</div>


    <!-- Contoh Statistik -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total Shifts -->
        <div class="bg-[#BAC5E9] rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-[#1A2254] text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2">
                Total Shifts
            </p>
            <p class="text-[#1A2254] text-4xl sm:text-5xl md:text-6xl font-[IM_FELL_English] leading-tight">
                <span x-text="shiftList.length"></span>
            </p>
        </div>
        <!-- Earliest Date -->
        <div class="bg-[#BAC5E9] rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-[#1A2254] text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2">
                Earliest Date
            </p>
            <p class="text-[#1A2254] text-2xl sm:text-3xl md:text-4xl font-[IM_FELL_English] leading-tight">
                <span x-text="shiftList.length ? shiftList[0].date : '-'"></span>
            </p>
        </div>
        <!-- Largest Quota -->
        <div class="bg-[#BAC5E9] rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-[#1A2254] text-xl sm:text-2xl md:text-3xl font-[IM_FELL_English] mb-2">
                Largest Quota
            </p>
            <p class="text-[#1A2254] text-2xl sm:text-3xl md:text-4xl font-[IM_FELL_English] leading-tight">
                <span x-text="Math.max(...shiftList.map(s => s.quota))"></span>
            </p>
        </div>
    </div>

    <!-- Tabel Shift -->
    <div class="mt-8 bg-[#D9D9D9] rounded-2xl p-4 sm:p-6 md:p-8">
        <!-- Show Entries & Search -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
            <!-- Show Entries -->
            <div class="flex items-center space-x-2 mb-3 md:mb-0">
                <label class="text-[#1A2254] text-base sm:text-lg md:text-xl font-[IM_FELL_English]">
                    Show
                </label>
                <input 
                    type="number" 
                    x-model="showEntries"
                    min="1"
                    class="w-16 bg-white border border-black rounded-[10px] p-1 
                           text-center focus:outline-none focus:ring-1 focus:ring-[#1A2254]
                           text-sm sm:text-base"
                >
                <label class="text-[#1A2254] text-base sm:text-lg md:text-xl font-[IM_FELL_English]">
                    Entries
                </label>
            </div>
            <!-- Search -->
            <div class="flex items-center space-x-2">
                <label class="text-[#1A2254] text-base sm:text-lg md:text-xl font-[IM_FELL_English]">
                    Search
                </label>
                <input 
                    type="text" 
                    x-model="searchTerm"
                    class="bg-white border border-black rounded-[30px] px-3 py-1 
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
                        <th class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg">
                            No.
                        </th>
                        <th class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg">
                            Date
                        </th>
                        <th class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg">
                            Shift No.
                        </th>
                        <th class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg">
                            Time
                        </th>
                        <th class="py-3 px-3 border-r border-black text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg">
                            Quota
                        </th>
                        <th class="py-3 px-3 text-[#1A2254]
                                   font-[IM_FELL_English] text-sm sm:text-base md:text-lg">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <template x-for="(shift, i) in paginatedData" :key="shift.id">
                        <tr class="border-b border-black last:border-b-0">
                            <!-- No -->
                            <td class="py-3 px-3 border-r border-black text-[#1A2254]
                                       font-[IM_FELL_English] text-sm sm:text-base">
                                <span x-text="(currentPage - 1) * showEntries + i + 1"></span>.
                            </td>
                            <!-- Date -->
                            <td class="py-3 px-3 border-r border-black text-[#1A2254]
                                       font-[IM_FELL_English] text-sm sm:text-base"
                                x-text="shift.date"
                            ></td>
                            <!-- Shift No -->
                            <td class="py-3 px-3 border-r border-black text-[#1A2254]
                                       font-[IM_FELL_English] text-sm sm:text-base"
                                x-text="shift.shiftNo"
                            ></td>
                            <!-- Time -->
                            <td class="py-3 px-3 border-r border-black text-[#1A2254]
                                       font-[IM_FELL_English] text-sm sm:text-base">
                                <span x-text="shift.timeStart"></span> - 
                                <span x-text="shift.timeEnd"></span>
                            </td>
                            <!-- Quota -->
                            <td class="py-3 px-3 border-r border-black text-[#1A2254]
                                       font-[IM_FELL_English] text-sm sm:text-base"
                                x-text="shift.quota"
                            ></td>
                            <!-- Action -->
                            <td class="py-3 px-3 text-[#1A2254]
                                       font-[IM_FELL_English] text-sm sm:text-base">
                                <div class="flex flex-wrap gap-2">
                                    <button 
                                        class="bg-[#1A5421] rounded-[15px] px-3 py-1 text-white
                                               hover:opacity-90 hover:shadow-md transition"
                                        @click="viewShift(shift)"
                                    >
                                        View
                                    </button>
                                    <button 
                                        class="bg-[#1A2254] rounded-[15px] px-3 py-1 text-white
                                               hover:opacity-90 hover:shadow-md transition"
                                        @click="editShift(shift)"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        class="bg-[#541A1A] rounded-[15px] px-3 py-1 text-white
                                               hover:opacity-90 hover:shadow-md transition"
                                        @click="confirmDelete(shift)"
                                    >
                                        Erase
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Info 'Showing x to y of z entries' -->
        <div class="mt-4 text-sm sm:text-base text-[#1A2254]" x-text="showingText"></div>

        <!-- Navigasi pagination -->
        <div class="mt-2 flex items-center space-x-2 text-sm sm:text-base text-[#1A2254]">
            <button 
                class="px-2 py-1 border rounded disabled:opacity-50"
                :disabled="currentPage <= 1"
                @click="prevPage"
            >
                Previous
            </button>
            <template x-for="page in totalPages" :key="page">
                <button 
                    class="px-2 py-1 border rounded"
                    :class="currentPage === page ? 'bg-[#1A2254] text-white' : ''"
                    @click="goToPage(page)"
                    x-text="page"
                ></button>
            </template>
            <button 
                class="px-2 py-1 border rounded disabled:opacity-50"
                :disabled="currentPage >= totalPages"
                @click="nextPage"
            >
                Next
            </button>
        </div>
    </div>

    <!-- ========================================
         MODALS
    ======================================== -->

    <!-- MODAL: Reset Plot -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isResetPlotOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-[#1A2254] text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isResetPlotOpen = false"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-[IM_FELL_English] mb-4">
                Reset Plot
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6 text-lg">
                Are you sure you want to reset <span class="font-bold">all the plot</span>? 
                This action cannot be undone.
            </p>
            <div class="flex justify-end gap-4">
                <button
                    class="bg-gray-300 text-[#1A2254] px-4 py-2 rounded-2xl
                           hover:opacity-90 transition"
                    @click="isResetPlotOpen = false"
                >
                    Cancel
                </button>
                <button
                    class="bg-[#BAC5E9] text-[#1A2254] px-4 py-2 rounded-2xl
                           hover:opacity-90 transition"
                    @click="confirmResetPlot"
                >
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: Reset Shift -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isResetShiftOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-[#1A2254] text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isResetShiftOpen = false"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-[IM_FELL_English] mb-4">
                Reset Shift
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6 text-lg">
                Are you sure you want to reset <span class="font-bold">all shift data</span>? 
                This action cannot be undone.
            </p>
            <div class="flex justify-end gap-4">
                <button
                    class="bg-gray-300 text-[#1A2254] px-4 py-2 rounded-2xl
                           hover:opacity-90 transition"
                    @click="isResetShiftOpen = false"
                >
                    Cancel
                </button>
                <button
                    class="bg-[#BAC5E9] text-[#1A2254] px-4 py-2 rounded-2xl
                           hover:opacity-90 transition"
                    @click="confirmResetShift"
                >
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: View Plot -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isViewPlotOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-[#1A2254] text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isViewPlotOpen = false"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-[IM_FELL_English] mb-4">
                View Plot
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6 text-lg">
                (Dummy) This is where you would show a plot or schedule visualization.
            </p>
            <div class="flex justify-end">
                <button
                    class="bg-[#BAC5E9] text-[#1A2254] px-4 py-2 rounded-2xl
                           hover:opacity-90 transition"
                    @click="viewPlot"
                >
                    OK
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: Add Shift -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isAddOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-[#1A2254] text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isAddOpen = false; resetAddForm();"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-[IM_FELL_English] mb-4">
                Add Shift
            </h2>
            <hr class="border-white/50 mb-6" />

            <!-- Form Add Shift -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-[#1A2254]">
                <!-- Shift No -->
                <div>
                    <label class="block text-xl mb-1 text-white">Shift No.</label>
                    <input 
                        type="text"
                        class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                        x-model="addShiftNo"
                        placeholder="Misal: 1, 2, 3..."
                    >
                </div>
                <!-- Date -->
                <div>
                    <label class="block text-xl mb-1 text-white">Date</label>
                    <input 
                        type="date"
                        class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                        x-model="addDate"
                    >
                </div>
                <!-- Time Start -->
                <div>
                    <label class="block text-xl mb-1 text-white">Time Start</label>
                    <input 
                        type="time"
                        class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                        x-model="addTimeStart"
                    >
                </div>
                <!-- Time End -->
                <div>
                    <label class="block text-xl mb-1 text-white">Time End</label>
                    <input 
                        type="time"
                        class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                        x-model="addTimeEnd"
                    >
                </div>
                <!-- Quota -->
                <div>
                    <label class="block text-xl mb-1 text-white">Quota</label>
                    <input 
                        type="number"
                        min="0"
                        class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                        x-model="addQuota"
                    >
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button 
                    class="bg-[#BAC5E9] text-[#1A2254] px-6 py-3 rounded-2xl hover:opacity-90 transition"
                    @click="saveAddShift"
                >
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: View Shift (Read-Only) -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isViewOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-[#1A2254] text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isViewOpen = false; selectedShift = null;"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-[IM_FELL_English] mb-4">
                View Shift
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedShift">
                <div class="space-y-3 text-lg">
                    <p><strong>ID:</strong> <span x-text="selectedShift.id"></span></p>
                    <p><strong>Shift No.:</strong> <span x-text="selectedShift.shiftNo"></span></p>
                    <p><strong>Date:</strong> <span x-text="selectedShift.date"></span></p>
                    <p><strong>Time Start:</strong> <span x-text="selectedShift.timeStart"></span></p>
                    <p><strong>Time End:</strong> <span x-text="selectedShift.timeEnd"></span></p>
                    <p><strong>Quota:</strong> <span x-text="selectedShift.quota"></span></p>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL: Edit Shift -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isEditOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-[#1A2254] text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isEditOpen = false; selectedShift = null;"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-[IM_FELL_English] mb-4">
                Edit Shift
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedShift">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-[#1A2254]">
                    <!-- ID (readonly) -->
                    <div>
                        <label class="block text-xl mb-1 text-white">ID</label>
                        <input 
                            type="text"
                            class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                            x-model="selectedShift.id"
                            readonly
                        >
                    </div>
                    <!-- Shift No. -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Shift No.</label>
                        <input 
                            type="text"
                            class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                            x-model="selectedShift.shiftNo"
                        >
                    </div>
                    <!-- Date -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Date</label>
                        <input 
                            type="date"
                            class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                            x-model="selectedShift.date"
                        >
                    </div>
                    <!-- Time Start -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Time Start</label>
                        <input 
                            type="time"
                            class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                            x-model="selectedShift.timeStart"
                        >
                    </div>
                    <!-- Time End -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Time End</label>
                        <input 
                            type="time"
                            class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                            x-model="selectedShift.timeEnd"
                        >
                    </div>
                    <!-- Quota -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Quota</label>
                        <input 
                            type="number"
                            min="0"
                            class="w-full bg-[#D9D9D9] rounded-2xl p-3 text-[#1A2254]"
                            x-model="selectedShift.quota"
                        >
                    </div>
                </div>
            </template>

            <div class="mt-6 flex justify-end">
                <button 
                    class="bg-[#BAC5E9] text-[#1A2254] px-6 py-3 rounded-2xl hover:opacity-90 transition"
                    @click="saveEditShift"
                >
                    Update
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: Confirm Delete -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isDeleteOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-[#1A2254] text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isDeleteOpen = false; selectedShift = null;"
            >
                &times;
            </button>
            <h2 class="text-2xl sm:text-3xl font-[IM_FELL_English] mb-4">
                Are you sure?
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6">
                You are about to <span class="font-semibold text-red-300">delete</span> Shift 
                with ID: <span class="font-bold" x-text="selectedShift?.id"></span>. 
                This action cannot be undone.
            </p>

            <div class="flex justify-end gap-4">
                <button
                    class="bg-gray-300 text-[#1A2254] px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="isDeleteOpen = false; selectedShift = null;"
                >
                    Cancel
                </button>
                <button
                    class="bg-red-600 text-white px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="deleteShift"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
