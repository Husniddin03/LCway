<x-layout>

    <x-slot:title>

        Sign Up - FindCourse

    </x-slot>

    <!-- ===== SignUp Form Start ===== -->
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
                <h2 class="ek ck kk wm xb">Create an Account</h2>
                <p>Lorem ipsum dolor sit amet, consectetur</p>

                <h3 class="hk yj kk wm ob mc">Sign up with Social Media</h3>
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

                    Or, sign up with your email
                </span>
            </div>

            <form class="sb" action="{{ route('register') }}" method="post">
                @csrf
                <div class="wb">
                    <label class="rc kk wm vb" for="fullname">Full name</label>
                    <input type="text" name="name" id="fullname" placeholder="Devid Wonder"
                        class="vd hh rg zk _g ch hm dm fm pl/50 xi mi sm xm pm dn/40" />
                </div>

                <div class="wb">
                    <label class="rc kk wm vb" for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com"
                        class="vd hh rg zk _g ch hm dm fm pl/50 xi mi sm xm pm dn/40" />
                </div>

                <div class="wb">
                    <label class="rc kk wm vb" for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="**************"
                        class="vd hh rg zk _g ch hm dm fm pl/50 xi mi sm xm pm dn/40" />
                </div>

                <button type="submit" class="vd rj ek rc rg gh lk ml il _l gi hi">
                    Sign Up
                </button>

                <p class="sj hk xj rj ob">
                    Already have an account?
                    <a class="mk" href="{{ route('signin') }}"> Sign In </a>
                </p>
            </form>
        </div>
    </section>
    <!-- ===== SignUp Form End ===== -->

</x-layout>
