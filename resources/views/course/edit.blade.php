<x-layout>
    <x-slot:title>O'quv markazni tahrirlash</x-slot:title>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $center->name }} markazini tahrirlash
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    O'quv markaz ma'lumotlarini yangilang
                </p>
            </div>
            <!-- Form Card -->
            <x-card class="mb-8">
                <form action="{{ route('course.update', $center->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div
                            class="bg-danger-50 dark:bg-danger-900/20 border border-danger-200 dark:border-danger-800 rounded-xl p-4 mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-danger-600 dark:text-danger-400 mr-3 flex-shrink-0 mt-0.5"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 0116 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 2v4a1 1 0 102-2h-1zm-2 0a2 2 0 00-2 2v4a2 2 0 002 2h1A2 2 0 002 2v-4a2 2 0 00-2-2h-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-danger-800 dark:text-danger-200">Iltimos,
                                        xatolarni to'g'rilang:</h4>
                                    <ul class="mt-2 text-sm text-danger-700 dark:text-danger-300 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Current Logo -->
                    @isset($center->logo)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mavjud Logo
                            </label>
                            <div class="w-32 h-32 rounded-xl overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                <img src="{{ asset('storage/' . $center->logo) }}" alt="Current logo"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endisset

                    <!-- Logo Upload -->
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Yangi Logo
                        </label>
                        <div
                            class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 transition-colors cursor-pointer">
                            <input type="file" name="logo" id="logo" class="hidden" accept="image/*"
                                onchange="document.getElementById('logo-preview').src = window.URL.createObjectURL(this.files[0])">
                            <div id="logo-preview"
                                class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                    <circle cx="12" cy="13" r="3" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Yangi logo yuklash uchun bosing
                            </p>
                        </div>
                        @error('logo')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomi <span class="text-danger-500">*</span>
                            </label>
                            <x-input type="text" name="name" id="name" value="{{ $center->name }}"
                                placeholder="O'quv markaz nomini kiriting" required />
                            @error('name')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Turi
                            </label>
                            <x-input type="text" name="type" id="type" value="{{ $center->type }}"
                                placeholder="Masalan: IT, Til o'rgatish, O'quv markazi" />
                            @error('type')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- About -->
                        <div class="lg:col-span-2">
                            <label for="about"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Haqida
                            </label>
                            <textarea name="about" id="about" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white resize-none"
                                placeholder="O'quv markaz haqida qisqacha ma'lumot...">{{ $center->about }}</textarea>
                            @error('about')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Manzil ma'lumotlari</h3>

                        <!-- Map -->
                        <div class="h-96 bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden">
                            <div id="map" class="w-full h-full"></div>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <p>Xaritadan manzilni tanlasangiz Viloyat, Tuman, manzil va manzil URL'i avtomatik
                                to'ldiriladi. Agarda xato bo'lsa, o'zgartirishingiz mumkin.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Region -->
                            <div>
                                <label for="region"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Viloyat <span class="text-danger-500">*</span>
                                </label>
                                <select name="province" id="region"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white"
                                    required>
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
                                    <option value="Farg'ona">Farg'ona</option>
                                    <option value="Qoraqalpog'iston">Qoraqalpog'iston</option>
                                </select>
                            </div>

                            <!-- District -->
                            <div>
                                <label for="district"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tuman <span class="text-danger-500">*</span>
                                </label>
                                <select name="region" id="district"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-800 dark:text-white"
                                    required>
                                    <option value="{{ $center->region }}" selected>{{ $center->region }}</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Manzil <span class="text-danger-500">*</span>
                                </label>
                                <x-input type="text" name="address" id="address"
                                    value="{{ $center->address }}" placeholder="To'liq manzilni kiriting" required />
                                @error('address')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location URL -->
                            <div class="md:col-span-2">
                                <label for="location"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    URL
                                </label>
                                <x-input type="text" name="location" id="location"
                                    value="{{ $center->location }}" placeholder="Manzil URL avtomatik yoziladi" />
                                @error('location')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden location fields -->
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>

                    <!-- Student Count -->
                    <div>
                        <label for="studentCount"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Hozirda markazingizdagi o'quvchilar soni
                        </label>
                        <x-input type="number" name="student_count" id="studentCount"
                            value="{{ $center->student_count }}" placeholder="0" min="0" />
                        @error('student_count')
                            <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit"
                            class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17,21 17,13 7,13 7,21" />
                                <polyline points="7,3 7,8 15,8" />
                            </svg>
                            Saqlash
                        </button>
                        <a href="{{ route('blog-single', $center->id) }}"
                            class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-3 px-6 rounded-xl transition-all duration-300 text-center">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Bekor qilish
                        </a>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

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
                lat: {{ $location[0] }},
                lng: {{ $location[1] }}
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

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer>
    </script>

</x-layout>
