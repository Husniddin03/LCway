@props([
    'src', 
    'alt' => '', 
    'class' => '', 
    'width' => null, 
    'height' => null, 
    'loading' => 'lazy', 
    'decoding' => 'async',
    'fetchpriority' => null,
    'eager' => false
])

@php
    // Eager loading sozlamalari
    if ($eager) {
        $loading = 'eager';
        $fetchpriority = $fetchpriority ?? 'high';
    }

    // Faqat storage ichidagi rasmlar uchun WebP versiyasini tekshiramiz
    $isStorage = str_contains($src, 'storage/');
    $webpSrc = $isStorage ? str_replace(['.jpg', '.jpeg', '.png'], '.webp', $src) : null;
    
    // O'lchamlarni olishda xatolikni oldini olish
    if (!$width || !$height) {
        try {
            $imageService = app(\App\Services\ImageOptimizationService::class);
            // Agar storage bo'lsa filtrlaymiz, aks holda asli qoladi
            $path = $isStorage ? str_replace(asset('storage/'), '', $src) : public_path(parse_url($src, PHP_URL_PATH));
            $dimensions = $imageService->getImageDimensions($path);
            $width = $width ?? ($dimensions['width'] ?? null);
            $height = $height ?? ($dimensions['height'] ?? null);
        } catch (\Exception $e) {
            // Xatolik bo'lsa o'lchamsiz qoldiramiz
        }
    }
@endphp

<picture>
    @if($webpSrc && $isStorage)
        <source srcset="{{ $webpSrc }}" type="image/webp">
    @endif
    <img 
        src="{{ $src }}" 
        alt="{{ $alt }}" 
        class="{{ $class }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        loading="{{ $loading }}"
        decoding="{{ $decoding }}"
        @if($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
    >
</picture>