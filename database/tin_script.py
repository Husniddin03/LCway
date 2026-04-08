import asyncio
import aiohttp
import json
import os
from bs4 import BeautifulSoup

BASE_DIR = "baza"
INPUT_FILE = os.path.join(BASE_DIR, "data.json")
OUTPUT_FILE = os.path.join(BASE_DIR, "new_data.json")
MAX_CONCURRENT_REQUESTS = 3 # Sayt bloklamasligi uchun biroz kamaytirdik

def decode_cloudflare_email(cf_email):
    # Hex kodni byte ko'rinishiga o'tkazamiz
    n = int(cf_email[:2], 16)
    email = ""
    for i in range(2, len(cf_email), 2):
        # Har bir juftlikni XOR amali bilan ochamiz
        email += chr(int(cf_email[i:i+2], 16) ^ n)
    return email

async def fetch_org_details(session, item):
    tin = item.get("TIN")
    if not tin:
        return item

    search_url = f"https://orginfo.uz/uz/search/all/?q={tin}"
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Accept-Language': 'uz,ru;q=0.9,en;q=0.8'
    }

    try:
        # 1-qadam: Qidiruv natijasidan tashkilot sahifasiga link topish
        async with session.get(search_url, headers=headers, timeout=15) as response:
            if response.status != 200:
                item["OrgInfo_Error"] = f"Search Status: {response.status}"
                return item
            
            html = await response.text()
            soup = BeautifulSoup(html, 'html.parser')
            
            # Kartochkadagi linkni qidirish
            org_link_tag = soup.find('a', class_='og-card')
            if not org_link_tag or not org_link_tag.get('href'):
                item["Status_from_web"] = "Topilmadi"
                return item
            
            detail_url = f"https://orginfo.uz{org_link_tag.get('href')}"

        # 2-qadam: Tashkilotning ichki sahifasidan ma'lumotlarni olish
        async with session.get(detail_url, headers=headers, timeout=15) as detail_res:
            if detail_res.status == 200:
                detail_html = await detail_res.text()
                d_soup = BeautifulSoup(detail_html, 'html.parser')
                
                # Ma'lumotlarni qirqib olish (Taqdim etgan HTML bo'yicha)
                
                # 1. Holati
                status = d_soup.find('span', itemprop='status')
                item["Status_from_web"] = status.text.strip() if status else "Noma'lum"
                
                # 2. Rahbar
                manager_tag = d_soup.find('a', href=lambda x: x and '/uz/search/managers/' in x)
                item["Manager_Name"] = manager_tag.find('span').text.strip() if manager_tag else "Noma'lum"
                
                # 3. Telefon
                phone_tag = d_soup.find('a', itemprop='telephone')
                item["Phone_Number"] = phone_tag.text.strip() if phone_tag else "Yashirilgan yoki yo'q"
                
                # 4. Email
                # Emailni olish qismi
                email_tag = d_soup.find('a', itemprop='email')
                if email_tag:
                    # Agar href ichida cfemail bo'lsa
                    cf_email = email_tag.get('data-cfemail') or email_tag.find('span', class_='__cf_email__')
                    if cf_email:
                        # Agar tag bo'lsa uning data-cfemail atributini olamiz
                        if hasattr(cf_email, 'get'):
                            hex_data = cf_email.get('data-cfemail')
                        else:
                            hex_data = cf_email
                        item["Email"] = decode_cloudflare_email(hex_data)
                    else:
                        item["Email"] = email_tag.text.strip()
                else:
                    item["Email"] = "Yo'q"
                
                # 5. IFUT
                ifut_section = d_soup.find(string="IFUT")
                if ifut_section:
                    ifut_value = ifut_section.find_parent('div').find_next_sibling('div').text.strip()
                    item["IFUT"] = ifut_value
                
                print(f"[OK] {tin} - {item.get('Nameoftheeducationalinstitution')[:30]}...")
            else:
                item["OrgInfo_Error"] = f"Detail Page Error: {detail_res.status}"

    except Exception as e:
        print(f"[ERROR] TIN: {tin} - {str(e)}")
        item["OrgInfo_Error"] = str(e)

    return item

async def main():
    if not os.path.exists(INPUT_FILE):
        print(f"Fayl topilmadi: {INPUT_FILE}")
        return

    with open(INPUT_FILE, 'r', encoding='utf-8') as f:
        data = json.load(f)

    # Test uchun birinchi 10 tasini ko'rish yoki hammasini:
    # data = data[:10] 

    connector = aiohttp.TCPConnector(limit_per_host=MAX_CONCURRENT_REQUESTS)
    async with aiohttp.ClientSession(connector=connector) as session:
        tasks = [fetch_org_details(session, item) for item in data]
        updated_data = await asyncio.gather(*tasks)

    with open(OUTPUT_FILE, 'w', encoding='utf-8') as f:
        json.dump(updated_data, f, indent=4, ensure_ascii=False)
    
    print(f"\nJarayon yakunlandi. Natija: {OUTPUT_FILE}")

if __name__ == "__main__":
    asyncio.run(main())
