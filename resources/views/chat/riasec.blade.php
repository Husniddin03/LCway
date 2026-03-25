<x-layout>
    <x-slot:title>{{ __('riasec.title') }}</x-slot:title>

    <main class="max-w-4xl mx-auto mt-20 p-6 space-y-6">
        <section class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                {{ __('riasec.hero.what_is') }}
            </h2>
            <p class="text-gray-600 leading-relaxed text-lg">
                {{ __('riasec.hero.description') }}
            </p>
        </section>

        <section class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                RIASEC harflari va yo‘nalishlari
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-3">R</div>
                        <h3 class="text-xl font-semibold text-gray-800">Realistic</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        <strong>{{ __('riasec.types.realistic.description') }}</strong> {{ __('riasec.types.realistic.details') }}
                    </p>
                    <p class="text-gray-600 text-xs mt-2 font-medium">{{ __('riasec.types.realistic.example') }}</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold mr-3">I</div>
                        <h3 class="text-xl font-semibold text-gray-800">Investigative</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        <strong>{{ __('riasec.types.investigative.description') }}</strong> {{ __('riasec.types.investigative.details') }}
                    </p>
                    <p class="text-gray-600 text-xs mt-2 font-medium">{{ __('riasec.types.investigative.example') }}</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-3">A</div>
                        <h3 class="text-xl font-semibold text-gray-800">Artistic</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        <strong>{{ __('riasec.types.artistic.description') }}</strong> {{ __('riasec.types.artistic.details') }}
                    </p>
                    <p class="text-gray-600 text-xs mt-2 font-medium">{{ __('riasec.types.artistic.example') }}</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white font-bold mr-3">S</div>
                        <h3 class="text-xl font-semibold text-gray-800">Social</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        <strong>{{ __('riasec.types.social.description') }}</strong> {{ __('riasec.types.social.details') }}
                    </p>
                    <p class="text-gray-600 text-xs mt-2 font-medium">{{ __('riasec.types.social.example') }}</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-orange-600 rounded-full flex items-center justify-center text-white font-bold mr-3">E</div>
                        <h3 class="text-xl font-semibold text-gray-800">Enterprising</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        <strong>{{ __('riasec.types.enterprising.description') }}</strong> {{ __('riasec.types.enterprising.details') }}
                    </p>
                    <p class="text-gray-600 text-xs mt-2 font-medium">{{ __('riasec.types.enterprising.example') }}</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white font-bold mr-3">C</div>
                        <h3 class="text-xl font-semibold text-gray-800">Conventional</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        <strong>{{ __('riasec.types.conventional.description') }}</strong> {{ __('riasec.types.conventional.details') }}
                    </p>
                    <p class="text-gray-600 text-xs mt-2 font-medium">{{ __('riasec.types.conventional.example') }}</p>
                </div>
            </div>
        </section>

        <section class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                RIASEC testi qanday ishlaydi?
            </h2>
            <p class="text-gray-600 leading-relaxed text-lg">
                {{ __('riasec.test.how_it_works') }}da 20–60 ta "Ha/Yo'q" savollaridan iborat bo'ladi.
                {{ __('riasec.test.description') }}
            </p>
        </section>

        <section class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('riasec.test.start_test') }}
            </h2>
            <p class="text-gray-600 leading-relaxed text-lg mb-4">
                {{ __('riasec.results.title') }}
            </p>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-emerald-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-gray-700">{{ __('riasec.results.identify_interests') }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-emerald-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-gray-700">{{ __('riasec.results.strengths_weaknesses') }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-emerald-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-gray-700">{{ __('riasec.results.choose_career') }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-6 h-6 text-emerald-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-gray-700">{{ __('riasec.results.develop_skills') }}</span>
                </li>
            </ul>
        </section>
    </main>
</x-layout>
