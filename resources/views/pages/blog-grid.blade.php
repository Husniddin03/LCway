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

                <style>
                    .nav-links {
                        display: flex;
                        gap: 20px;
                        margin-top: 20px;
                        list-style: none;
                        padding: 0;
                    }

                    .nav-links li a {
                        text-decoration: none;
                        font-size: 18px;
                        color: rgb(78 107 255);
                        padding: 8px 16px;
                        border-radius: 6px;
                        transition: background 0.3s;
                    }

                    .nav-links li a:hover {
                        background-color: pink;
                    }

                    #map-container {
                        max-height: 0;
                        overflow: hidden;
                        transition: max-height 0.5s ease;
                        margin-bottom: 40px;
                    }

                    #map-container.active {
                        max-height: 600px;
                        margin-top: 10px;
                    }

                    #map {
                        width: 100%;
                        height: 400px;
                        border-radius: 10px;
                    }

                    .location-inputs {
                        margin-top: 10px;
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                        gap: 10px;
                    }

                    .location-inputs input,
                    .location-inputs select {
                        padding: 8px;
                        font-size: 16px;
                        width: 100%;
                    }
                </style>

                <ul class="nav-links">
                    <li><a href="{{ route('blog-grid') }}">Barchasi</a></li>
                    <li><a href="#" id="toggle-map">Xarita</a></li>
                </ul>

                <div id="map-container">
                    <div id="map"></div>
                    <form action="{{ route('searchMap') }}" method="POST" class="location-inputs">
                        @csrf
                        <input type="text" id="address" placeholder="Manzil">
                        <input hidden type="text" id="location" placeholder="Google Maps URL">
                        <input hidden name="latitude" type="text" id="latitude" placeholder="Latitude">
                        <input hidden name="longitude" type="text" id="longitude" placeholder="Longitude">
                        <select name="subject_id" id="subject" value="{{ old('subject_id') }}">
                            <option value="" disabled selected>Fanni tanlang...</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="radius" id="radius" placeholder="Radius (km)" min="1"
                            max="1000">
                        <input type="number" name="maxPrice" id="maxPrice" placeholder="Maksimal narx (so'm)"
                            min="0">
                        <button type="submit">Yuborish</button>
                    </form>
                </div>

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

            </div>


            <div style="margin-bottom: 10px;" class="wc qf pn xo zf iq">
                <div class="animate_top sg vk rm xm">
                    <p>{{ $LearningCenters->count() }} ta o'quv markaz topildi</p>
                </div>
            </div>
            <div class="wc qf pn xo zf iq">
                <!-- Blog Item -->
                @foreach ($LearningCenters as $LearningCenter)
                    <div loading="lezi" class="animate_top sg vk rm xm">
                        <style>
                            .standard-img {
                                aspect-ratio: 4 / 3;
                                object-fit: cover;
                                width: 100%;
                                height: auto;
                            }
                        </style>

                        <div class="c rc i z-1 pg">
                            <img class="standard-img lazy-img" src="{{ $LearningCenter->logo }}" alt="Blog" />

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
                                        <p>{{ $LearningCenter->distance }} km</p>
                                    @else
                                        <p>Masofa ma'lum emas</p>
                                    @endif
                                </div>
                            </div>
                            <h4 class="ek tj ml il kk wm xl eq lb">
                                <a
                                    href="{{ route('blog-single', $LearningCenter->id) }}">{{ $LearningCenter->name }}</a>
                            </h4>
                            <div
                                style="background:#ffffff; padding:20px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.08); margin-bottom:16px; margin-top:16px; border-left:4px solid #2196f3; font-family:'Segoe UI', Tahoma, sans-serif; font-size:15px; color:#333;">
                                @if ($LearningCenter->needTeachers->count() > 0)
                                    <div
                                        style="display:flex; align-items:center; margin-bottom:16px; padding-bottom:12px; border-bottom:2px solid #f5f5f5;">
                                        <div
                                            style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-right:12px; box-shadow:0 4px 12px rgba(102,126,234,0.3);">
                                            <span style="font-size:24px;">📢</span>
                                        </div>
                                        <div>
                                            <h3 style="margin:0; font-size:20px; font-weight:700; color:#1a1a1a;">
                                                E'lonlar</h3>
                                            <p style="margin:4px 0 0 0; font-size:13px; color:#757575;">Mavjud ish
                                                o'rinlari</p>
                                        </div>
                                    </div>

                                    <div
                                        style="background:#f8f9fa; padding:12px; border-radius:8px; margin-bottom:12px;">
                                        <span
                                            style="display:flex; align-items:center; font-weight:600; color:#424242; font-size:15px;">
                                            <span style="margin-right:8px;">🧑‍🏫</span>
                                            O'qituvchi kerak
                                        </span>
                                    </div>

                                    <div style="display:flex; flex-wrap:wrap; gap:10px;">
                                        @foreach ($LearningCenter->needTeachers as $needTeacher)
                                            <a href="{{ route('teacher.announcement', $LearningCenter->id) }}"
                                                style="display:inline-flex; align-items:center; padding:10px 16px; background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); color:#ffffff; border-radius:8px; text-decoration:none; font-weight:600; font-size:14px; transition:all 0.3s ease; box-shadow:0 2px 8px rgba(102,126,234,0.25);"
                                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102,126,234,0.4)'"
                                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(102,126,234,0.25)'">
                                                <span style="margin-right:6px;">📚</span>
                                                {{ $needTeacher->subject->name }}
                                            </a>
                                        @endforeach
                                    </div>

                                    <div style="margin-top:16px; padding-top:12px; border-top:1px solid #e0e0e0;">
                                        <p style="margin:0; font-size:13px; color:#757575; text-align:center;">
                                            ⏰ Yangi e'lonlar muntazam yangilanadi
                                        </p>
                                    </div>
                                @else
                                    <div
                                        style="display:flex; align-items:center; margin-bottom:16px; padding-bottom:12px; border-bottom:2px solid #f5f5f5;">
                                        <div
                                            style="background:linear-gradient(135deg, #bdbdbd 0%, #9e9e9e 100%); width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-right:12px;">
                                            <span style="font-size:24px;">📢</span>
                                        </div>
                                        <div>
                                            <h3 style="margin:0; font-size:20px; font-weight:700; color:#1a1a1a;">
                                                E'lonlar</h3>
                                            <p style="margin:4px 0 0 0; font-size:13px; color:#757575;">Hozirgi holat
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        style="text-align:center; padding:30px 20px; background:#f8f9fa; border-radius:8px; border:2px dashed #e0e0e0;">
                                        <div style="font-size:48px; margin-bottom:12px;">📭</div>
                                        <p style="margin:0; font-size:16px; font-weight:600; color:#616161;">Hozircha
                                            e'lonlar yo'q</p>
                                        <p style="margin:8px 0 0 0; font-size:13px; color:#9e9e9e;">Yangi e'lonlar tez
                                            orada paydo bo'ladi</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ===== Blog Grid End ===== -->

</x-layout>


{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const images = document.querySelectorAll('img.lazy-img');

        const options = {
            root: null,
            rootMargin: "300px 0px", // 300px oldin yuklaydi
            threshold: 0
        };

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy-img');
                    obs.unobserve(img);
                }
            });
        }, options);

        images.forEach(img => {
            observer.observe(img);
        });
    });
</script> --}}
