<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Asosiy sahifa' }}</title>
    <link rel="icon" href="images/lcwayfavicon.png">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{-- <style>
        .snake-border::before {
            content: "";
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border-radius: 10px;
            background: linear-gradient(45deg, rgb(137, 137, 243), transparent, rgb(109, 109, 232));
            background-size: 200% 200%;
            animation: snake 10s linear infinite;
            z-index: -1;
        }

        /* Ilondek harakat animatsiya */
        @keyframes snake {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 50% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style> --}}
</head>

<body x-data="{ page: 'signup', 'darkMode': true, 'stickyMenu': false, 'navigationOpen': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'b eh': darkMode === false }">

    <!-- ===== Header Start ===== -->
    <header class="snake-border g s r vd ya cj" :class="{ 'hh sm _k dj bl ll': stickyMenu }"
        @scroll.window="stickyMenu = (window.pageYOffset > 20) ? true : false">
        <div class="bb ze ki xn 2xl:ud-px-0 oo wf yf i">
            <div class="vd to/4 tc wf yf">
                <a style="width: 50px" href="{{ route('index') }}">
                    <style>
                        @media (max-width: 768px) {
                            .log {
                                width: 45px !important;
                                height: 45px !important;
                            }
                        }
                    </style>
                    <img style="width: 100%; border-radius: 50%" class="om log"
                        src="{{ asset('images/lcwayfavicon.png') }}" alt="Logo Light" />
                    <img style="width: 100%; border-radius: 50%" class="xc nm log"
                        src="{{ asset('images/lcwayfavicon.png') }}" alt="Logo Dark" />
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
                        <li><a href="{{ route('blog-grid') }}" class="xl">O'quv markazlar</a></li>
                        <li><a href="{{ route('course.create') }}" class="xl">O'quv markaz qo'shish</a></li>
                        <li class="c i" x-data="{ dropdown: false }">
                            <a href="#!" class="xl tc wf yf bg" @click.prevent="dropdown = !dropdown"
                                :class="{
                                    'mk': page === 'index' || page === 'index'
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
                                <li><a href="{{ route('index') }}#features" class="xl"
                                        :class="{ 'mk': page === 'index' }">Biz haqimizda
                                    </a></li>
                                <li><a href="{{ route('index') }}#support" class="xl"
                                        :class="{ 'mk': page === 'index' }">Qo'llab-quvvatlash</a>
                                </li>
                            </ul>
                            <!-- Dropdown End -->
                        </li>
                        {{-- Tillar --}}
                        {{-- <li class="c i" x-data="{ dropdown: false }">
                            <a href="#!" class="xl tc wf yf bg" @click.prevent="dropdown = !dropdown"
                                :class="{
                                    'mk': page === 'index' || page === 'index'
                                }">
                                Tillar

                                <svg :class="{ 'wh': dropdown }" class="th mm we fd pf"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                </svg>
                            </a>

                            <!-- Dropdown Start -->
                            <ul class="a" :class="{ 'tc': dropdown }">
                                <li>
                                    <a href="{{ route('index') }}#features" class="xl"
                                        :class="{ 'mk': page === 'index' }">Uz
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('index') }}#support" class="xl"
                                        :class="{ 'mk': page === 'index' }">Rs</a>
                                </li>
                            </ul>
                        </li> --}}
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
                        <a style="width: 50px" href="#">
                            @isset(Auth::user()->avatar)
                                <img style="width: 100%; border-radius: 50%" src="{{ Auth::user()->avatar }}" alt="">
                            @else
                                <img style="width: 100%; border-radius: 50%"
                                    src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random&size=64"
                                    alt="Icon" />
                            @endisset
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('signin') }}"
                            :class="{ 'nk yl': page === 'home', 'ok': page === 'home' && stickyMenu }"
                            class="ek pk xl">Kirish</a>
                        <a href="{{ route('signup') }}"
                            :class="{ 'hh/[0.15]': page === 'home', 'sh': page === 'home' && stickyMenu }"
                            class="lk gh dk rg tc wf xf _l gi hi">Ro'yxatdan o'tish</a>
                    @endguest

                </div>
            </div>
        </div>
    </header>

    <main class="">

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
                            {{ $AllCenters->count() }} ta
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
                            <img style="width: 50px; border-radius: 50%" src="{{ asset('images/lcwayfavicon.png') }}"
                                alt="Logo" class="om log2" />
                            <img style="width: 50px; border-radius: 50%" src="{{ asset('images/lcwayfavicon.png') }}"
                                alt="Logo" class="xc nm log2" />
                        </a>

                        <p class="lc fb">LCway - Learning-Center way yani Ta’lim sari eng qulay yo‘lni topuvchi
                            platforma</p>

                        <ul class="tc wf cg">
                            <li>
                                <a href="https://t.me/lcway_channel" target="_blank" class="sc xl vb">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50"
                                        height="50" viewBox="0 0 48 48">
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
    <div x-data="{ scrollTop: false }" @scroll.window="scrollTop = (window.pageYOffset > 50)"
        style="-ms-flex-item-align: center">

        <!-- Scroll to top button with icon -->
        <button class="xc wf xf ie ld vg sr tr g sa ta _a" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            :class="{ 'uc': scrollTop }" style="bottom: 7rem; color: blue;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
            </svg>

        </button>

        <a href="{{route('chat.quiz')}}" class="xc wf xf ie ld vg sr tr g sa ta _a uc" style="right: 7rem; color: blue;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

        </a>

        <!-- Chat button -->
        <a href="{{route('chat.chat')}}" class="xc wf xf ie ld vg sr tr g sa ta _a uc" style="color: blue;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
            </svg>
        </a>
    </div>

    <!-- ====== Back To Top End ===== -->


    <script defer src="{{ asset('js/bundle.js') }}"></script>
</body>

</html>
