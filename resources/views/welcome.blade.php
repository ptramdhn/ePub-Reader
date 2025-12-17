<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FST ePub Reader - UIN Syarif Hidayatullah</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        uin: {
                            yellow: '#FFC700',
                            blue: '#0F265C',
                            green: '#009B4C',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-300">

    <nav class="fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <div class="w-10 h-10 rounded-full bg-uin-yellow flex items-center justify-center text-uin-blue font-bold border-2 border-uin-blue">
                    FST
                </div>
                <span class="self-center text-2xl font-bold whitespace-nowrap text-uin-blue dark:text-uin-yellow">
                    ePub<span class="text-uin-green">Reader</span>
                </span>
            </a>

            <div class="flex items-center md:order-2 space-x-3 md:space-x-4 rtl:space-x-reverse">
                
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1 font-medium px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition">
                        <span class="uppercase">{{ app()->getLocale() }}</span>
                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div class="absolute right-0 top-full mt-2 w-24 bg-white dark:bg-gray-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-100 dark:border-gray-700">
                        <a href="lang/id" class="block px-4 py-2 hover:bg-uin-light dark:hover:bg-gray-700 rounded-t-lg">Indonesia</a>
                        <a href="lang/en" class="block px-4 py-2 hover:bg-uin-light dark:hover:bg-gray-700 rounded-b-lg">English</a>
                    </div>
                </div>

                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-white bg-uin-blue hover:bg-blue-900 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-white bg-uin-blue hover:bg-blue-900 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition transform active:scale-95">
                            {{ __('messages.login_btn') }}
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-16 px-4 mx-auto max-w-screen-xl text-center lg:pt-40 lg:px-12">
        <a href="#" class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-uin-blue bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition">
            <span class="text-xs bg-uin-blue rounded-full text-white px-4 py-1.5 mr-3">Baru</span> 
            <span class="text-sm font-medium">Koleksi Buku FST 2025 Tersedia</span> 
            <svg class="w-2.5 h-2.5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
        </a>
        
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            {{ __('messages.welcome_title') }} <br> 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-uin-blue to-uin-green">Fakultas Sains & Teknologi</span>
        </h1>
        
        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
            Platform ePub Reader resmi UIN Syarif Hidayatullah Jakarta. Baca jurnal, buku ajar, dan skripsi mahasiswa FST kapan saja, di mana saja.
        </p>
        
        <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            <a href="#" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-uin-green hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-900 transition shadow-lg shadow-green-500/30">
                Mulai Membaca
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>
            <a href="#" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800 transition">
                <svg class="mr-2 -ml-1 w-5 h-5 text-uin-yellow" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                Tutorial Upload
            </a>
        </div>
    </section>

    <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800 border-t dark:border-gray-700">
        <div class="mx-auto max-w-screen-xl text-center">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="#" class="hover:underline text-uin-blue dark:text-uin-yellow">FST UIN Syarif Hidayatullah Jakarta</a>. All Rights Reserved.</span>
        </div>
    </footer>

    <script>
        // Cek preferensi user saat load
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }

        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Tampilkan icon yang sesuai
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // Toggle icons
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // Jika set via local storage sebelumnya
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                // Jika belum ada setting, cek class document
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