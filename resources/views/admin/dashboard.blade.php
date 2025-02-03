<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-3">
                <div class="flex justify-between items-center">
                    <div class="text-xl font-bold text-gray-800">Yönetim Paneli</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                            class="text-red-600 hover:text-red-800 transition duration-200">
                            Çıkış Yap
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Hoş Geldiniz, {{ Auth::user()->name }}</h2>
                    <p class="text-gray-600">Super Admin yetkilerine sahip yönetim panelindesiniz.</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 