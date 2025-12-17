<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.register_title') }} - FST ePub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
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
<body class="h-full bg-white dark:bg-gray-900 transition-colors duration-300">

    <a href="{{ url('/') }}" class="absolute top-4 left-4 z-50 flex items-center px-4 py-2 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-lg shadow-sm hover:bg-white dark:hover:bg-gray-700 transition-all text-sm font-medium text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ __('messages.back_home') }}
         </a>

    <div class="absolute top-4 right-4 z-50 flex items-center space-x-3">
        
        <div class="flex bg-gray-100 dark:bg-gray-800 rounded-lg p-1 border border-gray-200 dark:border-gray-700">
            <a href="{{ route('lang.switch', 'id') }}" 
               class="px-3 py-1 text-xs font-bold rounded-md transition-all {{ app()->getLocale() == 'id' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
               ID
            </a>
            <a href="{{ route('lang.switch', 'en') }}" 
               class="px-3 py-1 text-xs font-bold rounded-md transition-all {{ app()->getLocale() == 'en' ? 'bg-gray-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
               EN
            </a>
        </div>

        <button onclick="toggleTheme()" class="p-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors focus:outline-none border border-gray-200 dark:border-gray-700">
            <svg class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <svg class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
        </button>
    </div>

    <div class="min-h-screen flex">
        
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" 
                 src="https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" 
                 alt="Gedung FST UIN">
            <div class="absolute inset-0 bg-green-900 bg-opacity-40 mix-blend-multiply"></div>
             <div class="absolute bottom-0 left-0 p-10 text-white">
                <h2 class="text-4xl font-bold">{{ __('messages.fst_join') }}</h2>
                <p class="mt-2 text-lg text-gray-200">{{ __('messages.fst_desc') }}</p>
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-full lg:w-1/2 bg-white dark:bg-gray-900 transition-colors duration-300">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <h2 class="text-3xl font-extrabold text-green-600 dark:text-green-500">FST ePubReader</h2>
                    <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('messages.register_title') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('messages.have_account') }}
                        <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500 dark:text-green-500 transition-colors">
                            {{ __('messages.login_link') }}
                        </a>
                    </p>
                </div>

                <div class="mt-8">
                    <form action="{{ route('register') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.name_label') }}</label>
                            <input id="name" name="name" type="text" required 
                                class="mt-1 appearance-none block w-full px-3 py-3 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white sm:text-sm transition-colors">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.email_label') }}</label>
                            <input id="email" name="email" type="email" required 
                                class="mt-1 appearance-none block w-full px-3 py-3 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white sm:text-sm transition-colors">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.password_label') }}</label>
                            <input id="password" name="password" type="password" required 
                                class="mt-1 appearance-none block w-full px-3 py-3 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white sm:text-sm transition-colors">
                        </div>

                         <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.confirm_password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="mt-1 appearance-none block w-full px-3 py-3 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white sm:text-sm transition-colors">
                        </div>

                        @if ($errors->any())
                        <div class="text-red-600 dark:text-red-400 text-sm bg-red-50 dark:bg-red-900/20 p-3 rounded-md border border-red-200 dark:border-red-800">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                                {{ __('messages.register_button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>