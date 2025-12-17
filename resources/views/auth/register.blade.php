<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FST ePub Reader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                    Buat Akun Mahasiswa
                </h2>
                <p class="mt-2 text-center text-sm text-gray-400">
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-green-500 hover:text-green-400">Login disini</a>
                </p>
            </div>
            
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-300">Nama Lengkap</label>
                        <input id="name" name="name" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md text-white bg-gray-700 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-300">Email Kampus</label>
                        <input id="email" name="email" type="email" required class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md text-white bg-gray-700 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <input id="password" name="password" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md text-white bg-gray-700 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md text-white bg-gray-700 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-sm mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>