   <x-app-layout>
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
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Şifre</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" 
                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Beni Hatırla</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-500">
                        Şifremi Unuttum
                    </a>
                </div>

                <button type="submit" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition-all">
                    Giriş Yap
                </button>
                
                <div class="text-center mt-4">
                    <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-700">
                        Hesabınız yok mu? Kayıt olun
                    </a>
                </div>
            </form>
        </div>
    </div>
    </x-app-layout>
