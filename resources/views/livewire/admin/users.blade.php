<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-2xl font-bold text-gray-900">Foydalanuvchilar</h2>
        <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yangi foydalanuvchi
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input wire:model.live="search" type="text" placeholder="Qidirish..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <select wire:model.live="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Barcha rollar</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="moderator">Moderator</option>
                </select>
            </div>
            <div>
                <select wire:model.live="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Barcha statuslar</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="banned">Banned</option>
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
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        Ism
                        @if($sortField === 'name') 
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th wire:click="sortBy('email')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        Email
                        @if($sortField === 'email') 
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                @forelse($users as $user)
                @php
                    $isOnline = $user->isOnline();
                    $wasRecentlyOnline = $user->wasRecentlyOnline(30); // 30 daqiqa ichida online bo'lsa
                    $isLongInactive = $user->isLongInactive(30); // 30 kun davomida kirmagan bo'lsa
                    
                    $borderClass = '';
                    if ($isOnline) {
                        $borderClass = 'ring-2 ring-green-500 ring-offset-2';
                    } elseif ($wasRecentlyOnline) {
                        $borderClass = 'ring-2 ring-yellow-400 ring-offset-2';
                    } elseif ($isLongInactive) {
                        $borderClass = 'ring-2 ring-red-500 ring-offset-2';
                    }
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden {{ $borderClass }} transition-all duration-300">
                                @if($user->avatar)
                                    @if(str_starts_with($user->avatar, 'http'))
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @endif
                                @else
                                    <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-medium text-sm">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                                @if($isOnline)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span> online
                                    </span>
                                @elseif(isset($user->last_login_at) && $user->last_login_at)
                                    <p class="text-xs text-gray-500">{{ $user->last_login_at->diffForHumans() }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                               ($user->role === 'moderator' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button wire:click="toggleStatus({{ $user->id }})" 
                                class="px-2 py-1 text-xs rounded-full cursor-pointer
                                {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($user->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $user->status }}
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Tahrirlash</button>
                        @if(auth()->id() !== $user->id)
                            <button wire:click="delete({{ $user->id }})" 
                                    wire:confirm="Are you sure you want to delete this user?"
                                    class="text-red-600 hover:text-red-900">O'chirish</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        Foydalanuvchilar topilmadi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showCreateModal', false)"></div>
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full relative z-10">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Yangi foydalanuvchi</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ism</label>
                            <input wire:model="form.name" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                            @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input wire:model="form.email" type="email" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                            @error('form.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Parol</label>
                            <input wire:model="form.password" type="password" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                            @error('form.password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rol</label>
                            <select wire:model="form.role" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="form.status" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end gap-2 rounded-b-lg">
                    <button wire:click="$set('showCreateModal', false)" class="px-4 py-2 border rounded-lg">Bekor qilish</button>
                    <button wire:click="store" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Yaratish</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Modal -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showEditModal', false)"></div>
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full relative z-10">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Foydalanuvchini tahrirlash</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ism</label>
                            <input wire:model="form.name" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                            @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input wire:model="form.email" type="email" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                            @error('form.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Yangi parol (bo'sh qoldirilsa o'zgarmaydi)</label>
                            <input wire:model="form.password" type="password" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                            @error('form.password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rol</label>
                            <select wire:model="form.role" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="form.status" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end gap-2 rounded-b-lg">
                    <button wire:click="$set('showEditModal', false)" class="px-4 py-2 border rounded-lg">Bekor qilish</button>
                    <button wire:click="update" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Yangilash</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
