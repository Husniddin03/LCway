#!/usr/bin/env python3
"""
API kalitsiz o'quv markazlarini yig'ish - OpenStreetMap orqali
"""

import os
import json
import time
import requests
from datetime import datetime
import overpy

# ═══════════════════════════════════════════════════════
#  KONFIGURATSIYA
# ═══════════════════════════════════════════════════════
OUTPUT_DIR = "data"

# O'zbekiston koordinatalari
UZBEKISTAN_BBOX = {
    "min_lat": 37.0,
    "min_lon": 58.0,
    "max_lat": 45.0,
    "max_lon": 75.0
}

# O'quv markazlari uchun OSM taglari
EDUCATION_TAGS = {
    "amenity": ["school", "university", "college", "kindergarten"],
    "education": ["school", "university", "college", "language_school"],
    "shop": ["books"],
    "office": ["educational_institution"],
    "leisure": ["education"],
    "building": ["school", "university", "college"],
    "tourism": ["information"],
    "social_facility": ["education"]
}

# ═══════════════════════════════════════════════════════
#  OSM API FUNKSIYALARI
# ═══════════════════════════════════════════════════════

def get_osm_data(bbox, tags):
    """OSM dan ma'lumot olish"""
    api = overpy.Overpass()
    
    # Overpass query yaratish
    query_parts = []
    for key, values in tags.items():
        for value in values:
            query_parts.append(f'node["{key}"="{value}"]({bbox["min_lat"]},{bbox["min_lon"]},{bbox["max_lat"]},{bbox["max_lon"]});')
            query_parts.append(f'way["{key}"="{value}"]({bbox["min_lat"]},{bbox["min_lon"]},{bbox["max_lat"]},{bbox["max_lon"]});')
            query_parts.append(f'relation["{key}"="{value}"]({bbox["min_lat"]},{bbox["min_lon"]},{bbox["max_lat"]},{bbox["max_lon"]});')
    
    query = "\n".join(query_parts) + "\n(._;>;);\nout body;"
    
    try:
        result = api.query(query)
        return result
    except Exception as e:
        print(f"OSM API xatosi: {e}")
        return None

def get_address_from_coords(lat, lon):
    """Nominatim orqali manzil olish"""
    url = f"https://nominatim.openstreetmap.org/reverse"
    params = {
        "format": "json",
        "lat": lat,
        "lon": lon,
        "accept-language": "uz"
    }
    
    try:
        response = requests.get(url, params=params, timeout=10)
        if response.status_code == 200:
            data = response.json()
            return data.get("address", {})
    except Exception as e:
        print(f"Nominatim xatosi: {e}")
    
    return {}

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

def build_center_from_osm(element):
    """OSM elementidan o'quv markazi ma'lumotlarini yaratish"""
    tags = element.tags
    name = tags.get("name", "Noma'lum")
    
    # Koordinatalar
    if hasattr(element, "lat"):
        lat, lon = element.lat, element.lon
    elif hasattr(element, "center_lat"):
        lat, lon = element.center_lat, element.center_lon
    else:
        return None
    
    # Manzilni olish
    address = get_address_from_coords(lat, lon)
    
    # Turi
    education_type = classify_education_type(tags, name)
    
    return {
        "name": name,
        "type": education_type,
        "address": address.get("display_name", ""),
        "country": "uzbekistan",
        "province": address.get("state", ""),
        "region": address.get("city", address.get("town", address.get("village", ""))),
        "location": f"{lat},{lon}",
        
        # OSM ma'lumotlari
        "osm_id": element.id,
        "osm_type": element.__class__.__name__.lower(),
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

def collect_uzbekistan_education():
    """O'zbekistondagi barcha ta'lim muassasalarini yig'ish"""
    print("🌍 O'zbekistondagi ta'lim muassasalari (OSM)")
    print(f"   📍 BBOX: {UZBEKISTAN_BBOX}")
    print(f"   🏷️  {len(EDUCATION_TAGS)} ta tag kategoriya")
    print()
    
    # OSM dan ma'lumot olish
    print("📥 OSM dan ma'lumot yuklanmoqda...")
    print("   ⏳ Overpass API so'rovi yuborilmoqda...")
    
    osm_result = get_osm_data(UZBEKISTAN_BBOX, EDUCATION_TAGS)
    
    if not osm_result:
        print("❌ OSM dan ma'lumot olishning iloji bo'lmadi!")
        return []
    
    # Barcha elementlarni yig'ish
    all_elements = []
    all_elements.extend(osm_result.nodes)
    all_elements.extend(osm_result.ways)
    all_elements.extend(osm_result.relations)
    
    print(f"✅ {len(all_elements)} ta element topildi")
    print()
    print("🔄 Ma'lumotlar qayta ishlanmoqda...")
    
    # O'quv markazlarini qayta ishlash
    centers = []
    duplicates = set()
    processed_count = 0
    
    for i, element in enumerate(all_elements, 1):
        center = build_center_from_osm(element)
        if center:
            # Dublikatlarni olib tashlash (nomaga qarab)
            name_key = center["name"].lower().strip()
            if name_key not in duplicates:
                centers.append(center)
                duplicates.add(name_key)
                processed_count += 1
                
                # Progress indicator - har 50 tasidan
                if i % 50 == 0:
                    progress = (i / len(all_elements)) * 100
                    print(f"   📊 Progress: {progress:.1f}% ({i:4}/{len(all_elements)}) | ✅ Topildi: {processed_count}")
                
                # Birinchi 10 ta uchun detail ko'rsatish
                if processed_count <= 10:
                    print(f"   ✅ {processed_count:2}. {center['name'][:50]} ({center['type']})")
    
    print(f"\n🔍 Dublikatlar olib tashlandi: {len(all_elements) - processed_count} ta")
    print(f"📊 Yakuniy natija: {processed_count} ta ta'lim muassasi")
    
    return centers

def main():
    print("╔" + "═"*58 + "╗")
    print("║  O'ZBEKISTON O'QUV MARKAZLARI - OSM (API kalitsiz)  ║")
    print("║  OpenStreetMap orqali bepul qidiruv               ║")
    print("╚" + "═"*58 + "╝")
    print()
    
    os.makedirs(OUTPUT_DIR, exist_ok=True)
    
    start_time = time.time()
    
    # Ma'lumot yig'ish
    print("🚀 Boshlanmoqda...")
    centers = collect_uzbekistan_education()
    
    if not centers:
        print("\n❌ Hech qanday ma'lumot topilmadi!")
        return
    
    print(f"\n✅ {len(centers)} ta ta'lim muassasasi topildi")
    
    # JSON ga yozish
    print("💾 JSON faylga saqlanmoqda...")
    outfile = os.path.join(OUTPUT_DIR, "uzbekistan_osm_education.json")
    payload = {
        "generated_at": datetime.now().isoformat(),
        "country": "uzbekistan",
        "country_name": "O'zbekiston",
        "total": len(centers),
        "source": "OpenStreetMap (API kalitsiz)",
        "search_type": "all_education_institutions",
        "bbox": UZBEKISTAN_BBOX,
        "tags_used": EDUCATION_TAGS,
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
