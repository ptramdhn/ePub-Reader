<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login_title') }} - FST Library</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        uin: {
                            yellow: '#FFC700', // Kuning UIN
                            blue: '#0F265C',   // Biru UIN (Dominan)
                            green: '#009B4C',  // Hijau UIN (Aksen)
                            light: '#F3F4F6',
                            dark: '#111827',
                        }
                    }
                }
            }
        }
    </script>

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 transition-colors duration-300 font-sans">
    
    <a href="{{ url('/') }}" class="absolute top-4 left-4 z-50 flex items-center px-4 py-2 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full shadow-sm hover:bg-white dark:hover:bg-gray-700 transition-all text-sm font-bold text-uin-blue dark:text-uin-yellow border border-gray-200 dark:border-gray-700 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ __('messages.back_home') ?? 'Kembali' }}
    </a>
    
    <div class="absolute top-4 right-4 z-50 flex items-center space-x-3">
        <div class="flex bg-white dark:bg-gray-800 rounded-full p-1 border border-gray-200 dark:border-gray-700 shadow-sm">
            <a href="{{ route('lang.switch', 'id') }}" 
               class="px-3 py-1 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'id' ? 'bg-uin-blue text-white shadow' : 'text-gray-500 hover:text-uin-blue dark:text-gray-400' }}">
               ID
            </a>
            <a href="{{ route('lang.switch', 'en') }}" 
               class="px-3 py-1 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'en' ? 'bg-uin-blue text-white shadow' : 'text-gray-500 hover:text-uin-blue dark:text-gray-400' }}">
               EN
            </a>
        </div>

        <button onclick="toggleTheme()" class="p-2 rounded-full bg-white dark:bg-gray-800 text-gray-600 dark:text-uin-yellow hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none border border-gray-200 dark:border-gray-700 shadow-sm">
            <svg class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <svg class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
        </button>
    </div>

    <div class="min-h-screen flex">
        
        <div class="hidden lg:block relative w-0 flex-1 overflow-hidden">
            <img class="absolute inset-0 h-full w-full object-cover transition-transform duration-1000 hover:scale-105" 
                 src="https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" 
                 alt="Gedung FST UIN">
            
            <div class="absolute inset-0 bg-gradient-to-t from-uin-blue via-uin-blue/80 to-transparent mix-blend-multiply"></div>
            
            <div class="absolute bottom-0 left-0 p-16 text-white z-10">
                <div class="w-16 h-1 bg-uin-yellow mb-6"></div>
                <h2 class="text-5xl font-extrabold tracking-tight">Fakultas Sains<br>& Teknologi</h2>
                <p class="mt-4 text-xl text-gray-200 max-w-md font-light">{{ __('messages.fst_slogan') ?? 'Platform Baca Digital Terintegrasi untuk Civitas Akademika UIN Syarif Hidayatullah Jakarta.' }}</p>
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-full lg:w-1/2 bg-white dark:bg-gray-900 transition-colors duration-300">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                
                <div>
                    <div class="w-10 h-10 rounded bg-uin-yellow flex items-center justify-center text-uin-blue font-black border border-uin-blue mb-4 shadow-sm">
                        F
                    </div>
                    
                    <h2 class="text-3xl font-extrabold text-uin-blue dark:text-white">
                        {{ __('messages.login_title') ?? 'Selamat Datang Kembali' }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('messages.no_account') ?? 'Belum punya akun?' }}
                        <a href="{{ route('register') }}" class="font-bold text-uin-blue hover:text-blue-700 dark:text-uin-yellow dark:hover:text-yellow-400 transition-colors underline decoration-2 decoration-transparent hover:decoration-current">
                            {{ __('messages.register_link') ?? 'Daftar Sekarang' }}
                        </a>
                    </p>
                </div>

                <div class="mt-8">
                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.email_label') ?? 'Email Kampus' }}</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" required placeholder="nama@uinjkt.ac.id"
                                    class="appearance-none block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-uin-blue dark:focus:ring-uin-yellow focus:border-transparent bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white sm:text-sm transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.password_label') ?? 'Kata Sandi' }}</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" required placeholder="••••••••"
                                    class="appearance-none block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-uin-blue dark:focus:ring-uin-yellow focus:border-transparent bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white sm:text-sm transition-all">
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="rounded-md bg-red-50 dark:bg-red-900/30 p-4 border border-red-200 dark:border-red-800">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">{{ $errors->first() }}</h3>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-bold text-white bg-uin-blue hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-uin-blue transition-all transform hover:-translate-y-0.5">
                                {{ __('messages.login_button') ?? 'Masuk Sekarang' }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 text-center">
                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            &copy; 2025 Fakultas Sains dan Teknologi UIN Jakarta.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>