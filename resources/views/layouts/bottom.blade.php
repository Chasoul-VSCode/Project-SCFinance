<!-- Bottom Navigation -->
<nav class="fixed bottom-0 w-full bg-white dark:bg-gray-800 border-t dark:border-gray-700">
    <div class="grid grid-cols-3 sm:grid-cols-3 gap-2 sm:gap-4 p-2 sm:p-4">
        <a href="{{ route('home') }}" class="flex flex-col items-center text-pink-500 dark:text-pink-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2 transition-colors">
            <span class="text-lg sm:text-xl">📚</span>
            <span class="text-[10px] sm:text-xs">Home</span>
        </a>
        <a href="{{ route('kelola') }}" class="flex flex-col items-center text-gray-400 dark:text-gray-500 select-none hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2 transition-colors">
            <span class="text-lg sm:text-xl">📊</span>
            <span class="text-[10px] sm:text-xs">Kelola</span>
        </a>
        <a href="{{ route('report') }}" class="flex flex-col items-center text-gray-400 dark:text-gray-500 select-none hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2 transition-colors">
            <span class="text-lg sm:text-xl">📝</span>
            <span class="text-[10px] sm:text-xs">Report</span>
        </a>
    </div>
</nav>