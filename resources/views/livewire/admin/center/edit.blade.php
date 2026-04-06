<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.centers') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">O'quv markazini tahrirlash</h2>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form wire:submit="update" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                    <input wire:model="logoFile" type="file" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('logoFile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    
                    <!-- Preview: new file or existing logo -->
                    <div class="mt-3 flex items-center space-x-4">
                        @if($logoFile)
                            <!-- New file preview -->
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Yangi logo:</p>
                                <img src="{{ $logoFile->temporaryUrl() }}" alt="New Logo" class="h-16 w-16 object-cover rounded-lg border">
                            </div>
                        @elseif($form['logo'])
                            <!-- Existing logo -->
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Joriy logo:</p>
                                <img src="{{ asset('storage/' . $form['logo']) }}" alt="Current Logo" class="h-16 w-16 object-cover rounded-lg border">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Name -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomi *</label>
                    <input wire:model="form.name" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Turi *</label>
                    <select wire:model="form.type" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="O'quv markaz">O'quv markaz</option>
                        <option value="Kurs">Kurs</option>
                        <option value="Trening">Trening</option>
                        <option value="Maktab">Maktab</option>
                        <option value="Universitet">Universitet</option>
                    </select>
                    @error('form.type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select wire:model="form.status" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('form.status') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Country -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mamlakat *</label>
                    <input wire:model="form.country" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.country') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Province -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Viloyat *</label>
                    <input wire:model="form.province" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.province') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tuman *</label>
                    <input wire:model="form.region" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.region') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Manzil *</label>
                    <input wire:model="form.address" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokatsiya (lat,lng)</label>
                    <input wire:model="form.location" type="text" placeholder="41.2615,69.2177"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.location') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Student Count -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">O'quvchilar soni</label>
                    <input wire:model="form.student_count" type="number" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.student_count') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reyting (0-5)</label>
                    <input wire:model="form.rating" type="number" step="0.1" min="0" max="5"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.rating') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- User -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foydalanuvchi (Egasi) *</label>
                    <select wire:model="form.users_id" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Tanlang...</option>
                        @foreach($users as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('form.users_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- About -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tavsif (About) *</label>
                    <textarea wire:model="form.about" rows="4" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    @error('form.about') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Premium Until -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Premium muddati</label>
                    <input wire:model="form.premium_until" type="date" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.premium_until') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Checkboxes -->
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input wire:model="form.checked" type="checkbox" 
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Tasdiqlangan</span>
                    </label>
                    <label class="flex items-center">
                        <input wire:model="form.premium" type="checkbox" 
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Premium</span>
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.centers') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Bekor qilish
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Yangilash
                </button>
            </div>
        </form>
    </div>
</div>
