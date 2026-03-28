#!/usr/bin/env python3
"""
OSM - Kichikroq hudud bilan ma'lumot yig'ish
"""

import os
import json
import time
import requests
from datetime import datetime

# ═══════════════════════════════════════════════════════
#  KONFIGURATSIYA
# ═══════════════════════════════════════════════════════
OUTPUT_DIR = "data"

# Yirik shaharlarning koordinatalari (kichik radius)
MAJOR_CITIES = [
    {"name": "Toshkent", "lat": 41.2995, "lng": 69.2401, "radius": 0.15},
    {"name": "Samarqand", "lat": 39.6553, "lng": 66.9597, "radius": 0.15},
    {"name": "Buxoro", "lat": 39.7747, "lng": 64.4286, "radius": 0.15},
    {"name": "Namangan", "lat": 41.0011, "lng": 71.6728, "radius": 0.15},
    {"name": "Andijon", "lat": 40.7821, "lng": 72.3442, "radius": 0.15},
    {"name": "Farg'ona", "lat": 40.3834, "lng": 71.7814, "radius": 0.15},
    {"name": "Qarshi", "lat": 38.8610, "lng": 65.7883, "radius": 0.15},
    {"name": "Nukus", "lat": 42.4600, "lng": 59.6100, "radius": 0.15},
    {"name": "Guliston", "lat": 40.4897, "lng": 68.7842, "radius": 0.15},
    {"name": "Termiz", "lat": 37.2240, "lng": 67.2783, "radius": 0.15},
]

# ═══════════════════════════════════════════════════════
#  OSM API FUNKSIYALARI
# ═══════════════════════════════════════════════════════

def get_osm_data_for_city(city):
    """Bir shahar uchun OSM dan ma'lumot olish"""
    lat, lon = city["lat"], city["lng"]
    radius = city["radius"]
    
    # Bounding box hisoblash
    min_lat = lat - radius
    max_lat = lat + radius
    min_lon = lon - radius
    max_lon = lon + radius
    
    # Overpass API query - to'g'ri format
    query = f'[out:json][timeout:25];(node["amenity"~"school|university|college|kindergarten"]({min_lat},{min_lon},{max_lat},{max_lon});way["amenity"~"school|university|college|kindergarten"]({min_lat},{min_lon},{max_lat},{max_lon});node["education"~"school|university|college|language_school"]({min_lat},{min_lon},{max_lat},{max_lon});way["education"~"school|university|college|language_school"]({min_lat},{min_lon},{max_lat},{max_lon}););(._;>;);out body;'
    
    url = "https://overpass-api.de/api/interpreter"
    
    try:
        print(f"   📡 {city['name']} uchun so'rov yuborilmoqda...")
        response = requests.post(url, data=query, timeout=30)
        
        if response.status_code == 200:
            data = response.json()
            return data.get("elements", [])
        else:
            print(f"   ❌ {city['name']}: HTTP {response.status_code}")
            return []
            
    except Exception as e:
        print(f"   ❌ {city['name']}: {e}")
        return []

def classify_education_type(tags, name):
    """Ta'lim muassasasini klassifikatsiya qilish"""
    name_lower = name.lower() if name else ""
    
    # Universitetlar
    if any(word in name_lower for word in ["university", "universitet", "institute", "institut"]):
        return "Universitet"
    
    # Kollejlar va litseylar
    if any(word in name_lower for word in ["college", "kollej", "lycée", "litsey"]):
        return "Kollej/Litsey"
    
    # Maktablar
    if any(word in name_lower for word in ["school", "maktab"]):
        return "Maktab"
    
    # O'quv markazlari
    if any(word in name_lower for word in ["center", "markaz", "kurs", "training", "education", "ta'lim"]):
        return "O'quv markazi"
    
    # Til maktablari
    if any(word in name_lower for word in ["language", "til", "english", "russian"]):
        return "Til maktabi"
    
    # Bolalar bog'chalari
    if tags.get("amenity") == "kindergarten" or "kindergarten" in name_lower:
        return "Bolalar bog'chasi"
    
    return "Boshqa ta'lim muassasasi"

def build_center_from_element(element, city_name):
    """OSM elementidan o'quv markazi ma'lumotlarini yaratish"""
    tags = element.get("tags", {})
    name = tags.get("name", "Noma'lum")
    
    # Koordinatalar
    if element.get("type") == "node":
        lat = element.get("lat")
        lon = element.get("lon")
    elif element.get("type") == "way":
        center = element.get("center", {})
        lat = center.get("lat")
        lon = center.get("lon")
    else:
        return None
    
    if not lat or not lon:
        return None
    
    # Turi
    education_type = classify_education_type(tags, name)
    
    return {
        "name": name,
        "type": education_type,
        "address": f"{city_name}, O'zbekiston",
        "country": "uzbekistan",
        "province": city_name,
        "region": city_name,
        "location": f"{lat},{lon}",
        
        # OSM ma'lumotlari
        "osm_id": element.get("id"),
        "osm_type": element.get("type"),
        "osm_tags": tags,
        
        # Kontakt ma'lumotlari
        "phone": tags.get("phone", ""),
        "website": tags.get("website", ""),
        "email": tags.get("email", ""),
        
        # Qo'shimcha ma'lumotlar
        "opening_hours": tags.get("opening_hours", ""),
        "wheelchair": tags.get("wheelchair", ""),
        
        # Bog'liq jadvallar (bo'sh)
        "images": [],
        "working_hours": [],
        "connections": [],
        "reviews": [],
        "about": None,
        "logo": None,
        "rating": None,
        "ratings_total": 0,
        "price_level": None,
        "open_now": None,
        "weekday_texts": [],
        "google_types": [],
    }

def collect_major_cities_education():
    """Yirik shaharlardagi ta'lim muassasalarini yig'ish"""
    print("🌍 O'zbekiston yirik shaharlari (OSM)")
    print(f"   📍 {len(MAJOR_CITIES)} ta shahar")
    print(f"   🔍 Faqat asosiy ta'lim muassasalari")
    print()
    
    all_centers = []
    duplicates = set()
    
    for i, city in enumerate(MAJOR_CITIES, 1):
        city_name = city["name"]
        print(f"📍 [{i:2}/{len(MAJOR_CITIES)}] {city_name}  ", end="", flush=True)
        
        # OSM dan ma'lumot olish
        elements = get_osm_data_for_city(city)
        
        if not elements:
            print(" → ❌ Ma'lumot yo'q")
            continue
        
        # Elementlarni qayta ishlash
        city_centers = []
        for element in elements:
            center = build_center_from_element(element, city_name)
            if center:
                # Dublikatlarni olib tashlash
                name_key = center["name"].lower().strip()
                if name_key not in duplicates:
                    city_centers.append(center)
                    duplicates.add(name_key)
        
        all_centers.extend(city_centers)
        print(f" → ✅ {len(city_centers):3} ta | Jami: {len(all_centers):4}")
        
        # Kichik pauza (serverni yuklamaslik uchun)
        time.sleep(1)
    
    return all_centers

def main():
    print("╔" + "═"*58 + "╗")
    print("║  O'ZBEKISTON O'QUV MARKAZLARI - OSM (Yirik shaharlar) ║")
    print("║  OpenStreetMap orqali bepul qidiruv               ║")
    print("╚" + "═"*58 + "╝")
    print()
    
    os.makedirs(OUTPUT_DIR, exist_ok=True)
    
    start_time = time.time()
    
    # Ma'lumot yig'ish
    print("🚀 Boshlanmoqda...")
    centers = collect_major_cities_education()
    
    if not centers:
        print("\n❌ Hech qanday ma'lumot topilmadi!")
        return
    
    print(f"\n✅ {len(centers)} ta ta'lim muassasasi topildi")
    
    # JSON ga yozish
    print("💾 JSON faylga saqlanmoqda...")
    outfile = os.path.join(OUTPUT_DIR, "uzbekistan_major_cities_osm.json")
    payload = {
        "generated_at": datetime.now().isoformat(),
        "country": "uzbekistan",
        "country_name": "O'zbekiston",
        "total": len(centers),
        "source": "OpenStreetMap - Major Cities",
        "search_type": "major_cities_education",
        "cities_searched": len(MAJOR_CITIES),
        "cities": [city["name"] for city in MAJOR_CITIES],
        "centers": centers,
    }
    
    with open(outfile, "w", encoding="utf-8") as f:
        json.dump(payload, f, ensure_ascii=False, indent=2)
    
    elapsed = time.time() - start_time
    mins = int(elapsed // 60)
    secs = int(elapsed % 60)
    
    print(f"\n\n{'═'*60}")
    print(f"  YAKUNIY HISOBOT  ({mins}:{secs:02d} daqiqa)")
    print(f"{'═'*60}")
    print(f"  📊 Jami ta'lim muassasalari: {len(centers):,}")
    print(f"  📄 Saqlangan fayl: {outfile}")
    print(f"  💰 Xarajat: 0$ (Bepul!)")
    print(f"{'═'*60}")
    
    # Tahlil
    print("\n📊 Ta'lim muassasalari turlari bo'yicha tahlil...")
    types_count = {}
    for center in centers:
        t = center["type"]
        types_count[t] = types_count.get(t, 0) + 1
    
    for t, count in sorted(types_count.items(), key=lambda x: x[1], reverse=True):
        percentage = (count / len(centers)) * 100
        print(f"   📚 {t:<25}: {count:>4} ta ({percentage:.1f}%)")
    
    print(f"\n🎉 Jami {len(centers)} ta ta'lim muassasasi muvaffaqiyatli yig'ildi!")
    print(f"📄 To'liq ma'lumot: {outfile}")

if __name__ == "__main__":
    main()
