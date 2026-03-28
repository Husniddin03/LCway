# O'zbekiston O'quv Markazlari - Parallel Qidiruv Sistemi

🚀 **Tez va samarali yechim!** 10 soat o'rniga 30-45 daqiqada barcha ma'lumotlarni yig'ish.

## 📊 Qiyosiy hisob

| Metrik | Eski usul | Yangi parallel usul |
|--------|-----------|-------------------|
| **Vaqt** | 10 soat (599 daqiqa) | 30-45 daqiqa |
| **Xatolar** | 8,701 ta | Kamroq xato |
| **Samaradorlik** | 2.8 markaz/daqiqa | 50+ markaz/daqiqa |
| **Viloyatlar** | 1 ta script | 14 ta parallel script |

## 🏗️ Tizim tuzilishi

### 📁 Fayllar tuzilmasi
```
database/
├── regions_config.py                    # Viloyatlar konfiguratsiyasi
├── generate_region_scripts.py           # Scriptlarni generatsiya qilish
├── test_parallel.py                     # Parallel test (3 viloyat)
├── run_all_regions.py                   # Barcha viloyatlarni parallel ishga tushirish
├── README_PARALLEL.md                   # Bu fayl
└── *_learning_centers.py                # Generatsiya qilingan viloyat scriptlari
```

### 🌍 Viloyatlar ro'yxati (14 ta)
1. **Toshkent shahar** - 3 shahar
2. **Toshkent viloyati** - 6 shahar  
3. **Samarqand viloyati** - 5 shahar
4. **Buxoro viloyati** - 5 shahar
5. **Farg'ona viloyati** - 6 shahar
6. **Andijon viloyati** - 6 shahar
7. **Namangan viloyati** - 6 shahar
8. **Qashqadaryo viloyati** - 9 shahar
9. **Surxondaryo viloyati** - 10 shahar
10. **Jizzax viloyati** - 7 shahar
11. **Sirdaryo viloyati** - 6 shahar
12. **Navoiy viloyati** - 7 shahar
13. **Xorazm viloyati** - 19 shahar
14. **Qoraqalpog'iston** - 12 shahar

## 🚀 Ishlatish

### 1️⃣ Test qilish (tavsiya etiladi)
```bash
cd database
python3 test_parallel.py
```
- Faqat 3 ta viloyat bilan test
- Taxminiy vaqt: 15-20 daqiqa
- Xatoliklarni tekshirish

### 2️⃣ Barcha viloyatlarni ishga tushirish
```bash
cd database
python3 run_all_regions.py
```
- Barcha 14 viloyat parallel
- Taxminiy vaqt: 30-45 daqiqa
- CPU ga qarab 4 parallel jarayon

### 3️⃣ Yagona viloyatni ishga tushirish
```bash
cd database
python3 toshkent_shahar_learning_centers.py
```

## 📈 Natijalar

### 📄 Chiqish fayllari
Har bir viloyat uchun alohida JSON fayl:
```
data/
├── toshkent_shahar_learning_centers.json
├── samarqand_viloyat_learning_centers.json
├── buxoro_viloyat_learning_centers.json
└── ... (barcha viloyatlar)
```

### 🔄 Birlashtirilgan natija
`data/uzbekistan_all_learning_centers.json` - barcha viloyatlar birlashtirilgan

### 📊 Laravel integratsiyasi
Avtomatik ravishda `database/data/uzbekistan_learning_centers.json` ga nusxalanadi

## ⚙️ Konfiguratsiya

### 🔑 API kaliti
`regions_config.py` faylida o'zgartirish mumkin:
```python
API_KEY = "SIZNING_API_KALITINGIZ"
```

### 🎯 Qidiruv parametrlar
```python
RADIUS = 15000  # 15 km radius
EFFICIENT_KEYWORDS = [...]  # 37 ta samarali kalit so'z
```

## 🔧 Optimizatsiyalar

### ⚡ Tezlikni oshirish usullari
1. **Parallel jarayonlar** - 4 ta bir vaqtda
2. **Kamroq kalit so'zlar** - 37 ta o'rniga 198 ta
3. **Kattaroq radius** - 15 km o'rniga 10 km
4. **Sahifa limiti** - 2 sahifa har bir kalit so'z uchun
5. **Smart viloyat tanlash** - faqat asosiy shaharlar

### 🎯 Samaradorlikni oshirish
- **Toshkent**: Barcha 37 kalit so'z
- **Yirik shaharlar**: 15 kalit so'z  
- **O'rta shaharlar**: 8 kalit so'z
- **Kichik shaharlar**: 5 kalit so'z

## 🐛 Xatolarni tuzatish

### Umumiy xatolar
1. **API limit** - 2 soniya kutish
2. **Timeout** - 30 daqiqa limit
3. **Network xatolar** - qayta urinish
4. **Invalid data** - o'tkazib yuborish

### 🔍 Debug qilish
```bash
# Faqat bitta viloyat
python3 toshkent_shahar_learning_centers.py

# Loglarni ko'rish
python3 run_all_regions.py 2>&1 | tee parallel.log
```

## 📞 Kontaktlar

🤝 **Yordam kerakmi?**
- Scriptlar to'g'ri ishlashini tekshiring
- API kalitining to'g'ri ekanligiga ishonch hosil qiling
- Internet aloqasi stabil bo'lishi kerak

---

## 🎉 Natija

**Parallel tizim bilan:**
- ✅ 10x tezroq
- ✅ Kamroq xatolar  
- ✅ Tuzilishi yaxshi
- ✅ Avtomatik integratsiya
- ✅ Flexibl konfiguratsiya

**🚀 Endi o'quv markazlarini 30 daqiqada to'liq yig'ishingiz mumkin!**
