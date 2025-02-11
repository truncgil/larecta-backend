<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @if (file_exists(public_path('build/manifest.json')))
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
        <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Mobil Menü -->
        <div x-data="{ open: false }" class="lg:hidden">
            <div class="fixed inset-0 z-40 bg-black bg-opacity-50" x-show="open" x-cloak @click="open = false"></div>
            
            <div class="fixed inset-y-0 left-0 z-50 w-64 bg-purple-700 transform transition-transform duration-300" 
                 x-show="open" 
                 x-cloak
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                <!-- Mobil menü içeriği -->
            </div>
            
            <button @click="open = !open" 
                    class="fixed top-4 left-4 z-50 lg:hidden p-2 rounded-md text-gray-400 hover:text-white hover:bg-purple-600 focus:outline-none focus:bg-purple-600">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Üst Bildirim Çubuğu -->
        @if (session()->has('success') || session()->has('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 4000)"
                 class="fixed top-4 right-4 z-50">
                @if (session()->has('success'))
                    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <!-- Ana İçerik -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html> 