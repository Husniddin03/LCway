import json
import os
import time
from geopy.geocoders import Nominatim
from geopy.extra.rate_limiter import RateLimiter

BASE_DIR = "baza"
INPUT_FILE = os.path.join(BASE_DIR, "new_data.json")
OUTPUT_FILE = os.path.join(BASE_DIR, "final_data.json")
CACHE_FILE = os.path.join(BASE_DIR, "geo_cache.json")


def clean_text(text):
    if not text:
        return ""
    return (
        text.replace("ko`chasi", "ko'chasi")
            .replace("`", "'")
            .replace("  ", " ")
            .strip()
    )


def load_cache():
    if os.path.exists(CACHE_FILE):
        with open(CACHE_FILE, "r", encoding="utf-8") as f:
            return json.load(f)
    return {}


def save_cache(cache):
    with open(CACHE_FILE, "w", encoding="utf-8") as f:
        json.dump(cache, f, ensure_ascii=False, indent=2)


def get_coordinates():
    geolocator = Nominatim(user_agent="find_course_uz_cache_v1")

    # 🔥 RateLimiter to‘g‘ri sozlangan
    geocode = RateLimiter(
        geolocator.geocode,
        min_delay_seconds=1.2,
        max_retries=2,
        error_wait_seconds=5
    )

    if not os.path.exists(INPUT_FILE):
        print(f"{INPUT_FILE} topilmadi!")
        return

    with open(INPUT_FILE, "r", encoding="utf-8") as f:
        data = json.load(f)

    cache = load_cache()

    print(f"{len(data)} ta markaz tekshirilmoqda...\n")

    for index, item in enumerate(data):
        name = clean_text(item.get("Nameoftheeducationalinstitution", ""))
        address = clean_text(item.get("Businessaddress") or item.get("Legaladdress") or "")
        territory = clean_text(item.get("Territory", "").split(" ")[0])

        location = None

        # 🔥 Query variantlar
        queries = [
            f"{name}, {address}, Uzbekistan",
            f"{address}, Uzbekistan",
            f"{name}, {territory}, Uzbekistan",
            f"{name}, Uzbekistan"
        ]

        try:
            for query in queries:

                # 🔥 CACHE CHECK
                if query in cache:
                    location = cache[query]
                else:
                    location = geocode(query, timeout=10)

                    # cache ga yozamiz (None ham yoziladi!)
                    cache[query] = location

                if location:
                    break

            if location:
                item["latitude"] = location.latitude
                item["longitude"] = location.longitude
                status = "✅"
            else:
                item["latitude"] = None
                item["longitude"] = None
                status = "❌"

            print(f"[{index+1}] {status} {name}")

        except Exception as e:
            print(f"[{index+1}] ⚠️ XATO: {name} - {e}")
            item["latitude"] = None
            item["longitude"] = None
            time.sleep(3)

        # 🔥 har 50 ta da cache saqlanadi (crash bo‘lsa yo‘qolmaydi)
        if index % 50 == 0:
            save_cache(cache)

    # final save
    save_cache(cache)

    with open(OUTPUT_FILE, "w", encoding="utf-8") as f:
        json.dump(data, f, indent=4, ensure_ascii=False)

    print(f"\n✅ Tugadi: {OUTPUT_FILE}")


if __name__ == "__main__":
    get_coordinates()