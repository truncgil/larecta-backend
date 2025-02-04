<x-app-layout>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-purple-700 w-64 min-h-screen p-4">
            <div class="text-white text-2xl font-bold mb-8">Dashboard</div>
            <nav class="space-y-2">
                <a href="#" class="flex items-center p-3 text-white hover:bg-purple-600 rounded-lg">
                    <span class="ml-3">Ana Sayfa</span>
                </a>
                <a href="#" class="flex items-center p-3 text-white hover:bg-purple-600 rounded-lg">
                    <span class="ml-3">Profil</span>
                </a>
                <a href="#" class="flex items-center p-3 text-white hover:bg-purple-600 rounded-lg">
                    <span class="ml-3">Ayarlar</span>
                </a>
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