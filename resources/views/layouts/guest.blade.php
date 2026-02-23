<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'MiniShop') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background-color:#0f0f14; color:#e5e7eb;">

        <!-- Background -->
        <div class="fixed inset-0 pointer-events-none" style="z-index:0;
             background: radial-gradient(ellipse at top left, rgba(139,92,246,0.12) 0%, transparent 50%),
                         radial-gradient(ellipse at bottom right, rgba(99,102,241,0.1) 0%, transparent 50%),
                         #0f0f14;">
        </div>

        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-8 pb-8 px-4" style="z-index:1;">

            <!-- Brand -->
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 group mb-6">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-bold text-xl
                            transition-transform duration-200 group-hover:scale-110"
                     style="background:linear-gradient(135deg,#8b5cf6,#6366f1);
                            box-shadow:0 0 24px rgba(139,92,246,0.5);">
                    M
                </div>
                <span class="text-2xl font-bold gradient-text">MiniShop</span>
            </a>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md glass px-8 py-8 animate-fade-in-up">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
