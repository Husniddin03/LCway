<x-layout>
    <x-slot:title>{{ __('profile-edit.title') }}</x-slot:title>

    <!-- Main Content Container -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Profile Edit Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-8">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-100 via-blue-50 to-indigo-100 dark:from-gray-700 dark:to-gray-600 rounded-full mb-4 shadow-lg border border-blue-200/50 dark:border-gray-600">
                                <img src="{{ asset('images/lcwayfavicon.png') }}" alt="FindCourse"
                                    class="w-16 h-16 rounded-full">
                            </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ __('profile-edit.edit_profile.title') }}</h2>
                            <p class="text-gray-600 dark:text-gray-300">{{ __('profile-edit.edit_profile.subtitle') }}</p>
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
                                        {{ __('profile-edit.upload_avatar') }}
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
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ __('profile-edit.remove_avatar') }}
                                kameraga bosing</p>
                            </div>

                            <!-- Name Field -->
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('profile-edit.personal_info.name') }}
                                </label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                    placeholder="{{ __('profile-edit.personal_info.name_placeholder') }}">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('profile-edit.email') }}
                                </label>
                                <input type="email" id="email" value="{{ Auth::user()->email }}"
                                    disabled
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed transition-all duration-200"
                                    placeholder="{{ __('profile-edit.email_placeholder') }}">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('profile-edit.email_description') }}</p>
                            </div>

                            <!-- Bio Field -->
                            <div>
                                <label for="bio"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('profile-edit.bio') }}
                                </label>
                                <textarea id="bio" name="bio" rows="4"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                    placeholder="{{ __('profile-edit.bio_placeholder') }}">{{ $userData->bio ?? '' }}</textarea>
                                @error('bio')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Personal Information Section -->
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('profile-edit.personal_info.title') }}
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="first_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            {{ __('profile-edit.personal_info.name') }}
                                        </label>
                                        <input type="text" id="first_name" name="first_name"
                                            value="{{ $userData->first_name ?? '' }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="{{ __('profile-edit.edit_profile.subtitle') }}">
                                        @error('first_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="last_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            {{ __('profile-edit.personal_info.family') }}
                                        </label>
                                        <input type="text" id="last_name" name="last_name"
                                            value="{{ $userData->last_name ?? '' }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="{{ __('profile-edit.edit_profile.subtitle') }}">
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            {{ __('profile-edit.personal_info.phone') }}
                                        </label>
                                        <input type="tel" id="phone" name="phone"
                                            value="{{ $userData->phone ?? '' }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                            placeholder="+998 XX XXX XX XX">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="birthday"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            {{ __('profile-edit.personal_info.birthday') }}
                                        </label>
                                        <input type="date" id="birthday" name="birthday"
                                            value="{{ $userData->birthday ?? '' }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                                        @error('birthday')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            {{ __('profile-edit.personal_info.gender') }}
                                        </label>
                                        <select id="gender" name="gender" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                                            <option value="">{{ __('profile-edit.personal_info.select') }}</option>
                                            <option value="male" {{ ($userData->gender ?? '') == 'male' ? 'selected' : '' }}>{{ __('profile-edit.personal_info.male') }}
                                            </option>
                                            <option value="female" {{ ($userData->gender ?? '') == 'female' ? 'selected' : '' }}>{{ __('profile-edit.personal_info.female') }}
                                            </option>
                                        </select>
                                        @error('gender')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex space-x-4 pt-6">
                                <a href="{{ route('profile') }}" class="flex-1 px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-200 font-medium text-center">
                                    {{ __('profile-edit.buttons.back') }}
                                </a>
                                <button type="submit" class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 font-medium">
                                    {{ __('profile-edit.buttons.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Change Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-8">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-100 via-red-50 to-pink-100 dark:from-gray-700 dark:to-gray-600 rounded-full mb-4 shadow-lg border border-red-200/50 dark:border-gray-600">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ __('profile-edit.password_change.title') }}</h1>
                            <p class="text-gray-600 dark:text-gray-300">{{ __('profile-edit.password_change.description') }}</p>
                        </div>

                        <!-- Password Change Form -->
                        <form action="{{route('profile.change-password')}}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            @if(Auth::user()->password_status !== 'google')
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('profile-edit.password_change.current_password.label') }}
                                </label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                    placeholder="{{ __('profile-edit.password_change.current_password.placeholder') }}">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('profile-edit.password_change.new_password.label') }}
                                </label>
                                <input type="password" id="password" name="password" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                    placeholder="{{ __('profile-edit.password_change.new_password.placeholder') }}">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('profile-edit.password_change.confirm_password.label') }}
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                    placeholder="{{ __('profile-edit.password_change.confirm_password.placeholder') }}">
                            </div>

                            <!-- Submit Button -->
                            <div class="flex space-x-4">
                                <button type="submit"
                                    class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 font-medium">
                                    {{ __('profile-edit.buttons.save') }}
                                </button>
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
