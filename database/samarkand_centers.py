#!/usr/bin/env python3
"""
O'quv markazlari uchun rasmlarni bepul manbalardan yig'uvchi script.

Usul:
  1. DuckDuckGo Image Search — markaz nomi bo'yicha rasm qidiradi
  2. Wikimedia Commons     — topilmasa Wikimedia dan oladi

Kerakli kutubxonalar:
    pip install requests beautifulsoup4

Ishlatish:
    python3 fetch_images.py

Input:  data/samarkand_centers.json
Output: data/samarkand_centers.json (yangilangan)
        storage/app/public/learning_centers/ (yuklab olingan rasmlar)
"""

import os
import re
import json
import time
import random
import hashlib
import requests
from datetime import datetime
from urllib.parse import quote, urlencode
from bs4 import BeautifulSoup

INPUT_FILE   = "data/samarkand_centers.json"
OUTPUT_FILE  = "data/samarkand_centers.json"
BACKUP_FILE  = "data/samarkand_centers.bak.json"
IMAGES_DIR   = "storage/app/public/learning_centers"

# Rasmlarni diskka yuklab olishmi?
# True  → faylga saqlaydi, JSON ga lokal yo'lni yozadi
# False → faqat URL ni JSON ga yozadi
DOWNLOAD     = True

# Har bir markaz uchun max nechta rasm
MAX_IMAGES   = 5

# So'rovlar orasidagi kutish (bot himoyasidan o'tish uchun)
MIN_DELAY    = 1.5
MAX_DELAY    = 3.5

# ══════════════════════════════════════════════════════
#  HEADERS — oddiy brauzer kabi ko'rinish uchun
# ══════════════════════════════════════════════════════
HEADERS = {
    "User-Agent": (
        "Mozilla/5.0 (X11; Linux x86_64) "
        "AppleWebKit/537.36 (KHTML, like Gecko) "
        "Chrome/120.0.0.0 Safari/537.36"
    ),
    "Accept-Language": "uz,ru;q=0.9,en;q=0.8",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
}

# ══════════════════════════════════════════════════════
#  1. DuckDuckGo IMAGE SEARCH
# ══════════════════════════════════════════════════════

def duckduckgo_images(query: str, max_results: int = 5) -> list:
    """
    DuckDuckGo orqali rasm URL larini qaytaradi.
    Avval token oladi, keyin rasm qidiradi.
    """
    urls = []

    try:
        # 1. Token olish
        session = requests.Session()
        session.headers.update(HEADERS)

        r = session.get(
            "https://duckduckgo.com/",
            params={"q": query, "iar": "images", "iax": "images", "ia": "images"},
            timeout=15
        )
        token_match = re.search(r'vqd=([\d-]+)', r.text)
        if not token_match:
            return []
        token = token_match.group(1)

        time.sleep(random.uniform(0.5, 1.0))

        # 2. Rasm qidirish
        params = {
            "l":   "uz-uz",
            "o":   "json",
            "q":   query,
            "vqd": token,
            "f":   ",,,,,",
            "p":   "1",
        }
        r2 = session.get(
            "https://duckduckgo.com/i.js",
            params=params,
            timeout=15
        )
        data = r2.json()

        for result in data.get("results", [])[:max_results]:
            img_url = result.get("image")
            if img_url and img_url.startswith("http"):
                urls.append(img_url)

    except Exception as e:
        print(f"      DuckDuckGo xato: {e}")

    return urls


# ══════════════════════════════════════════════════════
#  2. WIKIMEDIA COMMONS SEARCH
# ══════════════════════════════════════════════════════

def wikimedia_images(query: str, max_results: int = 3) -> list:
    """
    Wikimedia Commons dan rasm URL larini qaytaradi.
    """
    urls = []

    try:
        params = {
            "action":      "query",
            "generator":   "search",
            "gsrnamespace": "6",       # File namespace
            "gsrsearch":   f"filetype:bitmap {query}",
            "gsrlimit":    max_results,
            "prop":        "imageinfo",
            "iiprop":      "url|size",
            "iiurlwidth":  800,
            "format":      "json",
            "origin":      "*",
        }
        r = requests.get(
            "https://commons.wikimedia.org/w/api.php",
            params=params,
            headers=HEADERS,
            timeout=15
        )
        data = r.json()
        pages = data.get("query", {}).get("pages", {})

        for page in pages.values():
            info = page.get("imageinfo", [{}])[0]
            url  = info.get("thumburl") or info.get("url")
            if url:
                urls.append(url)

    except Exception as e:
        print(f"      Wikimedia xato: {e}")

    return urls


# ══════════════════════════════════════════════════════
#  RASM YUKLASH
# ══════════════════════════════════════════════════════

def download_image(url: str, folder: str, filename: str) -> str | None:
    """Rasmni yuklab oladi, yo'lni qaytaradi"""
    os.makedirs(folder, exist_ok=True)
    filepath = os.path.join(folder, filename)

    if os.path.exists(filepath):
        return filepath

    try:
        r = requests.get(url, headers=HEADERS, timeout=20, stream=True)
        r.raise_for_status()

        content_type = r.headers.get("content-type", "")
        if "image" not in content_type and "jpeg" not in content_type:
            return None

        with open(filepath, "wb") as f:
            for chunk in r.iter_content(8192):
                f.write(chunk)

        size = os.path.getsize(filepath)
        if size < 5000:   # 5KB dan kichik → yaroqsiz rasm
            os.remove(filepath)
            return None

        return filepath

    except Exception as e:
        print(f"        Yuklash xato: {e}")
        return None


def make_filename(center_id: int, index: int, url: str) -> str:
    """Fayl nomini yasaydi"""
    ext  = url.split("?")[0].rsplit(".", 1)[-1].lower()
    ext  = ext if ext in ("jpg", "jpeg", "png", "webp") else "jpg"
    return f"lc_{center_id}_{index}.{ext}"


# ══════════════════════════════════════════════════════
#  ASOSIY FUNKSIYA — bitta markaz uchun rasm qidirish
# ══════════════════════════════════════════════════════

def fetch_images_for_center(center: dict, center_id: int) -> tuple[str | None, list]:
    """
    Markaz uchun rasmlar qidiradi.
    Qaytaradi: (logo_url, [images_list])
    """
    name    = center.get("name", "")
    region  = center.get("region", "Samarqand")
    address = center.get("address", "")

    # Qidiruv so'rovlari — aniqdan umumga
    queries = [
        f"{name} {region}",
        f"{name} Samarqand",
        f"{name} o'quv markaz",
        f"{name}",
    ]

    all_urls = []

    for query in queries:
        if len(all_urls) >= MAX_IMAGES:
            break

        print(f"      🔍 DuckDuckGo: '{query}'")
        ddg_urls = duckduckgo_images(query, MAX_IMAGES)
        all_urls.extend(ddg_urls)
        time.sleep(random.uniform(MIN_DELAY, MAX_DELAY))

        if not all_urls:
            print(f"      🔍 Wikimedia: '{query}'")
            wiki_urls = wikimedia_images(query, 3)
            all_urls.extend(wiki_urls)
            time.sleep(random.uniform(0.5, 1.5))

        if all_urls:
            break

    # Takrorlanmasin
    all_urls = list(dict.fromkeys(all_urls))[:MAX_IMAGES]

    if not all_urls:
        return None, []

    logo   = None
    images = []

    for i, url in enumerate(all_urls):
        if DOWNLOAD:
            filename = make_filename(center_id, i, url)
            local    = download_image(url, IMAGES_DIR, filename)
            if not local:
                continue
            # Laravel storage yo'li
            storage_path = f"learning_centers/{filename}"
            if i == 0:
                logo = storage_path
            else:
                images.append({"url": storage_path})
        else:
            if i == 0:
                logo = url
            else:
                images.append({"url": url})

        print(f"        {'🖼  logo' if i == 0 else f'📷 [{i}]'} ✅")
        time.sleep(0.3)

    return logo, images


# ══════════════════════════════════════════════════════
#  ASOSIY
# ══════════════════════════════════════════════════════

def main():
    print("═" * 58)
    print("  O'quv Markazlari — Bepul Rasm Yig'uvchi")
    print("  DuckDuckGo + Wikimedia Commons")
    print("═" * 58)

    # Faylni o'qish
    if not os.path.exists(INPUT_FILE):
        print(f"❌ Fayl topilmadi: {INPUT_FILE}")
        return

    with open(INPUT_FILE, "r", encoding="utf-8") as f:
        data = json.load(f)

    centers = data.get("centers", [])
    total   = len(centers)
    print(f"\n📄 {INPUT_FILE}")
    print(f"📊 Jami markazlar: {total}")
    print(f"🖼  Max rasm/markaz: {MAX_IMAGES}")
    print(f"💾 Yuklash: {'Ha' if DOWNLOAD else 'Yoq (faqat URL)'}\n")

    # Backup
    with open(BACKUP_FILE, "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=2)
    print(f"💾 Backup: {BACKUP_FILE}\n")

    stats = {"found": 0, "not_found": 0, "skipped": 0}

    for i, center in enumerate(centers):
        name = center.get("name", "Noma'lum")
        print(f"\n[{i+1:4}/{total}] {name[:50]}")

        # Allaqachon rasmi bor bo'lsa o'tkazib yuborish
        existing_logo   = center.get("logo")
        existing_images = center.get("images", [])

        if existing_logo and existing_images:
            print(f"      ⏭  Allaqachon rasmi bor, o'tkazildi")
            stats["skipped"] += 1
            continue

        # Rasm qidirish
        logo, images = fetch_images_for_center(center, i + 1)

        if logo or images:
            if not existing_logo and logo:
                center["logo"] = logo
            if not existing_images and images:
                center["images"] = images
            stats["found"] += 1
            print(f"      ✅ Logo: {'bor' if logo else 'yoq'} | Rasmlar: {len(images)}")
        else:
            stats["not_found"] += 1
            print(f"      ❌ Rasm topilmadi")

        # Har 10 ta markaz dan keyin faylni saqlash (xavfsizlik)
        if (i + 1) % 10 == 0:
            data["updated_at"] = datetime.now().isoformat()
            with open(OUTPUT_FILE, "w", encoding="utf-8") as f:
                json.dump(data, f, ensure_ascii=False, indent=2)
            print(f"\n  💾 Oraliq saqlash: {i+1} ta")

    # Yakuniy saqlash
    data["images_fetched_at"] = datetime.now().isoformat()
    with open(OUTPUT_FILE, "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=2)

    print(f"\n{'═'*58}")
    print(f"  NATIJA")
    print(f"{'═'*58}")
    print(f"  ✅ Rasm topildi:      {stats['found']}")
    print(f"  ❌ Rasm topilmadi:    {stats['not_found']}")
    print(f"  ⏭  O'tkazildi:       {stats['skipped']}")
    print(f"{'═'*58}")
    print(f"\n  💾 Saqlandi: {OUTPUT_FILE}")
    print(f"""
  Keyingi qadam:
    php artisan db:seed --class=LearningCenterSeeder
""")


if __name__ == "__main__":
    main()