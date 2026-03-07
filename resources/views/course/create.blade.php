<x-layout>
    <x-slot:title>O'quv markaz qo'shish</x-slot:title>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Yangi o'quv markaz qo'shing
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    O'quv markazingiz haqida to'liq ma'lumotlarni kiriting
                </p>
            </div>

            <!-- Form Card -->
            <x-card class="mb-8">
                <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div
                            class="bg-danger-50 dark:bg-danger-900/20 border border-danger-200 dark:border-danger-800 rounded-xl p-4 mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-danger-600 dark:text-danger-400 mr-3 flex-shrink-0 mt-0.5"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 0116 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 2v4a1 1 0 102-2h-1zm-2 0a2 2 0 00-2 2v4a2 2 0 002 2h1A2 2 0 002 2v-4a2 2 0 00-2-2h-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-danger-800 dark:text-danger-200">Iltimos,
                                        xatolarni to'g'irlang:</h4>
                                    <ul class="mt-2 text-sm text-danger-700 dark:text-danger-300 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Logo Upload -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Markazning asosiy rasmi (logo)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 transition-colors cursor-pointer"
                                onclick="document.getElementById('logo').click()">
                                <input type="file" name="logo" id="logo" class="hidden" accept="image/*"
                                    onchange="document.getElementById('logo-preview').src = window.URL.createObjectURL(this.files[0])">
                                <div id="logo-preview"
                                    class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                        <circle cx="12" cy="13" r="3" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Logo yuklash uchun bosing
                                </p>
                            </div>
                            @error('logo')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomi <span class="text-danger-500">*</span>
                            </label>
                            <x-input type="text" name="name" id="name" value="{{ old('name') }}"
                                placeholder="O'quv markaz nomini kiriting" required />
                            @error('name')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Turi <span class="text-danger-500">*</span>
                            </label>
                            <select name="type" id="type"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white"
                                required>
                                <option value="" disabled {{ !old('type') ? 'selected' : '' }}>Markaz turini
                                    tanlang...</option>
                                <option value="O'quv markaz" {{ old('type') == 'O\'quv markaz' ? 'selected' : '' }}>
                                    O'quv markaz</option>
                                <option value="Akademiya" {{ old('type') == 'Akademiya' ? 'selected' : '' }}>Akademiya
                                </option>
                                <option value="Kollej" {{ old('type') == 'Kollej' ? 'selected' : '' }}>Kollej</option>
                                <option value="Unversitet" {{ old('type') == 'Unversitet' ? 'selected' : '' }}>
                                    Unversitet</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- About -->
                        <div class="lg:col-span-2">
                            <label for="about"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Haqida
                            </label>
                            <textarea name="about" id="about" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white resize-none"
                                placeholder="O'quv markaz haqida qisqacha ma'lumot...">{{ old('about') }}</textarea>
                            @error('about')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Images Upload -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Markaz rasmlari
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 transition-colors cursor-pointer"
                                onclick="document.getElementById('images').click()">
                                <input type="file" name="images[]" id="images" class="hidden" accept="image/*"
                                    multiple>
                                <div
                                    class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                        <circle cx="12" cy="13" r="3" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Markaz rasmlarini yuklash uchun bosing
                                </p>
                            </div>
                            @error('images.*')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Manzil ma'lumotlari</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Region -->
                            <div>
                                <label for="region"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Viloyat <span class="text-danger-500">*</span>
                                </label>
                                <select name="province" id="region"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white"
                                    required>
                                    <option value="" disabled {{ !old('province') ? 'selected' : '' }}>Viloyatni
                                        tanlang...</option>
                                    <option value="Toshkent" {{ old('province') == 'Toshkent' ? 'selected' : '' }}>
                                        Toshkent</option>
                                    <option value="Sirdaryo" {{ old('province') == 'Sirdaryo' ? 'selected' : '' }}>
                                        Sirdaryo</option>
                                    <option value="Jizzax" {{ old('province') == 'Jizzax' ? 'selected' : '' }}>Jizzax
                                    </option>
                                    <option value="Samarqand" {{ old('province') == 'Samarqand' ? 'selected' : '' }}>
                                        Samarqand</option>
                                    <option value="Buxoro" {{ old('province') == 'Buxoro' ? 'selected' : '' }}>Buxoro
                                    </option>
                                    <option value="Navoiy" {{ old('province') == 'Navoiy' ? 'selected' : '' }}>Navoiy
                                    </option>
                                    <option value="Qashqadaryo"
                                        {{ old('province') == 'Qashqadaryo' ? 'selected' : '' }}>Qashqadaryo</option>
                                    <option value="Surxandaryo"
                                        {{ old('province') == 'Surxandaryo' ? 'selected' : '' }}>Surxandaryo</option>
                                    <option value="Xorazm" {{ old('province') == 'Xorazm' ? 'selected' : '' }}>Xorazm
                                    </option>
                                    <option value="Andijon" {{ old('province') == 'Andijon' ? 'selected' : '' }}>
                                        Andijon</option>
                                    <option value="Namangan" {{ old('province') == 'Namangan' ? 'selected' : '' }}>
                                        Namangan</option>
                                    <option value="Farg'ona" {{ old('province') == 'Farg\'ona' ? 'selected' : '' }}>
                                        Farg'ona</option>
                                    <option value="Qoraqalpog'iston"
                                        {{ old('province') == 'Qoraqalpog\'iston' ? 'selected' : '' }}>Qoraqalpog'iston
                                    </option>
                                </select>
                                @error('province')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- District -->
                            <div>
                                <label for="district"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tuman <span class="text-danger-500">*</span>
                                </label>
                                <select name="region" id="district"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white"
                                    required>
                                    <option value="" disabled {{ !old('region') ? 'selected' : '' }}>Tumanni
                                        tanlang...</option>
                                    <option value="{{ old('region') }}" selected>{{ old('region') }}</option>
                                </select>
                                @error('region')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Manzil <span class="text-danger-500">*</span>
                                </label>
                                <x-input type="text" name="address" id="address" value="{{ old('address') }}"
                                    placeholder="To'liq manzilni kiriting" required />
                                @error('address')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="h-96 bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden">
                            <div id="map" class="w-full h-full"></div>
                        </div>

                        <!-- Hidden location fields -->
                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    </div>

                    <!-- Subjects and Pricing -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Fanlar va narxlar</h3>

                        <div id="subjects-wrapper" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Fan <span class="text-danger-500">*</span>
                                    </label>
                                    <select name="subjects[0][id]"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white"
                                        required>
                                        <option value="" disabled>Fanni tanlang...</option>
                                        @foreach ($subjects as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Narxi (oyiga) <span class="text-danger-500">*</span>
                                    </label>
                                    <x-input type="number" name="subjects[0][price]" placeholder="Masalan: 1000000"
                                        required />
                                    @error('subjects.0.price')
                                        <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-subject"
                            class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Fan qo'shish
                        </button>
                    </div>

                    <!-- Schedule -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ish grafigi</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $uzbekDays = [
                                    1 => 'Dushanba',
                                    2 => 'Seshanba',
                                    3 => 'Chorshanba',
                                    4 => 'Payshanba',
                                    5 => 'Juma',
                                    6 => 'Shanba',
                                ];
                            @endphp

                            @for ($day = 0; $day < 6; $day++)
                                <div class="space-y-2">
                                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $uzbekDays[$day + 1] }}
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label
                                                class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Ochilishi</label>
                                            <input type="time" name="days[{{ $day }}][open_time]"
                                                value="{{ old("days.$day.open_time", '06:00') }}"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white">
                                            @error("days.$day.open_time")
                                                <p class="mt-1 text-xs text-danger-600 dark:text-danger-400">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Yopilishi</label>
                                            <input type="time" name="days[{{ $day }}][close_time]"
                                                value="{{ old("days.$day.close_time", '18:00') }}"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white">
                                            @error("days.$day.close_time")
                                                <p class="mt-1 text-xs text-danger-600 dark:text-danger-400">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="hidden" name="days[{{ $day }}][calendar_id]"
                                        value="{{ $day + 1 }}">
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Student Count -->
                    <div>
                        <label for="studentCount"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Hozirda markazingizdagi o'quvchilar soni
                        </label>
                        <x-input type="number" name="student_count" id="studentCount"
                            value="{{ old('student_count') }}" placeholder="0" min="0" />
                        @error('student_count')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit"
                            class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17,21 17,13 7,13 7,21" />
                                <polyline points="7,3 7,8 15,8" />
                            </svg>
                            Saqlash
                        </button>
                        <a href="{{ route('index') }}"
                            class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-3 px-6 rounded-xl transition-all duration-300 text-center">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Bekor qilish
                        </a>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer>
    </script>

    <script>
        // Logo preview functionality
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('logo-preview').innerHTML =
                        `<img src="${e.target.result}" class="w-full h-full object-cover rounded-full">`;
                };
                reader.readAsDataURL(file);
            }
        });

        // Multiple images preview functionality
        document.getElementById('images').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const previewContainer = document.getElementById('images-preview');

            if (files.length > 0) {
                let previewHtml = '<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">';

                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgElement = document.getElementById(`preview-${index}`);
                        if (imgElement) {
                            imgElement.src = e.target.result;
                        }
                    };
                    reader.readAsDataURL(file);

                    previewHtml += `
                        <div class="relative group">
                            <img id="preview-${index}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600" alt="Preview ${index + 1}">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm">${file.name}</span>
                            </div>
                        </div>
                    `;
                });

                previewHtml += '</div>';

                // Create or update preview container
                if (!previewContainer) {
                    const container = document.querySelector('input[name="images[]"]').parentElement;
                    const div = document.createElement('div');
                    div.id = 'images-preview';
                    div.innerHTML = previewHtml;
                    container.appendChild(div);
                } else {
                    previewContainer.innerHTML = previewHtml;
                }
            }
        });

        // Districts by region data
        const districtsByRegion = {
            "Toshkent": ["Bekobod", "Bo'ka", "Chinoz", "Oqqo'rg'on", "Ohangaron", "Piskent", "Quyichirchiq",
                "Yuqorichirchiq", "Zangiota", "Toshkent tumani", "Parkent"
            ],
            "Sirdaryo": ["Guliston", "Boyovut", "Sardoba", "Mirzaobod", "Hovos", "Oqoltin", "Sayxunobod",
                "Sirdaryo tumani"
            ],
            "Jizzax": ["Jizzax shahri", "Arnasoy", "Baxmal", "Do'stlik", "Forish", "G'llaorol", "Sharof Rashidov",
                "Paxtakor", "Zomin", "Yangiobod", "Mirzacho'l", "Gagarin"
            ],
            "Samarqand": ["Samarqand shahri", "Bulung'ur", "Jomboy", "Ishtixon", "Kattaqo'rg'on", "Narpay", "Oqdaryo",
                "Pastdarg'om", "Payariq", "Qo'shrabot", "Samarqand tumani", "Tayloq", "Urgut", "Chelak", "Ziyodin",
                "Kattaqo'rg'on shahri"
            ],
            "Buxoro": ["Buxoro shahri", "Buxoro tumani", "G'ijduvon", "Jondor", "Kogon shahri", "Kogon tumani", "Olot",
                "Peshku", "Qorako'l", "Qorovulbozor", "Shofirkon"
            ],
            "Navoiy": ["Navoiy shahri", "Zarafshon shahri", "Karmana", "Xatirchi", "Qiziltepa", "Navbahor", "Tomdi",
                "Uchquduq"
            ],
            "Qashqadaryo": ["Qarshi shahri", "Qarshi tumani", "Shahrisabz shahri", "Shahrisabz tumani", "Kitob",
                "Yakkabog'", "Chiroqchi", "Nishon", "Muborak", "Qamashi", "Koson", "Kasbi", "G'uzor", "Mirishkor"
            ],
            "Surxandaryo": ["Termiz shahri", "Angor", "Boysun", "Denov", "Jarqo'rg'on", "Muzrabot", "Oltinsoy",
                "Qiziriq", "Qumqo'rg'on", "Sariosiyo", "Sherobod", "Sho'rch", "Termiz tumani", "Uzun"
            ],
            "Xorazm": ["Urganch shahri", "Bog'ot", "Gurlan", "Hazorasp", "Xiva", "Qo'shko'pir", "Shovot", "Tuproqqal'a",
                "Urganch tumani", "Xonqa", "Yangibozor"
            ],
            "Andijon": ["Andijon shahri", "Andijon tumani", "Asaka", "Baliqchi", "Bo'z", "Buloqboshi", "Izboskan",
                "Jalolquduq", "Xo'jaobod", "Qo'rg'ontepa", "Marhamat", "Oltinko'l", "Paxtaobod", "Shahrixon",
                "Ulug'nor", "Xonobod shahri"
            ],
            "Namangan": ["Namangan shahri", "Chortoq", "Chust", "Kosonsoy", "Mingbuloq", "Norin", "Pop",
                "To'raqo'rg'on", "Uychi", "Yangiqo'rg'on", "Namangan tumani"
            ],
            "Farg'ona": ["Farg'ona shahri", "Qo'qon shahri", "Marg'ilon shahri", "Oltiariq", "O'zbekiston tumani",
                "Quva", "Rishton", "Toshloq", "Yozyovon", "Dang'ara", "Beshariq", "Bog'dod", "So'x", "Uchko'prik",
                "Furqat"
            ],
            "Qoraqalpog'iston": ["Nukus shahri", "Amudaryo", "Beruniy", "Chimboy", "Ellikqal'a", "Kegeyli", "Mo'ynoq",
                "Nukus tumani", "Qanliko'l", "Qo'ng'irot", "Qorao'zak", "Shumanay", "Taxtako'pir", "To'tko'l",
                "Xo'jayli", "Taxiatosh shahri"
            ]
        };

        // Region/District functionality
        const regionSelect = document.getElementById("region");
        const districtSelect = document.getElementById("district");

        regionSelect.addEventListener("change", () => {
            const selectedRegion = regionSelect.value;
            districtSelect.innerHTML = '<option value="" disabled selected>Tumanni tanlang...</option>';

            if (districtsByRegion[selectedRegion]) {
                districtsByRegion[selectedRegion].forEach((district) => {
                    const option = document.createElement("option");
                    option.value = district;
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
        });

        // Add subject functionality
        let subjectIndex = 1;
        document.getElementById('add-subject').addEventListener('click', function() {
            const wrapper = document.getElementById('subjects-wrapper');
            const newRow = document.createElement('div');
            newRow.className = 'grid grid-cols-1 md:grid-cols-2 gap-4';
            newRow.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Fan <span class="text-danger-500">*</span>
                    </label>
                    <select name="subjects[${subjectIndex}][id]" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white" required>
                        <option value="" disabled>Fanni tanlang...</option>
                        @foreach ($subjects as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Narxi (oyiga) <span class="text-danger-500">*</span>
                    </label>
                    <input type="number" name="subjects[${subjectIndex}][price]" placeholder="Masalan: 1000000"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white" required>
                </div>
            `;
            wrapper.appendChild(newRow);
            subjectIndex++;
        });

        // Map initialization
        function initMap() {
            const mapElement = document.getElementById("map");
            if (!mapElement) return;

            // Default location (Samarqand, Uzbekistan)
            const defaultLocation = {
                lat: 39.6574,
                lng: 66.9601
            };

            const map = new google.maps.Map(mapElement, {
                center: defaultLocation,
                zoom: 12,
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true
            });

            let marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
                title: "O'quv markaz manzili"
            });

            // Update hidden fields when marker is dragged
            marker.addListener('dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // Update marker position when map is clicked
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        marker.setPosition(userLocation);
                        document.getElementById('latitude').value = userLocation.lat;
                        document.getElementById('longitude').value = userLocation.lng;
                    },
                    function(error) {
                        console.log('Geolokatsiya xatosi:', error.message);
                    }
                );
            }
        }

        // Initialize map when page loads
        if (typeof google !== 'undefined') {
            window.initMap = initMap;
        }
    </script>
</x-layout>
