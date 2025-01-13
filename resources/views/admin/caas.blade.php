@extends('admin.layouts.app')

@section('title', 'Manage CaAs - Crystal Cavern')

@push('scripts')
<script>
async function createCaas(newCaasData) {
    try {
        const response = await fetch('/admin/caas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(newCaasData),
        });

        if (!response.ok) {
            throw new Error('Failed to create CAAS');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function updateCaas(caasId, updatedData) {
    try {
        updatedData._method = "patch";
        const response = await fetch(`/admin/caas/${caasId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(updatedData),
        });

        if (!response.ok) {
            throw new Error('Failed to update CAAS');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function deleteCaas(caasId) {
    try {
        const response = await fetch(`/admin/caas/${caasId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });

        if (!response.ok) {
            throw new Error('Failed to delete CAAS');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function manageCaAs() {
    return {
        caasList: @json($caasList),
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

        // Data untuk form "Set CaAs"
        setNim: '',
        setPassword: '',

        // Data untuk form "Add CaAs"
        addNim: '',
        addName: '',
        addEmail: '',
        addPassword: '',
        addMajor: '',
        addClass: '',
        addGems: '',
        addState: '',
        addStatus: '',

        // Daftar pilihan state & status
        states: [
            'Administration', 
            'Coding & Writing Test', 
            'Interview', 
            'Grouping Task', 
            'Teaching Test', 
            'Upgrading'
        ],
        statuses: ['Pass','Fail'],

        // Data untuk form "Import Excel"
        chosenFile: null,

        // Data yang dipilih untuk View/Edit/Delete
        selectedCaas: null,

        // ----------------------
        // Computed & Getter
        // ----------------------
        get filteredList() {
            const term = this.searchTerm.toLowerCase().trim();
            if (!term) return this.caasList;
            return this.caasList.filter(item =>
                item.nim.toLowerCase().includes(term) ||
                item.name.toLowerCase().includes(term) ||
                item.email.toLowerCase().includes(term) ||
                item.major.toLowerCase().includes(term) ||
                item.className.toLowerCase().includes(term) ||
                item.gems.toLowerCase().includes(term) ||
                item.status.toLowerCase().includes(term) ||
                item.state.toLowerCase().includes(term)
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

        // Reset form "Set CaAs"
        resetSetForm() {
            this.setNim = '';
            this.setPassword = '';
        },
        // Reset form "Add CaAs"
        resetAddForm() {
            this.addNim = '';
            this.addName = '';
            this.addEmail = '';
            this.addPassword = '';
            this.addMajor = '';
            this.addClass = '';
            this.addGems = '';
            this.addState = '';
            this.addStatus = '';
        },
        // Reset file import
        resetImport() {
            this.chosenFile = null;
        },

        // Modal "Set CaAs" -> simpan
        saveSetCaas() {
            // Cari data berdasarkan NIM
            const found = this.caasList.find(item => item.nim == this.setNim);
            if (found) {
                alert(`Password for NIM ${this.setNim} changed to: ${this.setPassword}`);
                // Misal kita perbarui pass di caasList
                found.password = this.setPassword;
            } else {
                alert(`NIM ${this.setNim} not found!`);
            }
            this.isSetOpen = false;
            this.resetSetForm();
        },

        // Modal "Add CaAs" -> simpan
        saveAddCaas() {
            this.caasList.push({
                id: this.caasList.length > 0 
                    ? Math.max(...this.caasList.map(caas => caas.id)) + 1 
                    : 1, // If the list is empty, start with 1
                nim: this.addNim || '000000000000',
                name: this.addName || 'No Name',
                email: this.addEmail || 'No Email',
                major: this.addMajor || 'N/A',
                className: this.addClass || 'N/A',
                gems: this.addGems || 'N/A',
                status: this.addStatus || 'N/A',
                state: this.addState || 'N/A'
            });
            createCaas({
                nim: this.addNim || '000000000000',
                name: this.addName || 'No Name',
                email: this.addEmail || 'No Email',
                major: this.addMajor || 'N/A',
                password: this.addPassword || 'N/A',
                className: this.addClass || 'N/A',
                gems: this.addGems || 'N/A',
                status: this.addStatus || 'N/A',
                state: this.addState || 'N/A'
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
        viewCaas(caas) {
            // Salin data agar aslinya tak terpengaruh
            this.selectedCaas = JSON.parse(JSON.stringify(caas));
            this.isViewOpen = true;
        },

        // 2. EDIT
        editCaas(caas) {
            this.selectedCaas = JSON.parse(JSON.stringify(caas));
            this.isEditOpen = true;
        },
        saveEditCaas() {
            // Temukan index data, lalu update
            const index = this.caasList.findIndex(item => item.nim === this.selectedCaas.nim);
            if (index !== -1) {
                this.caasList[index] = { ...this.selectedCaas };
                updateCaas(this.selectedCaas.id, {
                    name: this.selectedCaas.name,
                    nim: this.selectedCaas.nim,
                    email: this.selectedCaas.email,
                    major: this.selectedCaas.major,
                    className: this.selectedCaas.className,
                    gems: this.selectedCaas.gems,
                    status: this.selectedCaas.status,
                    state: this.selectedCaas.state,
                })
            }
            this.isEditOpen = false;
            this.selectedCaas = null;
        },

        // 3. DELETE (show modal)
        confirmDelete(caas) {
            this.selectedCaas = { ...caas };
            this.isDeleteOpen = true;
        },
        deleteCaas() {
            this.caasList = this.caasList.filter(c => c.nim !== this.selectedCaas.nim);
            deleteCaas(this.selectedCaas.id);
            this.isDeleteOpen = false;
            this.selectedCaas = null;
        },
    }
}
</script>
@endpush

@section('content')
<div 
    class="relative w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6"
    x-data="manageCaAs()"
>
    <!-- Judul Halaman -->
    <h1 class="text-center text-white text-3xl sm:text-4xl md:text-5xl font-im-fell-english mt-4">
        Manage CaAs
    </h1>

    <!-- Tombol utama -->
    <div class="mt-8 bg-abu-abu-keunguan rounded-2xl p-6 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Set CaAs (buka modal) -->
            <button
                class="bg-merah-tua rounded-[30px] py-3 sm:py-4 
                       text-white text-lg sm:text-2xl md:text-3xl font-im-fell-english
                       hover:opacity-90 hover:shadow-lg transition w-full"
                @click="isSetOpen = true"
            >
                Set CaAs
            </button>
            <!-- Add CaAs Account (buka modal) -->
            <button
                class="bg-biru-tua rounded-[30px] py-3 sm:py-4 
                       text-white text-lg sm:text-2xl md:text-3xl font-im-fell-english
                       hover:opacity-90 hover:shadow-lg transition w-full"
                @click="isAddOpen = true"
            >
                Add CaAs Account
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

    <!-- Statistik (Total, Pass, Fail) -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Total
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="caasList.length"></span>
            </p>
        </div>
        <!-- Pass -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Pass
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="caasList.filter(c => c.status.toLowerCase() === 'pass').length"></span>
            </p>
        </div>
        <!-- Fail -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Fail
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="caasList.filter(c => c.status.toLowerCase() === 'fail').length"></span>
            </p>
        </div>
    </div>

    <!-- Tabel Data CaAs -->
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
                        <!-- Kolom No. (index) -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            No.
                        </th>
                        <!-- NIM -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            NIM
                        </th>
                        <!-- Name -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Name
                        </th>
                        <!-- Email -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Email
                        </th>
                        <!-- Major -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Major
                        </th>
                        <!-- Class -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Class
                        </th>
                        <!-- Gems -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Gems
                        </th>
                        <!-- Status -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Status
                        </th>
                        <!-- State -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            State
                        </th>
                        <!-- Action -->
                        <th class="py-3 px-3 text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <!-- Loop data (paginatedData) -->
                    <template x-for="(caas, i) in paginatedData" :key="caas.nim">
                        <tr class="border-b border-black last:border-b-0">
                            <!-- No. (index + 1) -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base">
                                <span x-text="(currentPage - 1) * showEntries + i + 1"></span>.
                            </td>
                            <!-- NIM -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="caas.nim"
                            ></td>
                            <!-- Name -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="caas.name"
                            ></td>
                            <!-- Email -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="caas.email"
                            ></td>
                            <!-- Major -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="caas.major"
                            ></td>
                            <!-- Class -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="caas.className"
                            ></td>
                            <!-- Gems -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="caas.gems"
                            ></td>

                            <!-- Status (warna mencolok) -->
                            <td 
                                class="py-3 px-3 border-r border-black font-im-fell-english text-sm sm:text-base"
                                :class="{
                                    'text-green-600 font-semibold': caas.status.toLowerCase() === 'pass',
                                    'text-red-600 font-semibold': caas.status.toLowerCase() === 'fail',
                                    'text-biru-tua': !['pass','fail'].includes(caas.status.toLowerCase())
                                }"
                                x-text="caas.status"
                            ></td>

                            <!-- State -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base"
                                x-text="caas.state"
                            ></td>

                            <!-- Action Buttons -->
                            <td class="py-3 px-3 text-biru-tua font-im-fell-english text-sm sm:text-base">
                                <div class="flex flex-wrap gap-2">
                                    <button 
                                        class="bg-hijau-tua rounded-[15px] px-3 py-1 text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="viewCaas(caas)"
                                    >
                                        View
                                    </button>
                                    <button 
                                        class="bg-biru-tua rounded-[15px] px-3 py-1 text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="editCaas(caas)"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        class="bg-merah-tua rounded-[15px] px-3 py-1 text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="confirmDelete(caas)"
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
            <!-- Tombol Previous -->
            <button 
                class="px-2 py-1 border rounded disabled:opacity-50"
                :disabled="currentPage <= 1"
                @click="prevPage"
            >
                Previous
            </button>

            <!-- Angka halaman -->
            <template x-for="page in totalPages" :key="page">
                <button 
                    class="px-2 py-1 border rounded"
                    :class="currentPage === page ? 'bg-biru-tua text-white' : ''"
                    @click="goToPage(page)"
                    x-text="page"
                ></button>
            </template>

            <!-- Tombol Next -->
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
         MODAL: Set CaAs
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
                Set CaAs
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="text-xl sm:text-2xl mb-2">NIM</p>
            <input 
                type="text" 
                class="w-full bg-custom-gray rounded-2xl p-4 mb-4 text-biru-tua"
                placeholder="Enter NIM..."
                x-model="setNim"
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
                @click="saveSetCaas"
            >
                Save
            </button>
        </div>
    </div>

    <!-- -----------------------------
         MODAL: Add CaAs
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 translate-y-8"
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
                Add CaAs
            </h2>
            <hr class="border-white/50 mb-6" />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- NIM -->
                <div>
                    <label class="block text-xl mb-1">NIM</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="12-digit NIM..."
                        x-model="addNim"
                    >
                </div>
                <!-- Name -->
                <div>
                    <label class="block text-xl mb-1">Name</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="Enter name..."
                        x-model="addName"
                    >
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-xl mb-1">Email</label>
                    <input 
                        type="email"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="Enter email..."
                        x-model="addEmail"
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
                <!-- Major -->
                <div>
                    <label class="block text-xl mb-1">Major</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="Enter major..."
                        x-model="addMajor"
                    >
                </div>
                <!-- Class -->
                <div>
                    <label class="block text-xl mb-1">Class</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="Enter class..."
                        x-model="addClass"
                    >
                </div>
                <!-- Gems -->
                <div>
                    <label class="block text-xl mb-1">Gems</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        placeholder="Enter gems..."
                        x-model="addGems"
                    >
                </div>
                <!-- State (select) -->
                <div>
                    <label class="block text-xl mb-1">State</label>
                    <select 
                        class="w-full bg-abu-abu3 rounded-2xl p-3 text-biru-tua"
                        x-model="addState"
                    >
                        <option value="" disabled>Select state...</option>
                        <template x-for="st in states" :key="st">
                            <option :value="st" x-text="st"></option>
                        </template>
                    </select>
                </div>
                <!-- Status (select) -->
                <div class="sm:col-span-2">
                    <label class="block text-xl mb-1">Status</label>
                    <select 
                        class="w-full bg-abu-abu3 rounded-2xl p-3 text-biru-tua"
                        x-model="addStatus"
                    >
                        <option value="" disabled>Select status...</option>
                        <template x-for="sts in statuses" :key="sts">
                            <option :value="sts" x-text="sts"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <button 
                    class="bg-abu-abu-keunguan text-biru-tua px-6 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="saveAddCaas"
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
                Format file: (NIM, Name, Email, Major, Class, etc)
            </p>
            <div class="bg-custom-gray rounded-2xl p-4 sm:p-6 mb-4 text-biru-tua">
                <p>NIM, Name, Major, Email, Class ...</p>
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
         MODAL: View CaAs (Read-Only)
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isViewOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isViewOpen = false; selectedCaas = null;"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                View CaAs
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedCaas">
                <div class="space-y-3 text-lg">
                    <p><strong>NIM:</strong> <span x-text="selectedCaas.nim"></span></p>
                    <p><strong>Name:</strong> <span x-text="selectedCaas.name"></span></p>
                    <p><strong>Email:</strong> <span x-text="selectedCaas.email"></span></p>
                    <p><strong>Major:</strong> <span x-text="selectedCaas.major"></span></p>
                    <p><strong>Class:</strong> <span x-text="selectedCaas.className"></span></p>
                    <p><strong>Gems:</strong> <span x-text="selectedCaas.gems"></span></p>
                    <p>
                        <strong>Status:</strong>
                        <span 
                            :class="{
                                'text-green-400 font-semibold': selectedCaas.status?.toLowerCase() === 'pass',
                                'text-red-400 font-semibold': selectedCaas.status?.toLowerCase() === 'fail'
                            }"
                            x-text="selectedCaas.status"
                        ></span>
                    </p>
                    <p><strong>State:</strong> <span x-text="selectedCaas.state"></span></p>
                </div>
            </template>
        </div>
    </div>

    <!-- -----------------------------
         MODAL: Edit CaAs
         ----------------------------- -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 translate-y-8"
        x-show="isEditOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-xl relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isEditOpen = false; selectedCaas = null;"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Edit CaAs
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedCaas">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- NIM (readonly, bisa dibuka jika mau) -->
                    <div>
                        <label class="block text-xl mb-1">NIM</label>
                        <input 
                            type="text" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedCaas.nim"
                            readonly
                        >
                    </div>
                    <!-- Name -->
                    <div>
                        <label class="block text-xl mb-1">Name</label>
                        <input 
                            type="text" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedCaas.name"
                        >
                    </div>
                    <!-- Email -->
                    <div>
                        <label class="block text-xl mb-1">Email</label>
                        <input 
                            type="email" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedCaas.email"
                        >
                    </div>
                    <!-- Major -->
                    <div>
                        <label class="block text-xl mb-1">Major</label>
                        <input 
                            type="text" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedCaas.major"
                        >
                    </div>
                    <!-- Class -->
                    <div>
                        <label class="block text-xl mb-1">Class</label>
                        <input 
                            type="text" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedCaas.className"
                        >
                    </div>
                    <!-- Gems -->
                    <div>
                        <label class="block text-xl mb-1">Gems</label>
                        <input 
                            type="text" 
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="selectedCaas.gems"
                        >
                    </div>
                    <!-- Status -->
                    <div>
                        <label class="block text-xl mb-1">Status</label>
                        <select 
                            class="w-full bg-abu-abu3 rounded-2xl p-3 text-biru-tua"
                            x-model="selectedCaas.status"
                        >
                            <template x-for="sts in statuses" :key="sts">
                                 <option 
                                    x-bind:value="sts" 
                                    x-text="sts"
                                    x-bind:selected="sts === selectedCaas.status"
                                ></option>
                            </template>
                        </select>
                    </div>
                    <!-- State -->
                    <div>
                        <label class="block text-xl mb-1">State</label>
                        <select 
                            class="w-full bg-abu-abu3 rounded-2xl p-3 text-biru-tua"
                            x-model="selectedCaas.state"
                        >
                            <template x-for="st in states" :key="st">
                                 <option
                                    x-bind:value="st" 
                                    x-text="st"
                                    x-bind:selected="st === selectedCaas.state"
                                ></option>
                            </template>
                        </select>
                    </div>
                </div>
            </template>

            <div class="mt-6">
                <button 
                    class="bg-abu-abu-keunguan text-biru-tua px-6 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="saveEditCaas"
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
                @click="isDeleteOpen = false; selectedCaas = null;"
            >
                &times;
            </button>

            <h2 class="text-2xl sm:text-3xl font-im-fell-english mb-4">
                Are you sure?
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6">
                You are about to <span class="font-semibold text-red-300">delete</span> CaAs 
                with NIM: <span class="font-bold" x-text="selectedCaas?.nim"></span>. 
                This action cannot be undone.
            </p>

            <div class="flex justify-end gap-4">
                <button
                    class="bg-gray-300 text-biru-tua px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="isDeleteOpen = false; selectedCaas = null;"
                >
                    Cancel
                </button>
                <button
                    class="bg-red-600 text-white px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="deleteCaas"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
