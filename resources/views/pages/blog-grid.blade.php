<x-layout>
    <x-slot:title>
        Barcha o'quv markazlar
    </x-slot>

    <!-- ===== Blog Grid Start ===== -->
    <section class="ji gp uq">
        <div class="bb ye ki xn vq jb jo">
            <div class="animate_top">
                <form action="{{ route('blog-grid') }}" method="get">
                    <div class="i">
                        @foreach ($validated as $item)
                            <input type="hidden" type="text" name="{{ $item }}" placeholder="Search Here..."
                                value="{{ $item ?? '' }}" />
                        @endforeach
                        <input type="text" name="searchText" placeholder="Search Here..."
                            value="{{ $validated['searchText'] ?? '' }}"
                            class="vd sm _g ch pm vk xm rg gm dm/40 dn/40 li mi" />
                        <button type="submit" class="h r q _h">
                            <svg class="th ul ml il" width="21" height="21" viewBox="0 0 21 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.031 14.617L20.314 18.899L18.899 20.314L14.617 16.031C13.0237 17.3082 11.042 18.0029 9 18C4.032 18 0 13.968 0 9C0 4.032 4.032 0 9 0C13.968 0 18 4.032 18 9C18.0029 11.042 17.3082 13.0237 16.031 14.617ZM14.025 13.875C15.2941 12.5699 16.0029 10.8204 16 9C16 5.132 12.867 2 9 2C5.132 2 2 5.132 2 9C2 12.867 5.132 16 9 16C10.8204 16.0029 12.5699 15.2941 13.875 14.025L14.025 13.875Z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="wc qf zf iq" style="z-index: 1">
                <div class="animate_top tc sf yo ap zf ep" style="z-index: 100">
                    <ul class="nav-links">
                        <li class="c i nav-links-li"><a href="{{ route('blog-grid') }}">Barchasi</a> </li>
                        <li class="c i nav-links-li" id="toggle-map" style="cursor: pointer;">Xarita</li>
                        <li class="c i dropdown-container" x-data="{ dropdown: false }" style="width: auto !important">
                            <a href="#!" class="xl tc wf bg" @click.prevent="dropdown = !dropdown"
                                :class="{
                                    'mk': page === 'index' || page === 'index'
                                }">
                                Saralash
                                <svg :class="{ 'wh': dropdown }" class="th mm we fd pf"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                </svg>
                            </a>

                            <ul class="a dropdown-menu" :class="{ 'tc': dropdown }">
                                <li>
                                    @if (!isset($validated['name']))
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}"
                                            class="xl">Nomi ↑↓</a>
                                    @elseif ($validated['name'] == 'asc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'desc']) }}"
                                            class="xl">Nomi ↑</a>
                                    @elseif ($validated['name'] == 'desc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}"
                                            class="xl">Nomi ↓</a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}"
                                            class="xl">Nomi ↑↓</a>
                                    @endif
                                </li>
                                <li>
                                    @if (!isset($validated['distance']))
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}"
                                            class="xl">Masofasi ↑↓</a>
                                    @elseif ($validated['distance'] == 'asc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'desc']) }}"
                                            class="xl">Masofasi ↑</a>
                                    @elseif ($validated['distance'] == 'desc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}"
                                            class="xl">Masofasi ↓</a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}"
                                            class="xl">Masofasi ↑↓</a>
                                    @endif
                                </li>
                                <li>
                                    @if (!isset($validated['favorites']))
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}"
                                            class="xl">Reytingi ↑↓</a>
                                    @elseif ($validated['favorites'] == 'asc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'desc']) }}"
                                            class="xl">Reytingi ↑</a>
                                    @elseif ($validated['favorites'] == 'desc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}"
                                            class="xl">Reytingi ↓</a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}"
                                            class="xl">Reytingi ↑↓</a>
                                    @endif
                                </li>
                            </ul>
                        </li>
                        <li class="c i dropdown-container" x-data="{ dropdown: false }">
                            <a href="#!" class="xl tc wf yf bg" @click.prevent="dropdown = !dropdown"
                                :class="{
                                    'mk': page === 'index' || page === 'index'
                                }">
                                O'qituvchi e'lonlari
                                <svg :class="{ 'wh': dropdown }" class="th mm we fd pf"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                </svg>
                            </a>

                            <!-- Dropdown Start -->
                            <ul class="a dropdown-menu" :class="{ 'tc': dropdown }">
                                @foreach ($subjects as $subject)
                                    <li>
                                        <a href="{{ request()->fullUrlWithQuery(['needTeachers' => $subject->id]) }}"
                                            class="xl">{{ $subject->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- Dropdown End -->
                        </li>
                    </ul>
                </div>

                <div id="map-container">
                    <button class="toggle-btn" id="toggle-map">Xaritani Yopish/Ochish</button>

                    <div id="map"></div>

                    <div class="search-box">
                        <input type="text" class="search-input" placeholder="O'quv markazini qidiring..."
                            id="searchInput">
                        <div class="search-results" id="searchResults"></div>
                    </div>

                    <form class="map-form" action="{{ route('blog-grid') }}" method="get">
                        <input type="text" id="address" name="address" placeholder="Manzil" readonly>
                        <input type="hidden" id="location" name="location">
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">

                        <select class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" name="subject_id"
                            id="subject">
                            <option value="" disabled {{ isset($validated['sunject_id']) ? '' : 'selected' }}>
                                Fanni tanlang...</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ isset($validated['sunject_id']) ? ($subject->id == $validated['sunject_id'] ? 'selected' : '') : '' }}>
                                    {{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="radius" id="radius" placeholder="Radius (km)"
                            min="1" max="10000">
                        <input type="number" name="maxPrice" id="maxPrice" placeholder="Maksimal narx (so'm)"
                            min="0">

                        <button type="submit">Qidirish</button>
                    </form>

                    <button class="locate-btn" id="locateBtn" title="Joyimni top">📍</button>
                </div>
            </div>

            <div style="margin-bottom: 10px;" class="wc qf zf iq" style="z-index: 1">
                <div class="animate_top sg vk rm xm" style="z-index: 1; text-align: center;">
                    <p>{{ $LearningCenters->count() }} ta o'quv markaz topildi</p>
                </div>
            </div>

            <div class="wc qf pn xo zf iq learning-centers-grid">
                <!-- Blog Item -->
                @foreach ($LearningCenters as $LearningCenter)
                    <div loading="lezi" class="animate_top sg vk rm xm snake-border learning-center-card">
                        <div class="c rc i z-1 pg">
                            <img class="standard-img lazy-img" src="{{ asset('storage/' . $LearningCenter->logo) }}"
                                alt="Blog" />

                            <div class="im h r s df vd yc wg tc wf xf al hh/20 nl il z-10">
                                <a href="{{ route('blog-single', $LearningCenter->id) }}"
                                    class="vc ek rg lk gh sl ml il gi hi">Ko'proq o'qish</a>
                            </div>
                        </div>

                        <div class="yh">
                            <div class="tc uf wf ag jq card-meta">
                                <div class="tc wf ag meta-item">
                                    <p>{{ $LearningCenter->region . ', ' . $LearningCenter->province }}</p>
                                </div>
                                <div class="tc wf ag meta-item">
                                    <img src="{{ asset('/images/Calendar.jpg') }}" alt="Calender" />
                                    <p>{{ $LearningCenter->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="tc wf ag meta-item">
                                    @if (isset($LearningCenter->distance))
                                        <p>{{ $LearningCenter->distance }} km</p>
                                    @else
                                        <p>Masofani bilish uchun xaritadan joyni tanlang!</p>
                                    @endif
                                </div>
                            </div>

                            @php
                                $average = round($LearningCenter->favorites()->avg('rating') ?? 0, 1);
                            @endphp

                            <h4 class="favorite">
                                <div class="stars" id="rating1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $diff = $average - $i;
                                        @endphp
                                        <span
                                            class="star {{ $average >= $i ? 'full' : ($diff > -1 && $diff < 0 ? 'half' : '') }}">
                                            ★
                                        </span>
                                    @endfor
                                </div>
                                <div style="margin-top: 7px; font-size: 26px" class="result">{{ $average }}
                                </div>
                            </h4>

                            <h4 class="ek tj ml il kk wm xl eq lb">
                                <a href="{{ route('blog-single', $LearningCenter->id) }}">
                                    {{ $LearningCenter->name }}
                                </a>
                            </h4>
                            <div class="bb ze mb">
                                <!-- Service Item -->
                                <div class="animate_top" style="width: 100%">
                                    <div class="_b announcement-header">
                                        <img style="width: 2rem; margin-right: 2rem; height: 2rem;"
                                            src="{{ asset('/images/Announcement.jpg') }}" alt="Icon" />
                                        <h4 class="ek zj kk wm">E'lon</h4>
                                    </div>

                                    @if ($LearningCenter->needTeachers->count() > 0)
                                        <h4 class="ek kk wm">O'qituvchi kerak</h4>
                                        @foreach ($LearningCenter->needTeachers as $teacher)
                                            <p>🟢 {{ $teacher->subject->name }}</p>
                                            <p style="color: brown; text-align: end">🔥
                                                {{ $teacher->created_at->diffForHumans() }}</p>
                                        @endforeach
                                    @else
                                        <p>Hozicha elon berilmagan!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ===== Blog Grid End ===== -->
</x-layout>

<style>
    /* Base styles remain the same */
    .favorite {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 15px;
    }

    .favorite .stars {
        display: flex;
        justify-content: center;
        gap: 5px;
        font-size: 40px;
        cursor: pointer;
        position: relative;
    }

    .favorite .star {
        color: #ddd;
        transition: color 0.2s ease;
        user-select: none;
        position: relative;
    }

    .favorite .star.full {
        color: #ffc107;
    }

    .favorite .star.half {
        background: linear-gradient(90deg, #ffc107 50%, #ddd 50%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .favorite .result {
        font-size: 18px;
        color: #667eea;
        font-weight: bold;
        min-height: 30px;
    }

    .standard-img {
        aspect-ratio: 4 / 3;
        object-fit: cover;
        width: 100%;
        height: auto;
    }

    /* Navigation Links - Responsive */
    .nav-links {
        display: flex;
        gap: 20px;
        margin-top: 10px;
        list-style: none;
        padding: 0;
        flex-wrap: wrap;
        align-items: center;
    }

    .nav-links-li:hover {
        color: blue;
    }

    /* Map Container - Responsive */
    #map-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
        position: relative;
    }

    #map-container.active {
        max-height: 700px;
        margin-top: 10px;
    }

    #map {
        width: 100%;
        height: 400px;
        border-radius: 10px;
    }

    /* Map Form - Desktop */
    .map-form {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        width: 320px;
        z-index: 1000;
        max-height: 90vh;
        overflow-y: auto;
    }

    .map-form input,
    .map-form select,
    .map-form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .map-form button {
        background-color: #4285f4;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: 500;
    }

    .map-form button:hover {
        background-color: #3367d6;
    }

    /* Search Box - Responsive */
    .search-box {
        position: absolute;
        top: 10px;
        left: 10px;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        width: 300px;
        z-index: 1000;
        max-width: calc(100vw - 360px);
    }

    .search-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .search-results {
        max-height: 250px;
        overflow-y: auto;
        margin-top: 8px;
        display: none;
        background: white;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .result-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }

    .result-item:hover {
        background: #f5f5f5;
    }

    /* Locate Button */
    .locate-btn {
        position: absolute;
        right: 10px;
        bottom: 10px;
        background: white;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        z-index: 1000;
    }

    .locate-btn:hover {
        background: #f5f5f5;
    }

    /* Toggle Button */
    .toggle-btn {
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        z-index: 1001;
        font-weight: 500;
        border: none;
        font-size: 14px;
    }

    /* Learning Centers Grid - Responsive */
    .learning-centers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .learning-center-card {
        width: 100%;
        max-width: none;
    }

    /* Card Meta - Responsive */
    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Announcement Header */
    .announcement-header {
        display: flex;
        flex-direction: row;
        align-content: center;
        align-items: center;
    }

    /* Dropdown Menus - Responsive */
    .dropdown-container {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        min-width: 200px;
        z-index: 1000;
    }

    /* Info Window Content */
    .info-content {
        padding: 10px;
        max-width: 250px;
    }

    .info-content img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .info-title {
        margin: 0 0 5px 0;
        font-size: 16px;
        font-weight: bold;
    }

    .info-distance {
        margin: 0 0 5px 0;
        font-size: 13px;
        color: #1976d2;
        font-weight: 500;
    }

    .info-address {
        margin: 0 0 10px 0;
        font-size: 12px;
        color: #666;
    }

    .info-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #4285f4;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        margin-right: 5px;
    }

    .info-btn:hover {
        background-color: #3367d6;
    }

    /* Scrollbar styling */
    .search-results::-webkit-scrollbar,
    .map-form::-webkit-scrollbar {
        width: 6px;
    }

    .search-results::-webkit-scrollbar-thumb,
    .map-form::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    /* MOBILE RESPONSIVE STYLES */
    @media (max-width: 768px) {

        /* Navigation */
        .nav-links {
            overflow-x: auto;
            white-space: nowrap;
            gap: 15px;
            padding-bottom: 10px;
        }

        .nav-links li {
            flex-shrink: 0;
        }

        /* Map Container Mobile */
        #map-container.active {
            max-height: 80vh;
        }

        #map {
            height: 300px;
        }

        /* Map Form Mobile */
        .map-form {
            position: relative;
            top: 0;
            right: 0;
            left: 0;
            width: 100%;
            max-width: none;
            margin: 10px 0;
            box-sizing: border-box;
        }

        /* Search Box Mobile */
        .search-box {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            max-width: none;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        /* Toggle Button Mobile */
        .toggle-btn {
            position: relative;
            top: 0;
            left: 0;
            transform: none;
            width: 100%;
            margin-bottom: 10px;
        }

        /* Locate Button Mobile */
        .locate-btn {
            right: 15px;
            bottom: 15px;
            width: 50px;
            height: 50px;
            font-size: 22px;
        }

        /* Learning Centers Grid Mobile */
        .learning-centers-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        /* Card Meta Mobile */
        .card-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .meta-item {
            width: 100%;
            justify-content: flex-start;
        }

        .meta-item p {
            font-size: 14px;
        }

        /* Stars Mobile */
        .favorite {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .favorite .stars {
            font-size: 32px;
            gap: 3px;
        }

        .favorite .result {
            font-size: 20px;
        }

        /* Dropdown Mobile */
        .dropdown-menu {
            position: fixed;
            top: auto;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            max-height: 50vh;
            overflow-y: auto;
            border-radius: 8px 8px 0 0;
        }

        /* Announcement Header Mobile */
        .announcement-header {
            flex-direction: row;
            align-items: center;
        }

        .announcement-header img {
            width: 1.5rem !important;
            height: 1.5rem !important;
            margin-right: 1rem !important;
        }
    }

    /* TABLET RESPONSIVE STYLES */
    @media (max-width: 1024px) and (min-width: 769px) {

        /* Learning Centers Grid Tablet */
        .learning-centers-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        /* Map Form Tablet */
        .map-form {
            width: 280px;
        }

        /* Search Box Tablet */
        .search-box {
            width: 250px;
            max-width: calc(100vw - 320px);
        }

        /* Navigation Tablet */
        .nav-links {
            gap: 18px;
        }
    }

    /* LARGE DESKTOP STYLES */
    @media (min-width: 1200px) {
        .learning-centers-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .map-form {
            width: 350px;
        }

        .search-box {
            width: 320px;
        }
    }

    /* EXTRA LARGE DESKTOP STYLES */
    @media (min-width: 1400px) {
        .learning-centers-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* SMALL MOBILE STYLES */
    @media (max-width: 480px) {
        .nav-links {
            gap: 10px;
            font-size: 14px;
        }

        .favorite .stars {
            font-size: 28px;
        }

        .favorite .result {
            font-size: 18px;
        }

        .meta-item p {
            font-size: 13px;
        }

        #map {
            height: 250px;
        }

        .map-form {
            padding: 10px;
        }

        .search-box {
            padding: 8px;
        }
    }
</style>

<script>
    // Demo data - Laravel blade'dan keladi
    // Backend'da:
    const learningCentersData = {!! json_encode(
        $LearningCenters->map(function ($center) {
            $location = explode(',', $center->location);
            return [
                'id' => $center->id,
                'name' => $center->name,
                'latitude' => (float) ($location[0] ?? 0),
                'longitude' => (float) ($location[1] ?? 0),
                'address' => $center->address ?? '',
                'logo' => $center->logo ?? '',
                'distance' => 0,
            ];
        }),
    ) !!};

    let map, geocoder, userMarker;
    const markers = [];
    const defaultLat = 41.2995;
    const defaultLng = 69.2401;

    // Toggle map visibility
    document.getElementById('toggle-map').addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('map-container');
        container.classList.toggle('active');

        // Trigger map resize after container is visible
        if (container.classList.contains('active')) {
            setTimeout(() => {
                if (map) {
                    google.maps.event.trigger(map, 'resize');
                }
            }, 500);
        }
    });

    // Initialize map
    function initMap() {
        const defaultCenter = {
            lat: defaultLat,
            lng: defaultLng
        };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
            gestureHandling: 'greedy',
            disableDefaultUI: false,
            zoomControl: true,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true
        });

        geocoder = new google.maps.Geocoder();

        // User marker
        userMarker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                scaledSize: new google.maps.Size(40, 40)
            },
            title: "Sizning joylashuvingiz",
            optimized: true
        });

        // Add learning centers
        addLearningCenters();

        // Setup events
        setupEventListeners();

        // Get user location
        getUserLocation();
    }

    // Add learning centers to map
    function addLearningCenters() {
        learningCentersData.forEach(center => {
            if (!center.latitude || !center.longitude) return;

            const position = {
                lat: parseFloat(center.latitude),
                lng: parseFloat(center.longitude)
            };

            const marker = new google.maps.Marker({
                map: map,
                position: position,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    scaledSize: new google.maps.Size(32, 32)
                },
                title: center.name,
                optimized: true
            });

            const infoWindow = new google.maps.InfoWindow({
                content: createInfoContent(center)
            });

            marker.addListener("click", () => {
                closeAllInfoWindows();
                infoWindow.open(map, marker);
                updateDistance(center, userMarker.getPosition());
            });

            markers.push({
                marker,
                infoWindow,
                center
            });
        });
    }

    // Create info window content
    function createInfoContent(center) {
        return `
            <div class="info-content">
                <h3 class="info-title">${center.name}</h3>
                <p class="info-distance">📍 Masofa: <span id="dist-${center.id}">Hisoblanmoqda...</span></p>
                <p class="info-address">${center.address || 'Manzil ko\'rsatilmagan'}</p>
                <a href="/blog-single/${center.id}" class="info-btn">Batafsil</a>
                <a href="https://www.google.com/maps/dir/?api=1&destination=${center.latitude},${center.longitude}" 
                   class="info-btn" target="_blank">Yo'nalish</a>
            </div>
        `;
    }

    // Close all info windows
    function closeAllInfoWindows() {
        markers.forEach(m => m.infoWindow.close());
    }

    // Setup event listeners
    function setupEventListeners() {
        // Map click
        map.addListener("click", (e) => {
            const pos = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };
            userMarker.setPosition(pos);
            updateLocation(pos.lat, pos.lng);
        });

        // Marker drag
        userMarker.addListener("dragend", (e) => {
            const pos = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };
            updateLocation(pos.lat, pos.lng);
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.toLowerCase().trim();

            searchTimeout = setTimeout(() => {
                searchResults.innerHTML = '';

                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                const filtered = learningCentersData.filter(center =>
                    center.name.toLowerCase().includes(query) ||
                    center.address.toLowerCase().includes(query)
                );

                if (filtered.length === 0) {
                    searchResults.innerHTML = '<div class="result-item">Natija topilmadi</div>';
                    searchResults.style.display = 'block';
                    return;
                }

                searchResults.style.display = 'block';

                const fragment = document.createDocumentFragment();
                filtered.forEach(center => {
                    const div = document.createElement('div');
                    div.className = 'result-item';
                    div.innerHTML =
                        `<strong>${center.name}</strong><br><small>${center.address || 'Manzil ko\'rsatilmagan'}</small>`;
                    div.addEventListener('click', () => selectCenter(center));
                    fragment.appendChild(div);
                });
                searchResults.appendChild(fragment);
            }, 300);
        });

        // Close search on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-box')) {
                searchResults.style.display = 'none';
            }
        });

        // Locate button
        document.getElementById('locateBtn').addEventListener('click', getUserLocation);

        // Handle window resize for map
        window.addEventListener('resize', () => {
            if (map && document.getElementById('map-container').classList.contains('active')) {
                setTimeout(() => {
                    google.maps.event.trigger(map, 'resize');
                }, 100);
            }
        });
    }

    // Select center from search
    function selectCenter(center) {
        map.setCenter({
            lat: center.latitude,
            lng: center.longitude
        });
        map.setZoom(16);

        const targetMarker = markers.find(m => m.center.id === center.id);
        if (targetMarker) {
            closeAllInfoWindows();
            targetMarker.infoWindow.open(map, targetMarker.marker);
        }

        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('searchInput').value = '';
    }

    // Get user location
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    map.setZoom(15);
                    userMarker.setPosition(pos);
                    updateLocation(pos.lat, pos.lng);
                },
                () => {
                    updateLocation(defaultLat, defaultLng);
                }
            );
        } else {
            updateLocation(defaultLat, defaultLng);
        }
    }

    // Update location
    function updateLocation(lat, lng) {
        const url = `https://www.google.com/maps?q=${lat},${lng}`;

        // Update form fields
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
        document.getElementById("location").value = url;

        // Geocode address
        geocoder.geocode({
            location: {
                lat,
                lng
            }
        }, (results, status) => {
            if (status === "OK" && results[0]) {
                const address = results[0].formatted_address;
                document.getElementById("address").value = address;
            }
        });

        // Calculate distances
        calculateAllDistances({
            lat,
            lng
        });
    }

    // Calculate all distances
    function calculateAllDistances(userPos) {
        markers.forEach(m => {
            updateDistance(m.center, userPos);
        });
    }

    // Update distance for one center
    function updateDistance(center, userPos) {
        const dist = getDistance(userPos.lat, userPos.lng, center.latitude, center.longitude);
        const elem = document.getElementById(`dist-${center.id}`);
        if (elem) {
            elem.textContent = `${dist.toFixed(2)} km`;
        }
        center.distance = dist;
    }

    // Calculate distance (Haversine formula)
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    window.initMap = initMap;
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap"></script>
