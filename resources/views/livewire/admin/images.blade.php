<div class="space-y-6" x-data="{ initPhotoSwipe() {
    const lightbox = new PhotoSwipeLightbox({
        gallery: '#gallery',
        children: 'a',
        pswpModule: PhotoSwipe,
        bgOpacity: 0.9,
        spacing: 0.15,
        allowPanToNext: true,
        loop: true,
        wheelToZoom: true,
        pinchToClose: true,
        tapAction: 'toggle-controls',
        doubleTapAction: 'zoom',
    });
    lightbox.init();
} }" x-init="initPhotoSwipe()">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Rasmlar</h2>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input wire:model.live="search" type="text" placeholder="O'quv markazi bo'yicha qidirish..."
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session()->has('message'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-green-800">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Images Grid -->
    @if($images->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4" id="gallery">
            @foreach($images as $image)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden group relative">
                    <!-- Image -->
                    <div class="aspect-square bg-gray-100">
                        <a href="{{ asset('storage/' . $image->image) }}" 
                           data-pswp-width="1200" 
                           data-pswp-height="800"
                           class="block w-full h-full">
                            <img src="{{ asset('storage/' . $image->image) }}" 
                                 alt="Center image" 
                                 class="w-full h-full object-cover hover:opacity-90 transition-opacity cursor-pointer">
                        </a>
                    </div>
                    
                    <!-- Info -->
                    <div class="p-3">
                        <p class="text-xs text-gray-500 truncate">
                            {{ $image->learningCenter?->name ?? 'Noma\'lum markaz' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $image->created_at->format('d.m.Y') }}
                        </p>
                    </div>

                    <!-- Actions Overlay -->
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button wire:click="confirmDelete({{ $image->id }})" 
                                class="p-2 bg-red-500 text-white rounded-lg shadow-lg hover:bg-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $images->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-500">Rasmlar topilmadi</p>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($confirmingDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-600 bg-opacity-75">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Rasmni o'chirish</h3>
                <p class="text-gray-600 mb-6">Haqiqatan ham bu rasmini o'chirmoqchimisiz? Bu amalni ortga qaytarib bo'lmaydi.</p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="cancelDelete" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Bekor qilish
                    </button>
                    <button wire:click="delete({{ $confirmingDelete }})" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        O'chirish
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
