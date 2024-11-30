<!-- Main Content -->
<div class="pt-16 px-4">

    <!-- Date Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow mb-4">
        <div class="flex justify-between items-center mb-4">
            <button class="text-gray-400 dark:text-gray-500">&lt;</button>
            <span class="text-gray-700 dark:text-gray-300">{{ now()->format('n/Y') }}</span>
            <button class="text-gray-400 dark:text-gray-500">&gt;</button>
        </div>
        
        @php
            $finances = \App\Models\Finance::with('user')
                ->where('id_users', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            
            $total_tabungan = $finances->sum('total_tabungan');
            $total_penghasilan = $finances->sum('penghasilan');
            $total_pengeluaran = $finances->sum('pengeluaran');
        @endphp

        <div class="grid grid-cols-3 gap-4">
            <div class="text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Tabungan</p>
                <p class="font-bold dark:text-white">Rp{{ number_format($total_tabungan, 0, ',', '.') }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Penghasilan</p>
                <p class="font-bold text-green-500 dark:text-green-400">Rp{{ number_format($total_penghasilan, 0, ',', '.') }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Pengeluaran</p>
                <p class="font-bold text-red-500 dark:text-red-400">Rp{{ number_format($total_pengeluaran, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- All Finances -->
    @php
        $userTotals = \App\Models\Finance::with('user')
            ->selectRaw('id_users, SUM(total_tabungan) as total')
            ->groupBy('id_users')
            ->get();
            
        // Get max total for scaling
        $maxTotal = $userTotals->max('total') ?: 1;

        // Get total savings for progress bar
        $totalTabungan = $total_tabungan;
        $target = 10000000;
        $percentage = min(($totalTabungan / $target) * 100, 100);
    @endphp

    <!-- Progress Bar -->
    <div class="mt-8 px-4">
        <div class="bg-pink-100 dark:bg-pink-800 rounded-lg p-4">
            <div class="flex justify-between mb-2">
                <span class="text-sm text-gray-700 dark:text-gray-200">Target Tabungan</span>
                <span class="text-sm text-gray-700 dark:text-gray-200">
                    Rp {{ number_format($totalTabungan, 0, ',', '.') }} / Rp {{ number_format($target, 0, ',', '.') }}
                </span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                <div class="bg-pink-500 dark:bg-pink-400 h-4 rounded-full transition-all duration-500" 
                     style="width: {{ $percentage }}%">
                </div>
            </div>
            <div class="mt-1 text-right">
                <span class="text-sm text-gray-600 dark:text-gray-300">{{ number_format($percentage, 1) }}%</span>
            </div>
        </div>
    </div>
    @if($userTotals->isEmpty())
        <!-- Empty State -->
        <div class="w-full h-[calc(100vh-20rem)] flex items-center justify-center">
            <div class="text-center">
                <div class="inline-block p-4 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4">
                    <div class="hamster">
                        <div class="hamster__body">
                            <div class="hamster__head">
                                <div class="hamster__ear"></div>
                                <div class="hamster__eye"></div>
                                <div class="hamster__nose"></div>
                            </div>
                            <div class="hamster__limb hamster__limb--fr"></div>
                            <div class="hamster__limb hamster__limb--fl"></div>
                            <div class="hamster__limb hamster__limb--br"></div>
                            <div class="hamster__limb hamster__limb--bl"></div>
                            <div class="hamster__tail"></div>
                        </div>
                    </div>
                </div>
                <p class="text-gray-500 dark:text-gray-400">Tidak ada catatan dalam periode saat ini</p>
            </div>
        </div>
    @else
        <!-- User Totals List -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full px-4 sm:px-6 lg:px-8 h-[calc(100vh-10rem)] overflow-y-auto">
            @foreach($userTotals as $userTotal)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow aspect-[2/4] flex flex-col justify-between items-center p-4 transform transition-all duration-300 hover:scale-105 hover:shadow-lg relative overflow-hidden">
                @php
                    $level = 1;
                    $hamsterClass = '';
                    
                    if($userTotal->total > 5000000) {
                        $level = 6;
                        $hamsterClass = 'hamster--car';
                    } elseif($userTotal->total > 1000000) {
                        $level = 5;
                        $hamsterClass = 'hamster--suit';
                    } elseif($userTotal->total > 100000) {
                        $level = 4;
                        $hamsterClass = 'hamster--glasses';
                    } elseif($userTotal->total > 50000) {
                        $level = 3;
                        $hamsterClass = 'hamster--brown';
                    } elseif($userTotal->total > 10000) {
                        $level = 2;
                        $hamsterClass = 'hamster--brown-head';
                    } else {
                        $hamsterClass = 'hamster--white';
                    }
                    
                    $scale = min(($userTotal->total / $maxTotal) * 1.2 + 0.8, 1.5);
                @endphp
                
                <div class="w-full">
                    <span class="px-3 py-1 bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 rounded-full text-sm">
                        Level {{ $level }}
                    </span>
                </div>

                <div class="flex-grow flex items-center justify-center transform transition-all duration-500 hover:scale-110 cursor-pointer" 
                     style="transform: scale({{ $scale }})">
                    <div class="hamster {{ $hamsterClass }}">
                        <div class="hamster__body">
                            <div class="hamster__head">
                                <div class="hamster__ear"></div>
                                <div class="hamster__eye"></div>
                                <div class="hamster__nose"></div>
                                @if($userTotal->total > 100000)
                                <div class="hamster__glasses"></div>
                                @endif
                            </div>
                            <div class="hamster__limb hamster__limb--fr"></div>
                            <div class="hamster__limb hamster__limb--fl"></div>
                            <div class="hamster__limb hamster__limb--br"></div>
                            <div class="hamster__limb hamster__limb--bl"></div>
                            <div class="hamster__tail"></div>
                            @if($userTotal->total > 1000000)
                            <div class="hamster__suit"></div>
                            <div class="hamster__briefcase"></div>
                            @endif
                            @if($userTotal->total > 5000000)
                            <div class="hamster__car"></div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="text-center w-full mt-auto">
                    <p class="font-semibold dark:text-white text-lg mb-2">{{ $userTotal->user->username }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Total Tabungan</p>
                    <p class="font-bold dark:text-white">Rp{{ number_format($userTotal->total, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <style>
    .hamster {
        width: 40px;
        height: 40px;
        position: relative;
        display: inline-block;
    }

    .hamster__body {
        background: #f7d08a;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        position: relative;
        animation: hamsterBody 3s ease-in-out infinite;
        box-shadow: inset -5px -5px 0 rgba(0,0,0,0.1);
    }

    .hamster--white .hamster__body,
    .hamster--white .hamster__head {
        background: #ffffff;
    }

    .hamster--brown-head .hamster__body {
        background: #f7d08a;
    }
    
    .hamster--brown-head .hamster__head {
        background: #c17f59;
    }

    .hamster--brown .hamster__body,
    .hamster--brown .hamster__head {
        background: #c17f59;
    }

    .hamster__head {
        width: 60%;
        height: 60%;
        border-radius: 50%;
        position: absolute;
        top: -20%;
        left: 20%;
        box-shadow: inset -3px -3px 0 rgba(0,0,0,0.1);
    }

    .hamster__glasses {
        border: 2px solid #000;
        width: 70%;
        height: 30%;
        border-radius: 10px;
        position: absolute;
        top: 40%;
        left: 15%;
    }

    .hamster__suit {
        background: #2c3e50;
        width: 100%;
        height: 50%;
        position: absolute;
        bottom: 0;
        border-radius: 50%;
    }

    .hamster__briefcase {
        background: #34495e;
        width: 30%;
        height: 30%;
        position: absolute;
        bottom: -20%;
        right: -30%;
        border-radius: 5px;
    }

    .hamster__car {
        background: #e74c3c;
        width: 200%;
        height: 60%;
        position: absolute;
        bottom: -30%;
        left: -50%;
        border-radius: 10px;
    }

    .hamster__ear {
        background: #f0c078;
        width: 25%;
        height: 30%;
        border-radius: 50% 50% 0 0;
        position: absolute;
        top: -10%;
        left: 35%;
        transform-origin: bottom center;
        animation: earWiggle 1s ease-in-out infinite;
    }

    .hamster__eye {
        background: #000;
        width: 15%;
        height: 15%;
        border-radius: 50%;
        position: absolute;
        top: 40%;
        left: 60%;
        animation: blink 3s ease-in-out infinite;
    }

    .hamster__nose {
        background: #c17f59;
        width: 20%;
        height: 20%;
        border-radius: 50%;
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translateX(-50%);
    }

    .hamster__limb {
        width: 15%;
        height: 35%;
        position: absolute;
        border-radius: 25px;
    }

    .hamster--white .hamster__limb {
        background: #ffffff;
    }

    .hamster--brown .hamster__limb,
    .hamster--brown-head .hamster__limb {
        background: #f7d08a;
    }

    .hamster__limb--fr { top: 35%; left: -5%; transform: rotate(-30deg); }
    .hamster__limb--fl { top: 35%; right: -5%; transform: rotate(30deg); }
    .hamster__limb--br { bottom: 15%; left: -5%; transform: rotate(30deg); }
    .hamster__limb--bl { bottom: 15%; right: -5%; transform: rotate(-30deg); }

    .hamster__tail {
        background: #f0c078;
        width: 15%;
        height: 35%;
        border-radius: 25px;
        position: absolute;
        bottom: 25%;
        left: 50%;
        transform: rotate(30deg);
        transform-origin: top center;
        animation: tailWag 1s ease-in-out infinite;
    }

    @keyframes hamsterBody {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-2px); }
    }

    @keyframes blink {
        0%, 90%, 100% { transform: scaleY(1); }
        95% { transform: scaleY(0.1); }
    }

    @keyframes earWiggle {
        0%, 100% { transform: rotate(0); }
        50% { transform: rotate(-5deg); }
    }

    @keyframes tailWag {
        0%, 100% { transform: rotate(30deg); }
        50% { transform: rotate(40deg); }
    }

    .hamster:hover .hamster__body {
        animation: hamsterJump 0.5s ease-in-out infinite;
    }

    @keyframes hamsterJump {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    </style>
</div>

<!-- Add Transaction Button -->
<a href="{{ route('finances.index') }}" class="fixed right-6 bottom-20 bg-pink-500 dark:bg-pink-600 text-white p-3 rounded-full shadow-lg">
    <span class="text-xl">✏️</span>
</a>
