<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.library.title') }} - FST Library</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { uin: { blue: '#0F265C', yellow: '#FFC700', green: '#009B4C' } }
                }
            }
        }
    </script>

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen font-sans text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 shadow-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded bg-uin-yellow flex items-center justify-center text-uin-blue font-bold border border-uin-blue">F</div>
                    <span class="font-bold text-xl text-uin-blue dark:text-white">Pustaka<span class="text-uin-green">FST</span></span>
                </div>

                <div class="flex items-center gap-4">
                    
                    <div class="hidden sm:flex bg-gray-100 dark:bg-gray-700 rounded-full p-1">
                        <a href="{{ route('lang.switch', 'id') }}" class="px-3 py-1 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'id' ? 'bg-uin-blue text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:text-uin-blue' }}">ID</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'en' ? 'bg-uin-blue text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:text-uin-blue' }}">EN</a>
                    </div>

                    <button onclick="toggleTheme()" class="p-2 rounded-full text-gray-500 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <svg class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>

                    <a href="{{ route('dashboard') }}" class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-uin-blue dark:text-gray-400 dark:hover:text-white transition">
                        <span>&larr;</span> {{ __('messages.library.back') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.library.header_title') }}</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">{{ __('messages.library.header_desc') }}</p>
            </div>

            <div class="relative w-full md:w-96 group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg id="search-icon" class="h-5 w-5 text-gray-400 group-focus-within:text-uin-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <svg id="loading-icon" class="animate-spin h-5 w-5 text-uin-blue hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
                
                <input type="text" 
                       id="search-input"
                       placeholder="{{ __('messages.library.search_place') }}" 
                       class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-uin-blue focus:border-uin-blue sm:text-sm transition shadow-sm"
                       autocomplete="off">
            </div>
        </div>

        <div id="books-container">
            @include('components.books-list')
        </div>

    </main>

    <script>
        // 1. Theme Toggle
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }

        // 2. Live Search Logic
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const booksContainer = document.getElementById('books-container');
            const searchIcon = document.getElementById('search-icon');
            const loadingIcon = document.getElementById('loading-icon');
            let timeout = null;

            searchInput.addEventListener('input', function() {
                searchIcon.classList.add('hidden');
                loadingIcon.classList.remove('hidden');
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    const query = this.value;
                    fetch(`{{ route('books.index') }}?search=${query}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.text())
                    .then(html => {
                        booksContainer.innerHTML = html;
                        searchIcon.classList.remove('hidden');
                        loadingIcon.classList.add('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        searchIcon.classList.remove('hidden');
                        loadingIcon.classList.add('hidden');
                    });
                }, 500);
            });
        });
    </script>

</body>
</html>