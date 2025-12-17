<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FST ePub Reader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                    Masuk ke Akun
                </h2>
                <p class="mt-2 text-center text-sm text-gray-400">
                    Atau <a href="{{ route('register') }}" class="font-medium text-green-500 hover:text-green-400">daftar akun baru</a>
                </p>
            </div>
            
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email-address" class="sr-only">Email Address</label>
                        <input id="email-address" name="email" type="email" required class="appearance-none rounded-none rounded-t-md relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-500 text-white bg-gray-700 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Alamat Email">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required class="appearance-none rounded-none rounded-b-md relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-500 text-white bg-gray-700 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Password">
                    </div>
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-sm text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>