<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-2xl font-bold text-gray-900">Izohlar</h2>
    </div>

    <div class="bg-white p-4 rounded-xl border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <select wire:model.live="searchBy" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Barchasi</option>
                <option value="user">Foydalanuvchi</option>
                <option value="center">Markaz</option>
                <option value="comment">Izoh</option>
            </select>
            <input wire:model.live="search" type="text" placeholder="Qidirish..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <select wire:model.live="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Barcha statuslar</option>
                <option value="approved">Tasdiqlangan</option>
                <option value="pending">Kutilmoqda</option>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foydalanuvchi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Markaz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Izoh</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sevimlilar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amallar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($comments as $comment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $comment->user?->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $comment->learningCenter?->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $comment->comment }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $favoritesCount[$comment->learning_centers_id] ?? 0 }}
                    </td>
                    <td class="px-6 py-4">
                        @if($comment->checked)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Tasdiqlangan</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Kutilmoqda</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        @if(!$comment->checked)
                            <button wire:click="approve({{ $comment->id }})" class="text-green-600 hover:text-green-900 mr-3">Tasdiqlash</button>
                        @else
                            <button wire:click="reject({{ $comment->id }})" class="text-yellow-600 hover:text-yellow-900 mr-3">Rad etish</button>
                        @endif
                        <button wire:click="delete({{ $comment->id }})" wire:confirm="O'chirishni tasdiqlaysizmi?" class="text-red-600 hover:text-red-900">O'chirish</button>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Izohlar topilmadi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $comments->links() }}</div>
</div>
