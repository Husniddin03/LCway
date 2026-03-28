#!/usr/bin/env python3
"""
Barcha viloyatlar uchun scriptlarni parallel ishga tushirish
"""

import os
import time
import subprocess
import threading
from datetime import datetime
from regions_config import REGIONS_CONFIG

class RegionRunner:
    def __init__(self):
        self.results = {}
        self.start_time = time.time()
        self.lock = threading.Lock()
    
    def run_region_script(self, region_key, region_data):
        """Bir viloyat scriptini parallel ishga tushirish"""
        script_name = f"{region_key}_learning_centers.py"
        
        try:
            print(f"🚀 {region_data['name']} uchun qidiruv boshlandi...")
            
            # Scriptni ishga tushirish
            result = subprocess.run(
                ["python3", script_name],
                capture_output=True,
                text=True,
                timeout=3600  # 1 soat timeout
            )
            
            elapsed = time.time() - self.start_time
            
            with self.lock:
                self.results[region_key] = {
                    "name": region_data["name"],
                    "success": result.returncode == 0,
                    "output": result.stdout,
                    "error": result.stderr,
                    "elapsed_minutes": int(elapsed // 60),
                    "elapsed_seconds": int(elapsed % 60)
                }
            
            if result.returncode == 0:
                print(f"✅ {region_data['name']} muvaffaqiyatli yakunlandi!")
            else:
                print(f"❌ {region_data['name']} xatolik bilan yakunlandi!")
                print(f"   Xato: {result.stderr[:200]}")
                
        except subprocess.TimeoutExpired:
            print(f"⏰ {region_data['name']} timeout ga uchradi (1 soat)")
            with self.lock:
                self.results[region_key] = {
                    "name": region_data["name"],
                    "success": False,
                    "output": "",
                    "error": "Timeout after 1 hour",
                    "elapsed_minutes": 60,
                    "elapsed_seconds": 0
                }
        except Exception as e:
            print(f"💥 {region_data['name']} ishga tushirishda xatolik: {e}")
            with self.lock:
                self.results[region_key] = {
                    "name": region_data["name"],
                    "success": False,
                    "output": "",
                    "error": str(e),
                    "elapsed_minutes": 0,
                    "elapsed_seconds": 0
                }
    
    def run_all_parallel(self, max_workers=4):
        """Barcha viloyatlarni parallel ishga tushirish"""
        print("🌍 O'zbekistonning barcha viloyatlari uchun parallel qidiruv")
        print(f"   📍 {len(REGIONS_CONFIG)} ta viloyat")
        print(f"   🔥 {max_workers} ta parallel jarayon")
        print(f"   ⏱️ Taxminiy vaqt: {len(REGIONS_CONFIG)//max_workers * 15} daqiqa")
        print()
        
        threads = []
        
        # Threadlarni yaratish
        for region_key, region_data in REGIONS_CONFIG.items():
            thread = threading.Thread(
                target=self.run_region_script,
                args=(region_key, region_data)
            )
            threads.append(thread)
        
        # Threadlarni guruhlab ishga tushurish
        for i in range(0, len(threads), max_workers):
            batch = threads[i:i + max_workers]
            print(f"🔄 {i+1}-{min(i+max_workers, len(threads))} viloyatlar qidiruvi boshlandi...")
            
            # Batch ni parallel ishga tushirish
            for thread in batch:
                thread.start()
            
            # Batch ni tugashini kutish
            for thread in batch:
                thread.join()
            
            if i + max_workers < len(threads):
                print(f"⏳ Keyingi batch 5 soniyadan keyin boshlanadi...")
                time.sleep(5)
    
    def print_final_report(self):
        """Yakuniy hisobot"""
        total_elapsed = time.time() - self.start_time
        hours = int(total_elapsed // 3600)
        minutes = int((total_elapsed % 3600) // 60)
        seconds = int(total_elapsed % 60)
        
        time_str = f"{hours}:{minutes:02d}:{seconds:02d}" if hours > 0 else f"{minutes}:{seconds:02d}"
        
        print("\n" + "═"*80)
        print(f"  YAKUNIY HISOBOT - BARCHA VILOYATLAR  ({time_str})")
        print("═"*80)
        
        successful = sum(1 for r in self.results.values() if r["success"])
        failed = len(self.results) - successful
        
        print(f"  📊 Muvaffaqiyatli: {successful}/{len(self.results)} viloyat")
        print(f"  ❌ Xatoliklar: {failed} viloyat")
        print()
        
        # Har bir viloyat bo'yicha natijalar
        for region_key, result in self.results.items():
            status = "✅" if result["success"] else "❌"
            time_str = f"{result['elapsed_minutes']}:{result['elapsed_seconds']:02d}"
            print(f"  {status} {result['name']:<25} | Vaqt: {time_str}")
        
        print("\n" + "═"*80)
        
        # JSON fayllarini birlashtirish
        self.merge_all_results()
        
        print(f"\n🎉 Hammasi tugadi! Umumiy vaqt: {time_str}")
    
    def merge_all_results(self):
        """Barcha viloyat natijalarini bitta JSON faylga birlashtirish"""
        print("\n📥 Barcha natijalarni birlashtirish...")
        
        all_centers = []
        total_by_region = {}
        
        for region_key, result in self.results.items():
            if not result["success"]:
                continue
            
            json_file = f"data/{region_key}_learning_centers.json"
            
            if os.path.exists(json_file):
                try:
                    with open(json_file, "r", encoding="utf-8") as f:
                        data = json.load(f)
                    
                    centers = data.get("centers", [])
                    all_centers.extend(centers)
                    total_by_region[region_key] = len(centers)
                    
                    print(f"   📄 {result['name']}: {len(centers)} ta markaz")
                    
                except Exception as e:
                    print(f"   ❌ {json_file} faylini o'qib bo'lmadi: {e}")
        
        # Birlashtirilgan faylni yozish
        merged_file = "data/uzbekistan_all_learning_centers.json"
        
        payload = {
            "generated_at": datetime.now().isoformat(),
            "country": "uzbekistan",
            "country_name": "O'zbekiston",
            "total": len(all_centers),
            "source": "Google Places API - Parallel Regional Search",
            "search_type": "all_learning_centers",
            "regions_searched": len(REGIONS_CONFIG),
            "successful_regions": len(total_by_region),
            "total_by_region": total_by_region,
            "centers": all_centers,
        }
        
        with open(merged_file, "w", encoding="utf-8") as f:
            json.dump(payload, f, ensure_ascii=False, indent=2)
        
        print(f"   ✅ Birlashtirilgan fayl: {merged_file}")
        print(f"   📊 Jami o'quv markazlari: {len(all_centers):,}")
        
        # Laravel uchun ko'chirish
        laravel_file = "database/data/uzbekistan_learning_centers.json"
        if os.path.exists(laravel_file):
            os.remove(laravel_file)
        
        os.makedirs("database/data", exist_ok=True)
        import shutil
        shutil.copy2(merged_file, laravel_file)
        
        print(f"   🔄 Laravel uchun nusxalandi: {laravel_file}")
        print(f"\n🔥 Laravel da ishga tushirish:")
        print(f"   php artisan db:seed --class=UzbekistanLearningCentersSeeder")

def main():
    print("╔" + "═"*78 + "╗")
    print("║  O'ZBEKISTON O'QUV MARKAZLARI - PARALLEL QIDIRUV      ║")
    print("║  Barcha viloyatlar bir vaqtda                        ║")
    print("╚" + "═"*78 + "╝")
    print()
    
    # Scriptlarni generatsiya qilish
    print("📝 Avval viloyat scriptlarini generatsiya qilish...")
    os.system("python3 generate_region_scripts.py")
    print()
    
    # Parallel ishga tushirish
    runner = RegionRunner()
    
    # CPU soniga qarab parallel sonini aniqlash
    import multiprocessing
    cpu_count = multiprocessing.cpu_count()
    max_workers = min(cpu_count, 4)  # Maksimum 4 ta parallel
    
    runner.run_all_parallel(max_workers)
    runner.print_final_report()

if __name__ == "__main__":
    main()
