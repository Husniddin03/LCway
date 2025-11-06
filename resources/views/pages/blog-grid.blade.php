<x-layout>

    <x-slot:title>

        Blog Grid - FindCourse

    </x-slot>

    <!-- ===== Blog Grid Start ===== -->
    <section class="ji gp uq">
        <div class="bb ye ki xn vq jb jo">
            <div class="animate_top fb">

                <form action="{{ route('search') }}" method="POST">
                    @csrf
                    <div class="i">
                        @if (isset($searchText))
                            <input type="text" name="searchText" placeholder="Search Here..." value="{{ $searchText }}"
                                class="vd sm _g ch pm vk xm rg gm dm/40 dn/40 li mi" />
                        @else
                            <input type="text" name="searchText" placeholder="Search Here..."
                                class="vd sm _g ch pm vk xm rg gm dm/40 dn/40 li mi" />
                        @endif
                        <button type="submit" class="h r q _h">
                            <svg class="th ul ml il" width="21" height="21" viewBox="0 0 21 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.031 14.617L20.314 18.899L18.899 20.314L14.617 16.031C13.0237 17.3082 11.042 18.0029 9 18C4.032 18 0 13.968 0 9C0 4.032 4.032 0 9 0C13.968 0 18 4.032 18 9C18.0029 11.042 17.3082 13.0237 16.031 14.617ZM14.025 13.875C15.2941 12.5699 16.0029 10.8204 16 9C16 5.132 12.867 2 9 2C5.132 2 2 5.132 2 9C2 12.867 5.132 16 9 16C10.8204 16.0029 12.5699 15.2941 13.875 14.025L14.025 13.875Z" />
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="tc sf yo ap zf ep qb">

                    <ul class="nav-links">
                        <li><button class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 xi mi"><a
                                    href="{{ route('blog-grid') }}">Barchasi</a></abutton>
                        </li>
                        <li><button class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 xi mi" href="#"
                                id="toggle-map">Xarita</button></li>
                        <li>
                            <select style="padding: 1rem" id="subject" name="subject_id" id=""
                                placeholder="Type your subject" class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 xi mi">
                                <option value="" disabled selected>Saralash</option>
                                <option value="">Nomi bo'yicha</option>
                                <option value="">Masofa</option>
                                <option value="">Rayting</option>
                            </select>
                        </li>
                    </ul>
                </div>

                <div id="map-container">
                    <div id="map"></div>
                    <form class="map-form location-inputs" action="{{ route('searchMap') }}" method="POST">
                        @csrf
                        @if (isset($searchText))
                            <input type="hidden" type="text" name="searchText" placeholder="Search Here..."
                                value="{{ $searchText }}" />
                        @endif
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" type="text" id="address"
                            placeholder="Manzil">
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" hidden type="text"
                            id="location" placeholder="Google Maps URL">
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" hidden name="latitude"
                            type="text" id="latitude" placeholder="Latitude">
                        <input class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" hidden name="longitude"
                            type="text" id="longitude" placeholder="Longitude">
                        <select class="vd ph sg zk xm _g ch pm hm dm dn em pl/25 xi mi" name="subject_id" id="subject"
                            value="{{ old('subject_id') }}">
                            <option value="" disabled selected>Fanni tanlang...</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ isset($sunject_id) ? ($subject->id == $sunject_id ? 'selected' : '') : '' }}>
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


            <div style="margin-bottom: 10px;" class="wc qf pn xo zf iq">
                <div class="animate_top sg vk rm xm">
                    <p>{{ $LearningCenters->count() }} ta o'quv markaz topildi</p>
                </div>
            </div>

            <div id="centers" class="wc qf pn xo zf iq">
            </div>
        </div>
    </section>
    <!-- ===== Blog Grid End ===== -->


</x-layout>

<script>
    function sunjectName(id) {
        const subjects = @json($subjects);

        for (let i = 0; i < subjects.length; i++) {
            if (subjects[i].id == id) {
                return `<p>${subjects[i].name}</p>`;
            }
        }
        return `<p>Hozicha elon berilmagan!</p>`;
    }



    // PHP dan ma'lumotlarni JSON qilib JS ga uzatyapmiz
    const LearningCenters = @json($LearningCenters);

    // Domen url (masalan https://mysite.com)
    const baseUrl = "{{ url('/') }}";

    // Route("blog-single", id) ni JSda ishlatish uchun shablon yaratamiz
    const blogRoute = "{{ route('blog-single', ':id') }}";

    const container = document.getElementById('centers');
    container.innerHTML = ""; // Tozalaymiz
    LearningCenters.sort((a, b) => a.name.localeCompare(b.name)); // Sortlaymiz
    // Oshish tartibida (small -> big)
    LearningCenters.sort((a, b) => (a.favorite ?? 0) - (b.favorite ?? 0));

    // Teskari (descending)
    LearningCenters.sort((a, b) => (b.favorite ?? 0) - (a.favorite ?? 0));
    LearningCenters.sort((a, b) => (a.distance ?? 0) - (b.distance ?? 0));

    LearningCenters.forEach(center => {
        // Dinamik URL yasaymiz
        const blogUrl = blogRoute.replace(':id', center.id);

        // Rasmlar manzili
        const imageUrl = baseUrl + '/storage/' + center.logo;

        // O‘qituvchi kerak bo‘lsa
        let teachers = `<p>Hozicha elon berilmagan!</p>`;

        if (center.need_teachers.length > 0) {
            teachers = '';
            center.need_teachers.forEach(teacher => {
                teachers += sunjectName(teacher.subject_id);
            });
        }

        container.innerHTML += `
            <div id="${center.id}" loading="lezi" class="animate_top sg vk rm xm">

                <div class="c rc i z-1 pg">
                    <img class="standard-img lazy-img" src="${imageUrl}" alt="Blog" />

                    <div class="im h r s df vd yc wg tc wf xf al hh/20 nl il z-10">
                        <a href="${blogUrl}" class="vc ek rg lk gh sl ml il gi hi">Ko'proq o'qish</a>
                    </div>
                </div>

                <div class="yh">
                    <div class="tc uf wf ag jq">
                        <div class="tc wf ag">
                            <p>${center.region}, ${center.province}</p>
                        </div>
                        <div class="tc wf ag">
                            <img src="${baseUrl}/images/icon-calender.svg" alt="Calender" />
                            <p>${center.date}</p>
                        </div>
                        <div class="tc wf ag">
                            ${center.distance ? `<p>${center.distance} km</p>` : `<p>Masofani bilish uchun xaritadan joyni tanlang!</p>`}
                        </div>
                    </div>

                    <!-- Reyting yulduzchalari -->
                    <h4 class="favorite">
                        <div class="stars">
                            ${generateStars(center.favorite)}
                        </div>
                        <div style="margin-top: 7px; font-size: 26px" class="result">${center.favorite}</div>
                    </h4>

                    <h4 class="ek tj ml il kk wm xl eq lb">
                        <a href="${blogUrl}">${center.name}</a>
                    </h4>

                    <div class="bb ze mb">
                        <div class="animate_top" style="width: 100%">
                            <div class="_b" style="display: flex; align-items: center;">
                                <img style="width: 2rem; margin-right: 2rem; height: 2rem;"
                                    src="${baseUrl}/images/3d-speaker.png" alt="Icon" />
                                <h4 class="ek zj kk wm">O'qituvchi kerak</h4>
                            </div>
                            ${teachers}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    // Reyting uchun ⭐ generator
    function generateStars(average) {
        let stars = "";
        for (let i = 1; i <= 5; i++) {
            if (average >= i) {
                stars += `<span class="star full">★</span>`;
            } else if (average > i - 1) {
                stars += `<span class="star half">★</span>`;
            } else {
                stars += `<span class="star">★</span>`;
            }
        }
        return stars;
    }
</script>





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
        margin-top: 20px;
        list-style: none;
        padding: 0;
    }

    .nav-links li:hover {
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

    let map, geocoder, marker;

    function initMap() {
        const defaultCenter = {
            lat: 41.3111,
            lng: 69.2797
        }; // Toshkent

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
        });

        geocoder = new google.maps.Geocoder();

        marker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true
        });

        // ✅ Tugmani har doim xaritaga qo‘shamiz
        addLocateButton();

        // Foydalanuvchi joylashuvini avtomatik olishga harakat
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    map.setZoom(15);
                    marker.setPosition(userLocation);
                    updateLocation(userLocation.lat, userLocation.lng);
                },
                () => {
                    updateLocation(defaultCenter.lat, defaultCenter.lng);
                }
            );
        } else {
            updateLocation(defaultCenter.lat, defaultCenter.lng);
        }

        // 🗺️ Xaritani bosganda markerni yangilash
        map.addListener("click", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            marker.setPosition({
                lat,
                lng
            });
            updateLocation(lat, lng);
        });

        marker.addListener("dragend", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            updateLocation(lat, lng);
        });
    }

    // ✅ Xarita ichidagi “Joyimni top” tugmasi (har doim chiqadi)
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

        // Tugmani xaritaga joylash (o‘ng past burchak)
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);

        // Bosilganda joylashuvni aniqlash
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
                        marker.setPosition(userLocation);
                        updateLocation(userLocation.lat, userLocation.lng);
                    },
                    () => {
                        alert("Joylashuvni olishga ruxsat berilmadi 😔");
                    }
                );
            } else {
                alert("Sizning brauzeringiz joylashuvni qo‘llamaydi");
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
                document.getElementById("location").value = url;
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            }
        });
    }

    window.initMap = initMap;
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap"></script>
