#!/usr/bin/env python3
"""
database/data/ papkasidagi JSON fayllarida saqlangan
Google Places photo URL larini haqiqiy rasm URL lariga aylantiradi.

Ishlatish:
    pip install requests
    python3 resolve_photos.py

Natija:
    data/uzbekistan.json → yangilangan (haqiqiy URL lar bilan)
    data/kazakhstan.json → yangilangan
    ...
"""

import os
import json
import time
import requests
from datetime import datetime

# ── Sozlamalar ────────────────────────────────────────────
DATA_DIR    = "data"          # JSON fayllar papkasi
BACKUP      = True            # Asl faylni .bak sifatida saqlashmi?
DELAY       = 0.1             # So'rovlar orasidagi kutish (sekund)
TIMEOUT     = 10              # Har bir so'rov uchun timeout
# ──────────────────────────────────────────────────────────

GOOGLE_PHOTO_HOST = "maps.googleapis.com"


def is_google_photo_url(url: str) -> bool:
    """Google Places photo URL ekanligini tekshiradi"""
    return url and GOOGLE_PHOTO_HOST in url and "photo_reference" in url


def resolve_url(url: str) -> str:
    """
    Google Places photo URL → haqiqiy rasm URL.
    Google 302 redirect beradi, Location headerda haqiqiy URL bo'ladi.
    Haqiqiy URL: https://lh3.googleusercontent.com/... (kalit talamaydi)
    """
    try:
        r = requests.get(url, allow_redirects=False, timeout=TIMEOUT)
        location = r.headers.get("Location")
        if location:
            return location
    except Exception as e:
        print(f"    ⚠ Xato ({url[:60]}...): {e}")
    return url  # resolve bo'lmasa asl URL ni qaytaradi


def process_file(filepath: str) -> dict:
    """Bitta JSON faylni qayta ishlaydi"""
    stats = {"total": 0, "resolved": 0, "failed": 0, "skipped": 0}

    with open(filepath, "r", encoding="utf-8") as f:
        payload = json.load(f)

    centers = payload.get("centers", [])

    for ci, center in enumerate(centers):
        name = center.get("name", "?")

        # ── Logo ──────────────────────────────────────
        logo = center.get("logo")
        if logo and is_google_photo_url(logo):
            stats["total"] += 1
            print(f"  🖼  Logo  [{ci+1}] {name[:40]}")
            new_url = resolve_url(logo)
            if new_url != logo:
                center["logo"] = new_url
                stats["resolved"] += 1
                print(f"       ✅ {new_url[:70]}")
            else:
                stats["failed"] += 1
                print(f"       ❌ Resolve bo'lmadi")
            time.sleep(DELAY)

        # ── Images ────────────────────────────────────
        images = center.get("images", [])
        for ii, img in enumerate(images):
            url = img.get("url", "")
            if not is_google_photo_url(url):
                stats["skipped"] += 1
                continue

            stats["total"] += 1
            new_url = resolve_url(url)
            if new_url != url:
                img["url"] = new_url
                stats["resolved"] += 1
                print(f"       📷 [{ii+1}] ✅ {new_url[:70]}")
            else:
                stats["failed"] += 1
                print(f"       📷 [{ii+1}] ❌ Resolve bo'lmadi")
            time.sleep(DELAY)

    payload["resolved_at"] = datetime.now().isoformat()

    # Backup
    if BACKUP and stats["resolved"] > 0:
        bak = filepath + ".bak"
        if not os.path.exists(bak):
            with open(filepath, "r", encoding="utf-8") as f:
                orig = f.read()
            with open(bak, "w", encoding="utf-8") as f:
                f.write(orig)
            print(f"  💾 Backup: {bak}")

    # Yangilangan faylni yozish
    if stats["resolved"] > 0:
        with open(filepath, "w", encoding="utf-8") as f:
            json.dump(payload, f, ensure_ascii=False, indent=2)
        print(f"  ✅ Fayl yangilandi: {filepath}")

    return stats


def main():
    print("=" * 60)
    print("  Google Places Photo URL → Haqiqiy URL Konvertor")
    print("=" * 60)

    # JSON fayllarni topish
    if not os.path.isdir(DATA_DIR):
        print(f"❌ Papka topilmadi: {DATA_DIR}")
        print(f"   Scriptni JSON fayllar yonida ishga tushiring.")
        return

    json_files = [
        os.path.join(DATA_DIR, "uzbekistan.json")
    ]
    
    # Faqat mavjud fayllarni qo'shish
    json_files = [f for f in json_files if os.path.exists(f)]

    if not json_files:
        print(f"❌ {DATA_DIR}/ papkasida JSON fayl topilmadi.")
        return

    print(f"\n📂 Papka: {DATA_DIR}/")
    print(f"📄 Fayllar: {len(json_files)} ta")
    for f in json_files:
        size = os.path.getsize(f) // 1024
        print(f"   • {os.path.basename(f)}  ({size} KB)")

    print()

    grand = {"total": 0, "resolved": 0, "failed": 0, "skipped": 0}

    for filepath in json_files:
        fname = os.path.basename(filepath)
        print(f"\n{'─'*60}")
        print(f"📄 {fname}")
        print(f"{'─'*60}")

        try:
            stats = process_file(filepath)
            for k in grand:
                grand[k] += stats[k]

            print(f"\n  Jami: {stats['total']} | ✅ {stats['resolved']} | ❌ {stats['failed']}")
        except Exception as e:
            print(f"  ❌ Fayl xatosi: {e}")

    print(f"\n{'═'*60}")
    print(f"  YAKUNIY NATIJA")
    print(f"{'═'*60}")
    print(f"  📊 Jami URL lar:       {grand['total']}")
    print(f"  ✅ Muvaffaqiyatli:     {grand['resolved']}")
    print(f"  ❌ Resolve bo'lmadi:   {grand['failed']}")
    print(f"  ⏭  Allaqachon to'g'ri: {grand['skipped']}")
    print(f"{'═'*60}")

    if grand["resolved"] > 0:
        print(f"""
  Keyingi qadam — seeder bilan DB ga yangilash:
    php artisan db:seed --class=CentralAsiaSeeder
""")
    else:
        print("\n  ℹ Hech narsa o'zgarmadi (allaqachon to'g'ri yoki resolve bo'lmadi).")


if __name__ == "__main__":
    main()