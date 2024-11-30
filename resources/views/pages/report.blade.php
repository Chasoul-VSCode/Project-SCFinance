<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SC Finance - Report</title>
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
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
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

    <div class="pt-16 px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pb-20">
            @php
                $finances = \App\Models\Finance::where('id_users', Auth::id())
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            @forelse($finances as $finance)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ $finance->user->username }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $finance->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Total Tabungan:</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-100">
                                Rp {{ number_format($finance->total_tabungan, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Pengeluaran:</span>
                            <span class="font-semibold text-red-500 dark:text-red-400">
                                Rp {{ number_format($finance->pengeluaran, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Penghasilan:</span>
                            <span class="font-semibold text-green-500 dark:text-green-400">
                                Rp {{ number_format($finance->penghasilan, 0, ',', '.') }}
                            </span>
                        </div>

                        @if($finance->note)
                            <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Catatan:</span><br>
                                    {{ $finance->note }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full flex justify-center items-center h-[50vh]">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada catatan keuangan.</p>
                </div>
            @endforelse
        </div>
    </div>

    @include('layouts.bottom')
</body>
</html>
