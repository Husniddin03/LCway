<x-layout>

    <x-slot:title>

        Asosiy sahifa

    </x-slot>

    <!-- ===== Hero Start ===== -->
    <section class="gj do ir hj sp jr i pg">
        <!-- Hero Images -->
        <div class="animate_right xc fn zd/2 2xl:ud-w-187.5 bd 2xl:ud-h-171.5 h q r">
            <img src="{{asset('images/chatai.gif')}}" alt="ai" class="h q r ua" style="border-radius: 50%; margin-top: 100px; margin-right: 100px; width: 70%; border: 1px solid blue;  box-shadow: blue 10px 32px 70px 20px;" />
        </div>

        <!-- Hero Content -->
        <div class="bb ze ki xn 2xl:ud-px-0">
            <div class="tc _o">
                <div class="animate_left jn/2">
                    <h1 class="fk vj zp or kk wm wb">Assalomu alaykum, bizning sahifamizga xush kelibsiz!
                    </h1>
                    <p class="fq">
                        Bu yerda siz o'zingizga kreakli bo'lgan o'quv markazlarni topishingiz mumkun. Biz
                        sizga eng yaxshi xizmatni taqdim etamiz.
                    </p>

                    <div class="tc tf yo zf mb">
                        <a href="{{ route('blog-grid') }}" class="ek jk lk gh gi hi rg ml il vc _d _l">Hoziroq kurslarni
                            tanlash!</a>

                        <span class="tc sf">
                            <a href="#!" class="inline-block ek xj kk wm"> (+998) 77 025
                                026 77 </a>
                            <span class="inline-block">Har qanday savol yoki taklif uchun</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Hero End ===== -->

    <!-- ===== Small Features Start ===== -->
    <section id="features">
        <div class="bb ze ki yn 2xl:ud-px-12.5">
            <div class="tc uf zo xf ap zf bp mq">
                <!-- Small Features Item -->
                <div class="animate_top kn to/3 tc cg oq">
                    <div class="tc wf xf cf ae cd rg mh">
                        <img src="{{ asset('images/icon-01.svg') }}" alt="Icon" />
                    </div>
                    <div>
                        <h4 class="ek yj go kk wm xb">O'qituvchilar tanlovi</h4>
                        <p>O'zingiz munoib ko'rgan o'qituvchilarni tanlang.</p>
                    </div>
                </div>

                <!-- Small Features Item -->
                <div class="animate_top kn to/3 tc cg oq">
                    <div class="tc wf xf cf ae cd rg nh">
                        <img src="{{ asset('images/icon-02.svg') }}" alt="Icon" />
                    </div>
                    <div>
                        <h4 class="ek yj go kk wm xb">Butun O'zbekiston bo'ylab </h4>
                        <p>Butun O'zbekiston bo'ylab barcha o'quv markazlarini topishingiz mumkun.</p>
                    </div>
                </div>

                <!-- Small Features Item -->
                <div class="animate_top kn to/3 tc cg oq">
                    <div class="tc wf xf cf ae cd rg oh">
                        <img src="{{ asset('images/icon-03.svg') }}" alt="Icon" />
                    </div>
                    <div>
                        <h4 class="ek yj go kk wm xb">Markazlar reytingi bo'yicha</h4>
                        <p>O'quv markazlari reytingi bo'yicha qidiring.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Small Features End ===== -->

    <!-- ===== About Start ===== -->
    <section class="ji gp uq 2xl:ud-py-35 pg">
        <div class="bb ze ki xn wq">
            <div class="tc wf gg qq">
                <!-- About Images -->
                <div class="animate_left xc gn gg jn/2 i">
                    <div>
                        <img src="{{ asset('images/shape-05.svg') }}" alt="Shape" class="h -ud-left-5 x" />
                        <img src="{{ asset('images/we1.png') }}" alt="About" class="ib br-10" />
                        <img src="{{ asset('images/we3.png') }}" alt="About" class="br-10"/>
                    </div>
                    <div>
                        <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" />
                        <img src="{{ asset('images/we2.png') }}" alt="About" class="ob gb br-10" />
                        <img src="{{ asset('images/shape-07.svg') }}" alt="Shape" class="bb" />
                    </div>
                </div>

                <!-- About Content -->
                <div class="animate_right jn/2">
                    <h4 class="ek yj mk gb">Nima uchun bizni tanlaysiz</h4>
                    <h2 class="fk vj zp pr kk wm qb">Biz eng yaxshi xizmatlarni taqdim etish orqali mijozlarimizni
                        xursand qilamiz.</h2>
                    <p class="uo">Biz haqimizda ko'proq malumot olish uchun pastdagi videoni koring va biz haqimizda
                        o'z fikringizni qoldiring.</p>

                    <a href="{{asset('videos/aboutme.mp4')}}" data-fslightbox class="vc wf hg mb">
                        <span class="tc wf xf be dd rg i gh ua">
                            <span class="nf h vc yc vd rg gh qk -ud-z-1"></span>
                            <img src="{{ asset('images/icon-play.svg') }}" alt="Play" />
                        </span>
                        <span class="kk">Bizning ishga munosabatingiz qanday?</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== About End ===== -->

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

    <!-- ===== Services Start ===== -->
    <section class="lj tp kr">
        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `Biz siz uchun eng yaxshi sifatli xizmatni taklif etamiz.`, sectionTitleText: `Bu yerda biz qila oladigan ishlar berilgan.` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="bb ze ki xn yq mb en">
            <div class="wc qf pn xo ng">
                <!-- Service Item -->
                <div class="animate_top sg oi pi zq ml il am cn _m">
                    <img src="{{ asset('images/icon-04.svg') }}" alt="Icon" />
                    <h4 class="ek zj kk wm nb _b">Startup ishlab chiqish.</h4>
                    <p>Turli xil mavzularda startap loyhalar ishlab chiqamiz.</p>
                </div>

                <!-- Service Item -->
                <div class="animate_top sg oi pi zq ml il am cn _m">
                    <img src="{{ asset('images/icon-05.svg') }}" alt="Icon" />
                    <h4 class="ek zj kk wm nb _b">Yuqori sifatli dizayn</h4>
                    <p>Foydalanuvchilarga hush yoqadigan yuqori sifatli dizayn.</p>
                </div>

                <!-- Service Item -->
                <div class="animate_top sg oi pi zq ml il am cn _m">
                    <img src="{{ asset('images/icon-06.svg') }}" alt="Icon" />
                    <h4 class="ek zj kk wm nb _b">Websaytlar</h4>
                    <p>Biz siz uchun websayt qilib berishimiz mumkun.</p>
                </div>

                <!-- Service Item -->
                <div class="animate_top sg oi pi zq ml il am cn _m">
                    <img src="{{ asset('images/icon-07.svg') }}" alt="Icon" />
                    <h4 class="ek zj kk wm nb _b">Optimal tezlik</h4>
                    <p>Foydalanuvchilar uchun tezlikda hizmat qilish</p>
                </div>

                <!-- Service Item -->
                <div class="animate_top sg oi pi zq ml il am cn _m">
                    <img src="{{ asset('images/icon-05.svg') }}" alt="Icon" />
                    <h4 class="ek zj kk wm nb _b">To'liq moslashish</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis tortor.</p>
                </div>

                <!-- Service Item -->
                <div class="animate_top sg oi pi zq ml il am cn _m">
                    <img src="{{ asset('images/icon-06.svg') }}" alt="Icon" />
                    <h4 class="ek zj kk wm nb _b">Har ikkala tomondan</h4>
                    <p>Ham frontend ham backend bo'limlarni birdek bajarish</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Services End ===== -->

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
