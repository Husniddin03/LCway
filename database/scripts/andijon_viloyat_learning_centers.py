#!/usr/bin/env python3
"""
Andijon viloyati uchun o'quv markazlarini yig'ish scripti
"""

import os
import time
import json
import requests
from datetime import datetime
from regions_config import API_KEY, OUTPUT_DIR, RADIUS, EFFICIENT_KEYWORDS

BASE = "https://maps.googleapis.com/maps/api/place"
REGION_KEY = "andijon_viloyat"
REGION_NAME = "Andijon viloyati"
CITIES = [{'name': 'Andijon', 'lat': 40.7821, 'lng': 72.3442}, {'name': 'Xonobod', 'lat': 40.9833, 'lng': 68.4167}, {'name': 'Marhamat', 'lat': 40.4333, 'lng': 71.95}, {'name': 'Buloqboshi', 'lat': 40.95, 'lng': 71.6333}, {'name': 'Shahrixon', 'lat': 40.6167, 'lng': 72.3167}, {'name': 'Paxtobod', 'lat': 40.9333, 'lng': 72.1833}]

WEEKDAY = {
    0: "Yakshanba", 1: "Dushanba", 2: "Seshanba",
    3: "Chorshanba", 4: "Payshanba", 5: "Juma", 6: "Shanba",
}

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

def collect_region_learning_centers():
    all_ids = set()
    total_cities = len(CITIES)
    
    print(f"🌍 {REGION_NAME} viloyati uchun qidiruv...")
    print(f"   📍 {total_cities} ta shahar")
    print(f"   🔍 {len(EFFICIENT_KEYWORDS)} ta kalit so'z")
    print(f"   📡 {RADIUS/1000:.0f} km radius")
    print()
    
    for i, city in enumerate(CITIES, 1):
        city_name = city["name"]
        lat, lng = city["lat"], city["lng"]
        
        print(f"📍 [{i:2}/{total_cities}] {city_name}  ", end="", flush=True)
        before_count = len(all_ids)
        
        for j, keyword in enumerate(EFFICIENT_KEYWORDS, 1):
            if j % 5 == 1:
                print(f"\n    🔍 {keyword[:25]:<25} ", end="", flush=True)
            
            token = None
            page_count = 0
            max_pages = 2
            
            while token is not None or page_count == 0:
                if page_count > 0:
                    time.sleep(2.0)
                
                try:
                    data = nearby_search(lat, lng, keyword, token)
                    status = data.get("status")
                    results = data.get("results", [])
                    
                    if status == "REQUEST_DENIED":
                        print(f"\n    ⛔ API xatosi: {data.get('error_message', '')[:60]}")
                        break
                    if status not in ("OK", "ZERO_RESULTS"):
                        break
                    
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
    
    return all_ids

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
    
    province, region = "", ""
    for comp in details.get("address_components", []):
        types = comp.get("types", [])
        if "administrative_area_level_1" in types:
            province = comp.get("long_name", "")
        if "administrative_area_level_2" in types or "locality" in types:
            region = comp.get("long_name", "")
    
    pt = details.get("types", [])
    if any(t in pt for t in ["university", "school", "college", "kindergarten"]):
        ctype = "Ta'lim muassasasi"
    else:
        ctype = "O'quv markazi"
    
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
    
    hours = parse_hours(details.get("opening_hours"))
    
    connections = []
    phone = details.get("international_phone_number") or details.get("formatted_phone_number")
    if phone:
        connections.append({"type": "Telefon", "url": phone})
    if details.get("website"):
        connections.append({"type": "Sayt", "url": details["website"]})
    if details.get("url"):
        connections.append({"type": "Google Maps", "url": details["url"]})
    
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

def main():
    print("╔" + "═"*58 + "╗")
    print(f"║  {REGION_NAME.upper()[:30]:<30} O'QUV MARKAZLARI        ║")
    print("║  Google Places API orqali qidiruv              ║")
    print("╚" + "═"*58 + "╝")
    print(f"\n  API: {API_KEY[:16]}...")
    print(f"  Chiqish: {OUTPUT_DIR}/{REGION_KEY}_learning_centers.json")
    print()
    
    os.makedirs(OUTPUT_DIR, exist_ok=True)
    
    start_time = time.time()
    
    # 1. Place_id larni yig'ish
    all_place_ids = collect_region_learning_centers()
    total_ids = len(all_place_ids)
    
    if total_ids == 0:
        print("\n❌ Hech qanday o'quv markazi topilmadi!")
        return
    
    print(f"\n✅ {total_ids} ta o'quv markazi topildi")
    
    # 2. To'liq ma'lumot olish
    print(f"\n📥 To'liq ma'lumot olish...")
    centers = []
    errors = 0
    
    for i, place_id in enumerate(all_place_ids, 1):
        try:
            time.sleep(0.05)
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
    outfile = os.path.join(OUTPUT_DIR, f"{REGION_KEY}_learning_centers.json")
    payload = {
        "generated_at": datetime.now().isoformat(),
        "region_key": REGION_KEY,
        "region_name": REGION_NAME,
        "country": "uzbekistan",
        "country_name": "O'zbekiston",
        "total": len(centers),
        "source": "Google Places API",
        "search_type": "regional_learning_centers",
        "cities_searched": len(CITIES),
        "keywords_used": len(EFFICIENT_KEYWORDS),
        "centers": centers,
    }
    
    with open(outfile, "w", encoding="utf-8") as f:
        json.dump(payload, f, ensure_ascii=False, indent=2)
    
    elapsed = time.time() - start_time
    mins = int(elapsed // 60)
    secs = int(elapsed % 60)
    
    print(f"\n\n{'═'*60}")
    print(f"  {REGION_NAME} YAKUNIY HISOBOT  ({mins}:{secs:02d} daqiqa)")
    print(f"{'═'*60}")
    print(f"  📊 Jami o'quv markazlari: {len(centers):,}")
    print(f"  📄 Saqlangan fayl: {outfile}")
    print(f"  ❌ Xatolar: {errors}")
    print(f"  ⚡ Samaradorlik: {len(centers)/(elapsed/60):.0f} markaz/daqiqa")
    print(f"{'═'*60}")

if __name__ == "__main__":
    main()
