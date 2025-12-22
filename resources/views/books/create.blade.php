<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.upload.page_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
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
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <span class="font-bold text-xl text-uin-blue dark:text-white">{{ __('messages.upload.header_title') }}</span>
                
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="flex bg-gray-100 dark:bg-gray-700 rounded-full p-1">
                            <a href="{{ route('lang.switch', 'id') }}" class="px-2 py-0.5 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'id' ? 'bg-uin-blue text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:text-uin-blue' }}">ID</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-0.5 text-xs font-bold rounded-full transition-all {{ app()->getLocale() == 'en' ? 'bg-uin-blue text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:text-uin-blue' }}">EN</a>
                        </div>
                        <button onclick="toggleTheme()" class="p-1.5 rounded-full text-gray-500 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <svg class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <svg class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </button>
                    </div>

                    <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">{{ __('messages.upload.cancel') }}</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 transition-colors duration-300">
            
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('messages.upload.form_title') }}</h1>

            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.upload.label.title') }}</label>
                    <input type="text" name="title" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-uin-blue focus:border-uin-blue dark:bg-gray-700 dark:text-white transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.upload.label.author') }}</label>
                        <input type="text" name="author" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-uin-blue focus:border-uin-blue dark:bg-gray-700 dark:text-white transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.upload.label.category') }}</label>
                        <select name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-uin-blue focus:border-uin-blue dark:bg-gray-700 dark:text-white transition">
                            <option value="Informatika">{{ __('messages.categories.informatika') }}</option>
                            <option value="Sistem Informasi">{{ __('messages.categories.sistem_informasi') }}</option>
                            <option value="Matematika">{{ __('messages.categories.matematika') }}</option>
                            <option value="Biologi">{{ __('messages.categories.biologi') }}</option>
                            <option value="Fisika">{{ __('messages.categories.fisika') }}</option>
                            <option value="Kimia">{{ __('messages.categories.kimia') }}</option>
                            <option value="Agribisnis">{{ __('messages.categories.agribisnis') }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.upload.label.cover') }}</label>
                    
                    <div id="drop-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition relative">
                        <div id="default-content" class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                <label for="cover-upload" class="relative cursor-pointer rounded-md font-medium text-uin-blue dark:text-uin-yellow hover:underline px-1">
                                    <span>{{ __('messages.upload.drag.action') }}</span>
                                    <input id="cover-upload" name="cover" type="file" accept="image/*" class="sr-only" required>
                                </label>
                                <p class="pl-1">{{ __('messages.upload.drag.or') }}</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.upload.drag.hint') }}</p>
                        </div>

                        <div id="preview-container" class="hidden text-center w-full">
                            <img id="preview-image" src="#" alt="Preview Cover" class="mx-auto h-48 object-cover rounded-md shadow-md mb-3">
                            <button type="button" id="remove-image" class="text-sm text-red-600 hover:text-red-800 font-medium bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded border border-red-200 dark:border-red-800">
                                {{ __('messages.upload.drag.remove') }}
                            </button>
                        </div>

                        <div id="size-error" class="hidden absolute inset-0 bg-red-50/90 dark:bg-red-900/90 flex flex-col items-center justify-center rounded-md border-2 border-red-300">
                            <p class="text-red-700 dark:text-white font-bold">{{ __('messages.upload.error.title') }}</p>
                            <p class="text-red-600 dark:text-gray-200 text-sm mb-3">{{ __('messages.upload.error.desc') }}</p>
                            <button type="button" onclick="resetInput()" class="text-sm bg-white dark:bg-gray-800 border border-red-300 text-red-700 dark:text-red-400 px-3 py-1 rounded shadow-sm hover:bg-red-50">{{ __('messages.upload.error.retry') }}</button>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.upload.label.file') }}</label>
                    <input type="file" name="file_epub" accept=".epub" required class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-uin-blue
                        dark:file:bg-gray-700 dark:file:text-white
                        hover:file:bg-blue-100 dark:hover:file:bg-gray-600
                    ">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-uin-blue hover:bg-blue-900 dark:bg-uin-yellow dark:text-uin-blue dark:hover:bg-yellow-400 transition">
                        {{ __('messages.upload.submit') }}
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const coverInput = document.getElementById('cover-upload');
        const defaultContent = document.getElementById('default-content');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        const removeButton = document.getElementById('remove-image');
        const sizeError = document.getElementById('size-error');

        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) { showError(); return; }
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    defaultContent.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                    sizeError.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeButton.addEventListener('click', resetInput);

        function resetInput() {
            coverInput.value = '';
            defaultContent.classList.remove('hidden');
            previewContainer.classList.add('hidden');
            sizeError.classList.add('hidden');
        }

        function showError() {
            coverInput.value = '';
            sizeError.classList.remove('hidden');
        }

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