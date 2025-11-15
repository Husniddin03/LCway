<x-layout>

    <x-slot:title>

       Kirish sahifasi

    </x-slot>

    <!-- ===== SignIn Form Start ===== -->
    <section class="i pg fh rm ki xn vq gj qp gr hj rp hr">
        <!-- Bg Shapes -->
        <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" class="h j k" />
        <img src="{{ asset('images/shape-03.svg') }}" alt="Shape" class="h l m" />
        <img src="{{ asset('images/shape-17.svg') }}" alt="Shape" class="h n o" />
        <img src="{{ asset('images/shape-18.svg') }}" alt="Shape" class="h p q" />

        <div class="animate_top bb af i va sg hh sm vk xm yi _n jp hi ao kp">
            <!-- Bg Border -->
            <span class="rc h r s zd/2 od zg gh"></span>
            <span class="rc h r q zd/2 od xg mh"></span>

            <div class="rj">
                <h2 class="ek ck kk wm xb">Sign in to your Account</h2>
                <p>Lorem ipsum dolor sit amet, consectetur</p>

                <h3 class="hk yj kk wm ob mc">Sign in with Social Media</h3>
                <ul class="tc wf xf mg ec">
                    <li style="border: 1px solid blue; border-radius: 8px">
                        <a style="width: 100%;" class="tc wf xf be dd di sg _g ch qm ml il bm rl/40 ym/40"
                            href="{{ route('google.redirect') }}">
                            <img style="width: 40%" src="{{ asset('images/google.png') }}" alt="">
                        </a>
                    </li>
                </ul>

                <span class="i rc sj hk xj">
                    <span class="rc h s z/2 nd oe rh tm"></span>
                    <span class="rc h q z/2 nd oe rh tm"></span>

                    Or, sign in with your email
                </span>
            </div>

            {{-- all error --}}
            @error('email')
                <div style="background-color: red"
                    class="vd rj ek rc rg gh lk ml il _l hi ch hm dm fm xi mi sm xm pm dn/40 mb-4">
                    Iltimis malumotlaringizni qayta tekshiring!
                </div>
            @enderror
            @error('password')
                <div style="background-color: red"
                    class="vd rj ek rc rg gh lk ml il _l hi ch hm dm fm xi mi sm xm pm dn/40 mb-4">
                    Iltimis malumotlaringizni qayta tekshiring!
                </div>
            @enderror


            <form class="sb" action="{{ route('login') }}" method="post">
                @csrf
                <div class="wb">
                    <label class="rc kk wm vb" for="username">Username</label>
                    <input type="text" name="email" id="username" placeholder="example@gmail.com"
                        class="vd hh rg zk _g ch hm dm fm pl/50 xi mi sm xm pm dn/40" />
                </div>

                <div class="wb">
                    <label class="rc kk wm vb" for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="**************"
                        class="vd hh rg zk _g ch hm dm fm pl/50 xi mi sm xm pm dn/40" />
                </div>

                <button type="submit" class="vd rj ek rc rg gh lk ml il _l gi hi">
                    Sign In
                </button>

                <p class="sj hk xj rj ob">
                    Don't have an account?
                    <a class="mk" href="{{ route('signup') }}"> Sign Up </a>
                </p>
            </form>
        </div>
    </section>
    <!-- ===== SignIn Form End ===== -->

</x-layout>
