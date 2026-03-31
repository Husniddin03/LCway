.PHONY: deploy optimize clear-cache

# Git o'zgarishlarni yuborish (Ishlatish: make push m="Xabarni yozing")
push:
	@if [ -z "$(m)" ]; then \
		echo "❌ Xato: Commit xabarini yozing! Masalan: make push m='fix bug'"; \
		exit 1; \
	fi
	git add .
	git commit -m "$(m)"
	git push origin main
	@echo "✅ O'zgarishlar Git-ga muvaffaqiyatli yuborildi!"

# Git o'zgarishlarni yuborish (Interaktiv xabar so'rash bilan)
push-in:
	@echo "📝 Commit xabarini kiriting:"
	@read msg; \
	if [ -z "$$msg" ]; then \
		echo "❌ Xato: Xabar bo'sh bo'lishi mumkin emas!"; \
		exit 1; \
	fi; \
	git add .; \
	git commit -m "$$msg"; \
	git push origin main
	@echo "✅ O'zgarishlar Git-ga muvaffaqiyatli yuborildi!"

# Oxirgi versiyani olish
pull:
	git pull origin main
	@echo "📥 Oxirgi o'zgarishlar qabul qilindi!"

# Git holatini tekshirish
status:
	git status

# Default deployment command
deploy:
	@echo "🔄 Pulling latest changes..."
	git pull origin main

	@echo "🚀 Starting deployment..."
	
	# 1. Install dependencies
	composer install --optimize-autoloader --no-dev --no-interaction
	
	# 2. Database migrations (optional, uncomment if needed)
	# php artisan migrate --force
	
	# 3. Optimization
	php artisan config:cache
	php artisan route:cache
	php artisan view:cache
	php artisan event:cache
	php artisan optimize
	
	@echo "✅ Deployment finished successfully!"

# Just optimization
optimize:
	@echo "⚡ Optimizing application..."
	php artisan config:cache
	php artisan route:cache
	php artisan view:cache
	php artisan event:cache
	php artisan optimize
	@echo "✨ Optimization done!"

# Clear all cache (for debugging)
clear-cache:
	@echo "🧹 Clearing all cache..."
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear
	php artisan cache:clear
	@echo "🧼 Cache cleared!"
