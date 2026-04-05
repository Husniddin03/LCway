<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-2xl font-bold text-gray-900">O'quv markazlari</h2>
        <a href="{{ route('admin.centers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yangi markaz
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input wire:model.live="search" type="text" placeholder="Qidirish..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <select wire:model.live="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Barcha statuslar</option>
                    <option value="verified">Tasdiqlangan</option>
                    <option value="pending">Kutilmoqda</option>
                    <option value="premium">Premium</option>
                </select>
            </div>
            <div>
                <select wire:model.live="perPage" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="10">10 / sahifa</option>
                    <option value="20">20 / sahifa</option>
                    <option value="50">50 / sahifa</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        Nomi
                        @if($sortField === 'name') 
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Egasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tasdiqlangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Premium</th>
                    <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        Sana
                        @if($sortField === 'created_at') 
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($centers as $center)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $center->name }}</div>
                        <div class="text-sm text-gray-500">{{ $center->address }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $center->user?->name ?? 'Noma\'lum' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button wire:click="toggleVerification({{ $center->id }})" 
                                class="px-2 py-1 text-xs rounded-full cursor-pointer
                                {{ $center->checked ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $center->checked ? 'Ha' : 'Yo\'q' }}
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button wire:click="togglePremium({{ $center->id }})" 
                                class="px-2 py-1 text-xs rounded-full cursor-pointer
                                {{ $center->premium ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $center->premium ? 'Ha' : 'Yo\'q' }}
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $center->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.centers.show', $center->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ko'rish</a>
                        <a href="{{ route('admin.centers.edit', $center->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Tahrirlash</a>
                        <button wire:click="delete({{ $center->id }})" 
                                wire:confirm="O'chirishni tasdiqlaysizmi?"
                                class="text-red-600 hover:text-red-900">O'chirish</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        O'quv markazlari topilmadi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $centers->links() }}
    </div>
</div>
