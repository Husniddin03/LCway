<x-layout>


    <x-slot:title>

        {{ $LearningCenter->name }} haqida batafsil ma'lumot

    </x-slot>

    <!-- ===== Blog Single Start ===== -->
    <section class="gj qp gr hj rp hr">
        <div class="bb ze ki xn 2xl:ud-px-0">
            <div class="tc sf yo zf kq">
                <div class="ro">
                    <div
                        class="animate_top rounded-md shadow-solid-13 bg-white dark:bg-blacksection border border-stroke dark:border-strokedark p-7.5 md:p-10">
                        {{-- <a href="{{ asset('storage/' . $LearningCenter->logo) }}" data-fslightbox class="vc wf hg mb">
                            <img style="width: 100% !important; border-radius: 15px"
                                src="{{ asset('storage/' . $LearningCenter->logo) }}" alt="Blog" />
                        </a> --}}

                         <a href="{{$LearningCenter->logo }}" data-fslightbox class="vc wf hg mb">
                            <img style="width: 100% !important; border-radius: 15px;"
                                src="{{$LearningCenter->logo }}" alt="Blog" />
                        </a>

                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb gb">
                            {{ $LearningCenter->name }}

                            @php
                                $average = round($LearningCenter->favorites()->avg('rating') ?? 0, 1);
                            @endphp

                            <h4 class="favorite1">
                                <div class="stars1" id="rating11">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $diff = $average - $i;
                                        @endphp
                                        <span
                                            class="star1 {{ $average >= $i ? 'full' : ($diff > -1 && $diff < 0 ? 'half' : '') }}">
                                            ★
                                        </span>
                                    @endfor
                                </div>
                                <div style="margin-top: 6px" class="result1">{{ $average }}</div>
                            </h4>
                        </h2>

                        <ul class="tc uf cg 2xl:ud-gap-15 fb">
                            <li><span class="rc kk wm">Saytga kiritgan shaxs:
                                </span> <a
                                    href="mailto:{{ $LearningCenter->user->email }}">{{ $LearningCenter->user->name }}</a>
                            </li>
                            <li><span class="rc kk wm">Yuklangan sana: </span>
                                {{ $LearningCenter->created_at->diffForHumans() }} </li>
                            <li><span class="rc kk wm"> Tur:
                                </span> {{ $LearningCenter->type }}</li>
                            <li><span class="rc kk wm"> Manzil:
                                </span> <a target="_blank" style="color: cornflowerblue"
                                    href="https://www.google.com/maps?q={{ $LearningCenter->location }}">{{ $LearningCenter->address }}</a>
                            </li>
                        </ul>

                        <div class="bb ze mb">
                            <!-- Service Item -->
                            <div class="animate_top" style="width: 100%">
                                <div class="_b"
                                    style="display: flex; flex-direction: row; align-content: center; align-items: center;">
                                    <img style="width: 2rem; margin-right: 2rem; height: 2rem;"
                                        src="{{ asset('images/3d-speaker.png') }}" alt="Icon" />
                                    <h4 class="ek zj kk wm">O'qituvchi kerak</h4>
                                </div>
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <div
                                            style="width:100%;display:flex; flex-wrap:wrap; gap:12px; justify-content:center; margin-bottom:20px;">
                                            <h6 style="width:100%;font-size:16px; font-weight:600;">
                                                <a href="{{ route('teacher.announcement', $LearningCenter->id) }}"
                                                    :class="{
                                                        'hh/[0.15]': page === 'home',
                                                        'sh': page === 'home' &&
                                                            stickyMenu
                                                    }"
                                                    class="lk gh dk rg tc wf xf _l gi hi">
                                                    E'lon berish 📢
                                                </a>
                                            </h6>
                                        </div>
                                    @endcan
                                @endauth
                                @if ($LearningCenter->needTeachers->count() > 0)
                                    @foreach ($LearningCenter->needTeachers as $teacher)
                                        <div style="display: flex">
                                            <p>
                                                <span style="color: brown">{{ $teacher->subject->name }}</span> -
                                                {{ $teacher->description }}
                                            </p>
                                            @auth
                                                @can('isOun', $LearningCenter)
                                                    <form action="{{ route('teacher.delete_announcement', $teacher->id) }}"
                                                        onsubmit="return confirm('Rostdan ham {{ $teacher->subject->name }} uchun berilgan elon o‘chirilsinmi?');"
                                                        method="post">
                                                        @csrf
                                                        <button style="color: brown" type="submit">
                                                            &nbsp;❌
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endauth
                                        </div>
                                    @endforeach
                                @else
                                    <p>Hozicha elon berilmagan!</p>
                                @endif
                            </div>
                        </div>



                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb gb">
                            {{ $LearningCenter->name }} haqida qisqacha malumot:
                        </h2>

                        <p class="ob">
                            {{ $LearningCenter->about }}
                        </p>

                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb gb">
                            Rasimlar
                        </h2>

                        <div class="wc qf pn dg cb animate_right">
                            @foreach ($LearningCenter->images as $image)
                                {{-- <a href="{{ asset('storage/' . $image->image) }}" data-fslightbox
                                    class="animate_right vc wf hg mb">
                                    <img style="width: 100%; border-radius: 15px"
                                        src="{{ asset('storage/' . $image->image) }}" alt="Blog" />
                                </a> --}}
                                <a href="{{ $image->image}}" data-fslightbox
                                    class="animate_right vc wf hg mb">
                                    <img style="width: 100%; border-radius: 15px"
                                        src="{{ $image->image }}" alt="Blog" />
                                </a>
                            @endforeach
                            @auth
                                @can('isOun', $LearningCenter)
                                    <div style="display: flex; align-content: center; align-items: center; text-align: center">
                                        <a style="border: 1px solid blue"
                                            href="{{ route('course.editImage', $LearningCenter->id) }}"
                                            class="vc ek kk hh rg ol il cm gi hi">Tahrirlash </a>
                                    </div>
                                @endcan
                            @endauth
                        </div>

                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb qb">
                            {{ $LearningCenter->name }} kun tartibi.
                        </h2>

                        <div class="bb ze mb en">
                            <div class="wc qf pn xo ng">
                                <!-- Service Item -->
                                @foreach ($LearningCenter->calendar as $calendar)
                                    <div class="animate_top sg pi ml il am cn _m"
                                        style="display: flex; flex-direction: row; align-items: center; padding-bottom: 20px">
                                        <div>
                                            <h4 class="ek zj kk wm nb _b">
                                                {{ $calendar->calendar->weekdays }}
                                            </h4>
                                            <p>{{ date('H:i', strtotime($calendar->open_time)) }} -
                                                {{ date('H:i', strtotime($calendar->close_time)) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <div
                                            style="display: flex; align-content: center; align-items: center; text-align: center">
                                            <a style="border: 1px solid blue"
                                                href="{{ route('course.weekday', $LearningCenter->id) }}"
                                                class="vc ek kk hh rg ol il cm gi hi">Tahrirlash </a>
                                        </div>
                                    @endcan
                                @endauth
                            </div>
                        </div>

                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb qb">
                            {{ $LearningCenter->name }} bilan bog'lanish.
                        </h2>

                        <ul class="tc wf bg sb">
                            <li>
                                <p class="sj kk wm tb">Ijtimoiy tarmoqlar:</p>
                            </li>

                            @foreach ($LearningCenter->connections as $connection)
                                <ul style="text-align: center; background-color: #fff; border-radius: 50%">
                                    @if ($connection->connection->name == 'Phone')
                                        <li style="display: flex; align-items: center; gap: 8px;">
                                            <a class="c tc wf xf ie ld rg ml il tl" href="tel:{{ $connection->url }}"
                                                class="tc wf xf yd ad rg ml il ih wk">
                                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.62 2.48a2 2 0 01-.45 1.885l-1.516 1.516a16 16 0 006.586 6.586l1.516-1.516a2 2 0 011.885-.45l2.48.62A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1c-9.94 0-18-8.06-18-18V5z" />
                                                </svg>

                                            </a>
                                        </li>
                                    @elseif($connection->connection->name == 'Email')
                                        <li>
                                            <a class="c tc wf xf ie ld rg ml il tl"
                                                href="mailto:{{ $connection->url }}"
                                                class="tc wf xf yd ad rg ml il ih wk">
                                                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/gmail.svg"
                                                    width="20" height="20"
                                                    alt="{{ $connection->connection->name }}" />
                                            </a>
                                        </li>
                                    @elseif($connection->connection->name == 'Website')
                                        <li>
                                            <a class="c tc wf xf ie ld rg ml il tl" href="{{ $connection->url }}"
                                                class="tc wf xf yd ad rg ml il ih wk">
                                                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/googlechrome.svg"
                                                    width="20" height="20"
                                                    alt="{{ $connection->connection->name }}" />
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $connection->url }}" class="c tc wf xf ie ld rg ml il tl"
                                                class="tc wf xf yd ad rg ml il ih wk">
                                                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/{{ strtolower($connection->connection->name) }}.svg"
                                                    width="20" height="20"
                                                    alt="{{ $connection->connection->name }}" />
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @endforeach
                        </ul>
                        @auth
                            @can('isOun', $LearningCenter)
                                <div style="display: flex; align-content: center; align-items: center; text-align: center">
                                    <a style="border: 1px solid blue" href="{{ route('connect.edit', $LearningCenter->id) }}"
                                        class="vc ek kk hh rg ol il cm gi hi">Tahrirlash </a>
                                </div>
                            @endcan
                        @endauth
                        <div class="animate_top" style="margin-top: 1rem">
                            <h4 class="tj kk wm qb ta-c">Ustozlar</h4>
                            <div style="margin:0 auto; font-family:'Segoe UI', sans-serif;">

                                @auth
                                    @can('isOun', $LearningCenter)
                                        <div
                                            style="width:100%; :flex; flex-wrap:wrap; gap:12px; justify-content:center; margin-bottom:20px;">
                                            <h6 style="font-size:16px; font-weight:600;">
                                                <a href="{{ route('teacher.create', 'id=' . $LearningCenter->id) }}"
                                                    :class="{
                                                        'hh/[0.15]': page === 'home',
                                                        'sh': page === 'home' &&
                                                            stickyMenu
                                                    }"
                                                    class="lk gh dk rg tc wf xf _l gi hi">
                                                    Yangi ustoz ➕
                                                </a>
                                            </h6>
                                        </div>
                                    @endcan
                                @endauth

                                <hr style="margin:16px 0;">


                                @foreach ($LearningCenter->teachers as $teacher)
                                    <div class="tc uf zo ap zf bp" style="align-items: center">
                                        <div class="tc zo ap zf bp"
                                            style="display: flex; align-items: center; margin-bottom: 2rem">
                                            <!-- Small Features Item -->
                                            @if (isset($teacher->photo))
                                                <div class="tc wf xf cf ae cd rg mh"
                                                    style="width: 3rem; height: 3rem;">
                                                    {{-- <a href="{{ asset('storage/' . $teacher->photo) }}"
                                                        data-fslightbox>

                                                        <img style="border-radius: 50%"
                                                            src="{{ asset('storage/' . $teacher->photo) }}"
                                                            alt="Icon" />
                                                    </a> --}}
                                                    <a href="{{ $teacher->photo }}"
                                                        data-fslightbox>

                                                        <img style="border-radius: 50%"
                                                            src="{{  $teacher->photo }}"
                                                            alt="Icon" />
                                                    </a>
                                                </div>
                                            @else
                                                <div class="tc wf xf cf ae cd rg mh"
                                                    style="width: 3rem; height: 3rem;">
                                                    <img style="border-radius: 50%"
                                                        src="https://ui-avatars.com/api/?name={{ $teacher->name }}&background=random&size=64"
                                                        alt="Icon" />
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="ek yj go kk wm xb">{{ $teacher->name }}</h4>
                                                <p>{{ $teacher->phone }}</p>
                                                <p style="color: brown">{{ $teacher->subject->name }}</p>
                                                <p>{{ $teacher->about }}</p>
                                            </div>
                                        </div>

                                        @auth
                                            @can('isOun', $LearningCenter)
                                                <form id="delete-{{ $teacher->id }}"
                                                    action="{{ route('teacher.destroy', $teacher->id) }}" method="post"
                                                    onsubmit="return confirm('Rostdan ham {{ $teacher->name }}ni o‘chirilsinmi?');"
                                                    style="margin-left:10px;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="font-size: 1rem">❌</button>
                                                </form>
                                            @endcan
                                        @endauth
                                    </div>
                                @endforeach

                            </div>

                            <hr style="margin:16px 0;">
                        </div>
                        <div class="animate_top">
                            <h4 class="tj kk wm qb ta-c">Joylashuv</h4>

                            <div>
                                <iframe style="width: 100%; height: 20rem; border-radius: 0.5rem"
                                    src="https://www.google.com/maps?q={{ $LearningCenter->location }}&hl=uz&z=14&output=embed"
                                    allowfullscreen loading="lazy">
                                </iframe>
                            </div>
                        </div>

                        @auth
                            <div id="comment" class="animate_top">

                                <h4 class="favorite">
                                    <span class="rating-label">Markazni baholang:</span>
                                    <div class="stars" id="rating1" data-center-id="{{ $LearningCenter->id }}">
                                        <span class="star" data-value="1">★</span>
                                        <span class="star" data-value="2">★</span>
                                        <span class="star" data-value="3">★</span>
                                        <span class="star" data-value="4">★</span>
                                        <span class="star" data-value="5">★</span>
                                    </div>
                                    <div class="result" id="result1"></div>
                                </h4>

                                <h4 class="tj kk wm qb ta-c">Izohlar</h4>
                                <form action="{{ route('comment.store') }}" method="POST" class="mb-6">
                                    @csrf
                                    <input style="padding-right: 20px" type="hidden" name="learning_centers_id"
                                        value="{{ $LearningCenter->id }}">
                                    <div class="i">
                                        <input name="comment" type="text"
                                            placeholder="{{ $LearningCenter->name }} haqida fikringizni qoldiring..."
                                            class="vd sm _g ch pm vk xm rg gm dm/40 dn/40 li mi" />

                                        <button type="submit" class="h r q _h">
                                            <svg class="th ul ml il" width="21" height="21" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.01 21L23 12L2.01 3L2 10L17 12L2 14L2.01 21Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </button>

                                    </div>
                                </form>
                                <div>

                                    <!-- Slider main container -->
                                    <div style="margin-top: 20px" class="swiper testimonial-01">
                                        <p>Jami izohlar {{ $LearningCenter->comments->count() }}</p>
                                        <div class="swiper-wrapper">
                                            @foreach ($LearningCenter->comments->reverse() as $comment)
                                                <!-- Slides -->
                                                <div class="swiper-slide">
                                                    <div class="i hh rm sg vk xm bi qj">
                                                        <div class="tc sf rn tn un zf dp">
                                                            <div>
                                                                <p class="ek ik xj _p kc fb">
                                                                    {{ $comment->comment }}
                                                                </p>
                                                                <div class="tc yf vf">
                                                                    <div>
                                                                        <span
                                                                            class="rc ek xj kk wm zb">{{ $comment->user->name }}</span>
                                                                        <span
                                                                            class="rc">{{ $comment->user->email }}</span>
                                                                    </div>

                                                                </div>
                                                                <img class="rk" src="images/brand-light-02.svg')}}"
                                                                    alt="{{ $comment->created_at->diffForHumans() }}" />
                                                            </div>
                                                            @auth
                                                                @can('myComment', $comment)
                                                                    <form action="{{route('comment.delete', $comment->id)}}" method="post"
                                                                        onsubmit="return confirm('Rostdan bu izohni o‘chirilsinmi?');">
                                                                        @csrf
                                                                        <button type="submit">
                                                                            <span>Izohni o'chirish</span>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            @endauth
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ($LearningCenter->comments->count() > 1)
                                            <!-- If we need navigation -->
                                            <div class="tc wf xf fg jb">
                                                <div
                                                    class="swiper-button-prev c tc wf xf ie ld rg _g dh pf ml vr hh rm tl zm rl ym">
                                                    <svg class="th lm" width="14" height="14"
                                                        viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M3.52366 7.83336L7.99366 12.3034L6.81533 13.4817L0.333663 7.00002L6.81533 0.518357L7.99366 1.69669L3.52366 6.16669L13.667 6.16669L13.667 7.83336L3.52366 7.83336Z"
                                                            fill="" />
                                                    </svg>
                                                </div>
                                                <div
                                                    class="swiper-button-next c tc wf xf ie ld rg _g dh pf ml vr hh rm tl zm rl ym">
                                                    <svg class="th lm" width="14" height="14"
                                                        viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M10.4763 6.16664L6.00634 1.69664L7.18467 0.518311L13.6663 6.99998L7.18467 13.4816L6.00634 12.3033L10.4763 7.83331H0.333008V6.16664H10.4763Z"
                                                            fill="" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endauth

                        @guest

                            <h4 style="margin-top: 3rem">O'z fikringizni qoldirish uchun ro'yxatdan o'ting!</h4>
                            <div class="tc wf ig pb no animate_top" style="margin-top: 20px; text-align: center">
                                <a href="{{ route('signin') }}"
                                    :class="{ 'nk yl': page === 'home', 'ok': page === 'home' && stickyMenu }"
                                    class="ek pk xl">Sign In</a>
                                <a href="{{ route('signup') }}"
                                    :class="{ 'hh/[0.15]': page === 'home', 'sh': page === 'home' && stickyMenu }"
                                    class="lk gh dk rg tc wf xf _l gi hi">Sign Up</a>
                            </div>
                        @endguest

                    </div>
                    @auth
                        @can('isOun', $LearningCenter)
                            <div class="animate_right bf" style="margin-top: 10px">
                                <a style="border: 1px solid blue" href="{{ route('course.edit', $LearningCenter->id) }}"
                                    class="vc ek kk hh rg ol il cm gi hi"> {{ $LearningCenter->name }} markazini
                                    tahrirlash.</a>
                                <form id="delete-{{ $LearningCenter->id }}"
                                    onsubmit="return confirm('Rostdan ham {{ $LearningCenter->name }} markazini o‘chirilsinmi?');"
                                    action="{{ route('course.destroy', $LearningCenter->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: red; margin-top: 8px; border: 1px solid blue"
                                        class="vc ek kk hh rg ol il cm gi hi">
                                        {{ $LearningCenter->name }} markazini saytdan o'chirish.
                                    </button>
                                </form>
                            </div>
                        @endcan
                    @endauth
                </div>

                <div class="jn/2 so">
                    <div class="animate_top fb">
                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb gb">
                            {{ $LearningCenter->name }}
                        </h2>
                    </div>

                    <div class="animate_top fb">
                        <hr style="margin:16px 0;">

                        <h4 class="tj kk wm qb ta-c">
                            Fanlar</h4>

                        <ul
                            style="padding:0; margin:0; list-style:none; font-family:'Segoe UI', sans-serif; font-size:16px;">

                            @auth
                                @can('isOun', $LearningCenter)
                                    <li>
                                        <a href="{{ route('subject.create', 'id=' . $LearningCenter->id) }}"
                                            :class="{
                                                'hh/[0.15]': page === 'home',
                                                'sh': page === 'home' &&
                                                    stickyMenu
                                            }"
                                            class="lk gh dk rg tc wf xf _l gi hi">
                                            ➕
                                        </a>
                                    </li>
                                @endcan
                            @endauth

                            <hr style="margin:16px 0;">
                            @foreach ($LearningCenter->subjects as $subject)
                                <div class="tc uf zo ap zf bp" style="align-items: center">
                                    <div class="tc zo ap zf bp"
                                        style="display: flex; align-items: center; margin-bottom: 2rem">
                                        <!-- Small Features Item -->

                                        <div class="tc wf xf cf ae cd rg mh" style="width: 3rem; height: 3rem;">
                                            <img style="border-radius: 50%; width: 3rem; height: 3rem;"
                                                src="https://ui-avatars.com/api/?name={{ $subject->subject->name }}&background=random&size=64"
                                                alt="Icon" />
                                        </div>
                                        <div>
                                            <h4 class="ek yj go kk wm xb">{{ $subject->subject->name }}</h4>
                                            <p>{{ $subject->price }}</p>
                                        </div>
                                    </div>

                                    @auth
                                        @can('isOun', $LearningCenter)
                                            <form id="delete-{{ $subject->id }}"
                                                action="{{ route('subject.destroy', $subject->id) }}" method="post"
                                                onsubmit="return confirm('Rostdan ham {{ $subject->subject->name }}ni o‘chirilsinmi?');"
                                                style="margin-left:10px;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="font-size: 1rem">❌</button>
                                            </form>
                                        @endcan
                                    @endauth
                                </div>
                            @endforeach

                            <hr>
                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ===== Blog Single End ===== -->


</x-layout>


<style>
    .favorite1 {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
        margin-bottom: 20px
    }

    .favorite1 .stars1 {
        display: flex;
        justify-content: center;
        gap: 5px;
        font-size: 40px;
        cursor: pointer;
        position: relative;
    }

    .favorite1 .star1 {
        color: #ddd;
        transition: color 0.2s ease;
        user-select: none;
        position: relative;
    }

    .favorite1 .star1.full {
        color: #ffc107;
    }

    .favorite1 .star1.half {
        background: linear-gradient(90deg, #ffc107 50%, #ddd 50%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .favorite1 .result1 {
        font-size: 26px;
        color: #667eea;
        font-weight: bold;
        min-height: 30px;
    }

    /* favorites */
    .favorite {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        margin-top: 20px
    }

    .favorite .rating-label {
        color: #666;
        font-size: 24px;
    }

    .favorite .stars {
        display: flex;
        justify-content: center;
        gap: 10px;
        font-size: 40px;
        cursor: pointer;
    }

    .favorite .star {
        color: #ddd;
        transition: all 0.2s ease;
        user-select: none;
    }

    .favorite .star:hover,
    .favorite .star.hover {
        color: #ffc107;
        transform: scale(1.2);
    }

    .favorite .star.active {
        color: #ffc107;
    }

    .favorite .result {
        font-size: 18px;
        color: #667eea;
        font-weight: bold;
        min-height: 30px;
    }
</style>

<script>
    const ratings = {};

    function initRating(ratingId, resultId) {
        const starsContainer = document.getElementById(ratingId);
        const stars = starsContainer.querySelectorAll('.star');

        stars.forEach(star => {
            star.addEventListener('mouseenter', () => {
                const value = star.dataset.value;
                highlightStars(stars, value);
            });

            star.addEventListener('click', () => {
                const value = star.dataset.value;
                const centerId = starsContainer.dataset.centerId;
                ratings[ratingId] = value;

                // Yulduzlarni yangilash
                stars.forEach(s => {
                    if (s.dataset.value <= value) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });

                updateResult(resultId, value);

                // POST so‘rov yuborish
                sendRating(centerId, value);
            });
        });

        starsContainer.addEventListener('mouseleave', () => {
            const savedRating = ratings[ratingId];
            if (savedRating) {
                highlightStars(stars, savedRating);
            } else {
                stars.forEach(s => s.classList.remove('hover'));
            }
        });
    }

    function highlightStars(stars, value) {
        stars.forEach(star => {
            if (star.dataset.value <= value) {
                star.classList.add('hover');
            } else {
                star.classList.remove('hover');
            }
        });
    }

    function updateResult(resultId, value) {
        const resultEl = document.getElementById(resultId);
        const ratings_text = ['Juda yomon', 'Yomon', "O'rtacha", 'Yaxshi', 'Ajoyib'];
        resultEl.textContent = `${value} ⭐ - ${ratings_text[value - 1]}`;
    }

    // Reytingni serverga yuboruvchi funksiya
    function sendRating(centerId, value) {
        fetch('/comment/favoriteStore', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // Laravelga JSON kutayotganimizni aytadi
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    rating: value,
                    learning_centers_id: centerId
                })
            })
            .then(async response => {
                const text = await response.text(); // avval text oling
                console.log('Raw response text:', text);

                try {
                    const data = JSON.parse(text); // keyin JSON.parse
                    if (!response.ok) {
                        // server 4xx/5xx kod qaytargan bo'lishi mumkin
                        console.error('Server returned error:', data);
                    } else {
                        console.log('Reyting yuborildi:', data);
                    }
                } catch (err) {
                    // Agar JSON.parse xato bersa — text ichida nimadir noto'g'ri
                    console.error('JSON.parse xatosi — server noto\'g\'ri javob yubordi:', err);
                    console.error('Server returned raw text:', text);
                }
            })
            .catch(error => {
                console.error('Fetch xatosi:', error);
            });
    }


    initRating('rating1', 'result1');
</script>
