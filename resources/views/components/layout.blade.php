<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Todo Manager' }}</title>
    <link rel="icon" href="favicon.ico">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body x-data="{ page: 'signup', 'darkMode': true, 'stickyMenu': false, 'navigationOpen': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'b eh': darkMode === true }">

    <!-- ===== Header Start ===== -->
    <header class="g s r vd ya cj" :class="{ 'hh sm _k dj bl ll': stickyMenu }"
        @scroll.window="stickyMenu = (window.pageYOffset > 20) ? true : false">
        <div class="bb ze ki xn 2xl:ud-px-0 oo wf yf i">
            <div class="vd to/4 tc wf yf">
                <a href="{{ route('index') }}">
                    <style>
                        @media (max-width: 768px) {
                            .log {
                                width: 45px !important;
                                height: 45px !important;
                            }
                        }
                    </style>
                    <img style="width: 80px; height: 80px; border-radius: 50%" class="om log"
                        src="{{ asset('images/lcwaylogo.png') }}" alt="Logo Light" />
                    <img style="width: 80px; height: 80px; border-radius: 50%" class="xc nm log"
                        src="{{ asset('images/lcwaylogo.png') }}" alt="Logo Dark" />
                </a>

                <!-- Hamburger Toggle BTN -->
                <button class="po rc" @click="navigationOpen = !navigationOpen">
                    <span class="rc i pf re pd">
                        <span class="du-block h q vd yc">
                            <span class="rc i r s eh um tg te rd eb ml jl dl"
                                :class="{ 'ue el': !navigationOpen }"></span>
                            <span class="rc i r s eh um tg te rd eb ml jl fl"
                                :class="{ 'ue qr': !navigationOpen }"></span>
                            <span class="rc i r s eh um tg te rd eb ml jl gl"
                                :class="{ 'ue hl': !navigationOpen }"></span>
                        </span>
                        <span class="du-block h q vd yc lf">
                            <span class="rc eh um tg ml jl el h na r ve yc"
                                :class="{ 'sd dl': !navigationOpen }"></span>
                            <span class="rc eh um tg ml jl qr h s pa vd rd"
                                :class="{ 'sd rr': !navigationOpen }"></span>
                        </span>
                    </span>
                </button>
                <!-- Hamburger Toggle BTN -->
            </div>

            <div class="vd wo/4 sd qo f ho oo wf yf" :class="{ 'd hh rm sr td ud qg ug jc yh': navigationOpen }">
                <nav>
                    <ul class="tc _o sf yo cg ep">
                        <li><a href="{{ route('index') }}" class="xl"
                                :class="{ 'mk': page === 'home' }">Asosiy</a></li>
                        <li><a href="{{ route('index') }}#features" class="xl">Biz haqimizda</a></li>
                        <li class="c i" x-data="{ dropdown: false }">
                            <a href="#!" class="xl tc wf yf bg" @click.prevent="dropdown = !dropdown"
                                :class="{
                                    'mk': page === 'blog-grid' || page === 'blog-single' || page === 'signin' ||
                                        page === 'signup' || page === 'create'
                                }">
                                Sahifalar

                                <svg :class="{ 'wh': dropdown }" class="th mm we fd pf"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                </svg>
                            </a>

                            <!-- Dropdown Start -->
                            <ul class="a" :class="{ 'tc': dropdown }">
                                <li><a href="{{ route('blog-grid') }}" class="xl"
                                        :class="{ 'mk': page === 'blog-grid' }">O'quv markazlar
                                    </a></li>
                                <li><a href="{{ route('course.create') }}" class="xl"
                                        :class="{ 'mk': page === 'create' }">O'quv markaz qo'shish</a>
                                </li>
                            </ul>
                            <!-- Dropdown End -->
                        </li>
                        <li><a href="{{ route('index') }}#support" class="xl">Qo'llab-quvvatlash</a></li>
                    </ul>
                </nav>

                <div class="tc wf ig pb no">
                    <div class="pc h io pa ra" :class="navigationOpen ? '!-ud-visible' : 'd'">
                        <label class="rc ab i">
                            <input type="checkbox" :value="darkMode" @change="darkMode = !darkMode"
                                class="pf vd yc uk h r za ab" />
                            <!-- Icon Sun -->
                            <svg :class="{ 'wn': page === 'home', 'xh': page === 'home' && stickyMenu }"
                                class="th om" width="25" height="25" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.0908 18.6363C10.3549 18.6363 8.69 17.9467 7.46249 16.7192C6.23497 15.4916 5.54537 13.8268 5.54537 12.0908C5.54537 10.3549 6.23497 8.69 7.46249 7.46249C8.69 6.23497 10.3549 5.54537 12.0908 5.54537C13.8268 5.54537 15.4916 6.23497 16.7192 7.46249C17.9467 8.69 18.6363 10.3549 18.6363 12.0908C18.6363 13.8268 17.9467 15.4916 16.7192 16.7192C15.4916 17.9467 13.8268 18.6363 12.0908 18.6363ZM12.0908 16.4545C13.2481 16.4545 14.358 15.9947 15.1764 15.1764C15.9947 14.358 16.4545 13.2481 16.4545 12.0908C16.4545 10.9335 15.9947 9.8236 15.1764 9.00526C14.358 8.18692 13.2481 7.72718 12.0908 7.72718C10.9335 7.72718 9.8236 8.18692 9.00526 9.00526C8.18692 9.8236 7.72718 10.9335 7.72718 12.0908C7.72718 13.2481 8.18692 14.358 9.00526 15.1764C9.8236 15.9947 10.9335 16.4545 12.0908 16.4545ZM10.9999 0.0908203H13.1817V3.36355H10.9999V0.0908203ZM10.9999 20.8181H13.1817V24.0908H10.9999V20.8181ZM2.83446 4.377L4.377 2.83446L6.69082 5.14828L5.14828 6.69082L2.83446 4.37809V4.377ZM17.4908 19.0334L19.0334 17.4908L21.3472 19.8046L19.8046 21.3472L17.4908 19.0334ZM19.8046 2.83337L21.3472 4.377L19.0334 6.69082L17.4908 5.14828L19.8046 2.83446V2.83337ZM5.14828 17.4908L6.69082 19.0334L4.377 21.3472L2.83446 19.8046L5.14828 17.4908ZM24.0908 10.9999V13.1817H20.8181V10.9999H24.0908ZM3.36355 10.9999V13.1817H0.0908203V10.9999H3.36355Z"
                                    fill="" />
                            </svg>
                            <!-- Icon Sun -->
                            <img class="xc nm" src="{{ asset('images/icon-moon.svg') }}" alt="Moon" />
                        </label>
                    </div>

                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                :class="{ 'nk yl': page === 'home', 'ok': page === 'home' && stickyMenu }"
                                class="ek pk xl" style="color: red">Chiqish</button>
                        </form>
                        <a href="{{ route('index') }}"
                            :class="{ 'hh/[0.15]': page === 'home', 'sh': page === 'home' && stickyMenu }"
                            class="lk gh dk rg tc wf xf _l gi hi">{{ Auth::user()->name }}
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('signin') }}"
                            :class="{ 'nk yl': page === 'home', 'ok': page === 'home' && stickyMenu }"
                            class="ek pk xl">Sign In</a>
                        <a href="{{ route('signup') }}"
                            :class="{ 'hh/[0.15]': page === 'home', 'sh': page === 'home' && stickyMenu }"
                            class="lk gh dk rg tc wf xf _l gi hi">Sign Up</a>
                    @endguest

                </div>
            </div>
        </div>
    </header>
    <main>

        {{ $slot }}

        <!-- ===== CTA Start ===== -->
        <section class="i pg gh ji">
            <!-- Bg Shape -->
            <img class="h p q" src="{{ asset('images/shape-16.svg') }}" alt="Bg Shape" />

            <div class="bb ye i z-10 ki xn dr">
                <div class="tc uf sn tn un gg">
                    <div class="animate_left to/2">
                        <h2 class="fk vj zp pr lk ac">
                            Hozirda ro'yxatdan o'tganlar o'quv markazlar soni:
                            {{$AllCenters->count()}} ta
                        </h2>
                        <p class="lk">
                            Ular safida siz ham bo'ling va o'zingizning o'quv markazingizni qo'shing!
                        </p>
                    </div>
                    <div class="animate_right bf">
                        <a href="{{ route('course.create') }}" class="vc ek kk hh rg ol il cm gi hi">
                            Hoziroq qo'shiling
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CTA End ===== -->
    </main>

    <!-- ===== Footer Start ===== -->
    <footer>
        <div class="bb ze ki xn 2xl:ud-px-0">
            <!-- Footer Top -->
            <div class="ji gp">
                <div class="tc uf ap gg fp">
                    <div class="animate_top zd/2 to/4">
                        <a href="{{ route('index') }}">
                            <img style="width: 100px; height: 100px; border-radius: 50%"
                                src="{{ asset('images/lcwaylogo.png') }}" alt="Logo" class="om log2" />
                            <img style="width: 100px; height: 100px; border-radius: 50%"
                                src="{{ asset('images/lcwaylogo.png') }}" alt="Logo" class="xc nm log2" />
                        </a>

                        <p class="lc fb">LCway - Learning-Center way yani Ta’lim sari eng qulay yo‘l</p>

                        <ul class="tc wf cg">
                            <li>
                                <a href="https://t.me/lcway_group" target="_blank" class="sc xl vb">
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

                    <div class="vd ro tc sf rn un gg vn">
                        <div class="animate_top">
                            <h4 class="kk wm tj ec">Tez havolalar</h4>

                            <ul>
                                <li><a href="{{ route('index') }}" class="sc xl vb">Asosiy</a></li>
                                <li><a href="{{ route('index') }}#features" class="sc xl vb">Biz haqimizda</a></li>
                                <li>
                                    <a href="{{ route('blog-grid') }}" class="sc xl vb">
                                        O'quv markazlari

                                    </a>
                                </li>
                                <li><a href="{{ route('course.create') }}" class="sc xl vb">O'quv markazi
                                        qo'shish</a></li>
                            </ul>
                        </div>

                        <div class="animate_top">
                            <h4 class="kk wm tj ec">Xizmatlar</h4>

                            <ul>
                                <li><a href="#!" class="sc xl vb">Full stack datsurchi</a></li>
                                <li><a href="#!" class="sc xl vb">Frontend</a></li>
                                <li><a href="#!" class="sc xl vb">Backend</a></li>
                                <li><a href="#!" class="sc xl vb">Ui/Ux dezayn</a></li>
                            </ul>
                        </div>

                        {{-- <div class="animate_top">
                            <h4 class="kk wm tj ec">Support</h4>

                            <ul>
                                <li><a href="#!" class="sc xl vb">Company</a></li>
                                <li><a href="#!" class="sc xl vb">Press media</a></li>
                                <li><a href="#!" class="sc xl vb">Our Blog</a></li>
                                <li><a href="#!" class="sc xl vb">Contact Us</a></li>
                            </ul>
                        </div>

                        <div class="animate_top">
                            <h4 class="kk wm tj ec">Newsletter</h4>
                            <p class="ac qe">Subscribe to receive future updates</p>

                            <form action="#!" method="#!">
                                <div class="i">
                                    <input type="text" placeholder="Email address"
                                        class="vd sm _g ch pm vk xm rg gm dm dn gi mi" />

                                    <button class="h q fi">
                                        <svg class="th vm ul" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_48_1487)">
                                                <path
                                                    d="M3.1175 1.17318L18.5025 9.63484C18.5678 9.67081 18.6223 9.72365 18.6602 9.78786C18.6982 9.85206 18.7182 9.92527 18.7182 9.99984C18.7182 10.0744 18.6982 10.1476 18.6602 10.2118C18.6223 10.276 18.5678 10.3289 18.5025 10.3648L3.1175 18.8265C3.05406 18.8614 2.98262 18.8792 2.91023 18.8781C2.83783 18.8769 2.76698 18.857 2.70465 18.8201C2.64232 18.7833 2.59066 18.7308 2.55478 18.6679C2.51889 18.6051 2.50001 18.5339 2.5 18.4615V1.53818C2.50001 1.46577 2.51889 1.39462 2.55478 1.33174C2.59066 1.26885 2.64232 1.2164 2.70465 1.17956C2.76698 1.14272 2.83783 1.12275 2.91023 1.12163C2.98262 1.12051 3.05406 1.13828 3.1175 1.17318ZM4.16667 10.8332V16.3473L15.7083 9.99984L4.16667 3.65234V9.16651H8.33333V10.8332H4.16667Z"
                                                    fill="" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_48_1487">
                                                    <rect width="20" height="20" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- Footer Top -->

            <!-- Footer Bottom -->
            <div class="bh ch pm tc uf sf yo wf xf ap cg fp bj">
                <div class="animate_top">
                    <ul class="tc wf gg">
                        <li><a href="#!" class="xl">Uzbekistan</a></li>
                        <li><a href="#!" class="xl">Malumotlar himoyalangan</a></li>
                        <li><a href="{{ route('index') }}#support" class="xl">Qo'llab quvvatlash</a></li>
                    </ul>
                </div>

                <div class="animate_top">
                    <p>&copy; 2025 Base. All rights reserved. Distributed by <a href="https://themewagon.com"
                            target="_blank">ThemeWagon</a></p>
                </div>
            </div>
            <!-- Footer Bottom -->
        </div>
    </footer>

    <!-- ===== Footer End ===== -->

    <!-- ====== Back To Top Start ===== -->
    <button class="xc wf xf ie ld vg sr gh tr g sa ta _a" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        @scroll.window="scrollTop = (window.pageYOffset > 50) ? true : false" :class="{ 'uc': scrollTop }">
        <svg class="uh se qd" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
                d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z" />
        </svg>
    </button>

    <!-- ====== Back To Top End ===== -->


    <script defer src="{{ asset('js/bundle.js') }}"></script>
</body>

</html>
</body>

</html>
