<x-layout>
    <x-slot:title>404 - Sahifa topilmadi</x-slot:title>

    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-600 via-accent-600 to-primary-800 relative overflow-hidden">
        <!-- Background Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        </div>

        <!-- 404 Content -->
        <div class="relative z-10 text-center px-6 max-w-2xl mx-auto">
            <div class="animate-fade-in">
                <!-- 404 Number -->
                <div class="text-9xl md:text-[12rem] font-bold text-white/20 mb-8">
                    404
                </div>

                <!-- Error Illustration -->
                <div class="mb-8">
                    <div
                        class="inline-flex items-center justify-center w-32 h-32 bg-white/10 rounded-3xl backdrop-blur-xl border border-white/20">
                        <svg class="w-16 h-16 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Error Message -->
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Kechirasiz, sahifa topilmadi
                </h1>
                <p class="text-xl text-white/80 mb-8 max-w-lg mx-auto leading-relaxed">
                    Siz qidirayotgan sahifa ko'chirilgan, o'chirilgan yoki mavjud emas.
                    Asosiy sahifaga qaytib, kerakli ma'lumotni topishingiz mumkin.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <x-button variant="secondary" size="lg" href="{{ route('index') }}"
                        class="bg-white text-primary-600 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Asosiy sahifaga qaytish
                    </x-button>

                    <x-button variant="outline" size="lg" href="#"
                        class="border-white text-white hover:bg-white hover:text-primary-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Biz bilan bog'lanish
                    </x-button>
                </div>

                <!-- Help Text -->
                <div class="mt-12 text-white/60 text-sm">
                    Agar muammo davom etsa, iltimos, biz bilan bog'laning:
                    <a href="tel:+9987702502677" class="text-white/80 hover:text-white transition-colors">
                        (+998) 77 025 02 67
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
