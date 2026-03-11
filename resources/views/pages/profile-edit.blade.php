<x-layout>
    <x-slot:title>Profilni tahrirlash</x-slot:title>

    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-purple-900/20">
        <!-- Background Shapes -->
        <div class="absolute inset-0">
            <div
                class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-blue-200/20 to-blue-300/20 dark:bg-blue-400/10 rounded-full blur-3xl animate-pulse">
            </div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-br from-purple-200/20 to-purple-300/20 dark:bg-purple-400/10 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 1s"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-gradient-to-br from-indigo-200/15 to-indigo-300/15 dark:bg-indigo-400/8 rounded-full blur-2xl animate-pulse"
                style="animation-delay: 2s"></div>
        </div>

        <!-- Edit Profile Container -->
        <div class="relative z-10 container mx-auto px-4 py-12">
            <div class="max-w-2xl mx-auto">
                <!-- Edit Profile Card -->
                <div
                    class="border rounded-2xl border-gray-200/60 backdrop-blur-xl bg-white dark:bg-gray-800/95 shadow-2xl dark:shadow-black/20 border-gray-200 dark:border-gray-700">
                    <div class="p-8">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-100 via-blue-50 to-indigo-100 dark:from-gray-700 dark:to-gray-600 rounded-full mb-4 shadow-lg border border-blue-200/50 dark:border-gray-600">
                                <img src="{{ asset('images/lcwayfavicon.png') }}" alt="FindCourse"
                                    class="w-16 h-16 rounded-full">
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Profilni tahrirlash</h1>
                            <p class="text-gray-600 dark:text-gray-300">Shaxsiy ma'lumotlaringizni yangilang</p>
                        </div>

                        <!-- Edit Profile Form -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Avatar Section -->
                            <div class="text-center mb-8">
                                <div class="relative inline-block">
                                    @isset(Auth::user()->avatar)    
                                        @php
                                            if (str_starts_with(Auth::user()->avatar, 'http')) {
                                                $avatarUrl = Auth::user()->avatar;
                                            } else {
                                                $avatarUrl = Storage::url(Auth::user()->avatar);
                                            }
                                        @endphp
                                        <img id="avatar-preview" src="{{ $avatarUrl }}"
                                            alt="{{ Auth::user()->name }}"
                                            class="w-24 h-24 rounded-full ring-4 ring-white dark:ring-gray-800 shadow-xl">
                                    @else
                                        <img id="avatar-preview"
                                            src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random&size=96"
                                            alt="{{ Auth::user()->name }}"
                                            class="w-24 h-24 rounded-full ring-4 ring-white dark:ring-gray-800 shadow-xl">
                                    @endisset
                                    <label for="avatar"
                                        class="absolute bottom-0 right-0 w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center cursor-pointer hover:bg-primary-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </label>
                                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*"
                                        onchange="previewAvatar(event)">
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Rasmni o'zgartirish uchun
                                    kameraga bosing</p>
                            </div>

                            <!-- Name Field -->
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ism
                                </label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Ismingiz">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email
                                </label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                    placeholder="email@example.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bio Field -->
                            <div>
                                <label for="bio"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bio
                                </label>
                                <textarea id="bio" name="bio" rows="4"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                    placeholder="O'zingiz haqida qisqacha...">{{ Auth::user()->bio ?? '' }}</textarea>
                                @error('bio')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Personal Information Section -->
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Shaxsiy ma'lumotlar
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="first_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Ism
                                        </label>
                                        <input type="text" id="first_name" name="first_name"
                                            value="{{ $userData->first_name ?? '' }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Ismingiz">
                                        @error('first_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="last_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Familiya
                                        </label>
                                        <input type="text" id="last_name" name="last_name"
                                            value="{{ $userData->last_name ?? '' }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Familiyangiz">
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Telefon raqami
                                        </label>
                                        <input type="tel" id="phone" name="phone"
                                            value="{{ $userData->phone ?? '' }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="+998 90 123 45 67">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="gander"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Jins
                                        </label>
                                        <select id="gander" name="gander" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                                            <option value="">Jinsni tanlang</option>
                                            <option value="male"
                                                {{ ($userData->gander ?? '') == 'male' ? 'selected' : '' }}>Erkak
                                            </option>
                                            <option value="female"
                                                {{ ($userData->gander ?? '') == 'female' ? 'selected' : '' }}>Ayol
                                            </option>
                                        </select>
                                        @error('gander')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="birthday"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Tug'ilgan kun
                                        </label>
                                        <input type="date" id="birthday" name="birthday"
                                            value="{{ $userData?->birthday?->format('Y-m-d') ?? '' }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                                        @error('birthday')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Password Fields -->
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Parolni o'zgartirish
                                </h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="current_password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Joriy parol
                                        </label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Joriy parol">
                                        @error('current_password')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Yangi parol
                                        </label>
                                        <input type="password" id="password" name="password"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Yangi parol">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Yangi parolni tasdiqlang
                                        </label>
                                        <input type="password" id="password_confirmation"
                                            name="password_confirmation"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Yangi parolni qayta kiriting">
                                        @error('password_confirmation')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex space-x-4 pt-6">
                                <button type="submit"
                                    class="flex-1 px-6 py-3 bg-green-500 text-white rounded-lg hover:shadow-lg transition-all duration-300 font-medium">
                                    Saqlash
                                </button>
                                <a href="{{ route('profile') }}"
                                    class="flex-1 px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-200 font-medium text-center">
                                    Bekor qilish
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewAvatar(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('avatar-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

    <style>
        /* Override autofill colors for light mode */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #111827 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        
        /* Dark mode autofill */
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover,
        .dark input:-webkit-autofill:focus,
        .dark input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #374151 inset !important;
            -webkit-text-fill-color: #f9fafb !important;
        }
    </style>
</x-layout>
