#!/usr/bin/env python3
"""
API kalitni tekshiruvchi debug script.
Ishlatish: python3 debug_api.py YOUR_API_KEY
"""
import sys
import json
import requests

def check(api_key):
    print(f"🔑 API kalit: {api_key[:15]}...")
    print()

    # ── 1. Geocoding API test (eng oddiy) ──────────────────
    print("1️⃣  Geocoding API test...")
    r = requests.get(
        "https://maps.googleapis.com/maps/api/geocode/json",
        params={"address": "Samarkand, Uzbekistan", "key": api_key},
        timeout=10
    )
    data = r.json()
    status = data.get("status")
    print(f"   Status: {status}")
    if status == "OK":
        print("   ✅ Geocoding ishlaydi")
    else:
        print(f"   ❌ Xato: {data.get('error_message', 'Nomalum')}")

    print()

    # ── 2. Places Text Search ───────────────────────────────
    print("2️⃣  Places Text Search test...")
    r = requests.get(
        "https://maps.googleapis.com/maps/api/place/textsearch/json",
        params={
            "query":    "learning center samarkand uzbekistan",
            "key":      api_key,
            "language": "en",
        },
        timeout=10
    )
    data = r.json()
    status = data.get("status")
    print(f"   Status: {status}")
    if status == "OK":
        results = data.get("results", [])
        print(f"   ✅ Ishlaydi! {len(results)} ta natija")
        for res in results[:3]:
            print(f"      - {res.get('name')} | {res.get('formatted_address', '')[:50]}")
    elif status == "REQUEST_DENIED":
        msg = data.get("error_message", "")
        print(f"   ❌ REQUEST_DENIED: {msg}")
        print()
        print("   ═══ YECHIM ═══════════════════════════════════════")
        if "not authorized" in msg.lower() or "api" in msg.lower():
            print("   Places API yoqilmagan!")
            print("   → https://console.cloud.google.com/apis/library")
            print("   → 'Places API' ni qidiring va ENABLE bosing")
        if "billing" in msg.lower():
            print("   Billing ulanmagan!")
            print("   → https://console.cloud.google.com/billing")
            print("   → To'lov usulini ulang (kredit karta kerak)")
            print("   → Oyiga $200 = 28,000 so'rov bepul")
        print("   ═══════════════════════════════════════════════════")
    elif status == "ZERO_RESULTS":
        print("   ⚠ API ishlaydi lekin natija yo'q (bu boshqa muammo)")
    elif status == "INVALID_REQUEST":
        print(f"   ❌ Noto'g'ri so'rov: {data.get('error_message', '')}")
    else:
        print(f"   ❓ Kutilmagan status: {json.dumps(data, indent=2)[:300]}")

    print()

    # ── 3. Nearby Search ───────────────────────────────────
    print("3️⃣  Places Nearby Search test...")
    r = requests.get(
        "https://maps.googleapis.com/maps/api/place/nearbysearch/json",
        params={
            "location": "39.6553,66.9597",
            "radius":   5000,
            "keyword":  "education",
            "key":      api_key,
        },
        timeout=10
    )
    data = r.json()
    status = data.get("status")
    print(f"   Status: {status}")
    if status == "OK":
        results = data.get("results", [])
        print(f"   ✅ Ishlaydi! {len(results)} ta natija")
    else:
        print(f"   ❌ {status}: {data.get('error_message', '')}")

    print()
    print("═" * 55)
    print("  Agar REQUEST_DENIED chiqsa:")
    print("  1. https://console.cloud.google.com ga kiring")
    print("  2. APIs & Services > Library > 'Places API' ENABLE")
    print("  3. Billing > link a billing account")
    print("  4. Credentials > kalitingizga Places API ruxsati bering")
    print("═" * 55)


if __name__ == "__main__":
    if len(sys.argv) < 2:
        key = input("API kalitni kiriting: ").strip()
    else:
        key = sys.argv[1].strip()

    if not key:
        print("❌ API kalit bo'sh!")
        sys.exit(1)

    check(key)