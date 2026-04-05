<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-2xl font-bold text-gray-900">O'qituvchilar</h2>
        <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yangi o'qituvchi
        </button>
    </div>

    <div class="bg-white p-4 rounded-xl border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input wire:model.live="search" type="text" placeholder="Qidirish..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <select wire:model.live="centerFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Barcha markazlar</option>
                @foreach($centers as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            <select wire:model.live="perPage" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="10">10 / sahifa</option>
                <option value="20">20 / sahifa</option>
            </select>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('message') }}</div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer">
                        Ism @if($sortField === 'name') {{ $sortDirection === 'asc' ? '↑' : '↓' }} @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Markaz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telefon</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($teachers as $teacher)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $teacher->name }}</div>
                        <div class="text-sm text-gray-500">{{ $teacher->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher->learningCenter?->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher->phone }}</td>
                    <td class="px-6 py-4 text-right text-sm">
                        <button wire:click="edit({{ $teacher->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Tahrirlash</button>
                        <button wire:click="delete({{ $teacher->id }})" wire:confirm="O'chirishni tasdiqlaysizmi?" class="text-red-600 hover:text-red-900">O'chirish</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">O'qituvchilar topilmadi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $teachers->links() }}</div>

    @if($showCreateModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: true }">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showCreateModal', false)"></div>
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full relative z-10">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">Yangi o'qituvchi</h3>
                    <div class="space-y-4">
                        <input wire:model="form.name" type="text" placeholder="Ism" class="w-full border rounded-lg px-3 py-2">
                        <input wire:model="form.phone" type="text" placeholder="Telefon" class="w-full border rounded-lg px-3 py-2">
                        <input wire:model="form.email" type="email" placeholder="Email" class="w-full border rounded-lg px-3 py-2">
                        <textarea wire:model="form.bio" placeholder="Bio" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
                        <select wire:model="form.learning_center_id" class="w-full border rounded-lg px-3 py-2">
                            <option value="">Markaz tanlang</option>
                            @foreach($centers as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end gap-2 rounded-b-lg">
                    <button wire:click="$set('showCreateModal', false)" class="px-4 py-2 border rounded-lg">Bekor</button>
                    <button wire:click="store" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Saqlash</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showEditModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$set('showEditModal', false)"></div>
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full relative z-10">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">O'qituvchini tahrirlash</h3>
                    <div class="space-y-4">
                        <input wire:model="form.name" type="text" placeholder="Ism" class="w-full border rounded-lg px-3 py-2">
                        <input wire:model="form.phone" type="text" placeholder="Telefon" class="w-full border rounded-lg px-3 py-2">
                        <input wire:model="form.email" type="email" placeholder="Email" class="w-full border rounded-lg px-3 py-2">
                        <textarea wire:model="form.bio" placeholder="Bio" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
                        <select wire:model="form.learning_center_id" class="w-full border rounded-lg px-3 py-2">
                            <option value="">Markaz tanlang</option>
                            @foreach($centers as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end gap-2 rounded-b-lg">
                    <button wire:click="$set('showEditModal', false)" class="px-4 py-2 border rounded-lg">Bekor</button>
                    <button wire:click="update" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Yangilash</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
