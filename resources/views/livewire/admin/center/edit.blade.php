<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.centers') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">O'quv markazini tahrirlash</h2>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form wire:submit="update" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                    <input wire:model="logoFile" type="file" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('logoFile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    
                    <!-- Preview: new file or existing logo -->
                    <div class="mt-3 flex items-center space-x-4">
                        @if($logoFile)
                            <!-- New file preview -->
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Yangi logo:</p>
                                <img src="{{ $logoFile->temporaryUrl() }}" alt="New Logo" class="h-16 w-16 object-cover rounded-lg border">
                            </div>
                        @elseif($form['logo'])
                            <!-- Existing logo -->
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Joriy logo:</p>
                                <img src="{{ asset('storage/' . $form['logo']) }}" alt="Current Logo" class="h-16 w-16 object-cover rounded-lg border">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Name -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomi *</label>
                    <input wire:model="form.name" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Turi *</label>
                    <select wire:model="form.type" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="O'quv markaz">O'quv markaz</option>
                        <option value="Kurs">Kurs</option>
                        <option value="Trening">Trening</option>
                        <option value="Maktab">Maktab</option>
                        <option value="Universitet">Universitet</option>
                    </select>
                    @error('form.type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select wire:model="form.status" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('form.status') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Country -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mamlakat *</label>
                    <input wire:model="form.country" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.country') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Province -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Viloyat *</label>
                    <input wire:model="form.province" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.province') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tuman *</label>
                    <input wire:model="form.region" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.region') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Manzil *</label>
                    <input wire:model="form.address" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Location Section with Map -->
                <div class="col-span-2 border-t border-gray-200 pt-6 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Joylashuv ma'lumotlari
                    </h3>

                    <!-- Map Container -->
                    <div class="relative mb-4" id="map-wrapper" wire:ignore>
                        <!-- Search Bar -->
                        <div class="absolute top-3 left-20 right-20 z-[1000]">
                            <div class="relative flex items-center">
                                <svg class="absolute left-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" id="map-search" 
                                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 text-sm shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Shahar, ko'cha yoki mo'ljalni kiriting..."
                                    onkeydown="if(event.key==='Enter'){event.preventDefault();searchLocation();}">
                            </div>
                            <div id="search-results" class="absolute top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-xl border border-gray-200 max-h-48 overflow-y-auto hidden z-[1001]"></div>
                        </div>
                        
                        <!-- Current location button -->
                        <div class="absolute bottom-3 right-3 z-[1000]">
                            <button type="button" onclick="getCurrentLocation()"
                                class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110 border-2 border-white"
                                title="Mening joylashuvim">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Loading Overlay -->
                        <div id="map-loading" class="absolute inset-0 bg-white/80 rounded-xl z-20 hidden flex items-center justify-center">
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-sm">Yuklanmoqda...</span>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="h-80 rounded-xl overflow-hidden shadow-inner border border-gray-200">
                            <div id="map" class="w-full h-full"></div>
                        </div>
                        
                        <!-- Coordinates Display -->
                        <div class="absolute bottom-3 left-3 z-10 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1.5 text-xs text-gray-600 border border-gray-200">
                            <span id="coords-display">39.6542, 66.9757</span>
                        </div>
                    </div>

                    <!-- Address Display -->
                    <div id="address-display" class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4 hidden">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-green-800">Tanlangan manzil:</p>
                                <p id="selected-address-text" class="text-sm text-green-700 mt-1">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Location (Hidden) -->
                    <input type="hidden" wire:model="form.location" id="location">
                </div>

                <!-- Student Count -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">O'quvchilar soni</label>
                    <input wire:model="form.student_count" type="number" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.student_count') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reyting (0-5)</label>
                    <input wire:model="form.rating" type="number" step="0.1" min="0" max="5"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.rating') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- TIN (STIR) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">STIR raqami</label>
                    <input wire:model="form.tin" type="number" maxlength="20"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.tin') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- License Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Litsenziya raqami</label>
                    <input wire:model="form.license_number" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.license_number') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- License Registration Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Litsenziya berilgan sana</label>
                    <input wire:model="form.license_registration_date" type="date" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.license_registration_date') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- License Validity Period -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Litsenziya amal qilish muddati</label>
                    <input wire:model="form.license_validity_period" type="date" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.license_validity_period') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Manager Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rahbar F.I.Sh.</label>
                    <input wire:model="form.manager_name" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.manager_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefon raqami (markaz)</label>
                    <input wire:model="form.phone_number" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.phone_number') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input wire:model="form.email" type="email" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- IFUT Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">IFUT kodi</label>
                    <input wire:model="form.ifut_code" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.ifut_code') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Territory -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nazorat bo'limi (Hudud)</label>
                    <input wire:model="form.territory" type="text" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.territory') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Legal Address -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Yuridik manzil</label>
                    <textarea wire:model="form.legal_address" rows="3" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    @error('form.legal_address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- User -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foydalanuvchi (Egasi) *</label>
                    <select wire:model="form.users_id" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Tanlang...</option>
                        @foreach($users as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('form.users_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- About -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tavsif (About) *</label>
                    <textarea wire:model="form.about" rows="4" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    @error('form.about') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Premium Until -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Premium muddati</label>
                    <input wire:model="form.premium_until" type="date" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('form.premium_until') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Checkboxes -->
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input wire:model="form.checked" type="checkbox" 
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Tasdiqlangan</span>
                    </label>
                    <label class="flex items-center">
                        <input wire:model="form.premium" type="checkbox" 
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Premium</span>
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.centers') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Bekor qilish
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Yangilash
                </button>
            </div>
        </form>

        <!-- Leaflet CSS & JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
    let map, marker;
    const DEFAULT_LAT = 39.6542;
    const DEFAULT_LNG = 66.9757;

    function initMap() {
        // Parse existing location if available
        let centerLat = DEFAULT_LAT;
        let centerLng = DEFAULT_LNG;
        let zoom = 13;
        
        const existingLocation = document.getElementById('location').value;
        if (existingLocation) {
            const parts = existingLocation.split(',');
            if (parts.length === 2) {
                centerLat = parseFloat(parts[0].trim()) || DEFAULT_LAT;
                centerLng = parseFloat(parts[1].trim()) || DEFAULT_LNG;
                zoom = 15;
            }
        }
        
        const center = [centerLat, centerLng];
        
        map = L.map('map').setView(center, zoom);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        const customIcon = L.divIcon({
            html: `
                <div style="position:absolute;width:40px;height:40px;background:rgba(59,130,246,0.4);border-radius:50%;animation:pulse 2s ease-out infinite;transform:translate(-50%,-50%);left:50%;top:50%;"></div>
                <div style="position:absolute;width:32px;height:32px;background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);border-radius:50% 50% 50% 0;border:3px solid white;box-shadow:0 4px 12px rgba(37,99,235,0.4);transform:rotate(-45deg);left:50%;top:50%;margin-left:-16px;margin-top:-28px;display:flex;align-items:center;justify-content:center;z-index:2;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" style="transform:rotate(45deg);">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <style>@keyframes pulse{0%{transform:translate(-50%,-50%) scale(0.5);opacity:1}100%{transform:translate(-50%,-50%) scale(1.5);opacity:0}}</style>
            `,
            iconSize: [40, 48],
            iconAnchor: [20, 40],
            className: 'custom-marker-container'
        });

        marker = L.marker(center, { icon: customIcon, draggable: true }).addTo(map);
        
        marker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            updateCoordinates(pos.lat, pos.lng);
        });
        
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoordinates(e.latlng.lat, e.latlng.lng);
        });
        
        // Update coordinates display
        document.getElementById('coords-display').textContent = `${centerLat.toFixed(4)}, ${centerLng.toFixed(4)}`;
    }

    async function updateCoordinates(lat, lng) {
        document.getElementById('location').value = `${lat},${lng}`;
        @this.set('form.location', `${lat},${lng}`);
        document.getElementById('coords-display').textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
        
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=uz`);
            const data = await response.json();
            
            if (data && data.display_name) {
                document.getElementById('address-display').classList.remove('hidden');
                document.getElementById('selected-address-text').textContent = data.display_name;
            }
        } catch (e) {
            console.error('Reverse geocoding error:', e);
        }
    }

    async function searchLocation() {
        const query = document.getElementById('map-search').value.trim();
        if (!query) return;
        
        showMapLoading(true);
        
        try {
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Uzbekistan')}&limit=5&countrycodes=uz`;
            const response = await fetch(url);
            const data = await response.json();
            
            showMapLoading(false);
            
            if (data && data.length > 0) {
                if (data.length === 1) {
                    const result = data[0];
                    const lat = parseFloat(result.lat);
                    const lon = parseFloat(result.lon);
                    map.setView([lat, lon], 16);
                    marker.setLatLng([lat, lon]);
                    updateCoordinates(lat, lon);
                } else {
                    showSearchResults(data);
                }
            }
        } catch (e) {
            showMapLoading(false);
            console.error('Search error:', e);
        }
    }

    function showSearchResults(results) {
        const dropdown = document.getElementById('search-results');
        dropdown.innerHTML = '';
        
        results.forEach(result => {
            const item = document.createElement('div');
            item.className = 'px-4 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0';
            item.innerHTML = `
                <div class="font-medium text-sm text-gray-900">${result.display_name.split(',')[0]}</div>
                <div class="text-xs text-gray-500 truncate">${result.display_name}</div>
            `;
            item.onclick = () => {
                const lat = parseFloat(result.lat);
                const lon = parseFloat(result.lon);
                map.setView([lat, lon], 16);
                marker.setLatLng([lat, lon]);
                updateCoordinates(lat, lon);
                document.getElementById('map-search').value = result.display_name.split(',')[0];
                dropdown.classList.add('hidden');
            };
            dropdown.appendChild(item);
        });
        
        dropdown.classList.remove('hidden');
        setTimeout(() => {
            document.addEventListener('click', closeSearchResults, { once: true });
        }, 100);
    }

    function closeSearchResults(e) {
        if (!e.target.closest('#search-results') && !e.target.closest('#map-search')) {
            document.getElementById('search-results').classList.add('hidden');
        }
    }

    function getCurrentLocation() {
        if (!navigator.geolocation) {
            alert('Brauzer geolokatsiyani qo\'llab-quvvatlamaydi');
            return;
        }
        
        showMapLoading(true);
        
        navigator.geolocation.getCurrentPosition(
            pos => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                updateCoordinates(lat, lng);
                showMapLoading(false);
            },
            err => {
                showMapLoading(false);
                alert('Joylashuvni aniqlash mumkin emas');
            },
            { timeout: 10000, enableHighAccuracy: true }
        );
    }

    function showMapLoading(show) {
        const loading = document.getElementById('map-loading');
        if (show) loading.classList.remove('hidden');
        else loading.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
</script>
