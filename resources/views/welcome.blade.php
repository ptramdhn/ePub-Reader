<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.hero.title_1') }} - {{ __('messages.hero.title_2') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,600,700,900&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="antialiased font-['Inter'] bg-white text-gray-900 dark:bg-gray-950 dark:text-gray-100 transition-colors duration-300">

    <nav class="sticky top-0 z-50 w-full border-b border-gray-100 dark:border-gray-800 bg-white/95 dark:bg-gray-950/95 backdrop-blur supports-[backdrop-filter]:bg-white/60 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-8 h-8 rounded bg-uin-yellow flex items-center justify-center text-uin-blue font-black border border-uin-blue shadow-sm">
                        F
                    </div>
                    <span class="font-bold text-xl tracking-tight text-uin-blue dark:text-white">
                        FST<span class="text-uin-green">Reads</span>
                    </span>
                </div>

                <div class="hidden md:flex flex-1 max-w-lg mx-8">
                    <div class="relative w-full group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-uin-blue transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-full leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:bg-white focus:border-uin-blue focus:ring-2 focus:ring-uin-blue/20 sm:text-sm transition-all dark:bg-gray-900 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-100" 
                               placeholder="{{ __('messages.nav.search_placeholder') }}">
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    
                    <div class="relative group hidden sm:block">
                        <button class="flex items-center gap-1 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-uin-blue dark:hover:text-uin-yellow transition">
                            <span class="uppercase">{{ app()->getLocale() }}</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-32 bg-white dark:bg-gray-800 rounded shadow-xl border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform origin-top-right z-50">
                            <a href="/lang/id" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700">Indonesia</a>
                            <a href="/lang/en" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700">English</a>
                        </div>
                    </div>

                    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>

                    <div class="border-l border-gray-200 dark:border-gray-700 pl-4 ml-2">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 group" title="{{ __('messages.nav.account') }}">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-uin-blue to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow ring-2 ring-transparent group-hover:ring-uin-green transition-all">
                                        {{ substr(Auth::user()->name, 0, 1) }} </div>
                                    <span class="hidden lg:block text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-uin-blue transition">
                                        {{ __('messages.nav.account') }}
                                    </span>
                                </a>
                            @else
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-uin-blue dark:hover:text-uin-yellow transition">
                                        {{ __('messages.nav.login') }}
                                    </a>
                                    <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-uin-blue rounded-lg hover:bg-blue-900 transition shadow-md shadow-blue-500/20">
                                        {{ __('messages.nav.register') }}
                                    </a>
                                </div>
                            @endauth
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-white dark:bg-gray-900 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white dark:bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white dark:text-gray-900 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">{{ __('messages.hero.title_1') }}</span>
                            <span class="block text-uin-blue dark:text-uin-yellow">{{ __('messages.hero.title_2') }}</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            {{ __('messages.hero.desc') }}
                        </p>
                        
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-uin-green hover:bg-green-700 md:py-4 md:text-lg transition-all transform hover:-translate-y-1">
                                    {{ __('messages.hero.cta_read') }}
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('books.create') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-uin-blue bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition">
                                    {{ __('messages.hero.cta_upload') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-blue-50 dark:bg-gray-800 flex items-center justify-center p-6 lg:p-0 overflow-hidden">
            <div class="relative w-full h-64 sm:h-72 md:h-96 lg:h-full bg-uin-light/50 dark:bg-gray-700 overflow-hidden relative">
                <div class="absolute inset-0 opacity-30 dark:opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                
                <div class="absolute top-[-10%] right-[-10%] w-64 h-64 bg-uin-yellow/30 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-soft-light"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-64 h-64 bg-uin-blue/30 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-soft-light"></div>

                <div class="absolute inset-0 flex items-center justify-center">
                    <img src="https://placehold.co/200x300/0F265C/FFF?text=Sains+Data" alt="Buku 1" 
                         class="absolute w-32 md:w-48 shadow-xl transform -translate-x-16 md:-translate-x-24 translate-y-8 -rotate-12 z-10 transition hover:scale-105 duration-500">
                    
                    <img src="https://placehold.co/200x300/009B4C/FFF?text=Bioteknologi" alt="Buku 2" 
                         class="absolute w-32 md:w-48 shadow-xl transform translate-x-16 md:translate-x-24 -translate-y-8 rotate-12 z-10 transition hover:scale-105 duration-500">
                    
                    <img src="https://placehold.co/220x320/FFC700/000?text=Machine+Learning" alt="Buku Utama" 
                         class="absolute w-36 md:w-56 shadow-2xl transform z-20 hover:scale-110 transition duration-500">
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h2 class="text-3xl md:text-4xl font-serif text-center text-gray-900 dark:text-white mb-12">
                {{ __('messages.rec.title') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">

                <div class="group flex flex-col">
                    <div class="relative h-64 md:h-80 w-full bg-uin-yellow rounded-xl overflow-hidden flex items-center justify-center mb-6 shadow-sm group-hover:shadow-xl transition-all duration-300">
                        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#0F265C 2px, transparent 2px); background-size: 20px 20px;"></div>
                        
                        <div class="relative w-full h-full flex items-center justify-center pt-8">
                            <img src="https://placehold.co/180x260/0F265C/FFF?text=Jurnal+1" class="absolute w-32 md:w-40 shadow-xl transform -translate-x-16 translate-y-4 -rotate-6 transition duration-500 group-hover:-translate-x-20 group-hover:-rotate-12 z-10" alt="Book 1">
                            <img src="https://placehold.co/180x260/009B4C/FFF?text=Riset+2" class="absolute w-32 md:w-40 shadow-xl transform translate-x-16 translate-y-4 rotate-6 transition duration-500 group-hover:translate-x-20 group-hover:rotate-12 z-10" alt="Book 2">
                            <img src="https://placehold.co/190x280/white/000?text=Publikasi+Terbaik" class="absolute w-36 md:w-44 shadow-2xl transform hover:scale-105 transition duration-500 z-20" alt="Main Book">
                        </div>
                    </div>

                    <div>
                        <a href="#" class="inline-block text-lg md:text-xl font-bold text-gray-900 dark:text-white uppercase tracking-wide border-b-2 border-uin-yellow pb-1 hover:text-uin-blue transition-colors">
                            {{ __('messages.rec.card1_title') }}
                        </a>
                        <p class="mt-3 text-gray-600 dark:text-gray-400 text-base leading-relaxed">
                            {{ __('messages.rec.card1_desc') }}
                        </p>
                    </div>
                </div>

                <div class="group flex flex-col">
                    <div class="relative h-64 md:h-80 w-full bg-uin-blue rounded-xl overflow-hidden flex items-center justify-center mb-6 shadow-sm group-hover:shadow-xl transition-all duration-300">
                        <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #FFF 0, #FFF 1px, transparent 0, transparent 50%); background-size: 10px 10px;"></div>
                        
                        <div class="relative w-full h-full flex items-center justify-center pt-8">
                            <img src="https://placehold.co/150x200/FFC700/000?text=Modul+1" class="absolute w-28 md:w-36 shadow-lg transform -translate-x-24 translate-y-8 -rotate-12 transition duration-500 group-hover:-translate-x-28" alt="Modul 1">
                            <img src="https://placehold.co/150x220/white/000?text=Diktat+2" class="absolute w-30 md:w-38 shadow-lg transform -translate-x-8 translate-y-2 -rotate-3 z-10 transition duration-500 group-hover:-translate-x-10" alt="Modul 2">
                             <img src="https://placehold.co/160x240/009B4C/FFF?text=Buku+Ajar" class="absolute w-32 md:w-40 shadow-2xl transform translate-x-12 translate-y-6 rotate-6 z-20 transition duration-500 group-hover:translate-x-16 group-hover:rotate-12" alt="Modul 3">
                        </div>
                    </div>

                    <div>
                        <a href="#" class="inline-block text-lg md:text-xl font-bold text-gray-900 dark:text-white uppercase tracking-wide border-b-2 border-uin-blue dark:border-uin-yellow pb-1 hover:text-uin-blue dark:hover:text-uin-yellow transition-colors">
                            {{ __('messages.rec.card2_title') }}
                        </a>
                        <p class="mt-3 text-gray-600 dark:text-gray-400 text-base leading-relaxed">
                             {{ __('messages.rec.card2_desc') }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-12 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-stretch">

                <div class="lg:col-span-8 relative rounded-2xl overflow-hidden min-h-[400px] group">
                    <img src="https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=2094&auto=format&fit=crop" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                         alt="Sky Background">
                    
                    <div class="absolute inset-0 bg-uin-blue/60 mix-blend-multiply"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-uin-blue/90 via-transparent to-transparent"></div>

                    <div class="absolute top-6 left-6 w-24 h-24 bg-uin-yellow rounded-full blur-xl opacity-80 animate-pulse"></div>
                    <div class="absolute bottom-[-20px] right-[-20px] w-40 h-40 bg-uin-green rounded-full blur-2xl opacity-60"></div>

                    <div class="relative h-full flex flex-col justify-center items-center text-center p-8 z-10">
                        <span class="text-uin-yellow font-bold tracking-[0.2em] text-sm md:text-base mb-4 uppercase border border-uin-yellow px-3 py-1 rounded-full backdrop-blur-sm">
                            {{ __('messages.feat.badge') }}
                        </span>
                        
                        <h2 class="text-5xl md:text-7xl lg:text-8xl text-white leading-[0.9]">
                            <span class="font-serif block">{{ __('messages.feat.share') }}</span>
                            <span class="block text-3xl md:text-5xl font-light italic font-serif my-2 text-uin-light">{{ __('messages.feat.the') }}</span>
                            <span class="font-serif block">{{ __('messages.feat.knowledge') }}</span>
                        </h2>
                    </div>
                </div>

                <div class="lg:col-span-4 bg-gray-50 dark:bg-gray-900 p-8 lg:p-10 rounded-2xl flex flex-col justify-center items-start border border-gray-100 dark:border-gray-800 shadow-sm">
                    
                    <h3 class="text-3xl md:text-4xl font-light text-gray-900 dark:text-white mb-6 leading-tight">
                        {!! __('messages.feat.subhead') !!}
                    </h3>

                    <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        {{ __('messages.feat.desc') }}
                    </p>

                    <a href="#" class="group relative inline-flex items-center justify-start px-8 py-3 overflow-hidden font-bold transition-all bg-transparent border-2 border-uin-blue dark:border-uin-yellow rounded hover:bg-white group">
                        <span class="w-48 h-48 rounded rotate-[-40deg] bg-uin-blue dark:bg-uin-yellow absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                        <span class="relative w-full text-left text-uin-blue dark:text-uin-yellow transition-colors duration-300 ease-in-out group-hover:text-white dark:group-hover:text-gray-900 uppercase tracking-widest text-sm">
                            {{ __('messages.feat.cta') }}
                        </span>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <section class="py-12 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800">
        <div class="max-w-screen-xl mx-auto px-4">
            
            <div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-96">
                
                <div class="w-full lg:w-1/4 bg-gradient-to-br from-uin-yellow/20 via-white to-uin-green/20 dark:from-gray-800 dark:to-gray-900 border border-uin-yellow/30 rounded-xl p-8 flex flex-col justify-center items-start relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-uin-yellow/30 rounded-full blur-3xl group-hover:bg-uin-yellow/50 transition duration-700"></div>
                    
                    <div class="relative z-10">
                        <svg class="w-10 h-10 mb-4 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mb-6 font-sans">
                            {!! __('messages.top.title') !!}
                        </h2>
                    </div>

                    <a href="#" class="relative z-10 inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-gray-900 dark:bg-uin-blue rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 hover:bg-gray-800 dark:hover:bg-blue-800">
                        {{ __('messages.top.cta_chart') }}
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <div class="w-full lg:w-3/4 flex gap-4 overflow-x-auto pb-4 snap-x hide-scrollbar scroll-smooth">
                    
                    <div class="snap-center shrink-0 w-64 h-full bg-blue-50 dark:bg-gray-800 rounded-xl p-6 flex flex-col items-center justify-between hover:shadow-lg transition border border-transparent hover:border-uin-blue/20 cursor-pointer">
                        <div class="w-32 h-48 bg-gray-300 rounded shadow-md mb-4 bg-cover bg-center transition transform hover:scale-105" style="background-image: url('https://placehold.co/200x300/0F265C/white?text=Biologi+Dasar');"></div>
                        <div class="text-center mb-4">
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg leading-tight line-clamp-2">{{ __('messages.top.book1') }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Dr. Ahmad S.Si</p>
                        </div>
                        <div class="w-10 h-10 rounded-full border-2 border-gray-900 dark:border-white flex items-center justify-center text-xl font-bold text-gray-900 dark:text-white">
                            1
                        </div>
                    </div>

                    <div class="snap-center shrink-0 w-64 h-full bg-green-50 dark:bg-gray-800 rounded-xl p-6 flex flex-col items-center justify-between hover:shadow-lg transition border border-transparent hover:border-uin-green/20 cursor-pointer">
                        <div class="w-32 h-48 bg-gray-300 rounded shadow-md mb-4 bg-cover bg-center transition transform hover:scale-105" style="background-image: url('https://placehold.co/200x300/009B4C/white?text=Algoritma');"></div>
                        <div class="text-center mb-4">
                             <h3 class="font-bold text-gray-900 dark:text-white text-lg leading-tight line-clamp-2">{{ __('messages.top.book2') }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Prodi TI</p>
                        </div>
                        <div class="w-10 h-10 rounded-full border-2 border-gray-900 dark:border-white flex items-center justify-center text-xl font-bold text-gray-900 dark:text-white">
                            2
                        </div>
                    </div>

                    <div class="snap-center shrink-0 w-64 h-full bg-yellow-50 dark:bg-gray-800 rounded-xl p-6 flex flex-col items-center justify-between hover:shadow-lg transition border border-transparent hover:border-uin-yellow/20 cursor-pointer">
                        <div class="w-32 h-48 bg-gray-300 rounded shadow-md mb-4 bg-cover bg-center transition transform hover:scale-105" style="background-image: url('https://placehold.co/200x300/FFC700/black?text=Kalkulus');"></div>
                        <div class="text-center mb-4">
                             <h3 class="font-bold text-gray-900 dark:text-white text-lg leading-tight line-clamp-2">{{ __('messages.top.book3') }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Matematika FST</p>
                        </div>
                        <div class="w-10 h-10 rounded-full border-2 border-gray-900 dark:border-white flex items-center justify-center text-xl font-bold text-gray-900 dark:text-white">
                            3
                        </div>
                    </div>

                    <div class="snap-center shrink-0 w-32 h-full flex flex-col items-center justify-center">
                        <a href="#" class="w-12 h-12 rounded-full bg-white border border-gray-200 shadow flex items-center justify-center hover:bg-gray-50 transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        <span class="text-xs font-medium text-gray-500 mt-2">{{ __('messages.top.view_all') }}</span>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <section class="py-16 bg-white dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-serif text-gray-900 dark:text-white mb-2">
                    {{ __('messages.cat.title') }}
                </h2>
                <div class="w-24 h-1 bg-uin-yellow mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">

                <div class="group cursor-pointer flex flex-col items-center">
                    <div class="w-full aspect-[4/5] bg-blue-50 dark:bg-gray-900 rounded-lg mb-4 relative overflow-hidden flex items-center justify-center transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-100/50 to-transparent dark:from-blue-900/20"></div>
                        <img src="https://placehold.co/150x220/0F265C/FFF?text=TI" alt="Informatika" class="w-2/3 shadow-xl transform group-hover:scale-110 transition duration-500 z-10 rotate-3">
                        <div class="absolute w-2/3 h-4/5 bg-gray-300 dark:bg-gray-700 top-8 left-4 rounded shadow-sm -z-0 rotate-[-5deg] opacity-70"></div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center font-serif group-hover:text-uin-blue transition">{{ __('messages.cat.names.ti') }}</h3>
                </div>

                <div class="group cursor-pointer flex flex-col items-center">
                    <div class="w-full aspect-[4/5] bg-green-50 dark:bg-gray-900 rounded-lg mb-4 relative overflow-hidden flex items-center justify-center transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-100/50 to-transparent dark:from-green-900/20"></div>
                        <img src="https://placehold.co/150x220/009B4C/FFF?text=SI" alt="Sistem Informasi" class="w-2/3 shadow-xl transform group-hover:scale-110 transition duration-500 z-10 -rotate-2">
                        <div class="absolute w-2/3 h-4/5 bg-gray-300 dark:bg-gray-700 top-8 right-4 rounded shadow-sm -z-0 rotate-[4deg] opacity-70"></div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center font-serif group-hover:text-uin-blue transition">{{ __('messages.cat.names.si') }}</h3>
                </div>

                <div class="group cursor-pointer flex flex-col items-center">
                    <div class="w-full aspect-[4/5] bg-yellow-50 dark:bg-gray-900 rounded-lg mb-4 relative overflow-hidden flex items-center justify-center transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-100/50 to-transparent dark:from-yellow-900/20"></div>
                        <img src="https://placehold.co/150x220/FFC700/000?text=MTK" alt="Matematika" class="w-2/3 shadow-xl transform group-hover:scale-110 transition duration-500 z-10 rotate-1">
                        <div class="absolute w-2/3 h-4/5 bg-gray-300 dark:bg-gray-700 top-6 left-6 rounded shadow-sm -z-0 rotate-[-3deg] opacity-70"></div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center font-serif group-hover:text-uin-blue transition">{{ __('messages.cat.names.mtk') }}</h3>
                </div>

                <div class="group cursor-pointer flex flex-col items-center">
                    <div class="w-full aspect-[4/5] bg-teal-50 dark:bg-gray-900 rounded-lg mb-4 relative overflow-hidden flex items-center justify-center transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-100/50 to-transparent dark:from-teal-900/20"></div>
                        <img src="https://placehold.co/150x220/14b8a6/FFF?text=BIO" alt="Biologi" class="w-2/3 shadow-xl transform group-hover:scale-110 transition duration-500 z-10 rotate-3">
                         <div class="absolute w-2/3 h-4/5 bg-gray-300 dark:bg-gray-700 top-8 left-3 rounded shadow-sm -z-0 rotate-[-6deg] opacity-70"></div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center font-serif group-hover:text-uin-blue transition">{{ __('messages.cat.names.bio') }}</h3>
                </div>

                <div class="group cursor-pointer flex flex-col items-center">
                    <div class="w-full aspect-[4/5] bg-indigo-50 dark:bg-gray-900 rounded-lg mb-4 relative overflow-hidden flex items-center justify-center transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-100/50 to-transparent dark:from-indigo-900/20"></div>
                        <img src="https://placehold.co/150x220/6366f1/FFF?text=FIS" alt="Fisika" class="w-2/3 shadow-xl transform group-hover:scale-110 transition duration-500 z-10 -rotate-2">
                        <div class="absolute w-2/3 h-4/5 bg-gray-300 dark:bg-gray-700 top-7 right-5 rounded shadow-sm -z-0 rotate-[3deg] opacity-70"></div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center font-serif group-hover:text-uin-blue transition">{{ __('messages.cat.names.fis') }}</h3>
                </div>

                <div class="group cursor-pointer flex flex-col items-center">
                    <div class="w-full aspect-[4/5] bg-orange-50 dark:bg-gray-900 rounded-lg mb-4 relative overflow-hidden flex items-center justify-center transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-100/50 to-transparent dark:from-orange-900/20"></div>
                        <img src="https://placehold.co/150x220/f97316/FFF?text=KIM" alt="Kimia" class="w-2/3 shadow-xl transform group-hover:scale-110 transition duration-500 z-10 rotate-1">
                        <div class="absolute w-2/3 h-4/5 bg-gray-300 dark:bg-gray-700 top-6 left-5 rounded shadow-sm -z-0 rotate-[-2deg] opacity-70"></div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center font-serif group-hover:text-uin-blue transition">{{ __('messages.cat.names.kim') }}</h3>
                </div>

            </div>

            <div class="text-center mt-12">
                <a href="#" class="inline-block text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest border-b-2 border-gray-900 dark:border-white pb-1 hover:text-uin-blue hover:border-uin-blue transition-colors duration-300">
                    {{ __('messages.cat.explore') }}
                </a>
            </div>

        </div>
    </section>

    <section class="bg-uin-blue overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                
                <div class="mb-12 lg:mb-0 text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl">
                        <span class="block">{{ __('messages.bottom.title_1') }}</span>
                        <span class="block text-uin-yellow mt-2">{{ __('messages.bottom.title_2') }}</span>
                    </h2>
                    <p class="mt-4 text-lg text-blue-100 leading-relaxed max-w-lg mx-auto lg:mx-0">
                         {{ __('messages.bottom.desc') }}
                    </p>
                    
                    <div class="mt-8 flex justify-center lg:justify-start">
                        <div class="inline-flex rounded-md shadow-lg">
                            <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-md text-uin-blue bg-white hover:bg-gray-50 transition transform hover:-translate-y-1">
                                {{ __('messages.bottom.cta') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative flex items-center justify-center">
                    
                    <img src="/images/gambarbawah.png" 
                         alt="Ilustrasi Publikasi" 
                         class="w-full h-auto object-contain max-w-md lg:max-w-full mx-auto drop-shadow-2xl transform hover:scale-105 transition duration-500">
                    
                    <div class="absolute top-0 right-0 -mt-12 -mr-12 text-uin-yellow animate-pulse hidden lg:block">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white pt-12 pb-8 border-t border-gray-800">
        <div class="max-w-screen-xl mx-auto px-4">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="flex flex-wrap gap-x-8 gap-y-4 text-sm font-medium text-gray-300">
                        <a href="#" class="hover:text-white transition">{{ __('messages.footer.team') }}</a>
                        <a href="#" class="hover:text-white transition">{{ __('messages.footer.news') }}</a>
                        <a href="#" class="hover:text-white transition">{{ __('messages.footer.community') }}</a>
                        <a href="#" class="hover:text-white transition">{{ __('messages.footer.help') }}</a>
                        <a href="#" class="hover:text-white transition">{{ __('messages.footer.devs') }}</a>
                        
                        <div class="relative inline-block text-left group">
                            <button type="button" class="flex items-center gap-1 hover:text-white transition">
                                {{ app()->getLocale() == 'id' ? 'Bahasa Indonesia' : 'English' }}
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute left-0 bottom-full mb-2 w-32 bg-white text-gray-900 rounded shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="/lang/id" class="block px-4 py-2 hover:bg-gray-100">Indonesia</a>
                                <a href="/lang/en" class="block px-4 py-2 hover:bg-gray-100">English</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="bg-gray-800 p-2 rounded-full hover:bg-uin-blue transition group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        </div>
                </div>

                <div>
                    <h3 class="text-white text-base font-semibold mb-2">{{ __('messages.footer.news_title') }}</h3>
                    <p class="text-gray-400 text-sm mb-4">{{ __('messages.footer.news_desc') }}</p>
                    <form action="#" class="flex flex-col sm:flex-row gap-2">
                        <input type="email" placeholder="{{ __('messages.footer.news_place') }}" class="w-full px-4 py-2.5 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-uin-green" required>
                        <button type="submit" class="px-6 py-2.5 bg-uin-blue hover:bg-blue-800 text-white font-medium rounded-lg transition shadow-lg shadow-blue-500/20">
                            {{ __('messages.footer.subscribe') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                
                <div class="flex items-center gap-6 opacity-80 grayscale hover:grayscale-0 transition duration-300">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-uin-yellow border-2 border-white flex items-center justify-center text-uin-blue font-bold text-xs">UIN</div>
                        <span class="font-bold text-xl tracking-tight">Syarif Hidayatullah</span>
                    </div>
                    <div class="flex items-center gap-2 border-l border-gray-700 pl-6">
                        <span class="font-mono text-lg font-semibold text-uin-green">FST<span class="text-white">DEV</span></span>
                    </div>
                </div>

                <div class="text-center md:text-right">
                    <div class="flex flex-wrap justify-center md:justify-end gap-x-6 gap-y-2 text-xs text-gray-500 font-medium mb-2">
                        <a href="#" class="hover:text-gray-300">{{ __('messages.footer.privacy') }}</a>
                        <a href="#" class="hover:text-gray-300">{{ __('messages.footer.terms') }}</a>
                        <a href="#" class="hover:text-gray-300">{{ __('messages.footer.security') }}</a>
                    </div>
                    <p class="text-xs text-gray-600">
                        {{ __('messages.footer.copyright') }}
                    </p>
                </div>
            </div>

        </div>
    </footer>

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }

        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>