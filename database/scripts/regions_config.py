#!/usr/bin/env python3
"""
O'zbekiston viloyatlari va ularning asosiy shaharlari konfiguratsiyasi
"""

# ═══════════════════════════════════════════════════════
#  VILoyATLAR BO'YICHA SHAHARLAR
# ═══════════════════════════════════════════════════════

REGIONS_CONFIG = {
    "toshkent_shahar": {
        "name": "Toshkent shahar",
        "cities": [
            {"name": "Toshkent", "lat": 41.2995, "lng": 69.2401},
            {"name": "Chirchiq", "lat": 41.5333, "lng": 69.5833},
            {"name": "Angren", "lat": 41.0167, "lng": 70.1333},
        ]
    },
    "toshkent_viloyat": {
        "name": "Toshkent viloyati",
        "cities": [
            {"name": "Guliston", "lat": 40.4897, "lng": 68.7842},
            {"name": "Bekobod", "lat": 40.7833, "lng": 68.5333},
            {"name": "Olmaliq", "lat": 40.7833, "lng": 69.6000},
            {"name": "Piskent", "lat": 40.9667, "lng": 69.4167},
            {"name": "Zangiota", "lat": 41.1667, "lng": 69.2167},
            {"name": "Parkent", "lat": 41.2833, "lng": 69.6500},
        ]
    },
    "samarqand_viloyat": {
        "name": "Samarqand viloyati",
        "cities": [
            {"name": "Samarqand", "lat": 39.6553, "lng": 66.9597},
            {"name": "Kattakurgon", "lat": 39.8833, "lng": 66.8167},
            {"name": "Urgut", "lat": 39.6667, "lng": 67.2500},
            {"name": "Jomboy", "lat": 39.7167, "lng": 66.8333},
            {"name": "Bulung'ur", "lat": 39.5333, "lng": 66.9167},
        ]
    },
    "buxoro_viloyat": {
        "name": "Buxoro viloyati",
        "cities": [
            {"name": "Buxoro", "lat": 39.7747, "lng": 64.4286},
            {"name": "Kogon", "lat": 39.7500, "lng": 65.4167},
            {"name": "G'ijduvon", "lat": 39.6500, "lng": 64.7167},
            {"name": "Vobkent", "lat": 40.0333, "lng": 64.5167},
            {"name": "Jondor", "lat": 39.5833, "lng": 64.2333},
        ]
    },
    "fargona_viloyat": {
        "name": "Farg'ona viloyati",
        "cities": [
            {"name": "Farg'ona", "lat": 40.3834, "lng": 71.7814},
            {"name": "Marg'ilon", "lat": 40.4167, "lng": 71.6833},
            {"name": "Qo'qon", "lat": 40.7167, "lng": 70.9500},
            {"name": "Beshariq", "lat": 40.9167, "lng": 71.9500},
            {"name": "Quva", "lat": 40.4167, "lng": 71.8833},
            {"name": "Uchko'prik", "lat": 40.5333, "lng": 71.8500},
        ]
    },
    "andijon_viloyat": {
        "name": "Andijon viloyati",
        "cities": [
            {"name": "Andijon", "lat": 40.7821, "lng": 72.3442},
            {"name": "Xonobod", "lat": 40.9833, "lng": 68.4167},
            {"name": "Marhamat", "lat": 40.4333, "lng": 71.9500},
            {"name": "Buloqboshi", "lat": 40.9500, "lng": 71.6333},
            {"name": "Shahrixon", "lat": 40.6167, "lng": 72.3167},
            {"name": "Paxtobod", "lat": 40.9333, "lng": 72.1833},
        ]
    },
    "namangan_viloyat": {
        "name": "Namangan viloyati",
        "cities": [
            {"name": "Namangan", "lat": 41.0011, "lng": 71.6728},
            {"name": "Chortoq", "lat": 40.8500, "lng": 68.9500},
            {"name": "Uychi", "lat": 40.9667, "lng": 72.0333},
            {"name": "Pop", "lat": 40.9833, "lng": 71.0167},
            {"name": "Kosonsoy", "lat": 41.2833, "lng": 71.6500},
            {"name": "Uchqo'rg'on", "lat": 40.9167, "lng": 71.7833},
        ]
    },
    "qashqadaryo_viloyat": {
        "name": "Qashqadaryo viloyati",
        "cities": [
            {"name": "Qarshi", "lat": 38.8610, "lng": 65.7883},
            {"name": "Qamashi", "lat": 39.9667, "lng": 66.8833},
            {"name": "Muborak", "lat": 39.5667, "lng": 65.6833},
            {"name": "Koson", "lat": 39.5500, "lng": 65.5833},
            {"name": "Yakkabog'", "lat": 39.6167, "lng": 66.3167},
            {"name": "Qiziltepa", "lat": 38.9167, "lng": 65.7833},
            {"name": "Shahrisabz", "lat": 39.3000, "lng": 66.4167},
            {"name": "Kitob", "lat": 39.6667, "lng": 66.8667},
            {"name": "Mirzachul", "lat": 40.7500, "lng": 68.8333},
        ]
    },
    "surxondaryo_viloyat": {
        "name": "Surxondaryo viloyati",
        "cities": [
            {"name": "Termiz", "lat": 37.2240, "lng": 67.2783},
            {"name": "Denov", "lat": 38.2833, "lng": 67.8833},
            {"name": "Jarkurgon", "lat": 37.9167, "lng": 67.5667},
            {"name": "Qumqo'rg'on", "lat": 38.7667, "lng": 67.2167},
            {"name": "Qiziriq", "lat": 37.9500, "lng": 67.4500},
            {"name": "Bandixon", "lat": 37.2333, "lng": 67.2833},
            {"name": "Muzrabot", "lat": 37.6500, "lng": 67.4167},
            {"name": "Sho'rchi", "lat": 37.8500, "lng": 67.6833},
            {"name": "Angor", "lat": 37.5833, "lng": 67.4500},
            {"name": "Boysun", "lat": 38.2167, "lng": 67.0667},
        ]
    },
    "jizzax_viloyat": {
        "name": "Jizzax viloyati",
        "cities": [
            {"name": "Jizzax", "lat": 40.1158, "lng": 67.8422},
            {"name": "G'allaorol", "lat": 40.2833, "lng": 67.6833},
            {"name": "Paxtakor", "lat": 40.2333, "lng": 68.0167},
            {"name": "Zarbdor", "lat": 40.8833, "lng": 71.6667},
            {"name": "Mingbuloq", "lat": 40.9333, "lng": 68.1167},
            {"name": "Forish", "lat": 40.1167, "lng": 67.5167},
            {"name": "Yangibozor", "lat": 40.3500, "lng": 67.4500},
        ]
    },
    "sirdaryo_viloyat": {
        "name": "Sirdaryo viloyati",
        "cities": [
            {"name": "Guliston", "lat": 40.4897, "lng": 68.7842},
            {"name": "Boyovut", "lat": 40.4167, "lng": 68.2333},
            {"name": "Sirdaryo", "lat": 40.8333, "lng": 68.6667},
            {"name": "Xovos", "lat": 40.3500, "lng": 68.7500},
            {"name": "Baxt", "lat": 40.2833, "lng": 68.8833},
            {"name": "Sayxunobod", "lat": 40.4500, "lng": 68.9167},
        ]
    },
    "navoiy_viloyat": {
        "name": "Navoiy viloyati",
        "cities": [
            {"name": "Navoiy", "lat": 40.1008, "lng": 65.3792},
            {"name": "Zarafshon", "lat": 40.1333, "lng": 67.6167},
            {"name": "Uchquduq", "lat": 40.1167, "lng": 66.9167},
            {"name": "Tomdibuloq", "lat": 40.0667, "lng": 66.8167},
            {"name": "Qiziltepa", "lat": 40.4500, "lng": 65.6500},
            {"name": "Nurota", "lat": 40.1167, "lng": 65.6833},
            {"name": "Konimex", "lat": 39.7500, "lng": 65.2833},
        ]
    },
    "xorazm_viloyat": {
        "name": "Xorazm viloyati",
        "cities": [
            {"name": "Urganch", "lat": 41.5500, "lng": 60.6333},
            {"name": "Xiva", "lat": 41.3833, "lng": 60.3667},
            {"name": "Buloqboshi", "lat": 40.9500, "lng": 71.6333},
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
            {"name": "Gurlan", "lat": 41.6667, "lng": 60.1500},
            {"name": "Qo'shnopir", "lat": 41.5333, "lng": 60.2833},
            {"name": "Yangiariq", "lat": 41.5500, "lng": 60.6167},
            {"name": "Hazorasp", "lat": 41.4167, "lng": 60.6833},
            {"name": "Shovot", "lat": 41.3000, "lng": 60.5333},
            {"name": "Yangibozor", "lat": 41.6167, "lng": 60.4167},
        ]
    },
    "qoraqalpogiston": {
        "name": "Qoraqalpog'iston Respublikasi",
        "cities": [
            {"name": "Nukus", "lat": 42.4600, "lng": 59.6100},
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
        ]
    }
}

# ═══════════════════════════════════════════════════════
#  SAMARALI KALIT SO'ZLAR
# ═══════════════════════════════════════════════════════

EFFICIENT_KEYWORDS = [
    # Asosiy atamalar
    "o'quv markaz",
    "ta'lim markazi", 
    "kurs markazi",
    "learning center",
    "education center",
    "training center",
    
    # Til kurslari
    "ingliz tili kursi",
    "english course",
    "rus tili kursi",
    
    # IT va dasturlash
    "it kurslari",
    "programming course",
    "dasturlash kursi",
    "kompyuter kurslari",
    
    # Tayyorlov kurslari
    "maktabga tayyorlov",
    "test sinovlari",
    "imtihonga tayyorlov",
    "DTM kursi",
    "universitetga tayyorlov",
    
    # Xorijiy tillar
    "IELTS kursi",
    "TOEFL kursi",
    "chet tiliga tayyorlov",
    
    # Qo'shimcha
    "matematika kursi",
    "repetitor markazi",
    "tutorial center",
    "online kurs",
    
    # Rus tilida
    "учебный центр",
    "курсы английского языка",
    "курсы программирования",
]

API_KEY = "AIzaSyDWnRvtEeIQpCNX4v8grqnOiyi8ZNw4oz4"
OUTPUT_DIR = "data"
RADIUS = 15000  # 15 km
