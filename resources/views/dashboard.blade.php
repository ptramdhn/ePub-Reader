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
                    
                    <div class="hidden sm:flex bg-gray-100 dark:bg-gray-700 p-1 rounded-lg mr-2">
                        <a href="{{ route('dashboard.mode', 'reader') }}" 
                           class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ $mode === 'reader' ? 'bg-white dark:bg-gray-600 text-uin-blue dark:text-white shadow-sm' : 'text-gray-500 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            {{ __('messages.dashboard.mode_reader') }}
                        </a>
                        <a href="{{ route('dashboard.mode', 'creator') }}" 
                           class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ $mode === 'creator' ? 'bg-white dark:bg-gray-600 text-uin-blue dark:text-white shadow-sm' : 'text-gray-500 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            {{ __('messages.dashboard.mode_creator') }}
                        </a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('dashboard.mode', 'admin') }}" 
                               class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ $mode === 'admin' ? 'bg-uin-blue text-white shadow-sm' : 'text-gray-500 hover:text-gray-900 dark:hover:text-gray-300' }}">
                                Administrator
                            </a>
                        @endif
                    </div>

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
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                @if($mode === 'creator') {{ __('messages.dashboard.mode_creator') }}
                                @elseif($mode === 'admin') Administrator
                                @else {{ __('messages.dashboard.mode_reader') }} @endif
                            </div>
                        </div>
                        
                        <a href="{{ route('profile.edit') }}" class="p-2 text-gray-400 hover:text-uin-blue dark:hover:text-white transition" title="Edit Profil">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition" title="Logout">
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
                @if($mode === 'creator')
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.dashboard.creator_title') }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('messages.dashboard.creator_desc') }}</p>
                @elseif($mode === 'admin')
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.dashboard.admin_title') }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('messages.dashboard.admin_desc') }}</p>
                @else
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.dashboard.reader_title') }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('messages.dashboard.reader_desc') }}</p>
                @endif
            </div>

            <div class="flex gap-3">
                <div class="sm:hidden flex bg-gray-100 dark:bg-gray-700 p-1 rounded-lg">
                    <a href="{{ route('dashboard.mode', 'reader') }}" class="px-2 py-1 text-xs font-bold rounded {{ $mode === 'reader' ? 'bg-white shadow' : 'text-gray-500' }}">R</a>
                    <a href="{{ route('dashboard.mode', 'creator') }}" class="px-2 py-1 text-xs font-bold rounded {{ $mode === 'creator' ? 'bg-white shadow' : 'text-gray-500' }}">C</a>
                    @if(Auth::user()->is_admin) <a href="{{ route('dashboard.mode', 'admin') }}" class="px-2 py-1 text-xs font-bold rounded {{ $mode === 'admin' ? 'bg-white shadow' : 'text-gray-500' }}">A</a> @endif
                </div>

                @if($mode === 'creator')
                    <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-uin-blue hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition shadow-md group dark:bg-uin-yellow dark:text-uin-blue dark:hover:bg-yellow-400">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        {{ __('messages.dashboard.upload_new') }}
                    </a>
                @endif
            </div>
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


        @if($mode === 'admin')
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center md:items-start">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase mb-1">{{ __('messages.dashboard.stat_users') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</h2>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center md:items-start">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase mb-1">{{ __('messages.dashboard.stat_total_upload') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_uploads'] }}</h2>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center md:items-start">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase mb-1">{{ __('messages.dashboard.stat_approved') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-full bg-green-100 text-green-600 dark:bg-green-900/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['approved'] }}</h2>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center md:items-start">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase mb-1">{{ __('messages.dashboard.stat_rejected') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-full bg-red-100 text-red-600 dark:bg-red-900/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['rejected'] }}</h2>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white">{{ __('messages.dashboard.review_queue') }}</h3>
                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">{{ $books->count() }} Pending</span>
                </div>
                
                @if($books->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Uploader</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($books as $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($book->cover_path)
                                                    <img class="h-10 w-10 rounded object-cover" src="{{ asset('storage/' . $book->cover_path) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center text-xs">No Img</div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $book->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $book->category }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $book->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $book->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('books.read', $book->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-2">Preview</a>
                                            
                                            <form action="{{ route('admin.books.approve', $book->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 font-bold">Approve</button>
                                            </form>
                                            
                                            <form action="{{ route('admin.books.reject', $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak buku ini?')">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 ml-2">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center text-gray-500 dark:text-gray-400">{{ __('messages.dashboard.empty_queue') }}</div>
                @endif
            </div>


        @elseif($mode === 'creator')
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center md:items-start">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase mb-1">{{ __('messages.dashboard.stat_total_upload') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_uploads'] }}</h2>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center md:items-start">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase mb-1">{{ __('messages.dashboard.stat_pending') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending'] }}</h2>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center md:items-start">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase mb-1">{{ __('messages.dashboard.stat_approved') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-full bg-green-100 text-green-600 dark:bg-green-900/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['approved'] }}</h2>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center md:items-start">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase mb-1">{{ __('messages.dashboard.stat_rejected') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-full bg-red-100 text-red-600 dark:bg-red-900/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['rejected'] }}</h2>
                    </div>
                </div>
            </div>
            
            @include('components.books-grid')


        @else
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-lg flex items-center justify-between transition-transform hover:scale-105 duration-300">
                    <div>
                        <p class="text-blue-100 text-xs font-medium uppercase tracking-wider">{{ __('messages.dashboard.stat_time') }}</p>
                        <h2 class="text-3xl font-bold mt-1">
                            <span id="stat-time">{{ $stats['total_hours'] }}</span> 
                            <span class="text-lg font-normal opacity-80">{{ __('messages.dashboard.unit_hours') }}</span>
                        </h2>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-lg flex items-center justify-between transition-transform hover:scale-105 duration-300">
                    <div>
                        <p class="text-purple-100 text-xs font-medium uppercase tracking-wider">{{ __('messages.dashboard.stat_books') }}</p>
                        <h2 class="text-3xl font-bold mt-1">
                            <span id="stat-books">{{ $stats['books_read'] }}</span> 
                            <span class="text-lg font-normal opacity-80">{{ __('messages.dashboard.unit_books') }}</span>
                        </h2>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white shadow-lg flex items-center justify-between transition-transform hover:scale-105 duration-300">
                    <div>
                        <p class="text-green-100 text-xs font-medium uppercase tracking-wider">{{ __('messages.dashboard.stat_avg') }}</p>
                        <h2 class="text-3xl font-bold mt-1">
                            <span id="stat-avg">{{ number_format($stats['avg_progress'], 0) }}</span>
                            <span class="text-lg font-normal opacity-80">%</span>
                        </h2>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-end mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.dashboard.continue_reading') }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.dashboard.continue_reading_desc') }}</p>
                </div>
                <a href="{{ route('books.index') }}" class="flex items-center gap-2 text-sm font-bold text-uin-blue dark:text-uin-yellow hover:underline">
                    {{ __('messages.dashboard.explore_library') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            @if($books->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($books as $book)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
                            
                            <div class="relative w-full pt-[133%] bg-gray-100 dark:bg-gray-700 overflow-hidden">
                                @if($book->cover_path)
                                    <img src="{{ asset('storage/' . $book->cover_path) }}" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        <span class="text-xs">{{ __('messages.dashboard.no_cover') }}</span>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-white/90 dark:bg-gray-900/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-uin-blue dark:text-uin-yellow shadow-sm z-10">
                                    {{ $book->category }}
                                </div>
                            </div>

                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 mb-1 group-hover:text-uin-blue transition" title="{{ $book->title }}">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $book->author }}</p>
                                
                                <div class="mt-auto pt-4 border-t border-gray-50 dark:border-gray-700">
                                    <a href="{{ route('books.read', $book->id) }}" class="flex w-full justify-center items-center px-3 py-2 text-sm font-medium text-uin-green bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 transition">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        {{ __('messages.dashboard.btn_continue') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/20 text-uin-blue dark:text-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.dashboard.empty_history_title') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 mt-1">{{ __('messages.dashboard.empty_history_desc') }}</p>
                    <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-2.5 bg-uin-blue hover:bg-blue-900 text-white font-medium rounded-lg transition shadow-md">
                        {{ __('messages.dashboard.btn_start_explore') }} &rarr;
                    </a>
                </div>
            @endif

        @endif
        
    </main>

    <script>
        /**
         * Toggle Dark/Light Mode
         */
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }

        /**
         * Real-time Stats Polling (Reader Mode Only)
         */
        @if($mode === 'reader')
            document.addEventListener('DOMContentLoaded', function() {
                
                function fetchStats() {
                    fetch("{{ route('api.stats') }}")
                        .then(response => response.json())
                        .then(data => {
                            const elTime = document.getElementById('stat-time');
                            const elBooks = document.getElementById('stat-books');
                            const elAvg = document.getElementById('stat-avg');

                            if (elTime) elTime.innerText = data.total_hours;
                            if (elBooks) elBooks.innerText = data.books_read;
                            if (elAvg) elAvg.innerText = data.avg_progress;
                        })
                        .catch(err => console.error("Gagal update statistik:", err));
                }

                // Initial fetch & interval polling
                fetchStats();
                setInterval(fetchStats, 5000);
            });
        @endif
    </script>
</body>
</html>