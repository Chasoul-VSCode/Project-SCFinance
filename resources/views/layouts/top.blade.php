    <!-- Top Navigation -->
    <nav class="bg-pink-300 dark:bg-pink-900 p-4 fixed w-full top-0 z-50">
            <div class="flex justify-between items-center">
             
                <div>
                    <span class="text-white">{{ Auth::user()->username }}</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="toggleDarkMode()" class="bg-white dark:bg-gray-800 text-pink-500 px-4 py-1 rounded-full text-sm">
                        <span class="dark:hidden">🌙</span>
                        <span class="hidden dark:inline">☀️</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-white dark:bg-gray-800 text-pink-500 px-4 py-1 rounded-full text-sm">Logout</button>
                    </form>
                </div>
            </div>
        </nav>