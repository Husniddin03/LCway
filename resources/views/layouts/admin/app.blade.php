<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Findora</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/2.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- PhotoSwipe CSS -->
    <link rel="stylesheet" href="https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
        
        <!-- Sidebar -->
        @include('layouts.admin.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col transition-all duration-300">
            
            <!-- Top Navbar -->
            @include('layouts.admin.navbar')
            
            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
            
            <!-- Footer -->
            @include('layouts.admin.footer')
        </div>
    </div>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- User Online Status Tracking -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update user online status every 2 minutes
            const updateOnlineStatus = () => {
                fetch('/api/user/heartbeat', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin'
                }).catch(() => {});
            };
            
            // Update immediately on page load
            updateOnlineStatus();
            
            // Update every 2 minutes
            setInterval(updateOnlineStatus, 2 * 60 * 1000);
            
            // Update on user activity
            let activityTimeout;
            const handleActivity = () => {
                clearTimeout(activityTimeout);
                activityTimeout = setTimeout(updateOnlineStatus, 5000);
            };
            
            ['click', 'scroll', 'keypress', 'mousemove'].forEach(event => {
                document.addEventListener(event, handleActivity, { passive: true });
            });
        });
    </script>
    
    <!-- PhotoSwipe Scripts -->
    <script type="module">
        import PhotoSwipeLightbox from 'https://unpkg.com/photoswipe@5.4.4/dist/photoswipe-lightbox.esm.js';
        import PhotoSwipe from 'https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.esm.js';
        
        window.PhotoSwipe = PhotoSwipe;
        window.PhotoSwipeLightbox = PhotoSwipeLightbox;
    </script>
</body>
</html>
