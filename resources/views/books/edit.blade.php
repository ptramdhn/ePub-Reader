<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - FST Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { uin: { blue: '#0F265C', yellow: '#FFC700' } } } }
        }
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-4xl mx-auto px-4 h-16 flex justify-between items-center">
            <span class="font-bold text-xl text-uin-blue dark:text-white">Edit Buku</span>
            <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">Batal</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-10 px-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-8">
            
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Perhatian:</strong> Mengedit buku akan mengubah statusnya kembali menjadi 
                            <span class="font-bold uppercase">Menunggu Review</span>. Admin harus menyetujui ulang perubahan Anda.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT') <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.upload.label.title') }}</label>
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.upload.label.author') }}</label>
                        <input type="text" name="author" value="{{ old('author', $book->author) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.upload.label.category') }}</label>
                        <select name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @foreach(['Informatika', 'Sistem Informasi', 'Matematika', 'Biologi', 'Fisika', 'Kimia', 'Agribisnis'] as $cat)
                                <option value="{{ $cat }}" {{ $book->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ganti Sampul (Opsional)</label>
                    <div class="flex items-center gap-4">
                        @if($book->cover_path)
                            <img src="{{ asset('storage/' . $book->cover_path) }}" class="h-20 w-16 object-cover rounded border">
                        @endif
                        <input type="file" name="cover" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-uin-blue hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="flex-1 py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-uin-blue hover:bg-blue-900 transition">
                        Simpan Perubahan & Review Ulang
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>