@extends('admin.layouts.app')

@section('title', 'Manage Asisten - Crystal Cavern')

@push('scripts')
<script>
async function createAsisten(newAsistenData) {
    try {
        const response = await fetch('/admin/asisten', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(newAsistenData),
        });

        if (!response.ok) {
            const errorData = await response.json(); // Get the error message from the server
            throw new Error(errorData.error || 'Failed to create Asisten');
        }
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

async function updateAsisten(asistenId, updatedData) {
    try {
        updatedData._method = "patch";
        const response = await fetch(`/admin/asisten/${asistenId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(updatedData),
        });

        if (!response.ok) {
            throw new Error('Failed to update Asisten');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function deleteAsisten(AsistenId) {
    try {
        const response = await fetch(`/admin/asisten/${AsistenId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });

        if (!response.ok) {
            throw new Error('Failed to delete Asisten');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function manageAsisten() {
    return {
        // ----------------------
        // Data & Pagination
        // ----------------------
        asistenList: @json($asistenList),
        showEntries: 10,
        searchTerm: '',
        currentPage: 1,

        // ----------------------
        // Modal flags
        // ----------------------
        isSetOpen: false,
        isAddOpen: false,
        isImportOpen: false,

        // Modal untuk View / Edit / Delete
        isViewOpen: false,
        isEditOpen: false,
        isDeleteOpen: false,

        // Data untuk form "Set Asisten"
        setKode: '',
        setPassword: '',

        // Data untuk form "Add Asisten"
        addKode: '',
        addName: '',
        addDivisi: '',
        addPassword: '',

        // (Tidak perlu states/statuses, cukup divisi)

        // Data untuk form "Import Excel"
        chosenFile: null,

        // Data yang dipilih untuk View/Edit/Delete
        selectedAsisten: null,

        // ----------------------
        // Computed & Getter
        // ----------------------
        get filteredList() {
            const term = this.searchTerm.toLowerCase().trim();
            if (!term) return this.asistenList;
            return this.asistenList.filter(item =>
                item.kodeAsisten.toLowerCase().includes(term) ||
                item.namaLengkap.toLowerCase().includes(term) ||
                item.divisi.toLowerCase().includes(term)
            );
        },
        get totalPages() {
            return Math.ceil(this.filteredList.length / this.showEntries);
        },
        get paginatedData() {
            const start = (this.currentPage - 1) * this.showEntries;
            const end = start + this.showEntries;
            return this.filteredList.slice(start, end);
        },
        get showingText() {
            if (this.filteredList.length === 0) {
                return 'Showing 0 to 0 of 0 entries';
            }
            const start = (this.currentPage - 1) * this.showEntries + 1;
            const end = Math.min(this.currentPage * this.showEntries, this.filteredList.length);
            return `Showing ${start} to ${end} of ${this.filteredList.length} entries`;
        },

        // Statistik Divisi (sekadar contoh: Academic & Laboratory)
        get totalAcademic() {
            return this.asistenList.filter(a => a.divisi.toLowerCase() === 'academic').length;
        },
        get totalLab() {
            return this.asistenList.filter(a => a.divisi.toLowerCase() === 'laboratory').length;
        },

        // ----------------------
        // Methods
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

        // Reset form "Set Asisten"
        resetSetForm() {
            this.setKode = '';
            this.setPassword = '';
        },
        // Reset form "Add Asisten"
        resetAddForm() {
            this.addKode = '';
            this.addName = '';
            this.addDivisi = '';
            this.addPassword = '';
        },
        // Reset file import
        resetImport() {
            this.chosenFile = null;
        },

        // Modal "Set Asisten" -> simpan
        saveSetAsisten() {
            // Cari data berdasarkan kodeAsisten
            const found = this.asistenList.find(item => item.kodeAsisten == this.setKode);
            if (found) {
                alert(`Password for Kode ${this.setKode} changed to: ${this.setPassword}`);
            } else {
                alert(`Kode Asisten ${this.setKode} not found!`);
            }
            this.isSetOpen = false;
            this.resetSetForm();
        },

        // Modal "Add Asisten" -> simpan
        saveAddAsisten() {
            createAsisten({
                kodeAsisten: this.addKode,
                namaLengkap: this.addName || '',
                divisi: this.addDivisi || '',
                password: this.addPassword,
            });
            this.asistenList.push({
                id: this.asistenList.length > 0
                        ? Math.max(...this.asistenList.map(asisten => asisten.id)) + 1
                        : 2, // If the list is empty, start with 2
                kodeAsisten: this.addKode || 'AS000',
                namaLengkap: this.addName || 'No Name',
                password: this.addPassword || 'pwDefault',
                divisi: this.addDivisi || 'Other'
            });
            this.isAddOpen = false;
            this.resetAddForm();
        },

        // Modal "Import Excel" -> simpan
        saveImport() {
            alert('File imported (dummy).');
            this.isImportOpen = false;
            this.resetImport();
        },

        // ----------------------
        // View / Edit / Delete
        // ----------------------
        // 1. VIEW
        viewAsisten(asisten) {
            this.selectedAsisten = JSON.parse(JSON.stringify(asisten));
            this.isViewOpen = true;
        },

        // 2. EDIT
        editAsisten(asisten) {
            this.selectedAsisten = JSON.parse(JSON.stringify(asisten));
            this.isEditOpen = true;
        },
        saveEditAsisten() {
            const index = this.asistenList.findIndex(item => item.kodeAsisten === this.selectedAsisten.kodeAsisten);
            if (index !== -1) {
                updateAsisten(this.selectedAsisten.id, {
                    kodeAsisten: this.selectedAsisten.kodeAsisten,
                    namaLengkap: this.selectedAsisten.namaLengkap || '',
                    divisi: this.selectedAsisten.divisi || ''
                })
                this.asistenList[index] = { ...this.selectedAsisten };
            }
            this.isEditOpen = false;
            this.selectedAsisten = null;
        },

        // 3. DELETE (show modal)
        confirmDelete(asisten) {
            this.selectedAsisten = { ...asisten };
            this.isDeleteOpen = true;
        },
        deleteAsisten() {
            this.asistenList = this.asistenList.filter(a => a.kodeAsisten !== this.selectedAsisten.kodeAsisten);
            deleteAsisten(this.selectedAsisten.id);
            this.isDeleteOpen = false;
            this.selectedAsisten = null;
        },
    }
}
</script>
@endpush

@section('content')
<div 
    class="relative w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6"
    x-data="manageAsisten()"
>
    <!-- Judul Halaman -->
    <h1 class="text-center text-white text-3xl sm:text-4xl md:text-5xl font-im-fell-english mt-4">
        Manage Asisten
    </h1>

    <!-- Tombol utama -->
    <div class="mt-8 bg-abu-abu-keunguan rounded-2xl p-6 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Set Asisten (buka modal) -->
            <button
                class="bg-merah-tua rounded-[30px] py-3 sm:py-4 
                       text-white text-lg sm:text-2xl md:text-3xl font-im-fell-english
                       hover:opacity-90 hover:shadow-lg transition w-full"
                @click="isSetOpen = true"
            >
                Set Asisten
            </button>
            <!-- Add Asisten (buka modal) -->
            <button
                class="bg-biru-tua rounded-[30px] py-3 sm:py-4 
                       text-white text-lg sm:text-2xl md:text-3xl font-im-fell-english
                       hover:opacity-90 hover:shadow-lg transition w-full"
                @click="isAddOpen = true"
            >
                Add Asisten Account
            </button>
            <!-- Import Excel (buka modal) -->
            <button
                class="bg-hijau-tua rounded-[30px] py-3 sm:py-4 
                       text-white text-lg sm:text-2xl md:text-3xl font-im-fell-english
                       hover:opacity-90 hover:shadow-lg transition w-full"
                @click="isImportOpen = true"
            >
                Import Excel
            </button>
        </div>
    </div>

    <!-- Statistik (Total, Academic, Laboratory) -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Total
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="asistenList.length"></span>
            </p>
        </div>
        <!-- Academic -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Academic
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="totalAcademic"></span>
            </p>
        </div>
        <!-- Laboratory -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Laboratory
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="totalLab"></span>
            </p>
        </div>
    </div>

    <!-- Tabel Data Asisten -->
    <div class="mt-8 bg-custom-gray rounded-2xl p-4 sm:p-6 md:p-8">
        <!-- Show Entries & Search -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
            <!-- Show Entries -->
            <div class="flex items-center space-x-2 mb-3 md:mb-0">
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Show
                </label>
                <input 
                    type="number" 
                    x-model="showEntries"
                    min="1"
                    class="w-16 bg-white border border-black rounded-[10px] p-1 
                           text-center focus:outline-none focus:ring-1 focus:ring-biru-tua text-sm sm:text-base"
                >
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Entries
                </label>
            </div>
            <!-- Search -->
            <div class="flex items-center space-x-2">
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Search
                </label>
                <input 
                    type="text" 
                    x-model="searchTerm"
                    class="bg-white border border-black rounded-[30px] px-3 py-1 
                           focus:outline-none focus:ring-1 focus:ring-biru-tua text-sm sm:text-base"
                    placeholder="Type anything..."
                >
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-black rounded-md overflow-hidden table-auto">
                <!-- Thead -->
                <thead class="bg-white">
                    <tr class="border-b border-black">
                        <!-- Kolom No. -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            No.
                        </th>
                        <!-- Kode Asisten -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Kode Asisten
                        </th>
                        <!-- Nama Lengkap -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Nama Lengkap
                        </th>
                        <!-- Divisi -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Divisi
                        </th>
                        <!-- Action -->
                        <th class="py-3 px-3 text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <template x-for="(asisten, i) in paginatedData" :key="asisten.kodeAsisten">
                        <tr class="border-b border-black last:border-b-0">
                            <!-- No. -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base">
                                <span x-text="(currentPage - 1) * showEntries + i + 1"></span>.
                            </td>
                            <!-- Kode Asisten -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="asisten.kodeAsisten"
                            ></td>
                            <!-- Nama Lengkap -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="asisten.namaLengkap"
                            ></td>
                            <!-- Divisi -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="asisten.divisi"
                            ></td>
                            <!-- Action -->
                            <td class="py-3 px-3 text-biru-tua font-im-fell-english text-sm sm:text-base">
                                <div class="flex flex-wrap gap-2">
                                    <button 
                                        class="bg-hijau-tua rounded-[15px] px-3 py-1 text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="viewAsisten(asisten)"
                                    >
                                        View
                                    </button>
                                    <button 
                                        class="bg-biru-tua rounded-[15px] px-3 py-1 text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="editAsisten(asisten)"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        class="bg-merah-tua rounded-[15px] px-3 py-1 text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="confirmDelete(asisten)"
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
        <div class="mt-4 text-sm sm:text-base text-biru-tua" x-text="showingText"></div>

        <!-- Navigasi pagination -->
        <div class="mt-2 flex items-center space-x-2 text-sm sm:text-base text-biru-tua">
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
                    :class="currentPage === page ? 'bg-biru-tua text-white' : ''"
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

    <!-- -----------------------------
         MODAL: Set Asisten
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isSetOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isSetOpen = false; resetSetForm();"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Set Asisten
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="text-xl sm:text-2xl mb-2">Kode Asisten</p>
            <input 
                type="text" 
                class="w-full bg-custom-gray rounded-2xl p-4 mb-4 text-biru-tua"
                placeholder="Enter Kode Asisten..."
                x-model="setKode"
            >

            <p class="text-xl sm:text-2xl mb-2">New Password</p>
            <input 
                type="password" 
                class="w-full bg-custom-gray rounded-2xl p-4 mb-6 text-biru-tua"
                placeholder="Enter new password..."
                x-model="setPassword"
            >

            <button 
                class="bg-abu-abu2 text-biru-tua px-6 py-3 rounded-2xl hover:opacity-90 transition"
                @click="saveSetAsisten"
            >
                Save
            </button>
        </div>
    </div>

    <!-- -----------------------------
         MODAL: Add Asisten
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isAddOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-xl relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isAddOpen = false; resetAddForm();"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Add Asisten
            </h2>
            <hr class="border-white/50 mb-6" />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Kode Asisten -->
                <div>
                    <label class="block text-xl mb-1">Kode Asisten</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="e.g. AS001..."
                        x-model="addKode"
                    >
                </div>
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xl mb-1">Nama Lengkap</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="Enter full name..."
                        x-model="addName"
                    >
                </div>
                <!-- Divisi -->
                <div>
                    <label class="block text-xl mb-1">Divisi</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="Academic / Laboratory / etc."
                        x-model="addDivisi"
                    >
                </div>
                <!-- Password -->
                <div>
                    <label class="block text-xl mb-1">Password</label>
                    <input 
                        type="password"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="Enter password..."
                        x-model="addPassword"
                    >
                </div>
            </div>

            <div class="mt-6">
                <button 
                    class="bg-abu-abu-keunguan text-biru-tua px-6 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="saveAddAsisten"
                >
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- -----------------------------
         MODAL: Import Excel
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isImportOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isImportOpen = false; resetImport();"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Import Excel
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="text-xl sm:text-2xl mb-2">
                Format file: (Kode Asisten, Nama Lengkap, Divisi, etc.)
            </p>
            <div class="bg-custom-gray rounded-2xl p-4 sm:p-6 mb-4 text-biru-tua">
                <p>Kode, Nama, Divisi...</p>
            </div>

            <!-- Pilih File -->
            <p class="text-xl sm:text-2xl mb-2">Choose File</p>
            <label class="inline-block mb-4">
                <div 
                    class="bg-biru-tua border border-white py-2 px-4 
                            rounded-2xl cursor-pointer hover:opacity-90 inline-block"
                >
                    <span x-text="chosenFile ? chosenFile.name : 'No File Chosen'"></span>
                </div>
                <input 
                    type="file" 
                    class="hidden"
                    accept=".xlsx,.xls,.csv"
                    @change="chosenFile = $event.target.files[0]"
                >
            </label>

            <button 
                class="bg-abu-abu-keunguan text-biru-tua px-6 py-3 rounded-2xl hover:opacity-90 transition"
                @click="saveImport"
            >
                Import
            </button>
        </div>
    </div>

    <!-- -----------------------------
         MODAL: View Asisten (Read-Only)
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isViewOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isViewOpen = false; selectedAsisten = null;"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                View Asisten
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedAsisten">
                <div class="space-y-3 text-lg">
                    <p><strong>Kode Asisten:</strong> <span x-text="selectedAsisten.kodeAsisten"></span></p>
                    <p><strong>Nama Lengkap:</strong> <span x-text="selectedAsisten.namaLengkap"></span></p>
                    <p><strong>Divisi:</strong> <span x-text="selectedAsisten.divisi"></span></p>
                </div>
            </template>
        </div>
    </div>

    <!-- -----------------------------
         MODAL: Edit Asisten
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isEditOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-xl relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isEditOpen = false; selectedAsisten = null;"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Edit Asisten
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedAsisten">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Kode Asisten (readonly) -->
                    <div>
                        <label class="block text-xl mb-1">Kode Asisten</label>
                        <input 
                            type="text" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedAsisten.kodeAsisten"
                            readonly
                        >
                    </div>
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xl mb-1">Nama Lengkap</label>
                        <input 
                            type="text" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedAsisten.namaLengkap"
                        >
                    </div>
                    <!-- Divisi -->
                    <div>
                        <label class="block text-xl mb-1">Divisi</label>
                        <input 
                            type="text" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedAsisten.divisi"
                        >
                    </div>
                </div>
            </template>

            <div class="mt-6">
                <button 
                    class="bg-abu-abu-keunguan text-biru-tua px-6 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="saveEditAsisten"
                >
                    Update
                </button>
            </div>
        </div>
    </div>

    <!-- -----------------------------
         MODAL: Confirm Delete
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isDeleteOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isDeleteOpen = false; selectedAsisten = null;"
            >
                &times;
            </button>

            <h2 class="text-2xl sm:text-3xl font-im-fell-english mb-4">
                Are you sure?
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6">
                You are about to <span class="font-semibold text-red-300">delete</span> Asisten 
                with Kode: <span class="font-bold" x-text="selectedAsisten?.kodeAsisten"></span>. 
                This action cannot be undone.
            </p>

            <div class="flex justify-end gap-4">
                <button
                    class="bg-gray-300 text-biru-tua px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="isDeleteOpen = false; selectedAsisten = null;"
                >
                    Cancel
                </button>
                <button
                    class="bg-red-600 text-white px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="deleteAsisten"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
