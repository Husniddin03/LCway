#!/usr/bin/env python3
"""
Markaziy Osiyo — barcha ta'lim muassasalarini Google Places API orqali
yig'ib, har bir davlat uchun alohida JSON faylga saqlovchi script.

Davlatlar: O'zbekiston, Qozog'iston, Qirg'iziston, Tojikiston, Turkmaniston

Ta'lim turlari:
  - Maktablar (school)
  - Universitetlar (university)
  - Kollej / Litsey (college)
  - O'quv markazlari (learning center, kurs)
  - Til maktablari (language school)
  - Texnikumlar
  - Bolalar bog'chalari (kindergarten)

Ishlatish:
    pip install requests
    python3 fetch_central_asia.py

Natija:
    data/uzbekistan.json
    data/kazakhstan.json
    data/kyrgyzstan.json
    data/tajikistan.json
    data/turkmenistan.json
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

OUTPUT_DIR = "data"   # JSON fayllar saqlanadigan papka
RADIUS     = 15000    # har bir nuqta uchun radius (15 km)

BASE = "https://maps.googleapis.com/maps/api/place"

# ═══════════════════════════════════════════════════════
#  MARKAZIY OSIYO — SHAHARLAR VA KOORDINATLAR
# ═══════════════════════════════════════════════════════
COUNTRIES = {
    "uzbekistan": {
        "name": "O'zbekiston",
        "file": "uzbekistan.json",
        "bbox": (37.1, 56.0, 45.6, 73.2),   # lat_min, lon_min, lat_max, lon_max
        "cities": [
            {"name": "Toshkent",    "lat": 41.2995, "lng": 69.2401},
            {"name": "Samarqand",   "lat": 39.6553, "lng": 66.9597},
            {"name": "Buxoro",      "lat": 39.7747, "lng": 64.4286},
            {"name": "Namangan",    "lat": 41.0011, "lng": 71.6728},
            {"name": "Andijon",     "lat": 40.7821, "lng": 72.3442},
            {"name": "Farg'ona",    "lat": 40.3834, "lng": 71.7814},
            {"name": "Qarshi",      "lat": 38.8610, "lng": 65.7883},
            {"name": "Nukus",       "lat": 42.4600, "lng": 59.6100},
            {"name": "Guliston",    "lat": 40.4897, "lng": 68.7842},
            {"name": "Termiz",      "lat": 37.2240, "lng": 67.2783},
            {"name": "Navoiy",      "lat": 40.1008, "lng": 65.3792},
            {"name": "Urganch",     "lat": 41.5500, "lng": 60.6333},
            {"name": "Jizzax",      "lat": 40.1158, "lng": 67.8422},
        ],
    },
    "kazakhstan": {
        "name": "Qozog'iston",
        "file": "kazakhstan.json",
        "bbox": (40.5, 50.0, 55.5, 87.4),
        "cities": [
            {"name": "Almaty",      "lat": 43.2220, "lng": 76.8512},
            {"name": "Astana",      "lat": 51.1801, "lng": 71.4460},
            {"name": "Shymkent",    "lat": 42.3000, "lng": 69.6000},
            {"name": "Karaganda",   "lat": 49.8047, "lng": 73.0875},
            {"name": "Aktobe",      "lat": 50.2839, "lng": 57.1670},
            {"name": "Taraz",       "lat": 42.9000, "lng": 71.3667},
            {"name": "Oskemen",     "lat": 49.9667, "lng": 82.6167},
            {"name": "Pavlodar",    "lat": 52.3000, "lng": 76.9667},
            {"name": "Semey",       "lat": 50.4111, "lng": 80.2275},
            {"name": "Oral",        "lat": 51.2333, "lng": 51.3667},
            {"name": "Kostanay",    "lat": 53.2000, "lng": 63.6167},
            {"name": "Atyrau",      "lat": 47.1167, "lng": 51.9000},
        ],
    },
    "kyrgyzstan": {
        "name": "Qirg'iziston",
        "file": "kyrgyzstan.json",
        "bbox": (39.2, 69.3, 43.2, 80.3),
        "cities": [
            {"name": "Bishkek",     "lat": 42.8746, "lng": 74.5698},
            {"name": "Osh",         "lat": 40.5283, "lng": 72.7985},
            {"name": "Jalal-Abad",  "lat": 40.9333, "lng": 73.0000},
            {"name": "Karakol",     "lat": 42.4833, "lng": 78.3833},
            {"name": "Tokmok",      "lat": 42.8333, "lng": 75.3000},
            {"name": "Naryn",       "lat": 41.4286, "lng": 75.9908},
            {"name": "Batken",      "lat": 40.0625, "lng": 70.8194},
        ],
    },
    "tajikistan": {
        "name": "Tojikiston",
        "file": "tajikistan.json",
        "bbox": (36.7, 67.4, 41.1, 75.2),
        "cities": [
            {"name": "Dushanbe",    "lat": 38.5598, "lng": 68.7738},
            {"name": "Khujand",     "lat": 40.2792, "lng": 69.6233},
            {"name": "Kulob",       "lat": 37.9100, "lng": 69.7800},
            {"name": "Qurghonteppa","lat": 37.8306, "lng": 68.7806},
            {"name": "Istaravshan", "lat": 39.9139, "lng": 69.0039},
            {"name": "Tursunzoda",  "lat": 38.5167, "lng": 68.2333},
        ],
    },
    "turkmenistan": {
        "name": "Turkmaniston",
        "file": "turkmenistan.json",
        "bbox": (35.1, 52.4, 42.8, 66.7),
        "cities": [
            {"name": "Ashgabat",    "lat": 37.9601, "lng": 58.3261},
            {"name": "Turkmenabat", "lat": 39.0833, "lng": 63.5667},
            {"name": "Mary",        "lat": 37.5936, "lng": 61.8300},
            {"name": "Dashoguz",    "lat": 41.8333, "lng": 59.9667},
            {"name": "Balkanabat",  "lat": 39.5100, "lng": 54.3700},
        ],
    },
}

# ═══════════════════════════════════════════════════════
#  QIDIRUV SO'ZLARI — barcha ta'lim turlari
# ═══════════════════════════════════════════════════════
KEYWORDS = [
    # O'zbek
    "o'quv markaz", "ta'lim markazi", "maktab", "universitet",
    "kollej", "litsey", "texnikum", "repetitor", "kurs markazi",
    "ingliz tili", "it kurslari", "bolalar bog'chasi",
    # Rus
    "учебный центр", "школа", "университет", "колледж",
    "лицей", "техникум", "репетитор", "курсы", "детский сад",
    # Ingliz
    "school", "university", "college", "learning center",
    "education center", "language school", "kindergarten", "academy",
    "training center", "institute",
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
        "radius":   RADIUS,
        "keyword":  keyword,
        "language": "ru",   # Markaziy Osiyoda rus tili keng tarqalgan
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

def collect_ids_for_city(city, country_bbox):
    """Bir shahar uchun barcha place_id larni yig'adi"""
    lat, lng = city["lat"], city["lng"]
    lat_min, lon_min, lat_max, lon_max = country_bbox
    ids = set()

    for kw in KEYWORDS:
        token = None
        while True:
            if token:
                time.sleep(2.5)
            try:
                data    = nearby_search(lat, lng, kw, token)
                status  = data.get("status")
                results = data.get("results", [])

                if status == "REQUEST_DENIED":
                    print(f"\n        ⛔ {data.get('error_message', '')[:60]}")
                    break
                if status not in ("OK", "ZERO_RESULTS"):
                    break

                for r in results:
                    pid = r.get("place_id")
                    loc = r.get("geometry", {}).get("location", {})
                    rlat = loc.get("lat", 0)
                    rlng = loc.get("lng", 0)
                    # Davlat hududida ekanligini tekshirish
                    if lat_min < rlat < lat_max and lon_min < rlng < lon_max:
                        if pid:
                            ids.add(pid)

                token = data.get("next_page_token")
                if not token:
                    break
            except Exception as e:
                print(f"\n        ⚠ {e}")
                break

    return ids


# ═══════════════════════════════════════════════════════
#  MA'LUMOT QAYTA ISHLASH
# ═══════════════════════════════════════════════════════

def parse_hours(opening_hours):
    hours = []
    for period in (opening_hours or {}).get("periods", []):
        o  = period.get("open",  {})
        c  = period.get("close", {})
        dn = o.get("day")
        if dn is None:
            continue
        ot = o.get("time", "0000")
        ct = c.get("time", "2359") if c else "2359"
        hours.append({
            "weekday":    WEEKDAY.get(dn, "Dushanba"),
            "open_time":  f"{ot[:2]}:{ot[2:]}:00",
            "close_time": f"{ct[:2]}:{ct[2:]}:00",
        })
    return hours


def build_center(d, country_key):
    geo = d.get("geometry", {}).get("location", {})

    # Viloyat / shahar
    province, region = "", ""
    for comp in d.get("address_components", []):
        t = comp.get("types", [])
        if "administrative_area_level_1" in t:
            province = comp.get("long_name", "")
        if "administrative_area_level_2" in t or "locality" in t:
            region = comp.get("long_name", "")

    # Tur
    pt = d.get("types", [])
    if "university" in pt:
        ctype = "Universitet"
    elif "school" in pt:
        ctype = "Maktab"
    elif "college" in pt:
        ctype = "Kollej"
    elif "kindergarten" in pt:
        ctype = "Bolalar bog'chasi"
    elif "secondary_school" in pt:
        ctype = "O'rta maktab"
    elif "primary_school" in pt:
        ctype = "Boshlang'ich maktab"
    else:
        ctype = "O'quv markaz"

    # ── RASMLAR ──────────────────────────────────────
    # Birinchi rasm → logo
    # Qolganlari → images
    raw_photos = d.get("photos", [])
    logo = None
    images = []

    for i, p in enumerate(raw_photos[:15]):
        ref = p.get("photo_reference")
        if not ref:
            continue
        url = photo_url(ref)
        if i == 0:
            logo = url          # birinchi rasm logo bo'ladi
        else:
            images.append({
                "photo_reference": ref,
                "url": url,
                "width":  p.get("width"),
                "height": p.get("height"),
            })

    # ── ISH VAQTLARI ─────────────────────────────────
    hours = parse_hours(d.get("opening_hours"))

    open_now = d.get("opening_hours", {}).get("open_now")
    weekday_texts = d.get("opening_hours", {}).get("weekday_text", [])

    # ── KONTAKTLAR ───────────────────────────────────
    conns = []
    phone = d.get("international_phone_number") or d.get("formatted_phone_number")
    if phone:
        conns.append({"type": "Telefon", "url": phone})
    if d.get("website"):
        conns.append({"type": "Sayt", "url": d["website"]})
    if d.get("url"):
        conns.append({"type": "Google Maps", "url": d["url"]})

    # ── SHARHLAR ─────────────────────────────────────
    reviews = []
    for rv in d.get("reviews", [])[:5]:
        text = (rv.get("text") or "").strip()
        if text:
            reviews.append({
                "author":   rv.get("author_name", ""),
                "rating":   rv.get("rating"),
                "text":     text,
                "time":     rv.get("relative_time_description", ""),
            })

    # ── HAQIDA ───────────────────────────────────────
    summary = d.get("editorial_summary", {}).get("overview", "")
    rating  = d.get("rating")
    total   = d.get("user_ratings_total", 0)
    about_parts = []
    if summary:
        about_parts.append(summary)
    if rating:
        about_parts.append(f"Google Maps: {rating}⭐ ({total} ta baho)")
    about = " | ".join(about_parts) if about_parts else None

    return {
        # ── learning_centers jadvali ──────────────────
        "name":          d.get("name", "Noma'lum"),
        "logo":          logo,            # ← birinchi rasm logo
        "type":          ctype,
        "about":         about,
        "province":      province,
        "region":        region,
        "address":       d.get("formatted_address", ""),
        "location":      f"{geo['lat']},{geo['lng']}" if geo else None,

        # ── qo'shimcha meta ───────────────────────────
        "country":       country_key,
        "place_id":      d.get("place_id"),
        "rating":        rating,
        "ratings_total": total,
        "price_level":   d.get("price_level"),
        "open_now":      open_now,
        "weekday_texts": weekday_texts,
        "google_types":  pt,

        # ── bog'liq jadvallar ─────────────────────────
        "images":        images,          # → learning_centers_images (URL lar)
        "working_hours": hours,           # → learning_centers_calendar
        "connections":   conns,           # → learning_centers_connect
        "reviews":       reviews,         # → learning_centers_comments
    }


# ═══════════════════════════════════════════════════════
#  DAVLAT UCHUN TO'LIQ YIGIW
# ═══════════════════════════════════════════════════════

def fetch_country(country_key, country_data):
    name   = country_data["name"]
    cities = country_data["cities"]
    bbox   = country_data["bbox"]
    outfile = os.path.join(OUTPUT_DIR, country_data["file"])

    print(f"\n{'═'*60}")
    print(f"  🌍 {name} ({len(cities)} ta shahar, {len(KEYWORDS)} ta kalit so'z)")
    print(f"{'═'*60}")

    # ── 1. Barcha place_id larni yig'ish ─────────────
    all_ids = set()
    for city in cities:
        print(f"\n  📍 {city['name']}  ", end="", flush=True)
        before = len(all_ids)
        city_ids = collect_ids_for_city(city, bbox)
        all_ids |= city_ids
        added = len(all_ids) - before
        print(f"→ +{added} yangi | Jami: {len(all_ids)}")

    total_ids = len(all_ids)
    print(f"\n  ✅ {name}: {total_ids} ta noyob joy topildi")

    if total_ids == 0:
        return 0

    # ── 2. Har biri uchun details olish ──────────────
    print(f"\n  📥 To'liq ma'lumot olish...")
    centers = []
    errors  = 0

    for i, pid in enumerate(all_ids, 1):
        try:
            time.sleep(0.2)
            d = get_details(pid)
            if not d:
                errors += 1
                continue

            c = build_center(d, country_key)
            centers.append(c)

            star  = f"⭐{c['rating']}" if c['rating'] else "    "
            logo  = "🖼" if c['logo'] else " "
            imgs  = f"📷{len(c['images'])}" if c['images'] else ""
            print(f"    [{i:4}/{total_ids}] {logo}{imgs} {star} {c['name'][:45]}")

        except Exception as e:
            print(f"    [{i:4}/{total_ids}] ❌ {e}")
            errors += 1

    # ── 3. JSON ga yozish ────────────────────────────
    os.makedirs(OUTPUT_DIR, exist_ok=True)
    payload = {
        "generated_at": datetime.now().isoformat(),
        "country":      country_key,
        "country_name": name,
        "total":        len(centers),
        "source":       "Google Places API",
        "centers":      centers,
    }
    with open(outfile, "w", encoding="utf-8") as f:
        json.dump(payload, f, ensure_ascii=False, indent=2)

    print(f"\n  💾 {outfile} → {len(centers)} ta markaz (xato: {errors})")
    return len(centers)


# ═══════════════════════════════════════════════════════
#  ASOSIY
# ═══════════════════════════════════════════════════════

def main():
    print("╔" + "═"*58 + "╗")
    print("║  Markaziy Osiyo Ta'lim Muassasalari — Google Places    ║")
    print("║  O'zbekiston | Qozog'iston | Qirg'iziston |           ║")
    print("║  Tojikiston  | Turkmaniston                           ║")
    print("╚" + "═"*58 + "╝")
    print(f"\n  API: {API_KEY[:16]}...")
    print(f"  Chiqish: {OUTPUT_DIR}/ papkasi")

    os.makedirs(OUTPUT_DIR, exist_ok=True)

    grand_total = 0
    summary = []
    start_time = time.time()

    for key, data in COUNTRIES.items():
        try:
            count = fetch_country(key, data)
            grand_total += count
            summary.append((data["name"], count, data["file"]))
        except KeyboardInterrupt:
            print("\n\n⚠ Foydalanuvchi to'xtatdi!")
            break
        except Exception as e:
            print(f"\n❌ {data['name']} xatosi: {e}")
            summary.append((data["name"], 0, data["file"]))

    elapsed = time.time() - start_time
    mins    = int(elapsed // 60)
    secs    = int(elapsed % 60)

    print(f"\n\n{'═'*60}")
    print(f"  YAKUNIY HISOBOT  ({mins}:{secs:02d} daqiqa)")
    print(f"{'═'*60}")
    for cname, count, fname in summary:
        print(f"  {'✅' if count else '❌'}  {cname:20} → {count:4} ta  ({OUTPUT_DIR}/{fname})")
    print(f"{'─'*60}")
    print(f"  JAMI: {grand_total} ta ta'lim muassasasi")
    print(f"{'═'*60}")
    print(f"""
  Keyingi qadamlar (Laravel loyiha papkasida):
    mkdir -p database/data
    cp data/*.json database/data/
    php artisan db:seed --class=CentralAsiaSeeder
""")


if __name__ == "__main__":
    main()