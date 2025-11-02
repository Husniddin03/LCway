<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O'quv Markaz Ro'yxatga Olish</title>
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
</head>
<html>

<body>
    <main class="edu-center-wrapper">
        <div class="edu-center-container">
            <div class="edu-center-form-box">
                <h2 class="edu-center-title">{{$center->name }} markazini tahrirlash</h2>
                @if ($errors->any())
                    <div style="color: red">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="edu-center-form" action="{{ route('course.update', $center->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT');

                    @isset($center->logo)
                        <div class="edu-center-field-group">
                            <label for="logo" class="edu-center-label">Mavjud Logo</label>
                            <img style="width: 100%;" src="{{ asset('storage/' . $center->logo) }}" alt="">
                        </div>
                    @endisset

                    <div class="edu-center-field-group">
                        <label for="logo" class="edu-center-label">Yangi Logo</label>
                        <div class="edu-center-file-wrapper">
                            <input type="file" name="logo" id="logo" class="edu-center-file-input"
                                accept="image/*">
                            <div class="edu-center-file-display">
                                <svg class="edu-center-upload-icon" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path
                                        d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                    <circle cx="12" cy="13" r="3" />
                                </svg>
                                <span class="edu-center-upload-text">Yangi Logo yuklash</span>
                            </div>
                            @error('logo')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="edu-center-field-group">
                        <label for="name" class="edu-center-label edu-center-required">Nomi</label>
                        <input type="text" name="name" id="name" class="edu-center-input" required
                            placeholder="O'quv markaz nomini kiriting" value="{{ $center->name }}">
                        @error('name')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="edu-center-field-group">
                        <label for="type" class="edu-center-label">Turi</label>
                        <input type="text" name="type" id="type" class="edu-center-input"
                            placeholder="Masalan: IT, Til o'rgatish, O'quv markazi ..." value="{{ $center->type }}">
                        @error('type')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="edu-center-field-group">
                        <label for="about" class="edu-center-label">Haqida</label>
                        <textarea name="about" id="about" class="edu-center-textarea"
                            placeholder="O'quv markaz haqida qisqacha ma'lumot..." rows="4">{{ $center->about }}</textarea>
                        @error('about')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Xaritani ko'rsatish -->
                    <div id="map" style="width: 100%; height: 400px; margin-top: 10px; border-radius:10px;">
                    </div>

                    <div class="edu-center-field-group edu-center-full">
                        <label for="location" class="edu-center-label">Xaritadan manzilni tanlasangiz Viloyat, Tuman,
                            manzil va manzil urli automatik to'ldiriladi agarda xato bo'lsa o'zgartirishingiz
                            mumkin.</label>
                    </div>

                    <!-- Viloyat va Tuman tanlash -->
                    <div class="edu-center-row">
                        <div class="edu-center-field-group edu-center-half">
                            <label for="region" class="edu-center-label">Viloyat</label>
                            <select id="region" name="province" class="edu-center-input" required>
                                <option value="{{ $center->province }}" selected>{{ $center->province }}</option>
                                <option value="Toshkent">Toshkent</option>
                                <option value="Sirdaryo">Sirdaryo</option>
                                <option value="Jizzax">Jizzax</option>
                                <option value="Samarqand">Samarqand</option>
                                <option value="Buxoro">Buxoro</option>
                                <option value="Navoiy">Navoiy</option>
                                <option value="Qashqadaryo">Qashqadaryo</option>
                                <option value="Surxandaryo">Surxandaryo</option>
                                <option value="Xorazm">Xorazm</option>
                                <option value="Andijon">Andijon</option>
                                <option value="Namangan">Namangan</option>
                                <option value="Farg‘ona">Farg‘ona</option>
                                <option value="Qoraqalpog‘iston">Qoraqalpog‘iston</option>
                            </select>
                        </div>

                        <div class="edu-center-field-group edu-center-half">
                            <label for="district" class="edu-center-label">Tuman</label>
                            <select id="district" name="region" class="edu-center-input" required>
                                <option value="{{ $center->region }}" selected>{{ $center->region }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Manzil -->
                    <div class="edu-center-field-group">
                        <label for="address" class="edu-center-label">Manzil</label>
                        <input type="text" name="address" id="address" class="edu-center-input"
                            placeholder="To'liq manzilni kiriting" value="{{ $center->address }}">
                        @error('address')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- URL -->
                    <div class="edu-center-field-group edu-center-full">
                        <label for="location" class="edu-center-label">URL</label>
                        <input name="location" id="location" type="text" class="edu-center-input"
                            placeholder="Manzil URL avtomatik yoziladi" value="{{ $center->location }}">
                        @error('location')
                            <div style="color: red">{{ $message }}</div>
                        @enderror

                        <!-- yashirin inputlar -->
                        <input type="hidden" id="latitude">
                        <input type="hidden" id="longitude">
                    </div>

                    <div class="edu-center-field-group">
                        <label for="studentCount" class="edu-center-label">Hozirda markazingizdagi o'quvchilar
                            soni</label>
                        <input type="number" name="student_count" id="studentCount" class="edu-center-input"
                            placeholder="0" min="0" value="{{ $center->student_count }}">
                        @error('student_count')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="edu-center-buttons">
                        <button type="submit" class="edu-center-btn edu-center-btn-primary">
                            <svg class="edu-center-btn-icon" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17,21 17,13 7,13 7,21" />
                                <polyline points="7,3 7,8 15,8" />
                            </svg>
                            Saqlash
                        </button>
                        <a href="{{ route('blog-single', $center->id) }}" type="button"
                            class="edu-center-btn edu-center-btn-secondary">
                            <svg class="edu-center-btn-icon" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                            Bekor qilish
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/course.js') }}"></script>
</body>

</html>

<script>
    // Dinamik tumanlar ro'yxati
    const districtsByRegion = {
        Toshkent: ["Bekobod", "Bo‘ka", "Chinoz", "Oqqo‘rg‘on", "Ohangaron",
            "Piskent", "Quyichirchiq", "Yuqorichirchiq", "Zangiota",
            "Toshkent tumani", "Parkent"
        ],
        Sirdaryo: ["Guliston", "Boyovut", "Sardoba", "Mirzaobod", "Hovos",
            "Oqoltin", "Sayxunobod", "Sirdaryo tumani"
        ],
        Jizzax: ["Jizzax shahri", "Arnasoy", "Baxmal", "Do‘stlik", "Forish",
            "G‘allaorol", "Sharof Rashidov", "Paxtakor", "Zomin",
            "Yangiobod", "Mirzacho‘l", "Gagarin"
        ],
        Samarqand: ["Samarqand shahri", "Bulung‘ur", "Jomboy", "Ishtixon",
            "Kattaqo‘rg‘on", "Narpay", "Oqdaryo", "Pastdarg‘om",
            "Payariq", "Qo‘shrabot", "Samarqand tumani", "Tayloq",
            "Urgut", "Chelak", "Ziyodin", "Kattaqo‘rg‘on shahri"
        ],
        Buxoro: ["Buxoro shahri", "Buxoro tumani", "G‘ijduvon", "Jondor",
            "Kogon shahri", "Kogon tumani", "Olot", "Peshku",
            "Qorako‘l", "Qorovulbozor", "Shofirkon"
        ],
        Navoiy: ["Navoiy shahri", "Zarafshon shahri", "Karmana", "Xatirchi",
            "Qiziltepa", "Navbahor", "Tomdi", "Uchquduq"
        ],
        Qashqadaryo: ["Qarshi shahri", "Qarshi tumani", "Shahrisabz shahri",
            "Shahrisabz tumani", "Kitob", "Yakkabog‘", "Chiroqchi",
            "Nishon", "Muborak", "Qamashi", "Koson", "Kasbi",
            "G‘uzor", "Mirishkor"
        ],
        Surxandaryo: ["Termiz shahri", "Angor", "Boysun", "Denov", "Jarqo‘rg‘on",
            "Muzrabot", "Oltinsoy", "Qiziriq", "Qumqo‘rg‘on",
            "Sariosiyo", "Sherobod", "Sho‘rchi", "Termiz tumani", "Uzun"
        ],
        Xorazm: ["Urganch shahri", "Bog‘ot", "Gurlan", "Hazorasp", "Xiva",
            "Qo‘shko‘pir", "Shovot", "Tuproqqal’a", "Urganch tumani",
            "Xonqa", "Yangibozor"
        ],
        Andijon: ["Andijon shahri", "Andijon tumani", "Asaka", "Baliqchi",
            "Bo‘z", "Buloqboshi", "Izboskan", "Jalolquduq",
            "Xo‘jaobod", "Qo‘rg‘ontepa", "Marhamat", "Oltinko‘l",
            "Paxtaobod", "Shahrixon", "Ulug‘nor", "Xonobod shahri"
        ],
        Namangan: ["Namangan shahri", "Chortoq", "Chust", "Kosonsoy", "Mingbuloq",
            "Norin", "Pop", "To‘raqo‘rg‘on", "Uychi", "Yangiqo‘rg‘on",
            "Namangan tumani"
        ],
        "Farg‘ona": ["Farg‘ona shahri", "Qo‘qon shahri", "Marg‘ilon shahri",
            "Oltiariq", "O‘zbekiston tumani", "Quva", "Rishton",
            "Toshloq", "Yozyovon", "Dang‘ara", "Beshariq", "Bog‘dod",
            "So‘x", "Uchko‘prik", "Furqat"
        ],
        "Qoraqalpog‘iston": ["Nukus shahri", "Amudaryo", "Beruniy", "Chimboy",
            "Ellikqal‘a", "Kegeyli", "Mo‘ynoq", "Nukus tumani",
            "Qanliko‘l", "Qo‘ng‘irot", "Qorao‘zak", "Shumanay",
            "Taxtako‘pir", "To‘rtko‘l", "Xo‘jayli", "Taxiatosh shahri"
        ]
    };

    const regionSelect = document.getElementById("region");
    const districtSelect = document.getElementById("district");

    // Viloyat tanlanganda tumanni yangilash
    regionSelect.addEventListener("change", () => {
        const selectedRegion = regionSelect.value;
        districtSelect.innerHTML = '<option value="" disabled selected>Tumanni tanlang...</option>';

        if (districtsByRegion[selectedRegion]) {
            districtsByRegion[selectedRegion].forEach((district) => {
                const option = document.createElement("option");
                option.value = district;
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    });
</script>

@php
    $location = explode(',', $center->location);
@endphp

<script>
    let map, geocoder, marker;

    function initMap() {
        const defaultCenter = {
            lat: {{$location[0]}},
            lng: {{$location[1]}}
        }; // Toshkent markaz

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
        });

        geocoder = new google.maps.Geocoder();

        // Marker yaratish
        marker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true
        });

        // ⬇️ Hozirgi joylashuvni olish
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
                    // Agar ruxsat berilmasa Toshkentda qoladi
                    updateLocation(defaultCenter.lat, defaultCenter.lng);
                }
            );
        } else {
            updateLocation(defaultCenter.lat, defaultCenter.lng);
        }

        // Xaritaga bosilganda marker va manzilni yangilash
        map.addListener("click", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            marker.setPosition({
                lat,
                lng
            });
            updateLocation(lat, lng);
        });

        // Marker surilganda yangilash
        marker.addListener("dragend", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            updateLocation(lat, lng);
        });
    }

    function updateLocation(lat, lng) {
        const url = `${lat},${lng}`;

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

                console.log("📍 Manzil:", address);
                console.log("🔗 URL:", url);

                let regionSelect = document.getElementById("region");
                let districtSelect = document.getElementById("district");

                let components = results[0].address_components;

                let region = components.find(c => c.types.includes("administrative_area_level_1"));
                let district = components.find(c => c.types.includes("administrative_area_level_2"));

                if (region) {
                    for (let option of regionSelect.options) {
                        if (option.value && region.long_name.includes(option.value)) {
                            option.selected = true;
                            break;
                        }
                    }
                }

                if (district) {
                    districtSelect.innerHTML = `<option value="" disabled selected>Tumanni tanlang...</option>`;
                    let opt = document.createElement("option");
                    opt.value = district.long_name;
                    opt.textContent = district.long_name;
                    opt.selected = true;
                    districtSelect.appendChild(opt);
                }
            } else {
                console.log("Manzil topilmadi!");
            }
        });
    }

    window.initMap = initMap;
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap" async
    defer></script>
