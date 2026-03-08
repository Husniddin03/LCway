<x-layout>
    <x-slot:title>
        Rasimlarni tahrirlash
    </x-slot>
    <script>
        // Image preview functionality
        function previewImages(event) {
            const files = event.target.files;
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('image-preview-container');
            
            if (files.length === 0) {
                container.classList.add('hidden');
                return;
            }
            
            // Show preview container
            container.classList.remove('hidden');
            preview.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="Preview ${index + 1}" 
                                 class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center p-2">
                                <span class="text-white text-xs font-medium text-center break-words">${file.name}</span>
                            </div>
                            <button type="button" onclick="removePreviewImage(this)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Remove preview image
        function removePreviewImage(button) {
            button.parentElement.remove();
            const preview = document.getElementById('image-preview');
            if (preview.children.length === 0) {
                closePreview();
            }
        }
        
        // Close preview
        function closePreview() {
            const container = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview');
            const fileInput = document.getElementById('images');
            
            container.classList.add('hidden');
            fileInput.value = '';
            preview.innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-center col-span-full">Rasmlar tanlanmagan</p>';
        }
        
        // Clear file input
        function clearFileInput() {
            closePreview();
        }
    </script>
    <style>
        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Floating shapes */
        .floating-shape {
            position: absolute;
            opacity: 0.1;
            pointer-events: none;
        }
        
        .shape-1 {
            top: 10%;
            left: 5%;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }
        
        .shape-2 {
            top: 20%;
            right: 10%;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 10s ease-in-out infinite reverse;
        }
        
        .shape-3 {
            bottom: 20%;
            left: 8%;
            width: 120px;
            height: 120px;
            background: linear-gradient(225deg, #3b82f6, #8b5cf6);
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            animation: float 12s ease-in-out infinite;
        }
        
        /* Modern card styles */
        .modern-card {
            background: white;
            dark:bg-gray-800;
            border: 1px solid #e5e7eb;
            dark:border-gray-700;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .dark .modern-card {
            background: #1f2937;
            border-color: #374151;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        
        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
        
        .dark .modern-card:hover {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }
        
        /* Modern button styles */
        .modern-btn {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        /* Modern input styles */
        .modern-input {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            color: #111827;
            padding: 12px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .dark .modern-input {
            background: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }
        
        .modern-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Image gallery styles */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        
        .image-item {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .dark .image-item {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .image-item:hover {
            transform: scale(1.05);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }
        
        .dark .image-item:hover {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
        }
        
        .image-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .image-item:hover img {
            transform: scale(1.1);
        }
        
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ef4444;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
        }
        
        .image-item:hover .delete-btn {
            opacity: 1;
        }
        
        .delete-btn:hover {
            transform: scale(1.1);
            background: #dc2626;
        }
        
        /* Contact info styles */
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: #f9fafb;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #111827;
        }
        
        .dark .contact-item {
            background: #374151;
            color: #f9fafb;
        }
        
        .contact-item:hover {
            background: #3b82f6;
            color: white;
            transform: translateX(5px);
        }
        
        /* Image preview grid */
        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 12px;
            margin-top: 16px;
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .preview-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                gap: 8px;
            }
            
            .preview-grid img {
                height: 80px !important;
            }
            
            .modern-card {
                padding: 1rem !important;
            }
            
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .grid {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            
            .flex.gap-4 {
                flex-direction: column !important;
                gap: 0.75rem !important;
            }
            
            .modern-btn {
                width: 100% !important;
                justify-content: center !important;
            }
        }
        
        @media (max-width: 640px) {
            .preview-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 6px;
            }
            
            .preview-grid img {
                height: 70px !important;
            }
        }
    </style>
    <!-- ===== Contact Start ===== -->
    <section class="min-h-screen relative overflow-hidden bg-gray-50 dark:bg-gray-900">
        <!-- Floating Shapes -->
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>

        <div class="container mx-auto px-4 py-12 relative z-10">
            <!-- Header Section -->
            <div class="text-center mb-12" x-data="{ sectionTitle: `{{ $LearningCenter->name }}`, sectionTitleText: `{{ $LearningCenter->name }}ga yangi rasimlar yuklang!` }">
                <div class="inline-block">
                    <h1 x-text="sectionTitle" class="text-5xl font-bold mb-4">
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto" x-text="sectionTitleText"></p>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Learning Center Info Card -->
                <div class="lg:col-span-1">
                    <div class="modern-card p-8 h-full">
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ $LearningCenter->name }}</h3>
                            <span class="inline-block px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                                {{ $LearningCenter->type }}
                            </span>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Bog'lanish
                            </h4>
                            <div class="space-y-3">
                                @foreach ($LearningCenter->connections as $connection)
                                    @if ($connection->connection->name == 'Phone')
                                        <a href="tel:{{ $connection->url }}" class="contact-item">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.62 2.48a2 2 0 01-.45 1.885l-1.516 1.516a16 16 0 006.586 6.586l1.516-1.516a2 2 0 011.885-.45l2.48.62A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1c-9.94 0-18-8.06-18-18V5z"></path>
                                            </svg>
                                            <span>{{ $connection->url }}</span>
                                        </a>
                                    @elseif($connection->connection->name == 'Email')
                                        <a href="mailto:{{ $connection->url }}" class="contact-item">
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Email</span>
                                        </a>
                                    @elseif($connection->connection->name == 'Website')
                                        <a href="{{ $connection->url }}" class="contact-item">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                            </svg>
                                            <span>Website</span>
                                        </a>
                                    @else
                                        <a href="{{ $connection->url }}" class="contact-item">
                                            <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/{{ strtolower($connection->connection->name) }}.svg"
                                                width="20" height="20" alt="{{ $connection->connection->name }}" />
                                            <span>{{ $connection->connection->name }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="lg:col-span-2">
                    <div class="modern-card p-8">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Mavjud Rasmlar
                        </h2>
                        
                        @if($LearningCenter->images->count() > 0)
                            <div class="image-gallery">
                                @foreach ($LearningCenter->images as $image)
                                    <div class="image-item">
                                        <a href="{{ asset('storage/' . $image->image) }}" data-fslightbox>
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="Course Image" />
                                        </a>
                                        <form action="{{ route('course.deleteImage', $image->id) }}" method="post" 
                                              onsubmit="return confirm('Rostdan ham rasimni o‘chirilsinmi?');">
                                            @csrf
                                            <button type="submit" class="delete-btn">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-24 h-24 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-lg">Hozircha rasmlar yuklanmagan</p>
                            </div>
                        @endif

                        <!-- Upload Form -->
                        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Yangi Rasmlar Yuklash
                            </h3>
                            
                            <form action="{{ route('course.storeImages', ['id' => $LearningCenter->id]) }}" 
                                  method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                
                                <div>
                                    <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Rasimlarni tanlang
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 transition-colors cursor-pointer"
                                         onclick="document.getElementById('images').click()">
                                        <input type="file" name="images[]" id="images" class="hidden" accept="image/*" multiple onchange="previewImages(event)">
                                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Rasimlarni tanlash uchun bosing
                                        </p>
                                    </div>
                                    @error('images')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Image Preview -->
                                <div id="image-preview-container" class="hidden">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-medium text-gray-800 dark:text-white">Tanlangan rasmlar</h4>
                                        <button type="button" onclick="closePreview()" 
                                                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="image-preview" class="preview-grid">
                                        <p class="text-gray-500 dark:text-gray-400 text-center col-span-full">Rasmlar tanlanmagan</p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <div class="flex flex-col sm:flex-row gap-2 flex-1">
                                        <a href="{{ route('blog-single', $LearningCenter->id) }}" 
                                           class="modern-btn bg-gray-500 hover:bg-gray-600">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            Orqaga
                                        </a>
                                    </div>
                                    <button type="submit" class="modern-btn flex-1 sm:flex-initial">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V2"></path>
                                        </svg>
                                        Saqlash
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Contact End ===== -->
</x-layout>
