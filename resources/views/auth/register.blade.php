<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Kayıt Ol</h1>
                <p class="text-gray-500">Yeni bir hesap oluşturun</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ad Soyad</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Şifre Tekrar</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <button type="submit" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition-all">
                    Kayıt Ol
                </button>
                
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700">
                        Zaten hesabınız var mı? Giriş yapın
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
