<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Hoş Geldiniz</h1>
                <p class="text-gray-500">Lütfen hesabınıza giriş yapın</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Şifre</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <button type="submit" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition-all">
                    Giriş Yap
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
