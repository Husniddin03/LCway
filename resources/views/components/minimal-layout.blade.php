<!DOCTYPE html>
<html lang="uz" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'FindCourse - Eng yaxshi o\'quv markazlari' }}</title>
    <meta name="description"
        content="{{ $description ?? 'O\'zbekiston bo\'ylab eng yaxshi o\'quv markazlarini toping. Kurslar, ustozlar va baholash tizimi.' }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/lcwayfavicon.png') }}">

    <!-- Custom fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Theme initialization script -->
    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
    </script>

    <!-- Custom styles for minimal layout -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Reset body margins for full-screen experience */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Hide scrollbars but keep functionality */
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Scripts Stack -->
    @stack('scripts')

</body>

</html>
