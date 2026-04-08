import json
import os
import requests
from bs4 import BeautifulSoup
import re

# Ijtimoiy tarmoqlarni aniqlash uchun muntazam ifodalar (Regex)
INSTAGRAM_RE = r"https?://(?:www\.)?instagram\.com/[a-zA-Z0-0_.]+"
TELEGRAM_RE = r"https?://(?:www\.)?(?:t\.me|telegram\.me)/[a-zA-Z0-0_]+"

def find_social_links(query):
    # Google qidiruv natijalaridan havolalarni qidirish
    # DIQQAT: Bu yerda Serper.dev yoki shunga o'xshash arzon API ishlatish tavsiya etiladi
    search_url = f"https://www.google.com/search?q={query}"
    headers = {"User-Agent": "Mozilla/5.0"}
    
    links = {"instagram": None, "telegram": None, "website": None}
    
    try:
        response = requests.get(search_url, headers=headers)
        content = response.text
        
        # Instagram topish
        insta = re.findall(INSTAGRAM_RE, content)
        if insta: links["instagram"] = list(set(insta))[0]
        
        # Telegram topish
        tele = re.findall(TELEGRAM_RE, content)
        if tele: links["telegram"] = list(set(tele))[0]
        
    except Exception as e:
        print(f"Xato: {e}")
        
    return links

# Asosiy JSONni yangilash
def enrich_contacts():
    with open("baza/final_data.json", "r") as f:
        data = json.load(f)

    for item in data[:5]:  # Test uchun dastlabki 5 tasi
        name = item["Nameoftheeducationalinstitution"]
        city = item["Territory"].split(" ")[0]
        
        print(f"Qidirilmoqda: {name}...")
        
        # Qidiruv so'rovi: "Nomi + Shahar + instagram telegram"
        query = f"{name} {city} instagram telegram"
        socials = find_social_links(query)
        
        item.update(socials)
        
    with open("baza/ultra_data.json", "w") as f:
        json.dump(data, f, indent=4, ensure_ascii=False)

# enrich_contacts()