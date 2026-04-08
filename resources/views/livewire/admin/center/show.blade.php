<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.centers') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            @if($center->logo)
                <img src="{{ asset('storage/' . $center->logo) }}" alt="{{ $center->name }}" class="w-16 h-16 rounded-xl object-cover border border-gray-200 mr-4">
            @else
                <div class="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center mr-4">
                    <span class="text-indigo-600 text-2xl font-bold">{{ substr($center->name, 0, 1) }}</span>
                </div>
            @endif
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $center->name }}</h2>
                <p class="text-sm text-gray-500">{{ $center->address }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.centers.edit', $center->id) }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Tahrirlash
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Status Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Status</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Tasdiqlangan:</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               wire:click="toggleCenterChecked" 
                               {{ $center->checked ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Premium:</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               wire:click="toggleCenterPremium" 
                               {{ $center->premium ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Contact Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Aloqa</h3>
                <button wire:click="createConnection" class="text-green-600 hover:text-green-900 text-sm">+ Qo‘shish</button>
            </div>
            
            <!-- Social Networks -->
            @if($center->connections && $center->connections->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="space-y-2">
                        @foreach ($center->connections as $connection)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                @php
                                    $url = $connection->url;
                                    $name = strtolower($connection->connection_name);
                                    
                                    if ($name === 'phone' || str_contains($url, 'tel:')) {
                                        $url = str_replace('tel:', '', $url);
                                        $href = 'tel:' . $url;
                                    }
                                    elseif ($name === 'email' || str_contains($url, 'mailto:')) {
                                        $url = str_replace('mailto:', '', $url);
                                        $href = 'mailto:' . $url;
                                    }
                                    else {
                                        $href = $url;
                                    }
                                @endphp
                                <a href="{{ $href }}" 
                                   @if(!str_starts_with($href, 'tel:') && !str_starts_with($href, 'mailto:')) target="_blank" @endif
                                   class="flex items-center flex-1">
                                    <div class="w-8 h-8 flex items-center justify-center bg-white rounded-lg mr-2 shadow-sm">
                                        @if($connection->connection_icon)
                                            <x-social-icon :icon="$connection->connection_icon" size="w-5 h-5" />
                                        @else
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <span class="text-xs font-medium text-gray-700 truncate">{{ $connection->connection_name }}</span>
                                </a>
                                <div class="flex gap-2 ml-2">
                                    <button wire:click="editConnection({{ $connection->id }})" class="text-indigo-600 hover:text-indigo-900 text-xs">Tahrirlash</button>
                                    <button wire:click="deleteConnection({{ $connection->id }})" wire:confirm="O'chirishni tasdiqlaysizmi?" class="text-red-600 hover:text-red-900 text-xs">O'chirish</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-sm mt-4">Bog‘lanishlar yo‘q</p>
            @endif
        </div>

        <!-- Owner Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Egasi</h3>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                    <span class="text-indigo-600 font-medium">{{ substr($center->user?->name, 0, 1) }}</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $center->user?->name }}</p>
                    <p class="text-sm text-gray-500">{{ $center->user?->email }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Legal Info Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Huquqiy ma'lumotlar</h3>
            <div class="space-y-2 text-sm">
                @if($center->tin)
                    <div class="flex justify-between">
                        <span class="text-gray-600">STIR:</span>
                        <span class="font-medium text-gray-900">{{ $center->tin }}</span>
                    </div>
                @endif
                @if($center->license_number)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Litsenziya:</span>
                        <span class="font-medium text-gray-900">{{ $center->license_number }}</span>
                    </div>
                @endif
                @if($center->license_registration_date)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Berilgan sana:</span>
                        <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($center->license_registration_date)->format('d.m.Y') }}</span>
                    </div>
                @endif
                @if($center->license_validity_period)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amal qilish muddati:</span>
                        <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($center->license_validity_period)->format('d.m.Y') }}</span>
                    </div>
                @endif
                @if($center->manager_name)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Rahbar:</span>
                        <span class="font-medium text-gray-900">{{ $center->manager_name }}</span>
                    </div>
                @endif
                @if($center->phone_number)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Telefon:</span>
                        <span class="font-medium text-gray-900">{{ $center->phone_number }}</span>
                    </div>
                @endif
                @if($center->email)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-medium text-gray-900">{{ $center->email }}</span>
                    </div>
                @endif
                @if($center->ifut_code)
                    <div class="flex justify-between">
                        <span class="text-gray-600">IFUT:</span>
                        <span class="font-medium text-gray-900">{{ $center->ifut_code }}</span>
                    </div>
                @endif
                @if($center->territory)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Hudud:</span>
                        <span class="font-medium text-gray-900">{{ $center->territory }}</span>
                    </div>
                @endif
            </div>
            @if($center->legal_address)
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <span class="text-gray-600 text-sm">Yuridik manzil:</span>
                    <p class="text-sm text-gray-900 mt-1">{{ $center->legal_address }}</p>
                </div>
            @endif
        </div>

        <!-- Description -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tavsif</h3>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $center->about }}</p>
        </div>
    </div>

    <!-- Teachers List -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">O'qituvchilar ({{ $center->teachers->count() }})</h3>
            <button wire:click="createTeacher" class="text-green-600 hover:text-green-900 text-sm">+ Qo‘shish</button>
        </div> 
        @if($center->teachers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($center->teachers as $teacher)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-medium">{{ substr($teacher->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $teacher->name }}</p>
                            <p class="text-xs text-gray-500">{{ $teacher->phone }}</p>
                            @if($teacher->teacherSubjects->count() > 0)
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @foreach($teacher->teacherSubjects as $ts)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-800">
                                            {{ $ts->subject->subject_name ?? 'N/A' }}
                                            @if($ts->price) ({{ $ts->price }} {{ $ts->currency }}) @endif
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="editTeacher({{ $teacher->id }})" class="text-indigo-600 hover:text-indigo-900 text-sm">Tahrirlash</button>
                            <button wire:click="deleteTeacher({{ $teacher->id }})" wire:confirm="O'chirishni tasdiqlaysizmi?" class="text-red-600 hover:text-red-900 text-sm">O'chirish</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">O'qituvchilar yo'q</p>
        @endif
    </div>

    <!-- Subjects List -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Fanlar ({{ $center->subjects->count() }})</h3>
            <button wire:click="createSubject" class="text-green-600 hover:text-green-900 text-sm">+ Qo‘shish</button>
        </div>
        @if($center->subjects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($center->subjects as $subject)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $subject->subject_name }}</p>
                            @if($subject->teacherSubjects->count() > 0)
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @foreach($subject->teacherSubjects as $ts)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-green-100 text-green-800">
                                            {{ $ts->teacher->name ?? 'N/A' }}
                                            @if($ts->price) ({{ $ts->price }} {{ $ts->currency }}) @endif
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="editSubject({{ $subject->id }})" class="text-indigo-600 hover:text-indigo-900 text-sm">Tahrirlash</button>
                            <button wire:click="deleteSubject({{ $subject->id }})" wire:confirm="O'chirishni tasdiqlaysizmi?" class="text-red-600 hover:text-red-900 text-sm">O'chirish</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Fanlar yo'q</p>
        @endif
    </div>

    <!-- Comments List -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Izohlar ({{ $center->comments->count() }})</h3>
        </div>
        @if($center->comments->count() > 0)
            <div class="space-y-3">
                @foreach($center->comments as $comment)
                <div class="border border-gray-200 rounded-lg p-4 {{ $comment->checked ? 'bg-green-50' : 'bg-yellow-50' }}">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 text-xs font-medium">{{ substr($comment->user?->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-medium text-gray-900">{{ $comment->user?->name ?? 'Anonim' }}</p>
                                    @if($comment->checked)
                                        <span class="px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">Tasdiqlangan</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded-full">Kutilmoqda</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500">{{ $comment->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <p class="text-sm text-gray-700 mt-1">{{ $comment->comment }}</p>
                            @if($comment->rating)
                                <p class="text-xs text-yellow-600 mt-1">★ {{ $comment->rating }}/5</p>
                            @endif
                            <div class="flex gap-2 mt-3">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                        wire:click="toggleComment({{ $comment->id }})" 
                                        {{ $comment->checked ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                    <span class="ml-2 text-sm font-medium {{ $comment->checked ? 'text-green-600' : 'text-gray-500' }}">
                                        {{ $comment->checked ? 'Tasdiqlangan' : 'Kutilmoqda' }}
                                    </span>
                                </label>
                                <button wire:click="deleteComment({{ $comment->id }})" wire:confirm="O'chirishni tasdiqlaysizmi?" class="text-red-600 hover:text-red-900 text-sm ml-auto">O'chirish</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Izohlar yo'q</p>
        @endif
    </div>

    <!-- Weekdays/Schedule List -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Ish kunlari ({{ $center->weekdays->count() }})</h3>
        </div>
        @if(count($weekdays) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                @foreach($weekdays as $weekday)
                <div class="border border-gray-200 rounded-lg p-4 {{ $weekday['exists'] ? 'bg-green-50' : 'bg-gray-50' }}">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-gray-900">{{ $weekday['weekdays'] }}</p>
                        @if($weekday['exists'])
                            <span class="px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">Faol</span>
                        @else
                            <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full">Yopiq</span>
                        @endif
                    </div>
                    @if($weekday['exists'])
                        <p class="text-xs text-gray-600 mb-3">
                            {{ $weekday['open_time'] ? \Carbon\Carbon::parse($weekday['open_time'])->format('H:i') : '--:--' }} - 
                            {{ $weekday['close_time'] ? \Carbon\Carbon::parse($weekday['close_time'])->format('H:i') : '--:--' }}
                        </p>
                        <div class="flex gap-2">
                            <button wire:click="editWeekday('{{ $weekday['weekdays'] }}')" class="text-indigo-600 hover:text-indigo-900 text-xs">Tahrirlash</button>
                            <button wire:click="deleteWeekday({{ $weekday['id'] }})" wire:confirm="O'chirishni tasdiqlaysizmi?" class="text-red-600 hover:text-red-900 text-xs">O'chirish</button>
                        </div>
                    @else
                        <p class="text-xs text-gray-500 mb-3">Ish vaqti belgilanmagan</p>
                        <button wire:click="addWeekday('{{ $weekday['weekdays'] }}')" class="text-green-600 hover:text-green-900 text-xs">Qo‘shish</button>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Ish kunlari ma'lumoti yo'q</p>
        @endif
    </div>

    <!-- Images List with PhotoSwipe -->
    <div class="bg-white rounded-xl border border-gray-200 p-6" x-data="{
        images: {{ $center->images->map(fn($img) => ['src' => asset('storage/' . $img->image), 'width' => 1200, 'height' => 800, 'id' => $img->id])->toJson() }},
        initPhotoSwipe() {
            const lightbox = new window.PhotoSwipeLightbox({
                dataSource: this.images,
                pswpModule: window.PhotoSwipe,
                showHideAnimationType: 'zoom',
                bgOpacity: 0.9,
            });
            
            const deleteIcon = `<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path></svg>`;
            
            lightbox.on('afterInit', () => {
                const pswp = lightbox.pswp;
                const deleteBtn = document.createElement('button');
                deleteBtn.innerHTML = deleteIcon + '<span style=\'margin-left: 6px;\'>O\'chirish</span>';
                deleteBtn.style.cssText = 'position: absolute; bottom: 80px; left: 50%; transform: translateX(-50%); z-index: 10000; background: #dc2626; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; font-size: 14px;';
                deleteBtn.onclick = () => {
                    if (confirm('O\'chirishni tasdiqlaysizmi?')) {
                        const imageId = pswp.currSlide.data.id;
                        @this.deleteImage(imageId);
                        pswp.close();
                    }
                };
                pswp.element.appendChild(deleteBtn);
            });
            
            lightbox.init();
            this.lightbox = lightbox;
        },
        openPhotoSwipe(index) {
            this.lightbox.loadAndOpen(index);
        }
    }" x-init="initPhotoSwipe()">
        <style>
            .pswp__button--delete {
                color: #fff !important;
                background: #dc2626 !important;
                border-radius: 4px !important;
                padding: 8px 12px !important;
                display: flex !important;
                align-items: center !important;
                margin-right: 10px !important;
            }
            .pswp__button--delete:hover {
                background: #b91c1c !important;
            }
        </style>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Rasmlar ({{ $center->images->count() }})</h3>
            <button wire:click="openImageModal" class="text-green-600 hover:text-green-900 text-sm">+ Qo‘shish</button>
        </div>
        @if($center->images->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($center->images as $index => $image)
                <div class="relative group cursor-pointer" @click="openPhotoSwipe({{ $index }})">
                    <img src="{{ asset('storage/' . $image->image) }}" 
                         alt="Center image" 
                         class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <span class="text-white text-xs">Ko'rish</span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Rasmlar yo'q</p>
        @endif
    </div>

    <!-- Teacher Edit/Add Modal -->
    @if($showTeacherModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $editingTeacher ? 'O\'qituvchini tahrirlash' : 'Yangi o\'qituvchi' }}</h3>
            <form wire:submit.prevent="saveTeacher">
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
                        <input type="text" wire:model="teacherForm.name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('teacherForm.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telefon</label>
                        <input type="text" wire:model="teacherForm.phone" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('teacherForm.phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model="teacherForm.email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea wire:model="teacherForm.bio" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    
                    <!-- Subject Assignment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan</label>
                        <select wire:model="teacherForm.subject_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Fan tanlang</option>
                            @foreach($center->subjects as $subject)
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
                        <input type="text" wire:model="teacherForm.subject_type" placeholder="Guruh, individual..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan ikoni</label>
                        <input type="text" wire:model="teacherForm.subject_icon" placeholder="math, science..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Narx</label>
                            <input type="number" wire:model="teacherForm.price" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valyuta</label>
                            <input type="text" wire:model="teacherForm.currency" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Davr</label>
                        <input type="text" wire:model="teacherForm.period" placeholder="oy, hafta..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tavsif</label>
                        <textarea wire:model="teacherForm.description" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="closeTeacherModal" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Bekor qilish</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700" wire:loading.attr="disabled" wire:target="saveTeacher">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Subject Edit/Add Modal -->
    @if($showSubjectModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $editingSubject ? 'Fanni tahrirlash' : 'Yangi fan' }}</h3>
            <form wire:submit.prevent="saveSubject">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan nomi</label>
                        <input type="text" wire:model="subjectForm.subject_name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('subjectForm.subject_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Teacher Assignment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">O'qituvchi</label>
                        <select wire:model="subjectForm.teacher_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">O'qituvchi tanlang</option>
                            @foreach($center->teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        
                        @if($editingSubject && $editingSubject->teacherSubjects->count() > 0)
                        <div class="mt-2 p-2 bg-gray-50 rounded-lg">
                            <p class="text-xs font-medium text-gray-600 mb-1">Biriktirilgan o'qituvchilar:</p>
                            <div class="space-y-1">
                                @foreach($editingSubject->teacherSubjects as $ts)
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-700">{{ $ts->teacher->name ?? 'Noma\'lum' }} {{ $ts->subject_type ? '(' . $ts->subject_type . ')' : '' }}</span>
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
                        <input type="text" wire:model="subjectForm.subject_type" placeholder="Guruh, individual..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fan ikoni</label>
                        <input type="text" wire:model="subjectForm.subject_icon" placeholder="math, science..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Narx</label>
                            <input type="number" wire:model="subjectForm.price" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valyuta</label>
                            <input type="text" wire:model="subjectForm.currency" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Davr</label>
                        <input type="text" wire:model="subjectForm.period" placeholder="oy, hafta..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tavsif</label>
                        <textarea wire:model="subjectForm.description" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="closeSubjectModal" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Bekor qilish</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700" wire:loading.attr="disabled" wire:target="saveSubject">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Weekday Edit/Add Modal -->
    @if($showWeekdayModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $editingWeekday ? 'Ish kunini tahrirlash' : 'Yangi ish kuni' }}</h3>
            <form wire:submit.prevent="saveWeekday">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hafta kuni</label>
                        <input type="text" wire:model="weekdayForm.weekdays" readonly class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ochilish vaqti</label>
                            <input type="time" wire:model="weekdayForm.open_time" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Yopilish vaqti</label>
                            <input type="time" wire:model="weekdayForm.close_time" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="closeWeekdayModal" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Bekor qilish</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Image Upload Modal -->
    @if($showImageModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Yangi rasm qo'shish</h3>
            <form wire:submit.prevent="saveImage">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rasm tanlang</label>
                        <input type="file" wire:model="imageFile" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('imageFile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    @if($imagePreview)
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Oldindan ko'rish:</p>
                        <img src="{{ $imagePreview }}" class="w-full h-40 object-cover rounded-lg border border-gray-200">
                    </div>
                    @endif
                    
                    <div wire:loading wire:target="imageFile" class="text-sm text-gray-500">
                        Rasm yuklanmoqda...
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="closeImageModal" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Bekor qilish</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700" wire:loading.attr="disabled" wire:target="saveImage">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Connection Edit/Add Modal -->
    @if($showConnectionModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $editingConnection ? 'Bog\'lanishni tahrirlash' : 'Yangi bog\'lanish' }}</h3>
            <form wire:submit.prevent="saveConnection">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomi</label>
                        <input type="text" wire:model="connectionForm.connection_name" id="connection_name_input" placeholder="Telefon, Telegram, Instagram..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('connectionForm.connection_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ikon (ixtiyoriy)</label>
                        <input type="hidden" wire:model="connectionForm.connection_icon" id="connection_icon_input">
                        
                        <!-- Icon Picker Grid -->
                        <div class="grid grid-cols-6 sm:grid-cols-8 gap-2 p-3 bg-gray-50 rounded-xl border border-gray-200 mt-2">
                            <x-social-icon mode="picker" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">URL / Manzil</label>
                        <input type="text" wire:model="connectionForm.url" id="connection_url_input" placeholder="+998901234567 yoki https://t.me/username" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('connectionForm.url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="closeConnectionModal" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Bekor qilish</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>

<script>
    function selectIcon(iconClass, iconName) {
        const iconInput = document.getElementById('connection_icon_input');
        if (iconInput) {
            iconInput.value = iconClass;
            iconInput.dispatchEvent(new Event('input'));
        }
        document.querySelectorAll('.icon-btn').forEach(btn => {
            btn.classList.remove('ring-2', 'ring-blue-500', 'bg-white', 'dark:bg-gray-700');
            btn.style.backgroundColor = '';
        });
        const clickedBtn = event.currentTarget;
        clickedBtn.classList.add('ring-2', 'ring-blue-500', 'bg-white', 'dark:bg-gray-700');
        
        // Also update connection name if empty
        const nameInput = document.getElementById('connection_name_input');
        if (nameInput && !nameInput.value && iconName) {
            nameInput.value = iconName;
            nameInput.dispatchEvent(new Event('input'));
        }
        
        // Update URL placeholder
        updateUrlPlaceholder(iconClass);
    }
    
    function updateUrlPlaceholder(iconClass) {
        const urlInput = document.getElementById('connection_url_input');
        if (!urlInput) return;
        if (iconClass === 'fas fa-phone') {
            urlInput.placeholder = '+998 90 123 45 67';
        } else if (iconClass === 'fas fa-envelope') {
            urlInput.placeholder = 'example@mail.com';
        } else {
            urlInput.placeholder = 'https://t.me/username';
        }
    }
</script>
