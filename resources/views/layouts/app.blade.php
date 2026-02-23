<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MiniShop') }} — Premium Store</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background-color:#0f0f14; color:#e5e7eb;">

        <!-- Background gradient orbs -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden" style="z-index:0;">
            <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full opacity-10 blur-3xl"
                 style="background:radial-gradient(circle, #8b5cf6 0%, transparent 70%);"></div>
            <div class="absolute top-1/2 -right-40 w-96 h-96 rounded-full opacity-8 blur-3xl"
                 style="background:radial-gradient(circle, #6366f1 0%, transparent 70%);"></div>
            <div class="absolute -bottom-20 left-1/3 w-80 h-80 rounded-full opacity-8 blur-3xl"
                 style="background:radial-gradient(circle, #a78bfa 0%, transparent 70%);"></div>
        </div>

        <div class="relative min-h-screen" style="z-index:1;">
            @include('layouts.navigation')

            <!-- Flash Messages -->
            @if(session('success') || session('error') || session('info'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                    @if(session('success'))
                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 animate-fade-in"
                             style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3);">
                            <span class="text-green-400">✓</span>
                            <span class="text-green-300 text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 animate-fade-in"
                             style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3);">
                            <span class="text-red-400">✕</span>
                            <span class="text-red-300 text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 animate-fade-in"
                             style="background:rgba(99,102,241,0.1); border:1px solid rgba(99,102,241,0.3);">
                            <span class="text-indigo-400">ℹ</span>
                            <span class="text-indigo-300 text-sm font-medium">{{ session('info') }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="mt-20 py-8 text-center" style="border-top:1px solid rgba(139,92,246,0.12);">
                <p class="text-gray-600 text-sm">
                    © {{ date('Y') }} <span class="gradient-text font-semibold">MiniShop</span> — Crafted with ❤️
                </p>
            </footer>
        </div>
    </body>
</html>
