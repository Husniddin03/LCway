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
                <h2 class="edu-center-title">Yangi o'quv markaz qo'shing</h2>
                @if ($errors->any())
                    <div style="color: red">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="edu-center-form" action="{{ route('course.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="edu-center-field-group">
                        <label for="logo" class="edu-center-label">Markazning asosiy rasmi (logo)</label>
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
                                <span class="edu-center-upload-text">Logo yuklash</span>
                            </div>
                            @error('logo')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="edu-center-field-group">
                        <label for="name" class="edu-center-label edu-center-required">Nomi</label>
                        <input type="text" name="name" id="name" class="edu-center-input" required
                            value="{{ old('name') }}" placeholder="O'quv markaz nomini kiriting">
                        @error('name')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="edu-center-field-group">
                        <label for="images" class="edu-center-label">Markaz rasimlari</label>
                        <div class="edu-center-file-wrapper">
                            <input type="file" name="images[]" id="images" class="edu-center-file-input"
                                accept="image/*" multiple>
                            <div class="edu-center-file-display">
                                <svg class="edu-center-upload-icon" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path
                                        d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                    <circle cx="12" cy="13" r="3" />
                                </svg>
                                <span class="edu-center-upload-text">Markaz rasimlarini yuklash</span>
                            </div>
                            @error('images.*')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="edu-center-field-group">
                        <label for="type" class="edu-center-label">Turi</label>
                        {{-- <input type="text" name="type" id="type" class="edu-center-input"
                            placeholder="Masalan: IT, Til o'rgatish, O'quv markazi ..."> --}}
                        <select name="type" id="type" class="edu-center-input">
                            <option value="" disabled selected>Markaz turini tanlang ...</option>
                            <option value="O'quv markaz">O'quv markaz</option>
                            <option value="Akademiya">Akademiya</option>
                            <option value="Kollej">Kollej</option>
                            <option value="Unversitet">Unversitet</option>
                        </select>
                        @error('type')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="edu-center-field-group">
                        <label for="about" class="edu-center-label">Haqida</label>
                        <textarea name="about" id="about" class="edu-center-textarea"
                            placeholder="O'quv markaz haqida qisqacha ma'lumot..." rows="4">{{ old('about') }}</textarea>
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
                                <option value="{{ old('province') }}" selected>
                                    {{ old('province') }}</option>
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
                                <option value="{{ old('region') }}" selected>
                                    {{ old('region') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Manzil -->
                    <div class="edu-center-field-group">
                        <label for="address" class="edu-center-label">Manzil</label>
                        <input type="text" name="address" id="address" class="edu-center-input"
                            {{ old('address') }} placeholder="To'liq manzilni kiriting">
                        @error('address')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- URL -->
                    <div class="edu-center-field-group edu-center-full">
                        <label for="location" class="edu-center-label">URL</label>
                        <input name="location" id="location" type="text" class="edu-center-input"
                            {{ old('location') }} placeholder="Manzil URL avtomatik yoziladi">
                        @error('location')
                            <div style="color: red">{{ $message }}</div>
                        @enderror

                        <!-- yashirin inputlar -->
                        <input type="hidden" id="latitude">
                        <input type="hidden" id="longitude">
                    </div>

                    <div class="edu-center-field-group edu-center-full">
                        <label for="location" class="edu-center-label">Markazning kunlik ochilish va yopilish
                            vaqtlarini kiriting.</label>
                    </div>

                    <div class="edu-center-field-group">
                        <label for="studentCount" class="edu-center-label">Hozirda markazingizdagi o'quvchilar
                            soni</label>
                        <input type="number" name="student_count" id="studentCount" class="edu-center-input"
                            value="{{ old('student_count') }}" placeholder="0" min="0">
                        @error('student_count')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="edu-center-field-group edu-center-full">
                        <label for="location" class="edu-center-label">Markazda qanday fanlardan dars beriladi</label>
                    </div>
                    <div id="subjects-wrapper">
                        <div class="edu-center-row">
                            <div class="edu-center-field-group edu-center-half">
                                <label class="edu-center-label">Fan</label>

                                <select name="subjects[0][id]" class="edu-center-input" required>
                                    <option value="" disabled selected>Fanni tanlang ...</option>
                                    @foreach ($subjects as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="edu-center-field-group edu-center-half">
                                <label class="edu-center-label">Narxi (oyiga)</label>
                                <input type="number" name="subjects[0][price]" class="edu-center-input"
                                    placeholder="Masalan: 1000000">
                                @error('subjects.0.price')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Yangi qator qo‘shish tugmasi -->
                    <button type="button" id="add-subject" class="edu-center-btn edu-center-btn-secondary">+ Fan
                        qo‘shish</button>


                    {{-- connection --}}


                    <div class="edu-center-field-group edu-center-full">
                        <label class="edu-center-label">Markazda mavjud ulanish turlari</label>
                    </div>

                    <div id="connections-wrapper">
                        <div class="edu-center-row">
                            <div class="edu-center-field-group edu-center-half">
                                <label class="edu-center-label">Ijtimoiy tarmoq</label>
                                <select name="connections[0][id]" class="edu-center-input" required>
                                    <option value="" disabled selected>Ijtimoiy tarmoqni tanlang ...</option>
                                    @foreach ($connections as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="edu-center-field-group edu-center-half">
                                <label class="edu-center-label">Manzili</label>
                                <input type="text" name="connections[0][url]" class="edu-center-input"
                                    placeholder="Masalan: https://t.me/username">
                                @error('connections.0.url')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Yangi qator qo‘shish tugmasi -->
                    <button type="button" id="add-connection" class="edu-center-btn edu-center-btn-secondary">
                        + Ijtimoiy tarmoq qo‘shish
                    </button>

                    <?php
                    $uzbekDays = [
                        1 => 'Dushanba',
                        2 => 'Seshanba',
                        3 => 'Chorshanba',
                        4 => 'Payshanba',
                        5 => 'Juma',
                        6 => 'Shanba',
                    ];
                    
                    ?>


                    <div class="edu-center  field-group edu-center-full">
                        <label for="location" class="edu-center-label">Markazning haftalik ish vaqti</label>
                    </div>
                    @for ($day = 0; $day < 6; $day++)
                        <div class="edu-center-row">
                            <div class="edu-center-field-group">
                                <div style="font-size: 20px" class="edu-center-label">
                                    {{ $uzbekDays[$day + 1] }}
                                </div>
                            </div>

                            <div class="edu-center-field-group">
                                <label class="edu-center-label">Ochilishi</label>
                                <input type="time" name="days[{{ $day }}][open_time]"
                                    class="edu-center-input" style="width: 100%;">
                                @error('days.' . $day . '.open_time')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="edu-center-field-group">
                                <label class="edu-center-label">Yopilishi</label>
                                <input type="time" name="days[{{ $day }}][close_time]"
                                    class="edu-center-input" style="width: 100%;">
                                @error('days.' . $day . '.close_time')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="days[{{ $day }}][calendar_id]"
                                value="{{ $day + 1 }}">
                        </div>
                    @endfor



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
                        <a href="{{ route('index') }}" type="button"
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


<style>
    .edu-center-row {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 15px;
    }

    .edu-center-half {
        width: 48%;
    }

    /* Mobilga moslash */
    @media (max-width: 768px) {
        .edu-center-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .edu-center-field-group {
            width: 100%;
        }
    }

    .edu-center-row {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 15px;
    }

    .edu-center-field-group {
        flex: 1;
    }

    /* 📱 Mobil ekranlar uchun (768px dan kichik) */
    @media (max-width: 768px) {
        .edu-center-row {
            flex-direction: column;
            /* ustma-ust bo‘ladi */
            align-items: flex-start;
            gap: 10px;
        }

        .edu-center-field-group {
            width: 100%;
        }

        .edu-center-label {
            font-size: 16px;
        }
    }
</style>


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

    let map, geocoder, marker;

    function initMap() {
        const defaultCenter = {
            lat: {{ old('latitude') ?? 41.2995 }},
            lng: {{ old('longitude') ?? 69.2401 }}
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

    let subjectIndex = 1; // index 0 band bo‘ldi

    document.getElementById('add-subject').addEventListener('click', function() {
        let wrapper = document.getElementById('subjects-wrapper');

        let newRow = document.createElement('div');
        newRow.classList.add('edu-center-row');
        newRow.innerHTML = `
                                <div class="edu-center-field-group edu-center-half">
                                    <label class="edu-center-label">Fan</label>
                                    <select name="subjects[${subjectIndex}][id]" class="edu-center-input" required>
                                        <option value="" disabled selected>Fanni tanlang ...</option>
                                        @foreach ($subjects as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="edu-center-field-group edu-center-half">
                                    <label class="edu-center-label">Narxi (oyiga)</label>
                                    <input type="text" name="subjects[${subjectIndex}][price]" class="edu-center-input" placeholder="Masalan: 1000000">
                                    @error('subjects.${subjectIndex}.price')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            `;

        wrapper.appendChild(newRow);
        subjectIndex++;
    });

    let connectionIndex = 1; // index 0 band

    document.getElementById('add-connection').addEventListener('click', function() {
        let wrapper = document.getElementById('connections-wrapper');

        let newRow = document.createElement('div');
        newRow.classList.add('edu-center-row');
        newRow.innerHTML = `
                                <div class="edu-center-field-group edu-center-half">
                                    <label class="edu-center-label">Ijtimoiy tarmoq</label>
                                    <select name="connections[${connectionIndex}][id]" class="edu-center-input" required>
                                        <option value="" disabled selected>Ijtimoiy tarmoqni tanlang ...</option>
                                        @foreach ($connections as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="edu-center-field-group edu-center-half">
                                    <label class="edu-center-label">Manzili</label>
                                    <input type="text" name="connections[${connectionIndex}][url]" class="edu-center-input"
                                        placeholder="Masalan: https://t.me/username">
                                    @error('connections.${connectionIndex}.url')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            `;

        wrapper.appendChild(newRow);
        connectionIndex++;
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap" async
    defer></script>
