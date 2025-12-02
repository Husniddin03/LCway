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
                        <li class="c i" x-data="{ dropdown: false }" style="width: auto !important">
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

                            <ul class="a" :class="{ 'tc': dropdown }">
                                <li>
                                    @if (!isset($validated['name']))
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}"
                                            class="xl">Nomi
                                            ↑↓</a>
                                    @elseif ($validated['name'] == 'asc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'desc']) }}"
                                            class="xl">Nomi
                                            ↑</a>
                                    @elseif ($validated['name'] == 'desc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}"
                                            class="xl">Nomi
                                            ↓</a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}"
                                            class="xl">Nomi
                                            ↑↓</a>
                                    @endif
                                </li>
                                <li>
                                    @if (!isset($validated['distance']))
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}"
                                            class="xl">Masofasi
                                            ↑↓</a>
                                    @elseif ($validated['distance'] == 'asc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'desc']) }}"
                                            class="xl">Masofasi
                                            ↑</a>
                                    @elseif ($validated['distance'] == 'desc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}"
                                            class="xl">Masofasi
                                            ↓</a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}"
                                            class="xl">Masofasi
                                            ↑↓</a>
                                    @endif
                                </li>
                                <li>
                                    @if (!isset($validated['favorites']))
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}"
                                            class="xl">Reytingi
                                            ↑↓</a>
                                    @elseif ($validated['favorites'] == 'asc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'desc']) }}"
                                            class="xl">Reytingi
                                            ↑</a>
                                    @elseif ($validated['favorites'] == 'desc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}"
                                            class="xl">Reytingi
                                            ↓</a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}"
                                            class="xl">Reytingi
                                            ↑↓</a>
                                    @endif
                                </li>
                            </ul>
                        </li>
                        <li class="c i" x-data="{ dropdown: false }">
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
                            <ul class="a" :class="{ 'tc': dropdown }">
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

                <div id="map-container" style="z-index: 1">
                    <div id="map"></div>
                    <form class="map-form location-inputs" action="{{ route('blog-grid') }}" method="get">

                        @foreach ($validated as $item)
                            <input type="hidden" type="text" name="{{ $item }}"
                                placeholder="Search Here..." value="{{ $item ?? '' }}" />
                        @endforeach

                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" type="text" id="address"
                            placeholder="Manzil">
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" hidden type="text"
                            id="location" placeholder="Google Maps URL">
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" hidden name="latitude"
                            type="text" id="latitude" placeholder="Latitude">
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" hidden name="longitude"
                            type="text" id="longitude" placeholder="Longitude">
                        <select class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" name="subject_id"
                            id="subject">
                            <option value="" disabled {{ isset($validated['sunject_id']) ? '' : 'selected' }}>
                                Fanni
                                tanlang...</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ isset($validated['sunject_id']) ? ($subject->id == $validated['sunject_id'] ? 'selected' : '') : '' }}>
                                    {{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" type="number" name="radius"
                            id="radius" placeholder="Radius (km)" min="1" max="10000">
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" type="number" name="maxPrice"
                            id="maxPrice" placeholder="Maksimal narx (so'm)" min="0">
                        <button class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi"
                            style="background-color: blue; color: white" type="submit">Yuborish</button>
                    </form>
                </div>
            </div>

            <div style="margin-bottom: 10px;" class="wc qf zf iq" style="z-index: 1">
                <div class="animate_top sg vk rm xm" style="z-index: 1; text-align: center;">
                    <p>{{ $LearningCenters->count() }} ta o'quv markaz topildi</p>
                </div>
            </div>

            <div class="wc qf pn xo zf iq">

                <!-- Blog Item -->
                @foreach ($LearningCenters as $LearningCenter)
                    <div loading="lezi" class="animate_top sg vk rm xm snake-border">

                        <div class="c rc i z-1 pg">
                            <img class="standard-img lazy-img" src="{{ asset('storage/' . $LearningCenter->logo) }}"
                                alt="Blog" />
                            {{-- <img class="standard-img lazy-img" src="{{ $LearningCenter->logo }}"
                                alt="Blog" /> --}}

                            <div class="im h r s df vd yc wg tc wf xf al hh/20 nl il z-10">
                                <a href="{{ route('blog-single', $LearningCenter->id) }}"
                                    class="vc ek rg lk gh sl ml il gi hi">Ko'proq o'qish</a>
                            </div>
                        </div>

                        <div class="yh">
                            <div class="tc uf wf ag jq">
                                <div class="tc wf ag">
                                    <p>{{ $LearningCenter->region . ', ' . $LearningCenter->province }}</p>
                                </div>
                                <div class="tc wf ag">
                                    <img src="{{ asset('images/icon-calender.svg') }}" alt="Calender" />
                                    <p>{{ $LearningCenter->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="tc wf ag">
                                    @if (isset($LearningCenter->distance))
                                        {{-- <p class="nowAddress"></p> --}}
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
                                    <div class="_b"
                                        style="display: flex; flex-direction: row; align-content: center; align-items: center;">
                                        <img style="width: 2rem; margin-right: 2rem; height: 2rem;"
                                            src="{{ asset('images/3d-speaker.png') }}" alt="Icon" />
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

    /* nav-link */
    .nav-links {
        display: flex;
        gap: 20px;
        margin-top: 10px;
        list-style: none;
        padding: 0;
    }

    .nav-links-li:hover {
        color: blue;
    }

    #map-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
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

    .map-form {
        display: flex;
    }

    @media (max-width: 768px) {
        .map-form {
            flex-direction: column;
        }

        .nav-links {
            overflow-x: auto;
            width: auto;
        }
    }

    .location-inputs {
        margin-top: 10px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
        margin-bottom: 40px;
    }

    .location-inputs input {
        padding: 8px;
        font-size: 16px;
        width: 100%;
    }
</style>

<script>
    const toggleMapBtn = document.getElementById('toggle-map');
    const mapContainer = document.getElementById('map-container');

    toggleMapBtn.addEventListener('click', function(e) {
        e.preventDefault();
        mapContainer.classList.toggle('active');
    });

    let map, geocoder, userMarker;
    const learningCenterMarkers = [];

    function initMap() {
        const defaultCenter = {
            lat: {{ $validated['latitude'] ?? 41.2995 }},
            lng: {{ $validated['longitude'] ?? 69.2401 }}
        };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
        });

        geocoder = new google.maps.Geocoder();

        // Foydalanuvchi joylashuvi uchun marker (ko'k rang)
        userMarker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                labelOrigin: new google.maps.Point(16, -10)
            },
            title: "Sizning joylashuvingiz",
            label: {
                text: "SIZ",
                color: "#FFFFFF",
                fontSize: "13px",
                fontWeight: "bold",
                className: "user-marker-label"
            }
        });

        addLocateButton();

        // O'quv markazlarini xaritaga qo'shish
        addLearningCenters();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    map.setZoom(15);
                    userMarker.setPosition(userLocation);
                    updateLocation(userLocation.lat, userLocation.lng);
                },
                () => {
                    updateLocation(defaultCenter.lat, defaultCenter.lng);
                }
            );
        } else {
            updateLocation(defaultCenter.lat, defaultCenter.lng);
        }

        map.addListener("click", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            userMarker.setPosition({
                lat,
                lng
            });
            updateLocation(lat, lng);
        });

        userMarker.addListener("dragend", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            updateLocation(lat, lng);
        });
    }

    // O'quv markazlarini xaritaga qo'shish
    function addLearningCenters() {
        // Backend'dan kelgan ma'lumotlar (PHP'dan JSON formatida)
        const learningCenters = {!! json_encode(
            $LearningCenters->map(function ($center) {
                $location = explode(',', $center->location);
                if (count($location) < 2) {
                    $location = [null, null];
                }
                return [
                    'id' => $center->id,
                    'name' => $center->name,
                    'latitude' => (float) $location[0],
                    'longitude' => (float) $location[1],
                    'address' => $center->address ?? '',
                    'logo' => $center->logo ?? 'default-logo.png',
                    'distance' => $center->distance ?? 0,
                ];
            }),
        ) !!};

        console.log('Learning Centers:', learningCenters); // Debug uchun

        learningCenters.forEach(center => {
            // Agar latitude yoki longitude null bo'lsa, o'tkazib yuborish
            if (!center.latitude || !center.longitude ||
                isNaN(center.latitude) || isNaN(center.longitude)) {
                console.log('Invalid location for:', center.name);
                return;
            }

            const marker = new google.maps.Marker({
                map: map,
                position: {
                    lat: parseFloat(center.latitude),
                    lng: parseFloat(center.longitude)
                },
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    labelOrigin: new google.maps.Point(16, -10)
                },
                title: center.name,
                label: {
                    text: center.name.length > 20 ? center.name.substring(0, 20) + '...' : center.name,
                    color: "#FF4444",
                    fontSize: "13px",
                    fontWeight: "bold",
                    className: "center-marker-label"
                }
            });

            console.log('Marker created for:', center.name, center.latitude, center.longitude); // Debug

            // InfoWindow (bosgan vaqti ko'rinadigan oyna)
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="padding: 10px; max-width: 250px;">
                        <img src="/storage/${center.logo}" 
                             style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px; margin-bottom: 8px;"
                             onerror="this.style.display='none'"/>
                        <h3 style="margin: 0 0 5px 0; font-size: 16px; font-weight: bold;">
                            ${center.name}
                        </h3>
                        <p style="margin: 0 0 5px 0; font-size: 13px; color: #1976d2; font-weight: 500;">
                            📍 Masofa: ${center.distance ? center.distance.toFixed(2) : '0'} km
                        </p>
                        <p style="margin: 0 0 10px 0; font-size: 12px; color: #666;">
                            ${center.address || 'Manzil ko\'rsatilmagan'}
                        </p>
                        <a href="/blog-single/${center.id}" 
                           style="display: inline-block; padding: 8px 16px; background-color: #4285f4; 
                                  color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
                            Batafsil ko'rish
                        </a>
                    </div>
                `
            });

            marker.addListener("click", () => {
                // Boshqa barcha InfoWindow'larni yopish
                learningCenterMarkers.forEach(m => {
                    if (m.infoWindow) {
                        m.infoWindow.close();
                    }
                });

                infoWindow.open(map, marker);
            });

            learningCenterMarkers.push({
                marker: marker,
                infoWindow: infoWindow
            });
        });
    }

    function addLocateButton() {
        const controlDiv = document.createElement("div");
        const controlUI = document.createElement("button");

        controlUI.style.backgroundColor = "#fff";
        controlUI.style.border = "2px solid #fff";
        controlUI.style.borderRadius = "50%";
        controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        controlUI.style.cursor = "pointer";
        controlUI.style.margin = "10px";
        controlUI.style.padding = "8px";
        controlUI.style.width = "40px";
        controlUI.style.height = "40px";
        controlUI.style.display = "flex";
        controlUI.style.alignItems = "center";
        controlUI.style.justifyContent = "center";
        controlUI.title = "Joyimni top";
        controlUI.innerHTML = "📍";

        controlDiv.appendChild(controlUI);
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);

        controlUI.addEventListener("click", () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        map.setZoom(15);
                        userMarker.setPosition(userLocation);
                        updateLocation(userLocation.lat, userLocation.lng);
                    },
                    () => {
                        alert("Joylashuvni olishga ruxsat berilmadi 😔");
                    }
                );
            } else {
                alert("Sizning brauzeringiz joylashuvni qo'llamaydi");
            }
        });
    }

    function updateLocation(lat, lng) {
        const url = `https://www.google.com/maps?q=${lat},${lng}`;

        geocoder.geocode({
            location: {
                lat,
                lng
            }
        }, (results, status) => {
            if (status === "OK" && results[0]) {
                const address = results[0].formatted_address;
                document.getElementById("address").value = address;
                document.querySelectorAll(".nowAddress").forEach(el => {
                    el.innerHTML = address;
                });
                document.getElementById("location").value = url;
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            }
        });
    }

    window.initMap = initMap;
</script>

<script>
    const toggleMapBtn = document.getElementById('toggle-map');
    const mapContainer = document.getElementById('map-container');

    toggleMapBtn.addEventListener('click', function(e) {
        e.preventDefault();
        mapContainer.classList.toggle('active');
    });

    let map, geocoder, userMarker;
    const learningCenterMarkers = [];
    let allCentersData = []; // Barcha markazlar ma'lumotlari

    function initMap() {
        const defaultCenter = {
            lat: {{ $validated['latitude'] ?? 41.2995 }},
            lng: {{ $validated['longitude'] ?? 69.2401 }}
        };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
        });

        geocoder = new google.maps.Geocoder();

        // Foydalanuvchi joylashuvi uchun marker (ko'k rang)
        userMarker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                labelOrigin: new google.maps.Point(16, -10)
            },
            title: "Sizning joylashuvingiz",
            label: {
                text: "SIZ",
                color: "#FFFFFF",
                fontSize: "13px",
                fontWeight: "bold",
                className: "user-marker-label"
            }
        });

        addLocateButton();

        // O'quv markazlarini xaritaga qo'shish
        addLearningCenters();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    map.setZoom(15);
                    userMarker.setPosition(userLocation);
                    updateLocation(userLocation.lat, userLocation.lng);
                },
                () => {
                    updateLocation(defaultCenter.lat, defaultCenter.lng);
                }
            );
        } else {
            updateLocation(defaultCenter.lat, defaultCenter.lng);
        }

        map.addListener("click", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            userMarker.setPosition({lat, lng});
            updateLocation(lat, lng);
        });

        userMarker.addListener("dragend", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            updateLocation(lat, lng);
        });
    }

    // O'quv markazlarini xaritaga qo'shish
    function addLearningCenters() {
        // Backend'dan kelgan ma'lumotlar (PHP'dan JSON formatida)
        const learningCenters = {!! json_encode($LearningCenters->map(function($center) {
            $location = explode(',', $center->location);
            if(count($location) < 2){
                $location = [null, null];
            }
            return [
                'id' => $center->id,
                'name' => $center->name,
                'latitude' => (float)$location[0],
                'longitude' => (float)$location[1],
                'address' => $center->address ?? '',
                'logo' => $center->logo ?? 'default-logo.png',
                'distance' => $center->distance ?? 0
            ];
        })) !!};

        allCentersData = learningCenters; // Global o'zgaruvchiga saqlash
        console.log('Learning Centers:', learningCenters); // Debug uchun

        learningCenters.forEach(center => {
            // Agar latitude yoki longitude null bo'lsa, o'tkazib yuborish
            if (!center.latitude || !center.longitude || 
                isNaN(center.latitude) || isNaN(center.longitude)) {
                console.log('Invalid location for:', center.name);
                return;
            }

            const marker = new google.maps.Marker({
                map: map,
                position: {
                    lat: parseFloat(center.latitude),
                    lng: parseFloat(center.longitude)
                },
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    labelOrigin: new google.maps.Point(16, -10)
                },
                title: center.name,
                label: {
                    text: center.name.length > 20 ? center.name.substring(0, 20) + '...' : center.name,
                    color: "#FF4444",
                    fontSize: "13px",
                    fontWeight: "bold",
                    className: "center-marker-label"
                }
            });

            console.log('Marker created for:', center.name, center.latitude, center.longitude); // Debug

            // InfoWindow (bosgan vaqti ko'rinadigan oyna)
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <a href="/blog-single/${center.id}" style="padding: 10px; max-width: 250px;">
                        <img src="/storage/${center.logo}" 
                             style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px; margin-bottom: 8px;"
                             onerror="this.style.display='none'"/>
                        <h3 style="margin: 0 0 5px 0; font-size: 16px; font-weight: bold;">
                            ${center.name}
                        </h3>
                        <p style="margin: 0 0 5px 0; font-size: 13px; color: #1976d2; font-weight: 500;">
                            📍 Masofa: ${center.distance ? center.distance.toFixed(2) : '0'} km
                        </p>
                        <p style="margin: 0 0 10px 0; font-size: 12px; color: #666;">
                            ${center.address || 'Manzil ko\'rsatilmagan'}
                        </p>
                        <a href="/blog-single/${center.id}" 
                           style="display: inline-block; padding: 8px 16px; background-color: #4285f4; 
                                  color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
                            Batafsil ko'rish
                        </a>
                    </a>
                `
            });

            marker.addListener("click", () => {
                // Boshqa barcha InfoWindow'larni yopish
                learningCenterMarkers.forEach(m => {
                    if (m.infoWindow) {
                        m.infoWindow.close();
                    }
                });
                
                infoWindow.open(map, marker);
            });

            learningCenterMarkers.push({
                marker: marker,
                infoWindow: infoWindow,
                center: center  // Markaz ma'lumotlarini saqlash
            });
        });
    }

    // Qidiruv maydonini xaritaga qo'shish
    function addSearchBox() {
        console.log('addSearchBox called, centers count:', allCentersData.length);
        
        const searchContainer = document.createElement("div");
        searchContainer.style.backgroundColor = "white";
        searchContainer.style.margin = "10px";
        searchContainer.style.padding = "10px";
        searchContainer.style.borderRadius = "8px";
        searchContainer.style.boxShadow = "0 2px 6px rgba(0,0,0,0.3)";
        searchContainer.style.width = "300px";
        searchContainer.style.zIndex = "1000";

        const searchInput = document.createElement("input");
        searchInput.type = "text";
        searchInput.placeholder = "O'quv markazini qidiring...";
        searchInput.style.width = "100%";
        searchInput.style.padding = "8px";
        searchInput.style.border = "1px solid #ddd";
        searchInput.style.borderRadius = "4px";
        searchInput.style.fontSize = "14px";
        searchInput.style.boxSizing = "border-box";
        searchInput.style.outline = "none";

        const resultsContainer = document.createElement("div");
        resultsContainer.style.maxHeight = "200px";
        resultsContainer.style.overflowY = "auto";
        resultsContainer.style.marginTop = "5px";
        resultsContainer.style.display = "none";
        resultsContainer.style.backgroundColor = "white";
        resultsContainer.style.borderRadius = "4px";

        searchContainer.appendChild(searchInput);
        searchContainer.appendChild(resultsContainer);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchContainer);
        console.log('Search box added to map controls');

        // Qidiruv funksiyasi
        searchInput.addEventListener("input", function() {
            const query = this.value.toLowerCase().trim();
            resultsContainer.innerHTML = "";

            if (query.length < 2) {
                resultsContainer.style.display = "none";
                return;
            }

            const filtered = allCentersData.filter(center => 
                center.name.toLowerCase().includes(query)
            );

            if (filtered.length === 0) {
                resultsContainer.style.display = "none";
                return;
            }

            resultsContainer.style.display = "block";

            filtered.forEach(center => {
                const resultItem = document.createElement("div");
                resultItem.style.padding = "8px";
                resultItem.style.cursor = "pointer";
                resultItem.style.borderBottom = "1px solid #eee";
                resultItem.style.fontSize = "13px";
                resultItem.innerHTML = `
                    <strong>${center.name}</strong><br>
                    <small style="color: #666;">${center.address || 'Manzil ko\'rsatilmagan'}</small>
                `;

                resultItem.addEventListener("mouseover", function() {
                    this.style.backgroundColor = "#f5f5f5";
                });

                resultItem.addEventListener("mouseout", function() {
                    this.style.backgroundColor = "white";
                });

                resultItem.addEventListener("click", function() {
                    // Xaritani markazga o'tkazish
                    map.setCenter({
                        lat: center.latitude,
                        lng: center.longitude
                    });
                    map.setZoom(16);

                    // Tegishli markerni topish va InfoWindow'ni ochish
                    const targetMarker = learningCenterMarkers.find(m => 
                        m.center.id === center.id
                    );

                    if (targetMarker) {
                        // Barcha InfoWindow'larni yopish
                        learningCenterMarkers.forEach(m => {
                            if (m.infoWindow) {
                                m.infoWindow.close();
                            }
                        });
                        
                        // Tanlangan markerning InfoWindow'ni ochish
                        targetMarker.infoWindow.open(map, targetMarker.marker);
                    }

                    // Qidiruv natijalarini yopish
                    searchInput.value = center.name;
                    resultsContainer.style.display = "none";
                });

                resultsContainer.appendChild(resultItem);
            });
        });

        // Tashqariga bosilganda natijalarni yopish
        document.addEventListener("click", function(e) {
            if (!searchContainer.contains(e.target)) {
                resultsContainer.style.display = "none";
            }
        });
    }

    function addLocateButton() {
        const controlDiv = document.createElement("div");
        const controlUI = document.createElement("button");
        
        controlUI.style.backgroundColor = "#fff";
        controlUI.style.border = "2px solid #fff";
        controlUI.style.borderRadius = "50%";
        controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        controlUI.style.cursor = "pointer";
        controlUI.style.margin = "10px";
        controlUI.style.padding = "8px";
        controlUI.style.width = "40px";
        controlUI.style.height = "40px";
        controlUI.style.display = "flex";
        controlUI.style.alignItems = "center";
        controlUI.style.justifyContent = "center";
        controlUI.title = "Joyimni top";
        controlUI.innerHTML = "📍";
        
        controlDiv.appendChild(controlUI);
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);

        controlUI.addEventListener("click", () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        map.setZoom(15);
                        userMarker.setPosition(userLocation);
                        updateLocation(userLocation.lat, userLocation.lng);
                    },
                    () => {
                        alert("Joylashuvni olishga ruxsat berilmadi 😔");
                    }
                );
            } else {
                alert("Sizning brauzeringiz joylashuvni qo'llamaydi");
            }
        });
    }

    function updateLocation(lat, lng) {
        const url = `https://www.google.com/maps?q=${lat},${lng}`;

        geocoder.geocode({
            location: {lat, lng}
        }, (results, status) => {
            if (status === "OK" && results[0]) {
                const address = results[0].formatted_address;
                document.getElementById("address").value = address;
                document.querySelectorAll(".nowAddress").forEach(el => {
                    el.innerHTML = address;
                });
                document.getElementById("location").value = url;
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            }
        });
    }

    window.initMap = initMap;
</script>

<style>
    /* Marker label'larini ko'proq ko'rinadigan qilish */
    .user-marker-label {
        background-color: #2196F3 !important;
        padding: 4px 8px !important;
        border-radius: 4px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3) !important;
        border: 2px solid white !important;
    }
    
    .center-marker-label {
        background-color: #FFFFFF !important;
        padding: 3px 6px !important;
        border-radius: 3px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.3) !important;
        border: 1px solid #FF4444 !important;
    }
</style>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap"></script>