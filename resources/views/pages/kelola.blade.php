<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SC Finance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
                    }
                }
            }
        }
    </script>
    <script>
        // Check if user preference exists
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark')
                localStorage.theme = 'light'
            } else {
                document.documentElement.classList.add('dark')
                localStorage.theme = 'dark'
            }
        }

        // Function to calculate remaining income
        function calculateRemainingIncome() {
            const penghasilan = parseFloat(document.getElementById('penghasilan').value) || 0;
            const tabungan = parseFloat(document.getElementById('total_tabungan').value) || 0;
            const pengeluaran = parseFloat(document.getElementById('pengeluaran').value) || 0;
            
            const remainingIncome = penghasilan - tabungan - pengeluaran;
            document.getElementById('penghasilan').value = Math.max(0, remainingIncome);
        }

        // Function to update income when expenses change
        function updateIncome() {
            const penghasilan = parseFloat(document.getElementById('penghasilan').value) || 0;
            const pengeluaran = parseFloat(document.getElementById('pengeluaran').value) || 0;
            const tabungan = parseFloat(document.getElementById('total_tabungan').value) || 0;
            
            const remainingIncome = penghasilan - pengeluaran - tabungan;
            document.getElementById('penghasilan').value = Math.max(0, remainingIncome);
        }
    </script>
    <style>
        html {
            touch-action: manipulation;
        }
        body {
            min-height: 100vh;
            min-height: -webkit-fill-available;
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    @include('layouts.top')

    <!-- Main Content -->
    <div class="container mx-auto max-w-7xl px-2 sm:px-4 lg:px-8 pt-16">

        <!-- Form Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-3 sm:p-6 shadow">
            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold mb-4 sm:mb-6 text-gray-800 dark:text-white">Tambah Catatan Keuangan</h2>
            
            <form action="{{ route('finances.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label for="penghasilan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penghasilan</label>
                        <input type="number" step="0.01" name="penghasilan" id="penghasilan"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-gray-700 dark:text-gray-200 text-sm sm:text-base">
                    </div>

                    <div>
                        <label for="total_tabungan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Tabungan</label>
                        <input type="number" step="0.01" name="total_tabungan" id="total_tabungan"
                            onchange="calculateRemainingIncome()"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-gray-700 dark:text-gray-200 text-sm sm:text-base">
                    </div>

                    <div>
                        <label for="pengeluaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pengeluaran</label>
                        <input type="number" step="0.01" name="pengeluaran" id="pengeluaran" 
                            onchange="updateIncome()"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-gray-700 dark:text-gray-200 text-sm sm:text-base">
                    </div>
                </div>

                <div>
                    <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                    <textarea name="note" id="note" rows="3" maxlength="1000"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-gray-700 dark:text-gray-200 text-sm sm:text-base"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                        class="w-full sm:w-auto bg-pink-500 dark:bg-pink-600 text-white px-4 sm:px-6 py-2 rounded-md hover:bg-pink-600 dark:hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 text-sm sm:text-base">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- Finances List -->
        <div class="mt-6 sm:mt-8 bg-white dark:bg-gray-800 rounded-lg p-3 sm:p-6 shadow">
            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold mb-4 sm:mb-6 text-gray-800 dark:text-white">Riwayat Keuangan</h2>
            
            <div class="overflow-x-auto -mx-3 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pengguna</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                <th class="hidden sm:table-cell px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pengeluaran</th>
                                <th class="hidden sm:table-cell px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penghasilan</th>
                                <th class="hidden sm:table-cell px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Catatan</th>
                                <th class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $finances = \App\Models\Finance::where('id_users', Auth::id())
                                    ->with('user')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            @endphp
                            
                            @forelse($finances as $finance)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700 dark:text-gray-200">
                                        {{ $finance->user->username }}
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700 dark:text-gray-200">
                                        {{ $finance->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700 dark:text-gray-200">
                                        Rp {{ number_format($finance->total_tabungan, 0, ',', '.') }}
                                    </td>
                                    <td class="hidden sm:table-cell px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700 dark:text-gray-200">
                                        Rp {{ number_format($finance->pengeluaran, 0, ',', '.') }}
                                    </td>
                                    <td class="hidden sm:table-cell px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-700 dark:text-gray-200">
                                        Rp {{ number_format($finance->penghasilan, 0, ',', '.') }}
                                    </td>
                                    <td class="hidden sm:table-cell px-3 sm:px-6 py-4 text-xs sm:text-sm text-gray-700 dark:text-gray-200">
                                        {{ $finance->note }}
                                    </td>
                                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                                        <form action="{{ route('finances.destroy', $finance) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 sm:px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada catatan keuangan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.bottom')
</body>
</html>
