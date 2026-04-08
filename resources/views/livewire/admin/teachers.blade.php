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
            <select wire:model.live="searchBy" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Barchasi</option>
                <option value="name">Ism</option>
                <option value="center">Markaz</option>
                <option value="phone">Telefon</option>
            </select>
            <input wire:model.live="search" type="text" placeholder="Qidirish..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rasmi</th>
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
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </td>
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
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">O'qituvchilar topilmadi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $teachers->links() }}</div>

    @if($showCreateModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Yangi o'qituvchi</h3>
            <form wire:submit.prevent="store">
                <div class="space-y-4">
                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rasm</label>
                        <input type="file" wire:model="teacherPhoto" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('teacherPhoto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        
                        @if($teacherPhotoPreview)
                        <div class="mt-2">
                            <img src="{{ $teacherPhotoPreview }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                        </div>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ism</label>
                        <input type="text" wire:model="form.name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('form.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telefon</label>
                        <input type="text" wire:model="form.phone" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('form.phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model="form.email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea wire:model="form.bio" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Markaz</label>
                        <select wire:model="form.learning_centers_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Markaz tanlang</option>
                            @foreach($centers as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('form.learning_centers_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Subject Assignment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan</label>
                        <select wire:model="form.subject_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Fan tanlang</option>
                            @foreach($this->getCenterSubjects() as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan turi</label>
                        <input type="text" wire:model="form.subject_type" placeholder="Guruh, individual..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan ikoni</label>
                        <input type="text" wire:model="form.subject_icon" placeholder="math, science..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Narx</label>
                            <input type="number" wire:model="form.price" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valyuta</label>
                            <input type="text" wire:model="form.currency" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Davr</label>
                        <input type="text" wire:model="form.period" placeholder="oy, hafta..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tavsif</label>
                        <textarea wire:model="form.description" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Bekor qilish</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700" wire:loading.attr="disabled" wire:target="store">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($showEditModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-medium text-gray-900 mb-4">O'qituvchini tahrirlash</h3>
            <form wire:submit.prevent="update">
                <div class="space-y-4">
                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rasm</label>
                        <input type="file" wire:model="teacherPhoto" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('teacherPhoto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        
                        @if($teacherPhotoPreview)
                        <div class="mt-2">
                            <img src="{{ $teacherPhotoPreview }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                        </div>
                        @elseif($editingTeacher && $editingTeacher->photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $editingTeacher->photo) }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                        </div>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ism</label>
                        <input type="text" wire:model="form.name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('form.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telefon</label>
                        <input type="text" wire:model="form.phone" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('form.phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model="form.email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea wire:model="form.bio" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Markaz</label>
                        <select wire:model="form.learning_centers_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Markaz tanlang</option>
                            @foreach($centers as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('form.learning_centers_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Subject Assignment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan</label>
                        <select wire:model="form.subject_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Fan tanlang</option>
                            @foreach($this->getCenterSubjects() as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                        
                        @if($editingTeacher && $editingTeacher->teacherSubjects->count() > 0)
                        <div class="mt-2 p-2 bg-gray-50 rounded-lg">
                            <p class="text-xs font-medium text-gray-600 mb-1">Biriktirilgan fanlar:</p>
                            <div class="space-y-1">
                                @foreach($editingTeacher->teacherSubjects as $ts)
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-700">{{ $ts->subject->subject_name ?? 'Noma\'lum' }} {{ $ts->subject_type ? '(' . $ts->subject_type . ')' : '' }}</span>
                                    @if($ts->price)
                                    <span class="text-gray-500">{{ $ts->price }} {{ $ts->currency }}</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan turi</label>
                        <input type="text" wire:model="form.subject_type" placeholder="Guruh, individual..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan ikoni</label>
                        <input type="text" wire:model="form.subject_icon" placeholder="math, science..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Narx</label>
                            <input type="number" wire:model="form.price" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valyuta</label>
                            <input type="text" wire:model="form.currency" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Davr</label>
                        <input type="text" wire:model="form.period" placeholder="oy, hafta..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tavsif</label>
                        <textarea wire:model="form.description" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Bekor qilish</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700" wire:loading.attr="disabled" wire:target="update">Yangilash</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
