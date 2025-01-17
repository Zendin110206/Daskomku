<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Test Alpine Modal</title>
    <!-- Pastikan load Alpine v3 -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50">
    <div x-data="{ showModal: false }" class="p-6">
        <!-- Tombol buka modal -->
        <button @click="showModal = true" class="bg-blue-600 text-white p-2 rounded">
            Open Modal
        </button>

        <!-- Modal -->
        <div 
            class="fixed inset-0 bg-black/50 flex items-center justify-center"
            x-show="showModal"
            style="display: none;"         <!-- tambahkan agar pasti tersembunyi diawal -->
            x-transition
        >
            <div class="bg-white p-6 rounded shadow">
                <p>Modal Content Here...</p>
                <button 
                    class="mt-4 bg-red-500 text-white py-1 px-3 rounded"
                    @click="showModal = false"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</body>
</html>
