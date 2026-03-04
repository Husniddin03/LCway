<x-layout>
    <x-slot:title>FindCourse - Eng yaxshi o'quv markazlari</x-slot-title>
    
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-accent-600 to-primary-800"></div>
        
        <!-- Abstract Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
            <div class="animate-fade-in">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    Assalomu alaykum,<br>
                    <span class="text-yellow-300">
                        FindCourse
                    </span>
                    ga xush kelibsiz!
                </h1>
                
                <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Bu yerda siz o'zingizga mos bo'lgan o'quv markazlarni topishingiz mumkin. 
                    Biz sizga eng yaxshi xizmatni taqdim etamiz.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <x-button variant="secondary" size="lg" href="{{ route('blog-grid') }}" class="bg-white text-primary-600 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Hoziroq kurslarni tanlash
                    </x-button>
                    
                    <x-button variant="outline" size="lg" class="border-white text-white hover:bg-white hover:text-primary-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        (+998) 77 025 026 77
                    </x-button>
                </div>
                
                <p class="text-white/80 text-sm">
                    Har qanday savol yoki taklif uchun biz bilan bog'laning
                </p>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">O'qituvchilar tanlovi</h3>
                    <p class="text-gray-600 dark:text-gray-400">O'zingizga munosib ko'rgan o'qituvchilarni tanlang.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-r from-success-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Butun O'zbekiston bo'ylab</h3>
                    <p class="text-gray-600 dark:text-gray-400">Butun O'zbekiston bo'ylab barcha o'quv markazlarini topishingiz mumkin.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-r from-warning-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Markazlar reytingi</h3>
                    <p class="text-gray-600 dark:text-gray-400">O'quv markazlari reytingi bo'yicha qidiring.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <div class="relative z-10">
                        <img src="{{ asset('images/we1.png') }}" alt="About" class="rounded-2xl shadow-xl">
                    </div>
                    <div class="absolute -bottom-6 -right-6 z-0">
                        <img src="{{ asset('images/we2.png') }}" alt="About" class="rounded-2xl shadow-xl opacity-80">
                    </div>
                    <div class="absolute -top-6 -left-6 z-0">
                        <img src="{{ asset('images/we3.png') }}" alt="About" class="rounded-2xl shadow-xl opacity-60">
                    </div>
                </div>
                
                <div>
                    <x-badge variant="primary" class="mb-4">Nima uchun bizni tanlaysiz</x-badge>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Biz eng yaxshi xizmatlarni taqdim etamiz
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        Biz haqimizda ko'proq ma'lumot olish uchun pastdagi videoni koring va biz haqimizda o'z fikringizni qoldiring.
                    </p>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ asset('videos/aboutme.mp4') }}" class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Bizning ishga munosabatingiz qanday?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Team Start ===== -->
    {{-- <section class="i pg ji gp uq">
        <!-- Bg Shapes -->
        <span class="rc h s r vd fd/5 fh rm"></span>
        <img src="{{ asset('images/shape-08.svg') }}" alt="Shape Bg" class="h q r" />
        <img src="{{ asset('images/shape-09.svg') }}" alt="Shape" class="of h y z/2" />
        <img src="{{ asset('images/shape-10.svg') }}" alt="Shape" class="h _ aa" />
        <img src="{{ asset('images/shape-11.svg') }}" alt="Shape" class="of h m ba" />

        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `Bizning ijodiy bag'ishlangan jamoamiz bilan uchrashing`, sectionTitleText: `Sizda biz haqimizda savollaringiz bo'la bizning jamoga murojat qilishingiz mumkun. Bizning jamo (24/7) doimo sizni qo'llaydi.` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="bb ze i va ki xn xq jb jo">
            <div class="wc qf pn xo gg cp">
                <!-- Team Item -->
                <div class="animate_top rj">
                    <div class="c i pg z-1">
                        <img class="vd" src="{{ asset('images/team-01.png') }}" alt="Team" />

                        <div class="ef im nl il">
                            <span class="h -ud-left-5 -ud-bottom-21 rc de gd gh if wa"></span>
                            <span class="h s p rc vd hd mh va"></span>
                            <div class="h s p vd ij jj xa">
                                <ul class="tc xf wf gg">
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="10" height="18"
                                                viewBox="0 0 10 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.66634 10.25H8.74968L9.58301 6.91669H6.66634V5.25002C6.66634 4.39169 6.66634 3.58335 8.33301 3.58335H9.58301V0.783354C9.31134 0.74752 8.28551 0.666687 7.20218 0.666687C4.93968 0.666687 3.33301 2.04752 3.33301 4.58335V6.91669H0.833008V10.25H3.33301V17.3334H6.66634V10.25Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="18" height="14"
                                                viewBox="0 0 18 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.4683 1.71333C16.8321 1.99475 16.1574 2.17956 15.4666 2.26167C16.1947 1.82619 16.7397 1.14085 16.9999 0.333333C16.3166 0.74 15.5674 1.025 14.7866 1.17917C14.2621 0.617982 13.5669 0.245803 12.809 0.120487C12.0512 -0.00482822 11.2732 0.123742 10.596 0.486211C9.91875 0.848679 9.38024 1.42474 9.06418 2.12483C8.74812 2.82492 8.67221 3.60982 8.84825 4.3575C7.46251 4.28805 6.10686 3.92794 4.86933 3.30055C3.63179 2.67317 2.54003 1.79254 1.66492 0.715833C1.35516 1.24788 1.19238 1.85269 1.19326 2.46833C1.19326 3.67667 1.80826 4.74417 2.74326 5.36917C2.18993 5.35175 1.64878 5.20232 1.16492 4.93333V4.97667C1.16509 5.78142 1.44356 6.56135 1.95313 7.18422C2.46269 7.80709 3.17199 8.23456 3.96075 8.39417C3.4471 8.53337 2.90851 8.55388 2.38576 8.45417C2.60814 9.14686 3.04159 9.75267 3.62541 10.1868C4.20924 10.6209 4.9142 10.8615 5.64159 10.875C4.91866 11.4428 4.0909 11.8625 3.20566 12.1101C2.32041 12.3578 1.39503 12.4285 0.482422 12.3183C2.0755 13.3429 3.93 13.8868 5.82409 13.885C12.2349 13.885 15.7408 8.57417 15.7408 3.96833C15.7408 3.81833 15.7366 3.66667 15.7299 3.51833C16.4123 3.02514 17.0013 2.41418 17.4691 1.71417L17.4683 1.71333Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="17" height="16"
                                                viewBox="0 0 17 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3.78353 2.16665C3.78331 2.60867 3.6075 3.03251 3.29478 3.34491C2.98207 3.65732 2.55806 3.8327 2.11603 3.83248C1.674 3.83226 1.25017 3.65645 0.937761 3.34373C0.625357 3.03102 0.449975 2.60701 0.450196 2.16498C0.450417 1.72295 0.626223 1.29912 0.93894 0.986712C1.25166 0.674307 1.67567 0.498925 2.1177 0.499146C2.55972 0.499367 2.98356 0.675173 3.29596 0.98789C3.60837 1.30061 3.78375 1.72462 3.78353 2.16665V2.16665ZM3.83353 5.06665H0.500195V15.5H3.83353V5.06665ZM9.1002 5.06665H5.78353V15.5H9.06686V10.025C9.06686 6.97498 13.0419 6.69165 13.0419 10.025V15.5H16.3335V8.89165C16.3335 3.74998 10.4502 3.94165 9.06686 6.46665L9.1002 5.06665V5.06665Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h4 class="yj go kk wm ob zb">Olivia Andrium</h4>
                    <p>Product Manager</p>
                </div>

                <!-- Team Item -->
                <div class="animate_top rj">
                    <div class="c i pg z-1">
                        <img class="vd" src="{{ asset('images/team-02.png') }}" alt="Team" />

                        <div class="ef im nl il">
                            <span class="h -ud-left-5 -ud-bottom-21 rc de gd gh if wa"></span>
                            <span class="h s p rc vd hd mh va"></span>
                            <div class="h s p vd ij jj xa">
                                <ul class="tc xf wf gg">
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="10" height="18"
                                                viewBox="0 0 10 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.66634 10.25H8.74968L9.58301 6.91669H6.66634V5.25002C6.66634 4.39169 6.66634 3.58335 8.33301 3.58335H9.58301V0.783354C9.31134 0.74752 8.28551 0.666687 7.20218 0.666687C4.93968 0.666687 3.33301 2.04752 3.33301 4.58335V6.91669H0.833008V10.25H3.33301V17.3334H6.66634V10.25Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="18" height="14"
                                                viewBox="0 0 18 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.4683 1.71333C16.8321 1.99475 16.1574 2.17956 15.4666 2.26167C16.1947 1.82619 16.7397 1.14085 16.9999 0.333333C16.3166 0.74 15.5674 1.025 14.7866 1.17917C14.2621 0.617982 13.5669 0.245803 12.809 0.120487C12.0512 -0.00482822 11.2732 0.123742 10.596 0.486211C9.91875 0.848679 9.38024 1.42474 9.06418 2.12483C8.74812 2.82492 8.67221 3.60982 8.84825 4.3575C7.46251 4.28805 6.10686 3.92794 4.86933 3.30055C3.63179 2.67317 2.54003 1.79254 1.66492 0.715833C1.35516 1.24788 1.19238 1.85269 1.19326 2.46833C1.19326 3.67667 1.80826 4.74417 2.74326 5.36917C2.18993 5.35175 1.64878 5.20232 1.16492 4.93333V4.97667C1.16509 5.78142 1.44356 6.56135 1.95313 7.18422C2.46269 7.80709 3.17199 8.23456 3.96075 8.39417C3.4471 8.53337 2.90851 8.55388 2.38576 8.45417C2.60814 9.14686 3.04159 9.75267 3.62541 10.1868C4.20924 10.6209 4.9142 10.8615 5.64159 10.875C4.91866 11.4428 4.0909 11.8625 3.20566 12.1101C2.32041 12.3578 1.39503 12.4285 0.482422 12.3183C2.0755 13.3429 3.93 13.8868 5.82409 13.885C12.2349 13.885 15.7408 8.57417 15.7408 3.96833C15.7408 3.81833 15.7366 3.66667 15.7299 3.51833C16.4123 3.02514 17.0013 2.41418 17.4691 1.71417L17.4683 1.71333Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="17" height="16"
                                                viewBox="0 0 17 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3.78353 2.16665C3.78331 2.60867 3.6075 3.03251 3.29478 3.34491C2.98207 3.65732 2.55806 3.8327 2.11603 3.83248C1.674 3.83226 1.25017 3.65645 0.937761 3.34373C0.625357 3.03102 0.449975 2.60701 0.450196 2.16498C0.450417 1.72295 0.626223 1.29912 0.93894 0.986712C1.25166 0.674307 1.67567 0.498925 2.1177 0.499146C2.55972 0.499367 2.98356 0.675173 3.29596 0.98789C3.60837 1.30061 3.78375 1.72462 3.78353 2.16665V2.16665ZM3.83353 5.06665H0.500195V15.5H3.83353V5.06665ZM9.1002 5.06665H5.78353V15.5H9.06686V10.025C9.06686 6.97498 13.0419 6.69165 13.0419 10.025V15.5H16.3335V8.89165C16.3335 3.74998 10.4502 3.94165 9.06686 6.46665L9.1002 5.06665V5.06665Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h4 class="yj go kk wm ob zb">Jemse Kemorun</h4>
                    <p>Product Designer</p>
                </div>

                <!-- Team Item -->
                <div class="animate_top rj">
                    <div class="c i pg z-1">
                        <img class="vd" src="{{ asset('images/team-03.png') }}" alt="Team" />

                        <div class="ef im nl il">
                            <span class="h -ud-left-5 -ud-bottom-21 rc de gd gh if wa"></span>
                            <span class="h s p rc vd hd mh va"></span>
                            <div class="h s p vd ij jj xa">
                                <ul class="tc xf wf gg">
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="10" height="18"
                                                viewBox="0 0 10 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.66634 10.25H8.74968L9.58301 6.91669H6.66634V5.25002C6.66634 4.39169 6.66634 3.58335 8.33301 3.58335H9.58301V0.783354C9.31134 0.74752 8.28551 0.666687 7.20218 0.666687C4.93968 0.666687 3.33301 2.04752 3.33301 4.58335V6.91669H0.833008V10.25H3.33301V17.3334H6.66634V10.25Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="18" height="14"
                                                viewBox="0 0 18 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.4683 1.71333C16.8321 1.99475 16.1574 2.17956 15.4666 2.26167C16.1947 1.82619 16.7397 1.14085 16.9999 0.333333C16.3166 0.74 15.5674 1.025 14.7866 1.17917C14.2621 0.617982 13.5669 0.245803 12.809 0.120487C12.0512 -0.00482822 11.2732 0.123742 10.596 0.486211C9.91875 0.848679 9.38024 1.42474 9.06418 2.12483C8.74812 2.82492 8.67221 3.60982 8.84825 4.3575C7.46251 4.28805 6.10686 3.92794 4.86933 3.30055C3.63179 2.67317 2.54003 1.79254 1.66492 0.715833C1.35516 1.24788 1.19238 1.85269 1.19326 2.46833C1.19326 3.67667 1.80826 4.74417 2.74326 5.36917C2.18993 5.35175 1.64878 5.20232 1.16492 4.93333V4.97667C1.16509 5.78142 1.44356 6.56135 1.95313 7.18422C2.46269 7.80709 3.17199 8.23456 3.96075 8.39417C3.4471 8.53337 2.90851 8.55388 2.38576 8.45417C2.60814 9.14686 3.04159 9.75267 3.62541 10.1868C4.20924 10.6209 4.9142 10.8615 5.64159 10.875C4.91866 11.4428 4.0909 11.8625 3.20566 12.1101C2.32041 12.3578 1.39503 12.4285 0.482422 12.3183C2.0755 13.3429 3.93 13.8868 5.82409 13.885C12.2349 13.885 15.7408 8.57417 15.7408 3.96833C15.7408 3.81833 15.7366 3.66667 15.7299 3.51833C16.4123 3.02514 17.0013 2.41418 17.4691 1.71417L17.4683 1.71333Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!">
                                            <svg class="uh vl ml il" width="17" height="16"
                                                viewBox="0 0 17 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3.78353 2.16665C3.78331 2.60867 3.6075 3.03251 3.29478 3.34491C2.98207 3.65732 2.55806 3.8327 2.11603 3.83248C1.674 3.83226 1.25017 3.65645 0.937761 3.34373C0.625357 3.03102 0.449975 2.60701 0.450196 2.16498C0.450417 1.72295 0.626223 1.29912 0.93894 0.986712C1.25166 0.674307 1.67567 0.498925 2.1177 0.499146C2.55972 0.499367 2.98356 0.675173 3.29596 0.98789C3.60837 1.30061 3.78375 1.72462 3.78353 2.16665V2.16665ZM3.83353 5.06665H0.500195V15.5H3.83353V5.06665ZM9.1002 5.06665H5.78353V15.5H9.06686V10.025C9.06686 6.97498 13.0419 6.69165 13.0419 10.025V15.5H16.3335V8.89165C16.3335 3.74998 10.4502 3.94165 9.06686 6.46665L9.1002 5.06665V5.06665Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h4 class="yj go kk wm ob zb">Avi Pestarica</h4>
                    <p>Web Designer</p>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- ===== Team End ===== -->

    <!-- Services Section -->
    <section class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Biz siz uchun eng yaxshi sifatli xizmatni taklif etamiz
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Bu yerda biz qila oladigan ishlar berilgan
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <x-card hover class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Startup ishlab chiqish</h3>
                    <p class="text-gray-600 dark:text-gray-400">Turli xil mavzularda startup loyihalar ishlab chiqamiz.</p>
                </x-card>
                
                <!-- Service 2 -->
                <x-card hover class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Yuqori sifatli dizayn</h3>
                    <p class="text-gray-600 dark:text-gray-400">Foydalanuvchilarga hush yoqadigan yuqori sifatli dizayn.</p>
                </x-card>
                
                <!-- Service 3 -->
                <x-card hover class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-success-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Websaytlar</h3>
                    <p class="text-gray-600 dark:text-gray-400">Biz siz uchun veb-sayt qilib berishimiz mumkin.</p>
                </x-card>
                
                <!-- Service 4 -->
                <x-card hover class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-warning-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Optimal tezlik</h3>
                    <p class="text-gray-600 dark:text-gray-400">Foydalanuvchilar uchun tezlikda hizmat qilish.</p>
                </x-card>
                
                <!-- Service 5 -->
                <x-card hover class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-danger-500 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">To'liq moslashish</h3>
                    <p class="text-gray-600 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </x-card>
                
                <!-- Service 6 -->
                <x-card hover class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Har ikkala tomondan</h3>
                    <p class="text-gray-600 dark:text-gray-400">Ham frontend ham backend bo'limlarni birdek bajarish.</p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- Featured Courses Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Mashhur o'quv markazlari
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Eng yaxshi reytingga ega o'quv markazlari bilan tanishing
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @if(isset($centers) && $centers->count() > 0)
                    @foreach($centers->take(8) as $center)
                        <x-card hover class="group cursor-pointer">
                            <div class="relative overflow-hidden rounded-t-2xl">
                                @if($center->logo)
                                    <img src="{{ asset('storage/' . $center->logo) }}" 
                                         alt="{{ $center->name }}" 
                                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Rating Badge -->
                                <div class="absolute top-4 right-4 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm px-2 py-1 rounded-full">
                                    @php
                                        $average = round($center->favorites()->avg('rating') ?? 0, 1);
                                    @endphp
                                    <div class="flex items-center space-x-1">
                                        <span class="text-yellow-500 text-sm">★</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $average }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        {{ Str::limit($center->name, 30) }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $center->type }}</p>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ Str::limit($center->address, 25) }}
                                    </div>
                                </div>
                                
                                @if($center->subjects->count() > 0)
                                    <div class="flex flex-wrap gap-1 mb-4">
                                        @foreach($center->subjects->take(2) as $subject)
                                            <span class="px-2 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-xs rounded-full">
                                                {{ $subject->subject->name }}
                                            </span>
                                        @endforeach
                                        @if($center->subjects->count() > 2)
                                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs rounded-full">
                                                +{{ $center->subjects->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    @if($center->subjects->count() > 0)
                                        <div>
                                            <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                                {{ $center->subjects->min('price') ?? 0 }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">so'm/oydan</p>
                                        </div>
                                    @endif
                                    
                                    <x-button variant="outline" size="sm" href="{{ route('blog-single', $center->id) }}">
                                        Batafsil
                                    </x-button>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                @else
                    <!-- Placeholder cards when no centers -->
                    @for($i = 1; $i <= 4; $i++)
                        <x-card hover>
                            <div class="h-48 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 rounded-t-2xl"></div>
                            <div class="p-6">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded mb-4"></div>
                                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
                            </div>
                        </x-card>
                    @endfor
                @endif
            </div>
            
            <div class="text-center mt-12">
                <x-button variant="primary" size="lg" href="{{ route('blog-grid') }}">
                    Barcha markazlarni ko'rish
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </x-button>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    O'qish yo'nalishlari
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    O'zingizga mos bo'lgan yo'nalishni tanlang
                </p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-3">
                @php
                    $categories = [
                        'IT va dasturlash', 
                        'Chet tillari', 
                        'Matematika', 
                        'Fizika', 
                        'Kimyo', 
                        'Biologiya', 
                        'Tarix', 
                        'Adabiyot', 
                        'San\'at', 
                        'Biznes', 
                        'Marketing', 
                        'Dizayn'
                    ];
                @endphp
                
                @foreach($categories as $category)
                    <x-badge variant="primary" class="px-4 py-2 text-sm hover:scale-105 transition-transform cursor-pointer">
                        {{ $category }}
                    </x-badge>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    O'quvchilarimiz fikrlari
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Bitiruvchilarimiz tajribasi va muvaffaqiyatlari
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <x-card hover class="text-center">
                    <div class="mb-6">
                        <img src="https://ui-avatars.com/api/?name=Ali+Valiyev&background=random&size=100" 
                             alt="Ali Valiyev" 
                             class="w-20 h-20 rounded-full mx-auto mb-4">
                        <div class="flex justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-yellow-400 text-lg">★</span>
                            @endfor
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Ali Valiyev</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Web Dasturchi</p>
                    </div>
                    <blockquote class="text-gray-600 dark:text-gray-300 italic">
                        "FindCourse orqali o'zim uchun eng yaxshi IT kursini topdim. Endi yirik kompaniyada ishlayman. Ushbu platforma har qanday yosh uchun foydalidir!"
                    </blockquote>
                </x-card>
                
                <!-- Testimonial 2 -->
                <x-card hover class="text-center">
                    <div class="mb-6">
                        <img src="https://ui-avatars.com/api/?name=Malika+Karimova&background=random&size=100" 
                             alt="Malika Karimova" 
                             class="w-20 h-20 rounded-full mx-auto mb-4">
                        <div class="flex justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-yellow-400 text-lg">★</span>
                            @endfor
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Malika Karimova</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ingliz tuli o'qituvchisi</p>
                    </div>
                    <blockquote class="text-gray-600 dark:text-gray-300 italic">
                        "Chet tili kursini topish juda oson bo'ldi. Sifatli o'qituvchilar va qulay jadval. Hozir o'zim ham o'qituvchi sifatida faoliyat yuritaman."
                    </blockquote>
                </x-card>
                
                <!-- Testimonial 3 -->
                <x-card hover class="text-center">
                    <div class="mb-6">
                        <img src="https://ui-avatars.com/api/?name=Javohir+Toshmatov&background=random&size=100" 
                             alt="Javohir Toshmatov" 
                             class="w-20 h-20 rounded-full mx-auto mb-4">
                        <div class="flex justify-center mb-2">
                            @for($i = 1; $i <= 4; $i++)
                                <span class="text-yellow-400 text-lg">★</span>
                            @endfor
                            <span class="text-yellow-400 text-lg opacity-30">★</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Javohir Toshmatov</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Grafik dizayner</p>
                    </div>
                    <blockquote class="text-gray-600 dark:text-gray-300 italic">
                        "Dizayn yo'nalishida bir nechta kurslarni solishtirdim. Platforma orqali eng yaxshi markazni topdim va hozir o'z ishimga asos soldim."
                    </blockquote>
                </x-card>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-600 to-accent-600 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full bg-repeat" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    Hozirda ro'yxatdan o'tganlar o'quv markazlar soni: <span class="text-yellow-300">{{ $AllCenters->count() ?? 0 }} ta</span>
                </h2>
                <p class="text-xl text-white/90 mb-8">
                    Ular safida siz ham bo'ling va o'zingizning o'quv markazingizni qo'shing!
                </p>
                <x-button variant="secondary" size="lg" href="{{ route('course.create') }}" class="bg-white text-primary-600 hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Hoziroq qo'shiling
                </x-button>
            </div>
        </div>
    </section>
    
    <!-- ===== Pricing Table Start ===== -->
    {{-- <section x-data="setup()" class="i pg fh rm ji gp uq">
        <!-- Bg Shapes -->
        <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" class="h aa y" />
        <img src="{{ asset('images/shape-03.svg') }}" alt="Shape" class="h ca u" />
        <img src="{{ asset('images/shape-07.svg') }}" alt="Shape" class="h w da ee" />
        <img src="{{ asset('images/shape-12.svg') }}" alt="Shape" class="h p s" />
        <img src="{{ asset('images/shape-13.svg') }}" alt="Shape" class="h r q" />

        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `Ajoyib hamyonbop Premium narxlarni taklif qilamiz.`, sectionTitleText: `Sizda g'oya bormi, biz bilan bo'g'laning biz sizga qulay variantlarni taqdim qilamiz.` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <!-- Pricing switcher -->
        <div class="tc wf xf jb og">
            <span class="ek kk wm">Bir martalik loyihalar</span>
            <button class="i rg gm" x-cloak
                @click="billPlan == 'monthly' ? billPlan = 'annually' : billPlan = 'monthly'">
                <div class="fe id bl gh rg xk outline-none"></div>
                <div class="h vc wf xf ge jd cl jl ml mf hh rg yk ea fa"
                    :class="{ 'ff': billPlan == 'monthly', 'gf': billPlan == 'annually' }"></div>
            </button>
            <span class="ek kk wm">Davomiy loyihalar</span>
        </div>

        <!-- Pricing Table -->
        <div class="bb ze i va ki xn yq bc">
            <div class="wc qf pn xo jg">
                <template x-for="(plan, i) in plans" x-key="i">
                    <!-- Pricing Item -->
                    <div class="animate_top rj sg hh sm vk xm hi nj oj">
                        <h4 x-text="plan.name" class="wj kk wm fb"></h4>

                        <div class="tc wf xf kg cc">
                            <h2 :class="plan.name == 'Basic' ? 'text-green-500' : ''"
                                x-text="`$${billPlan == 'monthly' ? plan.price.monthly : plan.price.annually}`"
                                class="fk _j kk wm">
                            </h2>
                            <span x-text="billPlan == 'monthly' ? '/per month' : '/per year'"
                                class="sc ak kk wm"></span>
                        </div>

                        <p class="ur dc">No credit card required</p>

                        <!-- Button -->
                        <a href="#!" class="ek rg lk ml il gi ri"
                            :class="plan.name == 'Growth Plan' ? 'gh sl' : 'mh tl'">
                            Try for free
                        </a>

                        <!-- Features -->
                        <ul class="tc sf bg ob fb">
                            <template x-for="(feature, i) in plan.features" x-key="i">
                                <li x-text="feature"></li>
                            </template>
                        </ul>

                        <p class="kk wm">7-day free trial</p>
                    </div>
                </template>
            </div>
        </div>
    </section> --}}
    <!-- ===== Pricing Table End ===== -->

    <!-- ===== Projects Start ===== -->
    {{-- <section class="pg pj vp mr oj wp nr">
        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `We Offer Great Affordable Premium Prices.`, sectionTitleText: `It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using.` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="bb ze ki xn 2xl:ud-px-0 jb" x-data="{ filterTab: 1 }">
            <!-- Porject Tab -->
            <div class="projects-tab _e bb tc uf wf xf cg rg hh rm vk xm si ti fc">
                <button data-filter="*" @click="filterTab = 1" :class="{ 'gh lk': filterTab === 1 }"
                    class="project-tab-btn ek rg ml il vi mi">
                    All
                </button>
                <button data-filter=".branding" @click="filterTab = 2" :class="{ 'gh lk': filterTab === 2 }"
                    class="project-tab-btn ek rg ml il vi mi">
                    Branding Strategy
                </button>
                <button data-filter=".digital" @click="filterTab = 3" :class="{ 'gh lk': filterTab === 3 }"
                    class="project-tab-btn ek rg ml il vi mi">
                    Digital Experiences
                </button>
                <button data-filter=".ecommerce" @click="filterTab = 4" :class="{ 'gh lk': filterTab === 4 }"
                    class="project-tab-btn ek rg ml il vi mi">
                    Ecommerce
                </button>
            </div>

            <!-- Projects item wrapper -->
            <div class="projects-wrapper tc -ud-mx-5">
                <div class="project-sizer"></div>
                <!-- Project Item -->
                <div class="project-item wi fb vd jn/2 to/3 branding ecommerce">
                    <div class="c i pg sg z-1">
                        <img src="{{ asset('images/project-01.png') }}" alt="Project" />

                        <div class="h s r df nl kl im tc sf wf xf vd yc sg al hh/20 z-10">
                            <h4 class="ek tj kk hc">Photo Retouching</h4>
                            <p>Branded Ecommerce</p>
                            <a class="c tc wf xf ie ld rg _g dh ml il ph jm km jc" href="#!">
                                <svg class="th lm ml il" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.4763 6.16664L6.00634 1.69664L7.18467 0.518311L13.6663 6.99998L7.18467 13.4816L6.00634 12.3033L10.4763 7.83331H0.333008V6.16664H10.4763Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Project Item -->
                <div class="project-item wi fb vd jn/2 to/3 digital">
                    <div class="c i pg sg z-1">
                        <img src="{{ asset('images/project-02.png') }}" alt="Project" />

                        <div class="h s r df nl kl im tc sf wf xf vd yc sg al hh/20 z-10">
                            <h4 class="ek tj kk hc">Photo Retouching</h4>
                            <p>Branded Ecommerce</p>
                            <a class="c tc wf xf ie ld rg _g dh ml il ph jm km jc" href="#!">
                                <svg class="th lm ml il" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.4763 6.16664L6.00634 1.69664L7.18467 0.518311L13.6663 6.99998L7.18467 13.4816L6.00634 12.3033L10.4763 7.83331H0.333008V6.16664H10.4763Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Project Item -->
                <div class="project-item wi fb vd jn/2 to/3 branding ecommerce">
                    <div class="c i pg sg z-1">
                        <img src="{{ asset('images/project-04.png') }}" alt="Project" />

                        <div class="h s r df nl kl im tc sf wf xf vd yc sg al hh/20 z-10">
                            <h4 class="ek tj kk hc">Photo Retouching</h4>
                            <p>Branded Ecommerce</p>
                            <a class="c tc wf xf ie ld rg _g dh ml il ph jm km jc" href="#!">
                                <svg class="th lm ml il" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.4763 6.16664L6.00634 1.69664L7.18467 0.518311L13.6663 6.99998L7.18467 13.4816L6.00634 12.3033L10.4763 7.83331H0.333008V6.16664H10.4763Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Project Item -->
                <div class="project-item wi fb vd vo/3 digital ecommerce">
                    <div class="c i pg sg z-1">
                        <img src="{{ asset('images/project-03.png') }}" alt="Project" />

                        <div class="h s r df nl kl im tc sf wf xf vd yc sg al hh/20 z-10">
                            <h4 class="ek tj kk hc">Photo Retouching</h4>
                            <p>Branded Ecommerce</p>
                            <a class="c tc wf xf ie ld rg _g dh ml il ph jm km jc" href="#!">
                                <svg class="th lm ml il" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.4763 6.16664L6.00634 1.69664L7.18467 0.518311L13.6663 6.99998L7.18467 13.4816L6.00634 12.3033L10.4763 7.83331H0.333008V6.16664H10.4763Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- ===== Projects End ===== -->

    <!-- ===== Testimonials Start ===== -->
    {{-- <section class="hj rp hr">
        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `Client’s Testimonials`, sectionTitleText: `It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using.` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="bb ze ki xn ar">
            <div class="animate_top jb cq">
                <!-- Slider main container -->
                <div class="swiper testimonial-01">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide">
                            <div class="i hh rm sg vk xm bi qj">
                                <!-- Border Shape -->
                                <span class="rc je md/2 gh xg h q r"></span>
                                <span class="rc je md/2 mh yg h q p"></span>

                                <div class="tc sf rn tn un zf dp">
                                    <img class="bf" src="images/testimonial.png')}}" alt="User" />

                                    <div>
                                        <img src="{{ asset('images/icon-quote.svg') }}" alt="Quote" />
                                        <p class="ek ik xj _p kc fb">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dolor diam,
                                            feugiat quis enim sed,
                                            ullamcorper semper ligula. Mauris consequat justo volutpat.
                                        </p>

                                        <div class="tc yf vf">
                                            <div>
                                                <span class="rc ek xj kk wm zb">Devid Smith</span>
                                                <span class="rc">Founter @democompany</span>
                                            </div>

                                            <img class="rk" src="{{asset('images/brand-light-02.svg')}}" alt="Brand" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- If we need navigation -->
                    <div class="tc wf xf fg jb">
                        <div class="swiper-button-prev c tc wf xf ie ld rg _g dh pf ml vr hh rm tl zm rl ym">
                            <svg class="th lm" width="14" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3.52366 7.83336L7.99366 12.3034L6.81533 13.4817L0.333663 7.00002L6.81533 0.518357L7.99366 1.69669L3.52366 6.16669L13.667 6.16669L13.667 7.83336L3.52366 7.83336Z"
                                    fill="" />
                            </svg>
                        </div>
                        <div class="swiper-button-next c tc wf xf ie ld rg _g dh pf ml vr hh rm tl zm rl ym">
                            <svg class="th lm" width="14" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.4763 6.16664L6.00634 1.69664L7.18467 0.518311L13.6663 6.99998L7.18467 13.4816L6.00634 12.3033L10.4763 7.83331H0.333008V6.16664H10.4763Z"
                                    fill="" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- ===== Testimonials End ===== -->

    <!-- ===== Counter Start ===== -->
    {{-- <section class="i pg qh rm ji hp">
        <img src="{{ asset('images/shape-11.svg') }}" alt="Shape" class="of h ga ha ke" />
        <img src="{{ asset('images/shape-07.svg') }}" alt="Shape" class="h ia o ae jf" />
        <img src="{{ asset('images/shape-14.svg') }}" alt="Shape" class="h ja ka" />
        <img src="{{ asset('images/shape-15.svg') }}" alt="Shape" class="h q p" />

        <div class="bb ze i va ki xn br">
            <div class="tc uf sn tn xf un gg">
                <div class="animate_top me/5 ln rj">
                    <h2 class="gk vj zp or kk wm hc">785</h2>
                    <p class="ek bk aq">Global Brands</p>
                </div>
                <div class="animate_top me/5 ln rj">
                    <h2 class="gk vj zp or kk wm hc">533</h2>
                    <p class="ek bk aq">Happy Clients</p>
                </div>
                <div class="animate_top me/5 ln rj">
                    <h2 class="gk vj zp or kk wm hc">865</h2>
                    <p class="ek bk aq">Winning Award</p>
                </div>
                <div class="animate_top me/5 ln rj">
                    <h2 class="gk vj zp or kk wm hc">346</h2>
                    <p class="ek bk aq">Happy Clients</p>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- ===== Counter End ===== -->

    <!-- ===== Clients Start ===== -->
    {{-- <section class="pj vp mr">
        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `Trusted by Global Brands`, sectionTitleText: `It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using.` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="bb ze ah ch pm hj xp ki xn 2xl:ud-px-49 bc">
            <div class="wc rf qn zf cp kq xf wf">
                <a href="#!" class="rc animate_top">
                    <img class="th wl ml il zl om" src="{{asset('images/brand-light-01.svg')}}" alt="Clients" />
                    <img class="xc sk ml il zl nm" src="{{asset('images/brand-dark-01.svg')}}" alt="Clients" />
                </a>
                <a href="#!" class="rc animate_top">
                    <img class="tk ml il zl om" src="{{asset('images/brand-light-02.svg')}}" alt="Clients" />
                    <img class="xc sk ml il zl nm" src="{{asset('images/brand-dark-02.svg')}}" alt="Clients" />
                </a>
                <a href="#!" class="rc animate_top">
                    <img class="tk ml il zl om" src="{{asset('images/brand-light-03.svg')}}" alt="Clients" />
                    <img class="xc sk ml il zl nm" src="{{asset('images/brand-dark-03.svg')}}" alt="Clients" />
                </a>
                <a href="#!" class="rc animate_top">
                    <img class="tk ml il zl om" src="{{asset('images/brand-light-04.svg')}}" alt="Clients" />
                    <img class="xc sk ml il zl nm" src="{{asset('images/brand-dark-04.svg')}}" alt="Clients" />
                </a>
                <a href="#!" class="rc animate_top">
                    <img class="tk ml il zl om" src="{{asset('images/brand-light-05.svg')}}" alt="Clients" />
                    <img class="xc sk ml il zl nm" src="{{asset('images/brand-dark-05.svg')}}" alt="Clients" />
                </a>
                <a href="#!" class="rc animate_top">
                    <img class="tk ml il zl om" src="{{asset('images/brand-light-06.svg')}}" alt="Clients" />
                    <img class="xc sk ml il zl nm" src="{{asset('images/brand-dark-06.svg')}}" alt="Clients" />
                </a>
            </div>
        </div>
    </section> --}}
    <!-- ===== Clients End ===== -->

    <!-- ===== Blog Start ===== -->
    {{-- <section class="ji gp uq">
        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `Latest Blogs & News`, sectionTitleText: `It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using.` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="bb ye ki xn vq jb jo">
            <div class="wc qf pn xo zf iq">
                <!-- Blog Item -->
                <div class="animate_top sg vk rm xm">
                    <div class="c rc i z-1 pg">
                        <img class="w-full" src="{{asset('images/blog-01.png')}}" alt="Blog" />

                        <div class="im h r s df vd yc wg tc wf xf al hh/20 nl il z-10">
                            <a href="./blog-single.html" class="vc ek rg lk gh sl ml il gi hi">Read More</a>
                        </div>
                    </div>

                    <div class="yh">
                        <div class="tc uf wf ag jq">
                            <div class="tc wf ag">
                                <img src="{{ asset('images/icon-man.svg') }}" alt="User" />
                                <p>Musharof Chy</p>
                            </div>
                            <div class="tc wf ag">
                                <img src="{{ asset('images/icon-calender.svg') }}" alt="Calender" />
                                <p>25 Dec, 2025</p>
                            </div>
                        </div>
                        <h4 class="ek tj ml il kk wm xl eq lb">
                            <a href="blog-single.html">Free advertising for your online business</a>
                        </h4>
                    </div>
                </div>

                <!-- Blog Item -->
                <div class="animate_top sg vk rm xm">
                    <div class="c rc i z-1 pg">
                        <img class="w-full" src="{{asset('images/blog-02.png')}}" alt="Blog" />

                        <div class="im h r s df vd yc wg tc wf xf al hh/20 nl il z-10">
                            <a href="./blog-single.html" class="vc ek rg lk gh sl ml il gi hi">Read More</a>
                        </div>
                    </div>

                    <div class="yh">
                        <div class="tc uf wf ag jq">
                            <div class="tc wf ag">
                                <img src="{{ asset('images/icon-man.svg') }}" alt="User" />
                                <p>Musharof Chy</p>
                            </div>
                            <div class="tc wf ag">
                                <img src="{{ asset('images/icon-calender.svg') }}" alt="Calender" />
                                <p>25 Dec, 2025</p>
                            </div>
                        </div>
                        <h4 class="ek tj ml il kk wm xl eq lb">
                            <a href="blog-single.html">9 simple ways to improve your design skills</a>
                        </h4>
                    </div>
                </div>

                <!-- Blog Item -->
                <div class="animate_top sg vk rm xm">
                    <div class="c rc i z-1 pg">
                        <img class="w-full" src="{{asset('images/blog-03.png')}}" alt="Blog" />

                        <div class="im h r s df vd yc wg tc wf xf al hh/20 nl il z-10">
                            <a href="./blog-single.html" class="vc ek rg lk gh sl ml il gi hi">Read More</a>
                        </div>
                    </div>

                    <div class="yh">
                        <div class="tc uf wf ag jq">
                            <div class="tc wf ag">
                                <img src="{{ asset('images/icon-man.svg') }}" alt="User" />
                                <p>Musharof Chy</p>
                            </div>
                            <div class="tc wf ag">
                                <img src="{{ asset('images/icon-calender.svg') }}" alt="Calender" />
                                <p>25 Dec, 2025</p>
                            </div>
                        </div>
                        <h4 class="ek tj ml il kk wm xl eq lb">
                            <a href="blog-single.html">Tips to quickly improve your coding speed.</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- ===== Blog End ===== -->

    <!-- ===== Contact Start ===== -->
    <section id="support" class="i pg fh rm ji gp uq">
        <!-- Bg Shapes -->
        <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" class="h aa y" />
        <img src="{{ asset('images/shape-03.svg') }}" alt="Shape" class="h ca u" />
        <img src="{{ asset('images/shape-07.svg') }}" alt="Shape" class="h w da ee" />
        <img src="{{ asset('images/shape-12.svg') }}" alt="Shape" class="h p s" />
        <img src="{{ asset('images/shape-13.svg') }}" alt="Shape" class="h r q" />

        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `Aloqa uchun`, sectionTitleText: `Agar sizda biror loyiha websayt yoki taklif bo'lsa biz siz bilan albatta bog'lanamiz buning uchun bizga o'z malumotlaringizni yuboring yoki berilgan manzillar bilan bog'laning!` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="i va bb ye ki xn wq jb mo">
            <div class="tc uf sn tf rn un zf xl:gap-10">
                <div class="animate_top w-full mn/5 to/3 vk sg hh sm yh rq i pg">
                    <!-- Bg Shapes -->
                    <img src="{{ asset('images/shape-03.svg') }}" alt="Shape" class="h la x wd" />
                    <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" class="h la ma ne kf" />

                    <div class="fb">
                        <h4 class="wj kk wm cc">Elektron pochta</h4>
                        <p><a href="mailto:husniddin13124041@gmail.com">husniddin13124041@gmail.com</a></p>
                    </div>
                    <div class="fb">
                        <h4 class="wj kk wm cc">Manzil</h4>
                        <p>M254+HFP, улица Усто Умара Джуракулова, Samarqand, Samarqand viloyati, Uzbekistan</p>
                    </div>
                    <div class="fb">
                        <h4 class="wj kk wm cc">Telefon raqam</h4>
                        <p><a href="#!">+998 77 025 26 77</a></p>
                    </div>

                    <span class="rc nd rh tm lc fb"></span>

                    <div>
                        <h4 class="wj kk wm qb">Ijtimoiy tarmoqlar</h4>
                        <ul class="tc wf fg">
                            <li>
                                <a href="https://t.me/matritsachi" class="c tc wf xf ie ld rg ml il tl">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100"
                                        height="100" viewBox="0 0 48 48">
                                        <path fill="#29b6f6" d="M24,4C13,4,4,13,4,24s9,20,20,20s20-9,20-20S35,4,24,4z">
                                        </path>
                                        <path fill="#fff"
                                            d="M34,15l-3.7,19.1c0,0-0.2,0.9-1.2,0.9c-0.6,0-0.9-0.3-0.9-0.3L20,28l-4-2l-5.1-1.4c0,0-0.9-0.3-0.9-1	c0-0.6,0.9-0.9,0.9-0.9l21.3-8.5c0,0,0.7-0.2,1.1-0.2c0.3,0,0.6,0.1,0.6,0.5C34,14.8,34,15,34,15z">
                                        </path>
                                        <path fill="#b0bec5"
                                            d="M23,30.5l-3.4,3.4c0,0-0.1,0.1-0.3,0.1c-0.1,0-0.1,0-0.2,0l1-6L23,30.5z">
                                        </path>
                                        <path fill="#cfd8dc"
                                            d="M29.9,18.2c-0.2-0.2-0.5-0.3-0.7-0.1L16,26c0,0,2.1,5.9,2.4,6.9c0.3,1,0.6,1,0.6,1l1-6l9.8-9.1	C30,18.7,30.1,18.4,29.9,18.2z">
                                        </path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="animate_top w-full nn/5 vo/3 vk sg hh sm yh tq">
                    <form>
                        <div class="tc sf yo ap zf ep qb">
                            <div class="vd to/2">
                                <label class="rc ac" for="fullname">To'liq ismingiz</label>
                                <input type="text" name="fullname" id="fullname" placeholder="Husniddin"
                                    class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 xi mi" />
                            </div>

                            <div class="vd to/2">
                                <label class="rc ac" for="phone">Telefon raqamingiz</label>
                                <input type="text" name="phone" id="phone" placeholder="+998 77 025 26 77"
                                    class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 xi mi" />
                            </div>
                        </div>

                        <div class="fb">
                            <label class="rc ac" for="message">Xabar</label>
                            <textarea placeholder="Xabar.." rows="4" name="description" id="message"
                                class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 ci"></textarea>
                        </div>

                        <div class="tc xf">
                            <button class="vc rg lk gh ml il hi gi _l">Xabarni yuborish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Contact End ===== -->

    {{-- <script>
        //  Pricing Table
        const setup = () => {
            return {
                isNavOpen: false,

                billPlan: 'monthly',

                plans: [{
                        name: 'Boshlamg\'ich',
                        price: {
                            monthly: 29,
                            annually: 29 * 12 - 199,
                        },
                        features: ['400 GB Storaget', 'Unlimited Photos & Videos', 'Exclusive Support'],
                    },
                    {
                        name: 'O\'rta',
                        price: {
                            monthly: 59,
                            annually: 59 * 12 - 100,
                        },
                        features: ['400 GB Storaget', 'Unlimited Photos & Videos', 'Exclusive Support'],
                    },
                    {
                        name: 'Biznes',
                        price: {
                            monthly: 139,
                            annually: 139 * 12 - 100,
                        },
                        features: ['400 GB Storaget', 'Unlimited Photos & Videos', 'Exclusive Support'],
                    },
                ],
            };
        };
    </script> --}}
</x-layout>
