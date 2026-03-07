<x-layout>
    <x-slot:title>Yangi o'qituvchi qo'shish</x-slot:title>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $LearningCenter->name }}ga yangi o'qituvchi qo'shing
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Bu orqali talabalar o'qituvchilarni ham topa oladi
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Learning Center Info Card -->
                <div class="lg:col-span-1">
                    <x-card class="sticky top-8">
                        <div class="text-center mb-6">
                            <div
                                class="w-20 h-20 mx-auto mb-4 bg-primary-100 dark:bg-primary-900/20 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-primary-600 dark:text-primary-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $LearningCenter->name }}
                            </h3>
                            <x-badge variant="secondary">{{ $LearningCenter->type }}</x-badge>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Manzil</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $LearningCenter->address }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bog'lanish</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($LearningCenter->connections as $connection)
                                        @if ($connection->connection->name == 'Phone')
                                            <a href="tel:{{ $connection->url }}"
                                                class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.62 2.48a2 2 0 01-.45 1.885l-1.516 1.516a16 16 0 006.586 6.586l1.516-1.516a2 2 0 011.885-.45l2.48.62A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1c-9.94 0-18-8.06-18-18V5z" />
                                                </svg>
                                            </a>
                                        @elseif($connection->connection->name == 'Email')
                                            <a href="mailto:{{ $connection->url }}"
                                                class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ $connection->url }}" target="_blank"
                                                class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/{{ strtolower($connection->connection->name) }}.svg"
                                                    width="20" height="20"
                                                    alt="{{ $connection->connection->name }}" />
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </x-card>
                </div>

                <!-- Form -->
                <div class="lg:col-span-2">
                    <x-card>
                        <form action="{{ route('teacher.storeid', ['id' => $LearningCenter->id]) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div
                                    class="bg-danger-50 dark:bg-danger-900/20 border border-danger-200 dark:border-danger-800 rounded-xl p-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-danger-600 dark:text-danger-400 mr-3 flex-shrink-0 mt-0.5"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 0116 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 2v4a1 1 0 102-2h-1zm-2 0a2 2 0 00-2 2v4a2 2 0 002 2h1A2 2 0 002 2v-4a2 2 0 00-2-2h-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-medium text-danger-800 dark:text-danger-200">
                                                Iltimos, xatolarni to'g'irlang:</h4>
                                            <ul class="mt-2 text-sm text-danger-700 dark:text-danger-300 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>• {{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Photo Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ustoz rasmi (ixtiyoriy)
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 transition-colors cursor-pointer"
                                    onclick="document.getElementById('photo').click()">
                                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*"
                                        onchange="document.getElementById('photo-preview').src = window.URL.createObjectURL(this.files[0])">
                                    <div id="photo-preview"
                                        class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Rasm yuklash uchun bosing
                                    </p>
                                </div>
                                @error('photo')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name and Phone -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="fullname"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        To'liq ismi <span class="text-danger-500">*</span>
                                    </label>
                                    <x-input type="text" name="name" id="fullname" placeholder="Devid Wonder"
                                        required />
                                    @error('name')
                                        <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Telefon (ixtiyoriy)
                                    </label>
                                    <x-input type="tel" name="phone" id="phone"
                                        placeholder="+998 90 123 45 67" />
                                    @error('phone')
                                        <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Mutaxasisligi <span class="text-danger-500">*</span>
                                </label>
                                <select name="subject_id" id="subject"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white"
                                    required>
                                    <option value="" disabled>Fanni tanlang...</option>
                                    @foreach ($LearningCenter->subjects as $subject)
                                        <option value="{{ $subject->subject->id }}">{{ $subject->subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- About -->
                            <div>
                                <label for="message"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ustoz haqida (ixtiyoriy)
                                </label>
                                <textarea name="about" id="message" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white resize-none"
                                    placeholder="Ustoz haqida qisqacha ma'lumot..."></textarea>
                                @error('about')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                                <a href="{{ route('blog-single', $LearningCenter->id) }}"
                                    class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-3 px-6 rounded-xl transition-all duration-300 text-center">
                                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Bekor qilish
                                </a>
                                <button type="submit"
                                    class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Saqlash
                                </button>
                            </div>
                        </form>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</x-layout>
