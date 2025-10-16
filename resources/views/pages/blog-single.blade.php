<x-layout>


    <x-slot:title>

        Blog Single - FindCourse

    </x-slot>

    <!-- ===== Blog Single Start ===== -->
    <section class="gj qp gr hj rp hr">
        <div class="bb ze ki xn 2xl:ud-px-0">
            <div class="tc sf yo zf kq">
                <div class="ro">
                    <div
                        class="animate_top rounded-md shadow-solid-13 bg-white dark:bg-blacksection border border-stroke dark:border-strokedark p-7.5 md:p-10">
                        <a href="{{ $LearningCenter->logo }}" data-fslightbox class="vc wf hg mb">
                            <img style="width: 100%" src="{{ $LearningCenter->logo }}" alt="Blog" />
                        </a>

                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb gb">
                            {{ $LearningCenter->name }}
                        </h2>

                        <ul class="tc uf cg 2xl:ud-gap-15 fb">
                            <li><span class="rc kk wm">Saytga kiritgan shaxs:
                                </span> <a
                                    href="mailto:{{ $LearningCenter->user->email }}">{{ $LearningCenter->user->name }}</a>
                            </li>
                            <li><span class="rc kk wm">Yulangan sana: </span>
                                {{ $LearningCenter->created_at->diffForHumans() }} </li>
                            <li><span class="rc kk wm"> Tur:
                                </span> {{ $LearningCenter->type }}</li>
                            <li><span class="rc kk wm"> Manzil:
                                </span> <a target="_blank" style="color: cornflowerblue"
                                    href="{{ $LearningCenter->location }}">{{ $LearningCenter->address }}</a>
                            </li>
                            <li
                                style="background:linear-gradient(to right, #e3f2fd, #bbdefb); padding:16px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); margin-bottom:12px; list-style:none; font-family:'Segoe UI', sans-serif; font-size:16px; color:#1a237e;">
                                @if ($LearningCenter->needTeachers->count() > 0)
                                    <span
                                        style="font-weight:600; font-size:18px; color:#0d47a1; display:block; margin-bottom:8px;">📢
                                        Elonlar:</span>
                                    <span style="display:block; margin-bottom:6px;">🧑‍🏫 O'qituvchi kerak:</span>
                                    @foreach ($LearningCenter->needTeachers as $needTeacher)
                                        <a href="{{ route('teacher.announcement', $LearningCenter->id) }}"
                                            style="display:inline-block; margin:4px 6px 4px 0; padding:6px 12px; background-color:#e8f0fe; color:#1565c0; border-radius:6px; text-decoration:none; font-weight:500; transition:background-color 0.3s ease;"
                                            onmouseover="this.style.backgroundColor='#d0e3fc'"
                                            onmouseout="this.style.backgroundColor='#e8f0fe'">
                                            {{ $needTeacher->subject->name }}
                                        </a>
                                    @endforeach
                                @else
                                    <span
                                        style="font-weight:600; font-size:18px; color:#0d47a1; display:block; margin-bottom:8px;">📢
                                        Elonlar:</span>
                                    <span style="display:block; margin-bottom:6px;">Hozircha elonlar yo'q</span>
                                @endif
                            </li>


                        </ul>

                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb gb">
                            {{ $LearningCenter->name }} haqida qisqacha malumot:
                        </h2>

                        <p class="ob">
                            {{ $LearningCenter->about }}
                        </p>

                        <div class="wc qf pn dg cb">
                            @foreach ($LearningCenter->images as $image)
                                <a href="{{ $image->image }}" data-fslightbox class="vc wf hg mb">
                                    <img style="width: 100%" src="{{ $image->image }}" alt="Blog" />
                                </a>
                            @endforeach
                        </div>

                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb qb">
                            {{ $LearningCenter->name }} kun tartibi.
                        </h2>

                        <div
                            style="width:100%; overflow-x:auto; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.1); margin-top:20px;">
                            <table
                                style="min-width:600px; width:100%; border-collapse:collapse; font-family:'Segoe UI', sans-serif; font-size:15px; text-align:center;">
                                <thead style="background:linear-gradient(to right, #e0f7fa, #b2ebf2); color:#004d40;">
                                    <tr>
                                        <th style="padding:12px; border:1px solid #ccc;">#</th>
                                        <th style="padding:12px; border:1px solid #ccc;">Dushanba</th>
                                        <th style="padding:12px; border:1px solid #ccc;">Seshanba</th>
                                        <th style="padding:12px; border:1px solid #ccc;">Chorshanba</th>
                                        <th style="padding:12px; border:1px solid #ccc;">Payshanba</th>
                                        <th style="padding:12px; border:1px solid #ccc;">Juma</th>
                                        <th style="padding:12px; border:1px solid #ccc;">Shanba</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="background-color:#fff;"
                                        onmouseover="this.style.backgroundColor='#f1f8e9'"
                                        onmouseout="this.style.backgroundColor='#fff'">
                                        <td
                                            style="padding:10px; border:1px solid #ddd; font-weight:bold; color:#00796b;">
                                            Ochilishi</td>
                                        @foreach ($LearningCenter->calendar as $calendar)
                                            <td style="padding:10px; border:1px solid #ddd; color:#333;">
                                                {{ \Carbon\Carbon::parse($calendar->open_time)->format('H:i') }}</td>
                                        @endforeach
                                    </tr>
                                    <tr style="background-color:#fff;"
                                        onmouseover="this.style.backgroundColor='#f1f8e9'"
                                        onmouseout="this.style.backgroundColor='#fff'">
                                        <td
                                            style="padding:10px; border:1px solid #ddd; font-weight:bold; color:#d32f2f;">
                                            Yopilishi</td>
                                        @foreach ($LearningCenter->calendar as $calendar)
                                            <td style="padding:10px; border:1px solid #ddd; color:#333;">
                                                {{ \Carbon\Carbon::parse($calendar->close_time)->format('H:i') }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>



                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb qb">
                            {{ $LearningCenter->name }} bilan bog'lanish.
                        </h2>

                        <ul class="tc wf bg sb">
                            <li>
                                <p class="sj kk wm tb">Ijtimoiy tarmoqlar:</p>
                            </li>

                            @foreach ($LearningCenter->connections as $connection)
                                <ul style="text-align: center">
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


                    </div>
                    {{-- <form id="update-{{ $LearningCenter->id }}"
                        onsubmit="return confirm('Rostdan ham {{ $LearningCenter->name }} malumotlarini yangilamoqchimisiz?');"
                        action="{{ route('course.update', $LearningCenter->id) }}" method="post"
                        style="margin-top: 20px;" class="animate_right bf">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: green" class="vc ek kk hh rg ol il cm gi hi">
                            {{ $LearningCenter->name }} malumotlarini yangilash.
                        </button>
                    </form> --}}
                    @auth
                        @if (Auth::user()->id == $LearningCenter->user->id)
                            <form id="delete-{{ $LearningCenter->id }}"
                                onsubmit="return confirm('Rostdan ham {{ $LearningCenter->name }} markazini o‘chirilsinmi?');"
                                action="{{ route('course.destroy', $LearningCenter->id) }}" method="post"
                                style="margin-top: 20px; color: red" class="animate_right bf">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red" class="vc ek kk hh rg ol il cm gi hi">
                                    {{ $LearningCenter->name }} markazini saytdan o'chirish.
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

                <div class="jn/2 so">
                    <div class="animate_top fb">
                        <h2 class="ek vj 2xl:ud-text-title-lg kk wm nb gb">
                            {{ $LearningCenter->name }}
                        </h2>
                    </div>

                    <div class="animate_top fb">
                        <h4 class="tj kk wm qb ta-c">
                            Fanlar</h4>

                        <ul
                            style="padding:0; margin:0; list-style:none; font-family:'Segoe UI', sans-serif; font-size:16px;">

                            @auth
                                @if (Auth::user()->id == $LearningCenter->user->id)
                                    <li
                                        style="margin-bottom:16px; padding:12px 16px; background-color:#e3f2fd; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); text-align:center;">
                                        <a href="{{ route('subject.create', 'id=' . $LearningCenter->id) }}"
                                            style="text-decoration:none; color:#1565c0; font-weight:600;">➕ Fan
                                            qo'shish</a>
                                    </li>
                                @endif
                            @endauth

                            @foreach ($LearningCenter->subjects as $subject)
                                <hr style="border:none; border-top:1px solid #ddd; margin:12px 0;">
                                <li
                                    style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; padding:12px 16px; background-color:#f9f9f9; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.05); margin-bottom:8px;">
                                    <a href="#!" style="text-decoration:none; color:#2c3e50; font-weight:500;">
                                        📘 {{ $subject->subject->name }} — {{ $subject->price }} so'm
                                    </a>

                                    @auth
                                        @if (Auth::user()->id == $LearningCenter->user->id)
                                            <form id="delete-{{ $subject->id }}"
                                                action="{{ route('subject.destroy', $subject->id) }}" method="post"
                                                onsubmit="return confirm('Rostdan ham {{ $subject->subject->name }}ni o‘chirilsinmi?');"
                                                style="margin-left:10px;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="background:none; border:none; cursor:pointer;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                                        viewBox="0 0 100 100">
                                                        <path fill="#f37e98"
                                                            d="M25,30l3.645,47.383C28.845,79.988,31.017,82,33.63,82h32.74c2.613,0,4.785-2.012,4.985-4.617L75,30">
                                                        </path>
                                                        <path fill="#f15b6c"
                                                            d="M77 24h-4l-1.835-3.058C70.442 19.737 69.14 19 67.735 19h-35.47c-1.405 0-2.707.737-3.43 1.942L27 24h-4c-1.657 0-3 1.343-3 3s1.343 3 3 3h54c1.657 0 3-1.343 3-3S78.657 24 77 24z">
                                                        </path>
                                                        <path fill="#1f212b"
                                                            d="M66.37 83H33.63c-3.116 0-5.744-2.434-5.982-5.54l-3.645-47.383 1.994-.154 3.645 47.384C29.801 79.378 31.553 81 33.63 81H66.37c2.077 0 3.829-1.622 3.988-3.692l3.645-47.385 1.994.154-3.645 47.384C72.113 80.566 69.485 83 66.37 83z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </li>
                            @endforeach

                            <hr style="border:none; border-top:1px solid #ddd; margin:16px 0;">
                        </ul>

                    </div>

                    <div class="animate_top">
                        <h4 class="tj kk wm qb ta-c">Ustozlar</h4>

                        <div style="max-width:900px; margin:0 auto; padding:20px; font-family:'Segoe UI', sans-serif;">

                            @auth
                                @if (Auth::user()->id == $LearningCenter->user->id)
                                    <div
                                        style="display:flex; flex-wrap:wrap; gap:12px; justify-content:center; margin-bottom:20px;">
                                        <h6 style="font-size:16px; font-weight:600;">
                                            <a href="{{ route('teacher.create', 'id=' . $LearningCenter->id) }}"
                                                style="text-decoration:none; color:#1565c0; background-color:#e3f2fd; padding:8px 16px; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1); display:inline-block;">
                                                ➕ Ustoz qo'shish
                                            </a>
                                        </h6>
                                        <h6 style="font-size:16px; font-weight:600;">
                                            <a href="{{ route('teacher.announcement', $LearningCenter->id) }}"
                                                style="text-decoration:none; color:#2e7d32; background-color:#c8e6c9; padding:8px 16px; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1); display:inline-block;">
                                                📣 Ustoz kerak
                                            </a>
                                        </h6>
                                    </div>
                                @endif
                            @endauth

                            @foreach ($LearningCenter->teachers as $teacher)
                                <div
                                    style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; background-color:#f9f9f9; border-radius:10px; padding:12px 16px; margin-bottom:12px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">

                                    <div style="display:flex; align-items:center; gap:12px;">
                                        @if (isset($teacher->photo))
                                            <img src="{{ $teacher->photo }}" alt="Teacher"
                                                style="border-radius:50%; width:50px; height:50px; border:3px solid #4f46e5;" />
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ $teacher->name }}&background=random&size=64"
                                                alt="Avatar"
                                                style="border-radius:50%; width:50px; height:50px; border:3px solid #4f46e5;" />
                                        @endif

                                        <h5 style="margin:0; font-size:16px; font-weight:500; color:#2c3e50;">
                                            <a href="#!" style="text-decoration:none; color:inherit;">
                                                {{ $teacher->name }} — {{ $teacher->subject->name }}
                                            </a>
                                        </h5>
                                    </div>

                                    @auth
                                        @if (Auth::user()->id == $LearningCenter->user->id)
                                            <form id="delete-{{ $teacher->id }}"
                                                action="{{ route('teacher.destroy', $teacher->id) }}" method="post"
                                                onsubmit="return confirm('Rostdan ham {{ $teacher->name }}ni o‘chirilsinmi?');"
                                                style="margin-left:10px;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="background:none; border:none; cursor:pointer;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                                        viewBox="0 0 100 100">
                                                        <path fill="#f37e98"
                                                            d="M25,30l3.645,47.383C28.845,79.988,31.017,82,33.63,82h32.74c2.613,0,4.785-2.012,4.985-4.617L75,30">
                                                        </path>
                                                        <path fill="#f15b6c"
                                                            d="M77 24h-4l-1.835-3.058C70.442 19.737 69.14 19 67.735 19h-35.47c-1.405 0-2.707.737-3.43 1.942L27 24h-4c-1.657 0-3 1.343-3 3s1.343 3 3 3h54c1.657 0 3-1.343 3-3S78.657 24 77 24z">
                                                        </path>
                                                        <path fill="#1f212b"
                                                            d="M66.37 83H33.63c-3.116 0-5.744-2.434-5.982-5.54l-3.645-47.383 1.994-.154 3.645 47.384C29.801 79.378 31.553 81 33.63 81H66.37c2.077 0 3.829-1.622 3.988-3.692l3.645-47.385 1.994.154-3.645 47.384C72.113 80.566 69.485 83 66.37 83z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            @endforeach

                        </div>

                    </div>

                    <div class="animate_top"
                        style="z-index:1; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); background-color:#f9f9f9; max-width:900px; margin:0 auto;">
                        <h4
                            style="font-size:22px; font-weight:600; color:#2c3e50; margin-bottom:16px; text-align:center;">
                            Joylashuv</h4>

                        <div
                            style="position:relative; width:100%; height:0; padding-bottom:56.25%; border-radius:10px; overflow:hidden;">
                            <iframe
                                src="https://www.google.com/maps?q={{ $LearningCenter->location }}&hl=uz&z=14&output=embed"
                                style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;"
                                allowfullscreen loading="lazy">
                            </iframe>
                        </div>
                    </div>




                    <div id="comment" class="animate_top">

                        <style>
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
                                        <path d="M2.01 21L23 12L2.01 3L2 10L17 12L2 14L2.01 21Z" fill="currentColor" />
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
                                            <svg class="th lm" width="14" height="14" viewBox="0 0 14 14"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3.52366 7.83336L7.99366 12.3034L6.81533 13.4817L0.333663 7.00002L6.81533 0.518357L7.99366 1.69669L3.52366 6.16669L13.667 6.16669L13.667 7.83336L3.52366 7.83336Z"
                                                    fill="" />
                                            </svg>
                                        </div>
                                        <div
                                            class="swiper-button-next c tc wf xf ie ld rg _g dh pf ml vr hh rm tl zm rl ym">
                                            <svg class="th lm" width="14" height="14" viewBox="0 0 14 14"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
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

                    @guest
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
            </div>
        </div>
    </section>
    <!-- ===== Blog Single End ===== -->


</x-layout>
