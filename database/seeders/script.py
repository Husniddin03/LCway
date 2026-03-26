#!/usr/bin/env python3
"""
Samarqanddagi o'quv markazlarni OpenStreetMap (Overpass API) orqali olib,
JSON faylga saqlovchi script.

✅ Mutlaqo BEPUL
✅ API kalit KERAK EMAS
✅ Cheklov yo'q

O'rnatish:  pip install requests
Ishlatish:  python3 fetch_samarkand.py
Natija:     samarkand_centers.json
"""

import time
import json
import requests
from datetime import datetime

OUTPUT_FILE = "samarkand_centers.json"

# Samarqand bounding box (janub-g'arb → shimol-sharq)
BBOX = "39.5,66.7,39.8,67.2"  # lat_min,lon_min,lat_max,lon_max

# Overpass API endpointlari (agar biri ishlamasa keyingisiga o'tadi)
OVERPASS_SERVERS = [
    "https://overpass-api.de/api/interpreter",
    "https://overpass.kumi.systems/api/interpreter",
    "https://maps.mail.ru/osm/tools/overpass/api/interpreter",
]

# ──────────────────────────────────────────────
# Overpass QL so'rovlari — barcha turdagi o'quv joylari
# ──────────────────────────────────────────────
QUERIES = [
    # Rasmiy ta'lim muassasalari
    f'node["amenity"="school"]({BBOX});',
    f'way["amenity"="school"]({BBOX});',
    f'node["amenity"="university"]({BBOX});',
    f'way["amenity"="university"]({BBOX});',
    f'node["amenity"="college"]({BBOX});',
    f'way["amenity"="college"]({BBOX});',
    f'node["amenity"="language_school"]({BBOX});',
    f'way["amenity"="language_school"]({BBOX});',
    f'node["amenity"="driving_school"]({BBOX});',
    # O'quv markazlari (turli teglarda bo'lishi mumkin)
    f'node["education"="yes"]({BBOX});',
    f'node["leisure"="yes"]["name"~"markaz|kurs|school|center|о.қув",i]({BBOX});',
    f'node["name"~"o.quv markaz|ta.lim|kurs|learning|repetitor|Education",i]({BBOX});',
    f'way["name"~"o.quv markaz|ta.lim|kurs|learning|repetitor|Education",i]({BBOX});',
]


def overpass_query(query_body, server):
    full_query = f'[out:json][timeout:30];\n({query_body}\n);\nout body center;'
    r = requests.post(server, data={"data": full_query}, timeout=40)
    r.raise_for_status()
    return r.json()


def get_working_server():
    """Ishlaydigan Overpass serverni topadi"""
    for server in OVERPASS_SERVERS:
        try:
            r = requests.post(
                server,
                data={"data": "[out:json];node(1);out;"},
                timeout=10
            )
            if r.status_code == 200:
                print(f"✅ Server: {server}")
                return server
        except:
            continue
    return None


def extract_center(element):
    """
    OSM elementdan learning_centers sxemasiga mos dict yasaydi.
    """
    tags = element.get("tags", {})
    etype = element.get("type", "node")

    # Koordinatlar
    if etype == "node":
        lat = element.get("lat")
        lon = element.get("lon")
    else:
        # way uchun center
        center = element.get("center", {})
        lat = center.get("lat")
        lon = center.get("lon")

    if not lat or not lon:
        return None

    name = (
        tags.get("name:uz")
        or tags.get("name")
        or tags.get("name:ru")
        or tags.get("name:en")
        or "Noma'lum"
    )

    # Tur aniqlash
    amenity = tags.get("amenity", "")
    if amenity == "university":
        center_type = "Universitet"
    elif amenity in ("school", "college"):
        center_type = "Maktab/Kurs"
    elif amenity == "language_school":
        center_type = "Til kurslari"
    elif amenity == "driving_school":
        center_type = "Haydovchilik kursi"
    else:
        center_type = "O'quv markaz"

    # Manzil
    address_parts = []
    for key in ("addr:street", "addr:housenumber", "addr:city", "addr:district"):
        v = tags.get(key)
        if v:
            address_parts.append(v)
    address = ", ".join(address_parts) if address_parts else tags.get("addr:full", "Samarqand")

    # Ish vaqtlari (opening_hours tegi)
    working_hours = parse_opening_hours(tags.get("opening_hours", ""))

    # Kontaktlar
    conns = []
    phone = tags.get("phone") or tags.get("contact:phone")
    if phone:
        conns.append({"type": "Telefon", "url": phone})
    website = tags.get("website") or tags.get("contact:website") or tags.get("url")
    if website:
        conns.append({"type": "Sayt", "url": website})
    telegram = tags.get("contact:telegram")
    if telegram:
        conns.append({"type": "Telegram", "url": telegram})
    instagram = tags.get("contact:instagram")
    if instagram:
        conns.append({"type": "Instagram", "url": instagram})

    # OSM URL
    osm_id = element.get("id")
    osm_url = f"https://www.openstreetmap.org/{etype}/{osm_id}"
    conns.append({"type": "OpenStreetMap", "url": osm_url})

    # About
    desc = tags.get("description") or tags.get("description:uz") or tags.get("description:ru")
    subjects = tags.get("subject") or tags.get("subjects")
    about_parts = []
    if desc:
        about_parts.append(desc)
    if subjects:
        about_parts.append(f"Fanlar: {subjects}")
    about = " | ".join(about_parts) if about_parts else None

    return {
        "osm_id":   f"{etype}/{osm_id}",
        "name":     name,
        "type":     center_type,
        "about":    about,
        "province": "Samarqand viloyati",
        "region":   tags.get("addr:city", "Samarqand shahar"),
        "address":  address,
        "location": f"{lat},{lon}",
        "place_id": None,
        "rating":   None,
        "ratings_total": 0,
        "google_types":  [amenity] if amenity else [],
        "photos":        [],
        "working_hours": working_hours,
        "connections":   conns,
        "reviews":       [],
        # Qo'shimcha OSM ma'lumotlari
        "tags": tags,
    }


def parse_opening_hours(oh_str):
    """
    OSM opening_hours formatini parse qiladi.
    Misol: "Mo-Fr 09:00-18:00; Sa 10:00-15:00"
    """
    if not oh_str or oh_str.strip() == "24/7":
        if oh_str == "24/7":
            return [{"weekday": d, "open_time": "00:00:00", "close_time": "23:59:00"}
                    for d in ["Dushanba","Seshanba","Chorshanba","Payshanba","Juma","Shanba","Yakshanba"]]
        return []

    DAY_MAP = {
        "Mo": "Dushanba", "Tu": "Seshanba", "We": "Chorshanba",
        "Th": "Payshanba", "Fr": "Juma", "Sa": "Shanba", "Su": "Yakshanba",
    }
    ALL_DAYS = list(DAY_MAP.values())

    results = []
    try:
        parts = oh_str.split(";")
        for part in parts:
            part = part.strip()
            if not part:
                continue

            # Vaqtni ajratish: "Mo-Fr 09:00-18:00"
            tokens = part.split()
            if len(tokens) < 2:
                continue

            days_str = tokens[0]
            time_str = tokens[1] if len(tokens) > 1 else ""

            if "-" in time_str and ":" in time_str:
                times = time_str.split("-")
                open_t  = times[0].strip() + ":00" if len(times[0].strip()) == 5 else "09:00:00"
                close_t = times[1].strip() + ":00" if len(times) > 1 and len(times[1].strip()) == 5 else "18:00:00"
            else:
                open_t, close_t = "09:00:00", "18:00:00"

            # Kunlarni aniqlash
            if days_str == "Mo-Fr":
                days = ["Dushanba","Seshanba","Chorshanba","Payshanba","Juma"]
            elif days_str == "Mo-Sa":
                days = ALL_DAYS[:6]
            elif days_str == "Mo-Su":
                days = ALL_DAYS
            elif "-" in days_str:
                d_parts = days_str.split("-")
                start = DAY_MAP.get(d_parts[0])
                end   = DAY_MAP.get(d_parts[1])
                if start and end:
                    si = ALL_DAYS.index(start)
                    ei = ALL_DAYS.index(end)
                    days = ALL_DAYS[si:ei+1]
                else:
                    days = []
            elif "," in days_str:
                days = [DAY_MAP.get(d.strip()) for d in days_str.split(",") if DAY_MAP.get(d.strip())]
            else:
                days = [DAY_MAP.get(days_str)] if DAY_MAP.get(days_str) else []

            for day in days:
                if day:
                    results.append({
                        "weekday":    day,
                        "open_time":  open_t,
                        "close_time": close_t,
                    })
    except:
        pass

    return results


def main():
    print("=" * 58)
    print("  Samarqand O'quv Markazlari — OpenStreetMap Yig'uvchi")
    print("  (BEPUL, API kalit kerak emas)")
    print("=" * 58)

    # Ishlaydigan serverni topish
    print("\n🌐 Overpass server tekshirilmoqda...")
    server = get_working_server()
    if not server:
        print("❌ Hech qaysi Overpass server javob bermadi.")
        print("   Internet ulanishini tekshiring.")
        return

    # Barcha so'rovlarni yuborish
    print(f"\n1-BOSQICH: Ma'lumot yig'ish ({len(QUERIES)} ta so'rov)...")
    all_elements = {}  # osm_id → element (takrorlanmaslik uchun)

    for i, q in enumerate(QUERIES, 1):
        try:
            data = overpass_query(q, server)
            elements = data.get("elements", [])
            for el in elements:
                key = f"{el['type']}/{el['id']}"
                all_elements[key] = el
            print(f"  [{i}/{len(QUERIES)}] {len(elements):3d} ta | Jami noyob: {len(all_elements)}")
            time.sleep(1)  # Server yukini kamaytirish
        except Exception as e:
            print(f"  [{i}/{len(QUERIES)}] ⚠ Xato: {e}")

    print(f"\n✅ Jami {len(all_elements)} ta noyob element topildi")

    # Har birini parse qilish
    print("\n2-BOSQICH: Ma'lumotlarni tayyorlash...")
    centers = []
    skipped = 0

    for key, el in all_elements.items():
        tags = el.get("tags", {})
        name = tags.get("name") or tags.get("name:uz") or tags.get("name:ru")

        # Nomsizlarni o'tkazib yuborish (ko'pincha keraksiz)
        if not name:
            skipped += 1
            continue

        c = extract_center(el)
        if c:
            centers.append(c)
            print(f"  ✅ {c['name']} ({c['type']})")

    print(f"\n  O'tkazildi (nomsiz): {skipped}")

    # JSON ga yozish
    print(f"\n3-BOSQICH: JSON ga yozish → {OUTPUT_FILE}")
    payload = {
        "generated_at": datetime.now().isoformat(),
        "total":        len(centers),
        "source":       "OpenStreetMap / Overpass API",
        "city":         "Samarqand, Uzbekistan",
        "centers":      centers,
    }
    with open(OUTPUT_FILE, "w", encoding="utf-8") as f:
        json.dump(payload, f, ensure_ascii=False, indent=2)

    print("\n" + "=" * 58)
    print(f"  ✅ {len(centers)} ta markaz → {OUTPUT_FILE}")
    print("=" * 58)
    print(f"""
  Keyingi qadam (Laravel papkasida):
  mkdir -p database/data
  cp {OUTPUT_FILE} database/data/samarkand_centers.json
  php artisan db:seed --class=LearningCenterSeeder
""")


if __name__ == "__main__":
    main()