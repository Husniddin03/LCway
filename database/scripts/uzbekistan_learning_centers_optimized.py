#!/usr/bin/env python3
"""
Optimized version - O'zbekistondagi o'quv markazlarini tez samaradorlikda yig'ish
"""

import os
import time
import json
import requests
from datetime import datetime

# ═══════════════════════════════════════════════════════
#  API KALIT
# ═══════════════════════════════════════════════════════
API_KEY = "AIzaSyDWnRvtEeIQpCNX4v8grqnOiyi8ZNw4oz4"
OUTPUT_DIR = "data"
RADIUS = 15000  # 15 km radius - kattaroq radius kamroq shahar uchun

BASE = "https://maps.googleapis.com/maps/api/place"

# ═══════════════════════════════════════════════════════
#  ASOSIY SHAHARLAR (faqat yirik shaharlar)
# ═══════════════════════════════════════════════════════
MAJOR_CITIES = [
    {"name": "Toshkent", "lat": 41.2995, "lng": 69.2401, "priority": 1},
    {"name": "Samarqand", "lat": 39.6553, "lng": 66.9597, "priority": 2},
    {"name": "Buxoro", "lat": 39.7747, "lng": 64.4286, "priority": 2},
    {"name": "Namangan", "lat": 41.0011, "lng": 71.6728, "priority": 2},
    {"name": "Andijon", "lat": 40.7821, "lng": 72.3442, "priority": 2},
    {"name": "Farg'ona", "lat": 40.3834, "lng": 71.7814, "priority": 2},
    {"name": "Qarshi", "lat": 38.8610, "lng": 65.7883, "priority": 3},
    {"name": "Nukus", "lat": 42.4600, "lng": 59.6100, "priority": 3},
    {"name": "Guliston", "lat": 40.4897, "lng": 68.7842, "priority": 3},
    {"name": "Termiz", "lat": 37.2240, "lng": 67.2783, "priority": 3},
    {"name": "Navoiy", "lat": 40.1008, "lng": 65.3792, "priority": 3},
    {"name": "Urganch", "lat": 41.5500, "lng": 60.6333, "priority": 3},
    {"name": "Jizzax", "lat": 40.1158, "lng": 67.8422, "priority": 3},
    
    # Viloyat markazlari
    {"name": "Qo'qon", "lat": 40.7167, "lng": 70.9500, "priority": 4},
    {"name": "Marg'ilon", "lat": 40.4167, "lng": 71.6833, "priority": 4},
    {"name": "Angren", "lat": 41.0167, "lng": 70.1333, "priority": 4},
    {"name": "Chirchiq", "lat": 41.5333, "lng": 69.5833, "priority": 4},
    {"name": "Bekobod", "lat": 40.7833, "lng": 68.5333, "priority": 4},
    {"name": "Olmaliq", "lat": 40.7833, "lng": 69.6000, "priority": 4},
    {"name": "Denov", "lat": 38.2833, "lng": 67.8833, "priority": 4},
    {"name": "Qumqo'rg'on", "lat": 38.7667, "lng": 67.2167, "priority": 4},
    {"name": "Xiva", "lat": 41.3833, "lng": 60.3667, "priority": 4},
    {"name": "Beruniy", "lat": 42.1167, "lng": 59.8833, "priority": 4},
]

# ═══════════════════════════════════════════════════════
#  SAMARALI KALIT SO'ZLAR (faqat eng samaradorlari)
# ═══════════════════════════════════════════════════════
EFFICIENT_KEYWORDS = [
    # Asosiy atamalar - eng ko'p natija beradiganlar
    "o'quv markaz",
    "ta'lim markazi", 
    "kurs markazi",
    "learning center",
    "education center",
    "training center",
    
    # Til kurslari - juda mashhur
    "ingliz tili kursi",
    "english course",
    "rus tili kursi",
    
    # IT va dasturlash - zamonaviy va ko'p
    "it kurslari",
    "programming course",
    "dasturlash kursi",
    "kompyuter kurslari",
    
    # Maktabga tayyorlov - har doim talab
    "maktabga tayyorlov",
    "test sinovlari",
    "imtihonga tayyorlov",
    
    # Universitetga tayyorlov
    "DTM kursi",
    "universitetga tayyorlov",
    
    # Xorijiy tillar
    "IELTS kursi",
    "TOEFL kursi",
    "chet tiliga tayyorlov",
    
    # Qo'shimcha mashhur kurslar
    "matematika kursi",
    "repetitor markazi",
    "tutorial center",
    "online kurs",
    
    # Rus tilidagi asosiy atamalar
    "учебный центр",
    "курсы английского языка",
    "курсы программирования",
]

WEEKDAY = {
    0: "Yakshanba", 1: "Dushanba", 2: "Seshanba",
    3: "Chorshanba", 4: "Payshanba", 5: "Juma", 6: "Shanba",
}

# ═══════════════════════════════════════════════════════
#  API FUNKSIYALAR
# ═══════════════════════════════════════════════════════

def api_get(endpoint, params):
    params["key"] = API_KEY
    r = requests.get(f"{BASE}/{endpoint}/json", params=params, timeout=30)
    r.raise_for_status()
    return r.json()

def nearby_search(lat, lng, keyword, page_token=None):
    p = {
        "location": f"{lat},{lng}",
        "radius": RADIUS,
        "keyword": keyword,
        "language": "ru",
    }
    if page_token:
        p["pagetoken"] = page_token
    return api_get("nearbysearch", p)

def get_details(place_id):
    return api_get("details", {
        "place_id": place_id,
        "fields": (
            "place_id,name,formatted_address,geometry,"
            "formatted_phone_number,international_phone_number,"
            "website,url,rating,user_ratings_total,"
            "opening_hours,photos,reviews,types,"
            "address_components,editorial_summary,price_level"
        ),
        "language": "ru",
    }).get("result", {})

def photo_url(ref, width=1200):
    return f"{BASE}/photo?maxwidth={width}&photo_reference={ref}&key={API_KEY}"

# ═══════════════════════════════════════════════════════
#  OPTIMIZED PLACE ID YIG'ISH
# ═══════════════════════════════════════════════════════

def collect_learning_centers_optimized():
    """Optimized strategy - priority cities + efficient keywords"""
    all_ids = set()
    total_cities = len(MAJOR_CITIES)
    
    print(f"🚀 OPTIMIZED qidiruv boshlandi...")
    print(f"   📍 {total_cities} ta asosiy shahar")
    print(f"   🔍 {len(EFFICIENT_KEYWORDS)} ta samarali kalit so'z")
    print(f"   📡 {RADIUS/1000:.0f} km radius")
    print()
    
    # Shaharlarni priority bo'yicha saralash
    sorted_cities = sorted(MAJOR_CITIES, key=lambda x: x["priority"])
    
    for i, city in enumerate(sorted_cities, 1):
        city_name = city["name"]
        lat, lng = city["lat"], city["lng"]
        priority = city["priority"]
        
        print(f"📍 [{i:2}/{total_cities}] {city_name} (Priority: {priority})  ", end="", flush=True)
        before_count = len(all_ids)
        
        # Priority ga qarab kalit so'zlar sonini cheklash
        if priority == 1:  # Toshkent - barcha kalit so'zlar
            keywords_to_use = EFFICIENT_KEYWORDS
        elif priority == 2:  # Yirik shaharlar - asosiy kalit so'zlar
            keywords_to_use = EFFICIENT_KEYWORDS[:15]
        elif priority == 3:  # O'rta shaharlar - faqat asosiy atamalar
            keywords_to_use = EFFICIENT_KEYWORDS[:8]
        else:  # Kichik shaharlar - faqat eng muhim kalit so'zlar
            keywords_to_use = EFFICIENT_KEYWORDS[:5]
        
        for j, keyword in enumerate(keywords_to_use, 1):
            if j % 5 == 1:
                print(f"\n    🔍 {keyword[:25]:<25} ", end="", flush=True)
            
            token = None
            page_count = 0
            max_pages = 3  # Har bir kalit so'z uchun maksimum 3 sahifa
            
            while token is not None or page_count == 0:
                if page_count > 0:
                    time.sleep(2.5)  # API limit
                
                try:
                    data = nearby_search(lat, lng, keyword, token)
                    status = data.get("status")
                    results = data.get("results", [])
                    
                    if status == "REQUEST_DENIED":
                        print(f"\n    ⛔ API xatosi: {data.get('error_message', '')[:60]}")
                        break
                    if status not in ("OK", "ZERO_RESULTS"):
                        break
                    
                    # Natijalarni qo'shish
                    new_results = 0
                    for result in results:
                        place_id = result.get("place_id")
                        if place_id and place_id not in all_ids:
                            all_ids.add(place_id)
                            new_results += 1
                    
                    if new_results > 0:
                        print(f"+{new_results}", end="", flush=True)
                    
                    token = data.get("next_page_token")
                    page_count += 1
                    
                    if not token or page_count >= max_pages:
                        break
                        
                except Exception as e:
                    print(f"\n    ⚠ {keyword[:20]}: {e}")
                    break
        
        added_count = len(all_ids) - before_count
        print(f" → +{added_count:4} yangi | Jami: {len(all_ids):5}")
        
        # Agar ko'p natija topilsa, keyingi shaharlarni o'tkazib yuborish mumkin
        if len(all_ids) > 5000 and priority > 3:
            print(f"    📊 Yetarli natija topildi, qolgan shaharlar o'tkazildi")
            break
    
    return all_ids

# ═══════════════════════════════════════════════════════
#  MA'LUMOT QAYTA ISHLASH (o'zgarishsiz)
# ═══════════════════════════════════════════════════════

def parse_hours(opening_hours):
    hours = []
    for period in (opening_hours or {}).get("periods", []):
        open_info = period.get("open", {})
        close_info = period.get("close", {})
        day = open_info.get("day")
        if day is None:
            continue
        open_time = open_info.get("time", "0000")
        close_time = close_info.get("time", "2359") if close_info else "2359"
        hours.append({
            "weekday": WEEKDAY.get(day, "Dushanba"),
            "open_time": f"{open_time[:2]}:{open_time[2:]}:00",
            "close_time": f"{close_time[:2]}:{close_time[2:]}:00",
        })
    return hours

def build_center(details, country_key="uzbekistan"):
    geo = details.get("geometry", {}).get("location", {})
    
    # Viloyat / shahar
    province, region = "", ""
    for comp in details.get("address_components", []):
        types = comp.get("types", [])
        if "administrative_area_level_1" in types:
            province = comp.get("long_name", "")
        if "administrative_area_level_2" in types or "locality" in types:
            region = comp.get("long_name", "")
    
    # Tur - faqat o'quv markazlari
    pt = details.get("types", [])
    if any(t in pt for t in ["university", "school", "college", "kindergarten"]):
        ctype = "Ta'lim muassasasi"
    else:
        ctype = "O'quv markazi"
    
    # Rasmlar
    raw_photos = details.get("photos", [])
    logo = None
    images = []
    
    for i, photo in enumerate(raw_photos[:10]):
        ref = photo.get("photo_reference")
        if not ref:
            continue
        url = photo_url(ref)
        if i == 0:
            logo = url
        else:
            images.append({
                "photo_reference": ref,
                "url": url,
                "width": photo.get("width"),
                "height": photo.get("height"),
            })
    
    # Ish vaqtlari
    hours = parse_hours(details.get("opening_hours"))
    
    # Kontaktlar
    connections = []
    phone = details.get("international_phone_number") or details.get("formatted_phone_number")
    if phone:
        connections.append({"type": "Telefon", "url": phone})
    if details.get("website"):
        connections.append({"type": "Sayt", "url": details["website"]})
    if details.get("url"):
        connections.append({"type": "Google Maps", "url": details["url"]})
    
    # Sharhlar
    reviews = []
    for review in details.get("reviews", [])[:5]:
        text = (review.get("text") or "").strip()
        if text:
            reviews.append({
                "author": review.get("author_name", ""),
                "rating": review.get("rating"),
                "text": text,
                "time": review.get("relative_time_description", ""),
            })
    
    # Haqida
    summary = details.get("editorial_summary", {}).get("overview", "")
    rating = details.get("rating")
    total = details.get("user_ratings_total", 0)
    about_parts = []
    if summary:
        about_parts.append(summary)
    if rating:
        about_parts.append(f"Google Maps: {rating}⭐ ({total} ta baho)")
    about = " | ".join(about_parts) if about_parts else None
    
    return {
        "name": details.get("name", "Noma'lum"),
        "logo": logo,
        "type": ctype,
        "about": about,
        "country": country_key,
        "province": province,
        "region": region,
        "address": details.get("formatted_address", ""),
        "location": f"{geo['lat']},{geo['lng']}" if geo else None,
        
        "place_id": details.get("place_id"),
        "rating": rating,
        "ratings_total": total,
        "price_level": details.get("price_level"),
        "open_now": details.get("opening_hours", {}).get("open_now"),
        "weekday_texts": details.get("opening_hours", {}).get("weekday_text", []),
        "google_types": pt,
        
        "images": images,
        "working_hours": hours,
        "connections": connections,
        "reviews": reviews,
    }

# ═══════════════════════════════════════════════════════
#  ASOSIY FUNKSIYA
# ═══════════════════════════════════════════════════════

def main():
    print("╔" + "═"*58 + "╗")
    print("║  O'ZBEKISTON O'QUV MARKAZLARI - OPTIMIZED       ║")
    print("║  Tez va samarali qidiruv                        ║")
    print("╚" + "═"*58 + "╝")
    print(f"\n  API: {API_KEY[:16]}...")
    print(f"  Chiqish: {OUTPUT_DIR}/ papkasi")
    print()
    
    os.makedirs(OUTPUT_DIR, exist_ok=True)
    
    start_time = time.time()
    
    # 1. Optimized place_id yig'ish
    all_place_ids = collect_learning_centers_optimized()
    total_ids = len(all_place_ids)
    
    if total_ids == 0:
        print("\n❌ Hech qanday o'quv markazi topilmadi!")
        return
    
    print(f"\n✅ {total_ids} ta o'quv markazi topildi")
    
    # 2. To'liq ma'lumot olish (tezroq)
    print(f"\n📥 To'liq ma'lumot olish...")
    centers = []
    errors = 0
    
    for i, place_id in enumerate(all_place_ids, 1):
        try:
            time.sleep(0.05)  # Kamroq kutish
            details = get_details(place_id)
            if not details:
                errors += 1
                continue
            
            center = build_center(details)
            centers.append(center)
            
            if i % 20 == 0:  # Ko'proq progress ko'rsatish
                print(f"    [{i:5}/{total_ids}] ✅ {center['name'][:40]}")
            
        except Exception as e:
            print(f"    [{i:5}/{total_ids}] ❌ {e}")
            errors += 1
    
    # 3. JSON ga yozish
    outfile = os.path.join(OUTPUT_DIR, "uzbekistan_learning_centers_optimized.json")
    payload = {
        "generated_at": datetime.now().isoformat(),
        "country": "uzbekistan",
        "country_name": "O'zbekiston",
        "total": len(centers),
        "source": "Google Places API - Optimized",
        "search_type": "learning_centers_optimized",
        "cities_searched": len(MAJOR_CITIES),
        "keywords_used": len(EFFICIENT_KEYWORDS),
        "centers": centers,
    }
    
    with open(outfile, "w", encoding="utf-8") as f:
        json.dump(payload, f, ensure_ascii=False, indent=2)
    
    elapsed = time.time() - start_time
    hours = int(elapsed // 3600)
    mins = int((elapsed % 3600) // 60)
    secs = int(elapsed % 60)
    
    time_str = f"{hours}:{mins:02d}:{secs:02d}" if hours > 0 else f"{mins}:{secs:02d}"
    
    print(f"\n\n{'═'*60}")
    print(f"  YAKUNIY HISOBOT  ({time_str})")
    print(f"{'═'*60}")
    print(f"  📊 Jami o'quv markazlari: {len(centers):,}")
    print(f"  📄 Saqlangan fayl: {outfile}")
    print(f"  ❌ Xatolar: {errors}")
    print(f"  ⚡ Samaradorlik: {len(centers)/(elapsed/60):.0f} markaz/daqiqa")
    print(f"{'═'*60}")
    print(f"""
  Keyingi qadamlar (Laravel loyiha papkasida):
    cp {outfile} database/data/uzbekistan_learning_centers.json
    php artisan db:seed --class=UzbekistanLearningCentersSeeder
""")

if __name__ == "__main__":
    main()
