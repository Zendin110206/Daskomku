@extends('admin.layouts.app3')

@section('title', 'Manage Gems - Crystal Cavern')

@push('scripts')
<script>
function manageGems() {
    return {
        // ----------------------
        // Data & Pagination
        // ----------------------
        gemsList: [
            {
                id: 1,
                name: 'Emerald',
                description: 'Greenish gem with energy.',
                quota: 10,
                image: ''
            },
            {
                id: 2,
                name: 'Sapphire',
                description: 'Blue gem with watery aura.',
                quota: 7,
                image: ''
            },
            {
                id: 3,
                name: 'Ruby',
                description: 'Red gem blazing with fire.',
                quota: 12,
                image: ''
            },
        ],
        showEntries: 10,
        searchTerm: '',
        currentPage: 1,

        // ----------------------
        // Modal flags
        // ----------------------
        isAddOpen: false,
        isViewOpen: false,
        isEditOpen: false,
        isDeleteOpen: false,

        // Data form "Add Gem"
        addName: '',
        addDescription: '',
        addQuota: '',
        addImage: null,

        // Data terpilih (View/Edit/Delete)
        selectedGem: null,

        // Temporary holder for "Edit" image
        editImage: null,

        // ----------------------
        // Computed / Getter
        // ----------------------
        get filteredList() {
            const term = this.searchTerm.toLowerCase().trim();
            if (!term) return this.gemsList;
            return this.gemsList.filter(item =>
                item.name.toLowerCase().includes(term) ||
                item.description.toLowerCase().includes(term)
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
        // Methods: Add Gem
        // ----------------------
        resetAddForm() {
            this.addName = '';
            this.addDescription = '';
            this.addQuota = '';
            this.addImage = null;
        },
        handleAddImage(event) {
            const file = event.target.files[0];
            if (!file) {
                this.addImage = null;
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                this.addImage = e.target.result; // Data URL
            };
            reader.readAsDataURL(file);
        },
        saveAddGem() {
            const newId = this.gemsList.length
                ? this.gemsList[this.gemsList.length - 1].id + 1
                : 1;
            this.gemsList.push({
                id: newId,
                name: this.addName || 'No Name',
                description: this.addDescription || 'No Description',
                quota: parseInt(this.addQuota) || 0,
                image: this.addImage || ''
            });
            alert(`New Gem #${newId} added.`);
            this.isAddOpen = false;
            this.resetAddForm();
        },

        // ----------------------
        // Methods: View/Edit/Delete
        // ----------------------
        viewGem(gem) {
            this.selectedGem = JSON.parse(JSON.stringify(gem));
            this.isViewOpen = true;
        },
        editGem(gem) {
            // Salin data gem ke selectedGem
            this.selectedGem = JSON.parse(JSON.stringify(gem));
            // Set editImage = null (belum upload)
            this.editImage = null;
            this.isEditOpen = true;
        },
        handleEditImage(event) {
            const file = event.target.files[0];
            if (!file) {
                this.editImage = null;
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                this.editImage = e.target.result; 
            };
            reader.readAsDataURL(file);
        },
        saveEditGem() {
            const index = this.gemsList.findIndex(g => g.id === this.selectedGem.id);
            if (index !== -1) {
                // Jika user upload gambar baru, gantikan image lama
                if (this.editImage) {
                    this.selectedGem.image = this.editImage;
                }
                this.gemsList[index] = { ...this.selectedGem };
                alert(`Gem #${this.selectedGem.id} updated.`);
            }
            this.isEditOpen = false;
            this.selectedGem = null;
        },
        confirmDelete(gem) {
            this.selectedGem = { ...gem };
            this.isDeleteOpen = true;
        },
        deleteGem() {
            this.gemsList = this.gemsList.filter(g => g.id !== this.selectedGem.id);
            alert(`Gem #${this.selectedGem.id} erased.`);
            this.isDeleteOpen = false;
            this.selectedGem = null;
        },
    }
}
</script>
@endpush

@section('content')
<div 
    class="relative w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6"
    x-data="manageGems()"
>
    <!-- Header / Judul Halaman -->
    <h1 class="text-center text-white text-3xl sm:text-4xl md:text-5xl font-im-fell-english mt-4">
        Manage Gems
    </h1>

    <!-- Tombol utama (1 tombol: Add Gem) -->
    <div class="mt-8 bg-abu-abu-keunguan rounded-2xl p-6 sm:p-8">
        <div class="flex justify-center items-center">
            <button
                class="bg-biru-tua rounded-[30px] py-3 sm:py-4 
                       text-white text-lg sm:text-2xl md:text-3xl font-im-fell-english
                       hover:opacity-90 hover:shadow-lg transition w-full max-w-xs"
                @click="isAddOpen = true"
            >
                Add Gem
            </button>
        </div>
    </div>

    <!-- Statistik (opsional) -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Total
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="gemsList.length"></span>
            </p>
        </div>
        <!-- Highest Quota -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Highest Quota
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="Math.max(...gemsList.map(g => g.quota))"></span>
            </p>
        </div>
        <!-- Lowest Quota -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Lowest Quota
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="Math.min(...gemsList.map(g => g.quota))"></span>
            </p>
        </div>
    </div>

    <!-- Tabel Data Gems -->
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
                    placeholder="Search gem..."
                >
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-black rounded-md overflow-hidden table-auto">
                <!-- Thead -->
                <thead class="bg-white">
                    <tr class="border-b border-black">
                        <!-- No. -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            No.
                        </th>
                        <!-- Gem Name -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Name
                        </th>
                        <!-- Image -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Image
                        </th>
                        <!-- Description -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Description
                        </th>
                        <!-- Quota -->
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Quota
                        </th>
                        <!-- Action -->
                        <th class="py-3 px-3 text-biru-tua font-im-fell-english 
                                   text-sm sm:text-base md:text-lg">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <!-- Loop data (paginatedData) -->
                    <template x-for="(gem, i) in paginatedData" :key="gem.id">
                        <tr class="border-b border-black last:border-b-0">
                            <!-- No. -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base">
                                <span x-text="(currentPage - 1) * showEntries + i + 1"></span>.
                            </td>
                            <!-- Gem Name -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="gem.name"
                            ></td>
                            <!-- Image (thumbnail) -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base">
                                <template x-if="gem.image">
                                    <img 
                                        :src="gem.image" 
                                        alt="Gem Image" 
                                        class="h-16 w-16 object-cover rounded-md border"
                                    />
                                </template>
                                <template x-if="!gem.image">
                                    <span class="text-gray-400 italic">No Image</span>
                                </template>
                            </td>
                            <!-- Description -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="gem.description"
                            ></td>
                            <!-- Quota -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="gem.quota"
                            ></td>
                            <!-- Action -->
                            <td class="py-3 px-3 text-biru-tua font-im-fell-english text-sm sm:text-base">
                                <div class="flex flex-wrap gap-2">
                                    <button 
                                        class="bg-hijau-tua rounded-[15px] px-3 py-1 
                                               text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="viewGem(gem)"
                                    >
                                        View
                                    </button>
                                    <button 
                                        class="bg-biru-tua rounded-[15px] px-3 py-1 
                                               text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="editGem(gem)"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        class="bg-merah-tua rounded-[15px] px-3 py-1 
                                               text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="confirmDelete(gem)"
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

    <!-- =============================
         MODALS
    ============================= -->

    <!-- MODAL: Add Gem -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isAddOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isAddOpen = false; resetAddForm();"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Add Gem
            </h2>
            <hr class="border-white/50 mb-6" />

            <!-- Form Add -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-biru-tua">
                <!-- Name -->
                <div>
                    <label class="block text-xl mb-1 text-white">Name</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3"
                        x-model="addName"
                        placeholder="Gem name..."
                    >
                </div>
                <!-- Quota -->
                <div>
                    <label class="block text-xl mb-1 text-white">Quota</label>
                    <input 
                        type="number"
                        min="0"
                        class="w-full bg-custom-gray rounded-2xl p-3"
                        x-model="addQuota"
                        placeholder="Enter quantity..."
                    >
                </div>
                <!-- Description -->
                <div class="sm:col-span-2">
                    <label class="block text-xl mb-1 text-white">Description</label>
                    <textarea 
                        class="w-full bg-custom-gray rounded-2xl p-3 h-24"
                        x-model="addDescription"
                        placeholder="Describe the gem..."
                    ></textarea>
                </div>
                <!-- Image -->
                <div class="sm:col-span-2">
                    <label class="block text-xl mb-1 text-white">Image</label>
                    <input 
                        type="file"
                        accept="image/*"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        @change="handleAddImage($event)"
                    >
                </div>
            </div>

            <!-- Save -->
            <div class="mt-6 flex justify-end">
                <button 
                    class="bg-abu-abu-keunguan text-biru-tua px-6 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="saveAddGem"
                >
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: View Gem -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isViewOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isViewOpen = false; selectedGem = null;"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                View Gem
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedGem">
                <div class="space-y-3 text-lg">
                    <p><strong>ID:</strong> <span x-text="selectedGem.id"></span></p>
                    <p><strong>Name:</strong> <span x-text="selectedGem.name"></span></p>
                    <p><strong>Description:</strong> <span x-text="selectedGem.description"></span></p>
                    <p><strong>Quota:</strong> <span x-text="selectedGem.quota"></span></p>
                    <p>
                        <strong>Image:</strong>
                        <template x-if="selectedGem.image">
                            <img 
                                :src="selectedGem.image" 
                                alt="Gem Image" 
                                class="mt-2 h-24 w-24 object-cover rounded-md border"
                            />
                        </template>
                        <template x-if="!selectedGem.image">
                            <span class="text-gray-200 italic">No Image</span>
                        </template>
                    </p>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL: Edit Gem -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isEditOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isEditOpen = false; selectedGem = null;"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Edit Gem
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedGem">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-biru-tua">
                    <!-- ID (readonly) -->
                    <div>
                        <label class="block text-xl mb-1 text-white">ID</label>
                        <input 
                            type="text"
                            class="w-full bg-custom-gray rounded-2xl p-3"
                            x-model="selectedGem.id"
                            readonly
                        >
                    </div>
                    <!-- Name -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Name</label>
                        <input 
                            type="text"
                            class="w-full bg-custom-gray rounded-2xl p-3"
                            x-model="selectedGem.name"
                        >
                    </div>
                    <!-- Quota -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Quota</label>
                        <input 
                            type="number"
                            min="0"
                            class="w-full bg-custom-gray rounded-2xl p-3"
                            x-model="selectedGem.quota"
                        >
                    </div>
                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label class="block text-xl mb-1 text-white">Description</label>
                        <textarea 
                            class="w-full bg-custom-gray rounded-2xl p-3 h-24"
                            x-model="selectedGem.description"
                        ></textarea>
                    </div>
                    <!-- Preview Gambar Lama (jika ada) -->
                    <div class="sm:col-span-2">
                        <p class="text-white text-xl mb-2">Current Image:</p>
                        <template x-if="selectedGem.image">
                            <img 
                                :src="selectedGem.image"
                                alt="Gem Image"
                                class="h-24 w-24 object-cover rounded-md border mb-2"
                            />
                        </template>
                        <template x-if="!selectedGem.image">
                            <span class="text-gray-200 italic">No Image</span>
                        </template>
                    </div>
                    <!-- Upload Baru (untuk Ganti Gambar) -->
                    <div class="sm:col-span-2">
                        <label class="block text-xl mb-1 text-white">Update Image (Optional)</label>
                        <input 
                            type="file"
                            accept="image/*"
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            @change="handleEditImage($event)"
                        >
                    </div>
                </div>
            </template>

            <div class="mt-6 flex justify-end">
                <button 
                    class="bg-abu-abu-keunguan text-biru-tua px-6 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="saveEditGem"
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
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isDeleteOpen = false; selectedGem = null;"
            >
                &times;
            </button>
            <h2 class="text-2xl sm:text-3xl font-im-fell-english mb-4">
                Are you sure?
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6">
                You are about to <span class="font-semibold text-red-300">delete</span> Gem 
                with ID: <span class="font-bold" x-text="selectedGem?.id"></span>. 
                This action cannot be undone.
            </p>

            <div class="flex justify-end gap-4">
                <button
                    class="bg-gray-300 text-biru-tua px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="isDeleteOpen = false; selectedGem = null;"
                >
                    Cancel
                </button>
                <button
                    class="bg-red-600 text-white px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="deleteGem"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
