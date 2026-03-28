#!/usr/bin/env python3
"""
O'zbekistondagi barcha o'quv markazlarini Google Places API orqali
yig'ib, JSON faylga saqlovchi script.

Faqat o'quv markazlari (learning centers, kurslar, repetitor markazlari)
Barcha shaharlar va qishloqlarni qamrab oladi.

Ishlatish:
    pip install requests
    python3 uzbekistan_learning_centers.py

Natija:
    data/uzbekistan_learning_centers.json
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
RADIUS = 10000  # 10 km radius

BASE = "https://maps.googleapis.com/maps/api/place"

# ═══════════════════════════════════════════════════════
#  O'ZBEKISTON - ASOSIY SHAHARLAR VA KOORDINATLAR
# ═══════════════════════════════════════════════════════
UZBEKISTAN_CITIES = [
    # Poytaxt va yirik shaharlar
    {"name": "Toshkent", "lat": 41.2995, "lng": 69.2401},
    {"name": "Samarqand", "lat": 39.6553, "lng": 66.9597},
    {"name": "Buxoro", "lat": 39.7747, "lng": 64.4286},
    {"name": "Namangan", "lat": 41.0011, "lng": 71.6728},
    {"name": "Andijon", "lat": 40.7821, "lng": 72.3442},
    {"name": "Farg'ona", "lat": 40.3834, "lng": 71.7814},
    {"name": "Qarshi", "lat": 38.8610, "lng": 65.7883},
    {"name": "Nukus", "lat": 42.4600, "lng": 59.6100},
    {"name": "Guliston", "lat": 40.4897, "lng": 68.7842},
    {"name": "Termiz", "lat": 37.2240, "lng": 67.2783},
    {"name": "Navoiy", "lat": 40.1008, "lng": 65.3792},
    {"name": "Urganch", "lat": 41.5500, "lng": 60.6333},
    {"name": "Jizzax", "lat": 40.1158, "lng": 67.8422},
    
    # Viloyat markazlari va yirik tumanlar
    {"name": "Angren", "lat": 41.0167, "lng": 70.1333},
    {"name": "Chirchiq", "lat": 41.5333, "lng": 69.5833},
    {"name": "Bekobod", "lat": 40.7833, "lng": 68.5333},
    {"name": "Olmaliq", "lat": 40.7833, "lng": 69.6000},
    {"name": "Pop", "lat": 40.9833, "lng": 71.0167},
    {"name": "Qo'qon", "lat": 40.7167, "lng": 70.9500},
    {"name": "Marg'ilon", "lat": 40.4167, "lng": 71.6833},
    {"name": "Qo'qon", "lat": 40.7167, "lng": 70.9500},
    {"name": "Kitob", "lat": 39.6667, "lng": 66.8667},
    {"name": "Uchqo'rg'on", "lat": 39.4000, "lng": 66.8667},
    {"name": "G'ijduvon", "lat": 39.6500, "lng": 64.7167},
    {"name": "Vobkent", "lat": 40.0333, "lng": 64.5167},
    {"name": "Kogon", "lat": 39.7500, "lng": 65.4167},
    {"name": "Piskent", "lat": 40.9667, "lng": 69.4167},
    {"name": "Zangiota", "lat": 41.1667, "lng": 69.2167},
    {"name": "Chortoq", "lat": 40.8500, "lng": 68.9500},
    {"name": "Yangiyer", "lat": 39.0833, "lng": 66.8667},
    {"name": "Xonobod", "lat": 40.9833, "lng": 68.4167},
    {"name": "Mingbuloq", "lat": 40.9333, "lng": 68.1167},
    {"name": "Sirdaryo", "lat": 40.8333, "lng": 68.6667},
    {"name": "Boyovut", "lat": 40.4167, "lng": 68.2333},
    {"name": "Baxmal", "lat": 40.2833, "lng": 67.6833},
    {"name": "Forish", "lat": 40.1167, "lng": 67.5167},
    {"name": "Zarafshon", "lat": 40.1333, "lng": 67.6167},
    {"name": "Uchquduq", "lat": 40.1167, "lng": 66.9167},
    {"name": "Tomdibuloq", "lat": 40.0667, "lng": 66.8167},
    {"name": "Qamashi", "lat": 39.9667, "lng": 66.8833},
    {"name": "Muborak", "lat": 39.5667, "lng": 65.6833},
    {"name": "Koson", "lat": 39.5500, "lng": 65.5833},
    {"name": "Yakkabog'", "lat": 39.6167, "lng": 66.3167},
    {"name": "Qamashi", "lat": 39.9667, "lng": 66.8833},
    {"name": "Muborak", "lat": 39.5667, "lng": 65.6833},
    {"name": "Koson", "lat": 39.5500, "lng": 65.5833},
    {"name": "Yakkabog'", "lat": 39.6167, "lng": 66.3167},
    {"name": "Qiziltepa", "lat": 38.9167, "lng": 65.7833},
    {"name": "Qamashi", "lat": 39.9667, "lng": 66.8833},
    {"name": "Shahrisabz", "lat": 39.3000, "lng": 66.4167},
    {"name": "Mirzachul", "lat": 40.7500, "lng": 68.8333},
    {"name": "Xovos", "lat": 40.3500, "lng": 68.7500},
    {"name": "Sirdaryo", "lat": 40.8333, "lng": 68.6667},
    {"name": "Boysun", "lat": 38.2167, "lng": 67.0667},
    {"name": "Denov", "lat": 38.2833, "lng": 67.8833},
    {"name": "Jarkurgon", "lat": 37.9167, "lng": 67.5667},
    {"name": "Qumqo'rg'on", "lat": 38.7667, "lng": 67.2167},
    {"name": "Qiziriq", "lat": 37.9500, "lng": 67.4500},
    {"name": "Bandixon", "lat": 37.2333, "lng": 67.2833},
    {"name": "Muzrabot", "lat": 37.6500, "lng": 67.4167},
    {"name": "Sho'rchi", "lat": 37.8500, "lng": 67.6833},
    {"name": "Angor", "lat": 37.5833, "lng": 67.4500},
    {"name": "Qo'shtepa", "lat": 37.8333, "lng": 67.5667},
    {"name": "Qumqo'rg'on", "lat": 38.7667, "lng": 67.2167},
    {"name": "Oltinko'l", "lat": 41.0333, "lng": 68.8500},
    {"name": "Xojayli", "lat": 42.8167, "lng": 59.9500},
    {"name": "Qong'irot", "lat": 43.1833, "lng": 59.6167},
    {"name": "To'rtko'l", "lat": 41.9333, "lng": 60.8667},
    {"name": "Beruniy", "lat": 42.1167, "lng": 59.8833},
    {"name": "Shumanay", "lat": 42.1000, "lng": 59.4167},
    {"name": "Qorao'zak", "lat": 43.4500, "lng": 59.8833},
    {"name": "Kegeyli", "lat": 42.8833, "lng": 59.9333},
    {"name": "Moynoq", "lat": 42.7500, "lng": 60.0333},
    {"name": "Taxtako'pir", "lat": 42.7167, "lng": 60.0500},
    {"name": "Qipchoq", "lat": 42.9167, "lng": 59.9667},
    {"name": "Xiva", "lat": 41.3833, "lng": 60.3667},
    {"name": "Gurlan", "lat": 41.6667, "lng": 60.1500},
    {"name": "Qo'shnopir", "lat": 41.5333, "lng": 60.2833},
    {"name": "Yangibozor", "lat": 41.6167, "lng": 60.4167},
    {"name": "Hazorasp", "lat": 41.4167, "lng": 60.6833},
    {"name": "Shovot", "lat": 41.3000, "lng": 60.5333},
    {"name": "Yangiariq", "lat": 41.5500, "lng": 60.6167},
    {"name": "Buloqboshi", "lat": 40.9500, "lng": 71.6333},
    {"name": "Chortoq", "lat": 40.8500, "lng": 68.9500},
    {"name": "Uychi", "lat": 40.9667, "lng": 72.0333},
    {"name": "Paxtobod", "lat": 40.9333, "lng": 72.1833},
    {"name": "Marhamat", "lat": 40.4333, "lng": 71.9500},
    {"name": "Oltinko'l", "lat": 41.0333, "lng": 68.8500},
    {"name": "Baliqchi", "lat": 40.9500, "lng": 71.6333},
    {"name": "Xonobod", "lat": 40.9833, "lng": 68.4167},
    {"name": "Mingbuloq", "lat": 40.9333, "lng": 68.1167},
    {"name": "Zarbdor", "lat": 40.8833, "lng": 71.6667},
    {"name": "Beshariq", "lat": 40.9167, "lng": 71.9500},
    {"name": "Buvayda", "lat": 40.7667, "lng": 71.8667},
    {"name": "Toshloq", "lat": 40.8333, "lng": 71.7667},
    {"name": "Oltinko'l", "lat": 41.0333, "lng": 68.8500},
]

# ═══════════════════════════════════════════════════════
#  FAQAT O'QUV MARKAZLARI UCHUN QIDIRUV SO'ZLARI
# ═══════════════════════════════════════════════════════
LEARNING_CENTER_KEYWORDS = [
    # O'zbek tilidagi o'quv markazlari
    "o'quv markaz", "ta'lim markazi", "kurs markazi", "repetitor markazi",
    "ingliz tili kursi", "it kurslari", "kompyuter kurslari", "dasturlash kursi",
    "matematika kursi", "fizika kursi", "kimyo kursi", "biologiya kursi",
    "rus tili kursi", "arab tili kursi", "koreys tili kursi", "xitoy tili kursi",
    "iqtisodiyot kursi", "buxgalteriya kursi", "marketing kursi", "dizayn kursi",
    "rasm chizish kursi", "musiqa kursi", "raqs kursi", "sport seksiyasi",
    "hayotiy ko'nikmalar", "liderlik kursi", "motivatsiya kursi", "psixologiya kursi",
    "tayyorlov kursi", "DTM kursi", "magistrlikka tayyorlov", "universitetga tayyorlov",
    "maktabga tayyorlov", "bog'chaga tayyorlov", "test sinovlari", "imtihonga tayyorlov",
    "chet tiliga tayyorlov", "IELTS kursi", "TOEFL kursi", "SAT kursi",
    "online kurs", "masofaviy ta'lim", "video kurs", "audio kurs",
    
    # Rus tilidagi o'quv markazlari
    "учебный центр", "образовательный центр", "курсы", "репетиторский центр",
    "курсы английского языка", "курсы программирования", "компьютерные курсы",
    "курсы математики", "курсы физики", "курсы химии", "курсы биологии",
    "курсы русского языка", "курсы арабского языка", "курсы корейского языка",
    "курсы китайского языка", "курсы экономики", "курсы бухгалтерии",
    "курсы маркетинга", "курсы дизайна", "курсы рисования", "музыкальные курсы",
    "танцевальные курсы", "спортивные секции", "курсы жизненных навыков",
    "курсы лидерства", "курсы мотивации", "курсы психологии",
    "подготовительные курсы", "курсы к ЕГЭ", "курсы к экзаменам",
    "курсы IELTS", "курсы TOEFL", "курсы SAT", "онлайн курсы",
    
    # Ingliz tilidagi o'quv markazlari
    "learning center", "education center", "training center", "tutorial center",
    "english course", "programming course", "computer course", "coding course",
    "math course", "physics course", "chemistry course", "biology course",
    "russian course", "arabic course", "korean course", "chinese course",
    "economics course", "accounting course", "marketing course", "design course",
    "drawing course", "music course", "dance course", "sports training",
    "life skills course", "leadership course", "motivation course", "psychology course",
    "preparatory course", "test preparation", "exam preparation", "entrance exam prep",
    "IELTS preparation", "TOEFL preparation", "SAT preparation", "online course",
    "distance learning", "video course", "audio course", "e-learning",
    
    # Umumiy atamalar
    "academy", "institute", "college", "school", "center", "course",
    "class", "lesson", "training", "education", "learning", "study",
    "tutoring", "coaching", "workshop", "seminar", "lecture",
    
    # O'zbekistondagi mashhur o'quv markazlari turlari
    "akademik litsey", "kasb-hunar kolleji", "texnikum", "professiol maktab",
    "musiqa maktabi", "san'at maktabi", "sport maktabi", "badiiy gimnaziya",
    "til kurslari markazi", "chet tili markazi", "xorijiy til markazi",
    "kompyuter akademiyasi", "it akademiyasi", "dasturlash akademiyasi",
    "biznes maktabi", "tadbirkorlik maktabi", "menejment maktabi",
    "moliya maktabi", "bank maktabi", "sug'urta maktabi",
    "huquqshunoslik maktabi", "yuridik maktab", "advokatlik kurslari",
    "jurnalistika maktabi", "reklama maktabi", "pr maktabi",
    "tibbiyot kurslari", "tibbiyotot maktabi", "feldsherlik kurslari",
    "hamshiralik kurslari", "dorixona kurslari", "farmatsevt kurslari",
    "qurilish kurslari", "arxitektura kurslari", "muhandislik kurslari",
    "avtomobil maktabi", "haydovchi kurslari", "avto maktab",
    "aviatsiya maktabi", "uchuvchilik kurslari", "pilotlik kurslari",
    "dengiz maktabi", "kemachilik kurslari", "dengizchilik kurslari",
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
    r = requests.get(f"{BASE}/{endpoint}/json", params=params, timeout=20)
    r.raise_for_status()
    return r.json()

def nearby_search(lat, lng, keyword, page_token=None):
    p = {
        "location": f"{lat},{lng}",
        "radius": RADIUS,
        "keyword": keyword,
        "language": "ru",  # O'zbekistonda rus tili keng tarqalgan
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
#  PLACE ID YIGISH
# ═══════════════════════════════════════════════════════

def collect_all_learning_centers():
    """O'zbekistonning barcha shaharlaridan o'quv markazlarini yig'ish"""
    all_ids = set()
    total_cities = len(UZBEKISTAN_CITIES)
    
    print(f"🌍 O'zbekistondagi barcha o'quv markazlarini qidirish...")
    print(f"   📍 {total_cities} ta shahar va qishloq")
    print(f"   🔍 {len(LEARNING_CENTER_KEYWORDS)} ta kalit so'z")
    print(f"   📡 {RADIUS/1000:.0f} km radius")
    print()
    
    for i, city in enumerate(UZBEKISTAN_CITIES, 1):
        city_name = city["name"]
        lat, lng = city["lat"], city["lng"]
        
        print(f"📍 [{i:2}/{total_cities}] {city_name}  ", end="", flush=True)
        before_count = len(all_ids)
        
        for j, keyword in enumerate(LEARNING_CENTER_KEYWORDS, 1):
            if j % 10 == 1:
                print(f"\n    🔍 {keyword[:30]:<30} ", end="", flush=True)
            
            token = None
            while True:
                if token:
                    time.sleep(2.5)  # API limitni kutish
                
                try:
                    data = nearby_search(lat, lng, keyword, token)
                    status = data.get("status")
                    results = data.get("results", [])
                    
                    if status == "REQUEST_DENIED":
                        print(f"\n    ⛔ API xatosi: {data.get('error_message', '')[:60]}")
                        break
                    if status not in ("OK", "ZERO_RESULTS"):
                        break
                    
                    for result in results:
                        place_id = result.get("place_id")
                        if place_id:
                            all_ids.add(place_id)
                    
                    token = data.get("next_page_token")
                    if not token:
                        break
                        
                except Exception as e:
                    print(f"\n    ⚠ {keyword[:20]}: {e}")
                    break
        
        added_count = len(all_ids) - before_count
        print(f" → +{added_count:4} yangi | Jami: {len(all_ids):5}")
    
    return all_ids

# ═══════════════════════════════════════════════════════
#  MA'LUMOT QAYTA ISHLASH
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
    
    for i, photo in enumerate(raw_photos[:10]):  # Birinchi 10 ta rasm
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
        # learning_centers jadvali
        "name": details.get("name", "Noma'lum"),
        "logo": logo,
        "type": ctype,
        "about": about,
        "country": country_key,
        "province": province,
        "region": region,
        "address": details.get("formatted_address", ""),
        "location": f"{geo['lat']},{geo['lng']}" if geo else None,
        
        # Qo'shimcha meta
        "place_id": details.get("place_id"),
        "rating": rating,
        "ratings_total": total,
        "price_level": details.get("price_level"),
        "open_now": details.get("opening_hours", {}).get("open_now"),
        "weekday_texts": details.get("opening_hours", {}).get("weekday_text", []),
        "google_types": pt,
        
        # Bog'liq jadvallar
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
    print("║  O'ZBEKISTON O'QUV MARKAZLARI                     ║")
    print("║  Google Places API orqali to'liq qamrov           ║")
    print("╚" + "═"*58 + "╝")
    print(f"\n  API: {API_KEY[:16]}...")
    print(f"  Chiqish: {OUTPUT_DIR}/ papkasi")
    print()
    
    os.makedirs(OUTPUT_DIR, exist_ok=True)
    
    start_time = time.time()
    
    # 1. Barcha place_id larni yig'ish
    all_place_ids = collect_all_learning_centers()
    total_ids = len(all_place_ids)
    
    if total_ids == 0:
        print("\n❌ Hech qanday o'quv markazi topilmadi!")
        return
    
    print(f"\n✅ {total_ids} ta o'quv markazi topildi")
    
    # 2. Har biri uchun to'liq ma'lumot olish
    print(f"\n📥 To'liq ma'lumot olish...")
    centers = []
    errors = 0
    
    for i, place_id in enumerate(all_place_ids, 1):
        try:
            time.sleep(0.1)  # API limitni kutish
            details = get_details(place_id)
            if not details:
                errors += 1
                continue
            
            center = build_center(details)
            centers.append(center)
            
            if i % 10 == 0:
                print(f"    [{i:5}/{total_ids}] ✅ {center['name'][:40]}")
            
        except Exception as e:
            print(f"    [{i:5}/{total_ids}] ❌ {e}")
            errors += 1
    
    # 3. JSON ga yozish
    outfile = os.path.join(OUTPUT_DIR, "uzbekistan_learning_centers.json")
    payload = {
        "generated_at": datetime.now().isoformat(),
        "country": "uzbekistan",
        "country_name": "O'zbekiston",
        "total": len(centers),
        "source": "Google Places API",
        "search_type": "learning_centers_only",
        "cities_searched": len(UZBEKISTAN_CITIES),
        "keywords_used": len(LEARNING_CENTER_KEYWORDS),
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
    print(f"  📊 Jami o'quv markazlari: {len(centers):,}")
    print(f"  📄 Saqlangan fayl: {outfile}")
    print(f"  ❌ Xatolar: {errors}")
    print(f"{'═'*60}")
    print(f"""
  Keyingi qadamlar (Laravel loyiha papkasida):
    cp {outfile} database/data/uzbekistan_learning_centers.json
    php artisan db:seed --class=UzbekistanLearningCentersSeeder
""")

if __name__ == "__main__":
    main()
