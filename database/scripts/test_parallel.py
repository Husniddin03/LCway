#!/usr/bin/env python3
"""
Parallel ishga tushirishni test qilish - faqat 3 ta viloyat bilan
"""

import os
import time
import subprocess
import threading
from datetime import datetime

# Test uchun 3 ta viloyat
TEST_REGIONS = {
    "samarqand_viloyat": {"name": "Samarqand viloyati"},
}

class TestRunner:
    def __init__(self):
        self.results = {}
        self.start_time = time.time()
        self.lock = threading.Lock()
    
    def run_region_script(self, region_key, region_data):
        """Bir viloyat scriptini parallel ishga tushirish"""
        script_name = f"{region_key}_learning_centers.py"
        
        try:
            print(f"🚀 {region_data['name']} uchun qidiruv boshlandi...")
            
            result = subprocess.run(
                ["python3", script_name],
                capture_output=True,
                text=True,
                timeout=1800  # 30 daqiqa timeout
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
            print(f"⏰ {region_data['name']} timeout ga uchradi (30 daqiqa)")
            with self.lock:
                self.results[region_key] = {
                    "name": region_data["name"],
                    "success": False,
                    "output": "",
                    "error": "Timeout after 30 minutes",
                    "elapsed_minutes": 30,
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
    
    def run_test_parallel(self):
        """Test uchun 3 ta viloyatni parallel ishga tushirish"""
        print("🧪 PARALLEL TEST - 3 ta viloyat")
        print(f"   📍 {len(TEST_REGIONS)} ta viloyat")
        print(f"   🔥 3 ta parallel jarayon")
        print(f"   ⏱️ Taxminiy vaqt: 15-20 daqiqa")
        print()
        
        threads = []
        
        # Threadlarni yaratish
        for region_key, region_data in TEST_REGIONS.items():
            thread = threading.Thread(
                target=self.run_region_script,
                args=(region_key, region_data)
            )
            threads.append(thread)
        
        # Barchasini parallel ishga tushirish
        print("🔄 Barcha 3 viloyatlar qidiruvi boshlandi...")
        
        for thread in threads:
            thread.start()
        
        # Barchasini tugashini kutish
        for thread in threads:
            thread.join()
    
    def print_test_report(self):
        """Test natijalari"""
        total_elapsed = time.time() - self.start_time
        minutes = int(total_elapsed // 60)
        seconds = int(total_elapsed % 60)
        
        print("\n" + "═"*80)
        print(f"  TEST YAKUNIY HISOBOT  ({minutes}:{seconds:02d} daqiqa)")
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
        
        # Agar test muvaffaqiyatli bo'lsa
        if successful == len(TEST_REGIONS):
            print("🎉 TEST MUVAFFAQIYATLI!")
            print("🔥 Endi barcha viloyatlarni ishga tushirish mumkin:")
            print("   python3 run_all_regions.py")
        else:
            print("⚠️ TESTDA XATOLIKLAR BOR!")
            print("🔧 Xatolarni tuzatib qayta urinib ko'ring.")

def main():
    print("╔" + "═"*78 + "╗")
    print("║  O'ZBEKISTON O'QUV MARKAZLARI - PARALLEL TEST         ║")
    print("║  Faqat 3 ta viloyat bilan sinov                       ║")
    print("╚" + "═"*78 + "╝")
    print()
    
    runner = TestRunner()
    runner.run_test_parallel()
    runner.print_test_report()

if __name__ == "__main__":
    main()
