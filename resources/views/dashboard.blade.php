<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.dashboard.title') }} - FST Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        uin: { blue: '#0F265C', yellow: '#FFC700', green: '#009B4C' }
                    }
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

    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded bg-uin-yellow flex items-center justify-center text-uin-blue font-bold border border-uin-blue">F</div>
                    <span class="font-bold text-xl text-uin-blue dark:text-white">FST<span class="text-uin-green">Reads</span></span>
                </div>

                <div class="flex items-center gap-3 sm:gap-6">
                    
                    <div class="flex items-center gap-2 border-r border-gray-200 dark:border-gray-700 pr-4">
                        <div class="flex bg-gray-100 dark:bg-gray-700 rounded-full p-1">
                            <a href="{{ route('lang.switch', 'id') }}" class="px-2 py-0.5 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'id' ? 'bg-uin-blue text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:text-uin-blue' }}">ID</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-0.5 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'en' ? 'bg-uin-blue text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:text-uin-blue' }}">EN</a>
                        </div>
                        
                        <button onclick="toggleTheme()" class="p-1.5 rounded-full text-gray-500 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <svg class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <svg class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </button>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition" title="{{ __('messages.auth.logout') }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.dashboard.my_collection') }}</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('messages.dashboard.collection_desc') }}</p>
            </div>
            <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-uin-blue hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition shadow-md group dark:bg-uin-yellow dark:text-uin-blue dark:hover:bg-yellow-400">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('messages.dashboard.upload_new') }}
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-uin-green p-4 rounded-r shadow-sm flex items-start">
                <svg class="w-5 h-5 text-uin-green mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <div>
                    <h3 class="text-sm font-medium text-green-800 dark:text-green-200">{{ __('messages.dashboard.success') }}</h3>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($books->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
                    
                    <div class="relative w-full pt-[133%] bg-gray-100 dark:bg-gray-700 overflow-hidden">
                        @if($book->cover_path)
                            <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400 dark:text-gray-500">
                                <span class="text-xs">{{ __('messages.dashboard.no_cover') }}</span>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-2 py-1 rounded text-xs font-bold text-uin-blue dark:text-uin-yellow shadow-sm border border-gray-100 dark:border-gray-700">
                            {{ $book->category }}
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 mb-1 group-hover:text-uin-blue dark:group-hover:text-uin-yellow transition" title="{{ $book->title }}">
                            {{ $book->title }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $book->author }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-50 dark:border-gray-700 flex gap-2">
                            <a href="{{ route('books.read', $book->id) }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-uin-green bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                {{ __('messages.dashboard.read') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.dashboard.empty_title') }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('messages.dashboard.empty_desc') }}</p>
                <a href="{{ route('books.create') }}" class="text-uin-blue dark:text-uin-yellow font-bold hover:underline">{{ __('messages.dashboard.empty_action') }} &rarr;</a>
            </div>
        @endif
        
    </main>

    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    </script>
</body>
</html>