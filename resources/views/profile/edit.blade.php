<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.profile.page_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { uin: { blue: '#0F265C', yellow: '#FFC700', green: '#009B4C' } } } }
        }
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen font-sans text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-4xl mx-auto px-4 h-16 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="font-bold text-xl text-uin-blue dark:text-white">{{ __('messages.profile.header') }}</span>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-uin-blue dark:text-gray-400 dark:hover:text-white transition">
                &larr; {{ __('messages.profile.back_dashboard') }}
            </a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-10">
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
            
            <div class="flex items-center gap-4 mb-8">
                <div class="w-16 h-16 rounded-full bg-uin-blue text-white flex items-center justify-center text-2xl font-bold">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->is_admin ? __('messages.profile.role_admin') : __('messages.profile.role_user') }}
                    </p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.profile.label_name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-uin-blue focus:border-uin-blue dark:bg-gray-700 dark:text-white transition">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('messages.profile.label_email') }} 
                        <span class="text-xs text-gray-400 font-normal">({{ __('messages.profile.email_locked') }})</span>
                    </label>
                    <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-900 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 my-6 pt-6">
                    <h3 class="text-md font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.profile.password_section') }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">{{ __('messages.profile.password_hint') }}</p>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.profile.label_new_pass') }}</label>
                        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-uin-blue focus:border-uin-blue dark:bg-gray-700 dark:text-white transition">
                        @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.profile.label_confirm_pass') }}</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-uin-blue focus:border-uin-blue dark:bg-gray-700 dark:text-white transition">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-uin-blue hover:bg-blue-900 text-white font-medium rounded-lg shadow-md transition transform active:scale-95">
                        {{ __('messages.profile.btn_save') }}
                    </button>
                </div>

            </form>
        </div>
    </main>

</body>
</html>