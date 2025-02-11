<x-app-layout>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-purple-700 w-64 min-h-screen p-4">
            <div class="flex items-center space-x-3 mb-8">
                <span class="text-white text-2xl font-bold">Admin Panel</span>
            </div>
            <nav class="space-y-2">
                <a href="#" class="flex items-center p-3 text-white hover:bg-purple-600 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="ml-3">Ana Sayfa</span>
                </a>
                <a href="#" class="flex items-center p-3 text-white hover:bg-purple-600 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="ml-3">Profil</span>
                </a>
                <a href="#" class="flex items-center p-3 text-white hover:bg-purple-600 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="ml-3">Ayarlar</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="flex w-full items-center p-3 text-white hover:bg-purple-600 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="ml-3">Çıkış Yap</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Hoş Geldiniz, {{ Auth::user()->name }}</h2>
                    
                    <!-- Dashboard Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800">Toplam Kullanıcı</h3>
                            <p class="text-3xl font-bold text-blue-600 mt-2">1,234</p>
                        </div>
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800">Aktif Projeler</h3>
                            <p class="text-3xl font-bold text-green-600 mt-2">42</p>
                        </div>
                        <div class="bg-purple-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800">Tamamlananlar</h3>
                            <p class="text-3xl font-bold text-purple-600 mt-2">89</p>
                        </div>
                    </div>

                    <!-- Recent Activity Table -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Son Etkinlikler</h3>
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kullanıcı</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aktivite</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarih</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Tablo içeriği buraya gelecek -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 