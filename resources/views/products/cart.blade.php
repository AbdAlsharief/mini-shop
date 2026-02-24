<x-app-layout>
    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                $cart = session('cart', []);
                $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            @endphp

            <!-- Page Header -->
            <div class="mb-8 animate-fade-in">
                <p class="section-label mb-1">Shopping</p>
                <h1 class="text-4xl font-extrabold gradient-text">Your Cart</h1>
            </div>

            <!-- Flash Messages -->
            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium animate-fade-in"
                     style="background:rgba(239,68,68,0.12); border:1px solid rgba(239,68,68,0.3); color:#f87171;">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium animate-fade-in"
                     style="background:rgba(34,197,94,0.12); border:1px solid rgba(34,197,94,0.3); color:#4ade80;">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4 stagger">
                        @foreach($cart as $id => $details)
                            <div class="glass p-5 flex items-center gap-5 animate-fade-in-up
                                        transition-all duration-200 hover:-translate-y-1"
                                 style="border-color:rgba(139,92,246,0.18);">

                                <!-- Icon -->
                                <div class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0"
                                     style="background:linear-gradient(135deg,rgba(139,92,246,0.2),rgba(99,102,241,0.1));">
                                    <span class="text-2xl">🛍️</span>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-100 truncate mb-1">{{ $details['name'] }}</h3>
                                    <p class="text-violet-400 font-semibold text-sm">${{ number_format($details['price'], 2) }} each</p>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @php $stock = $details['stock'] ?? PHP_INT_MAX; @endphp

                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ max(1, $details['quantity'] - 1) }}">
                                        <button type="submit"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center font-bold transition-all duration-150"
                                                style="background:rgba(139,92,246,0.15); color:#a78bfa;"
                                                onmouseenter="this.style.background='rgba(139,92,246,0.3)'"
                                                onmouseleave="this.style.background='rgba(139,92,246,0.15)'">−</button>
                                    </form>

                                    <span class="w-8 text-center font-bold text-gray-100 text-sm">{{ $details['quantity'] }}</span>

                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                        <button type="submit"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center font-bold transition-all duration-150"
                                                style="background:rgba(139,92,246,0.15); color:#a78bfa;"
                                                {{ $details['quantity'] >= $stock ? 'disabled' : '' }}
                                                onmouseenter="this.style.background='rgba(139,92,246,0.3)'"
                                                onmouseleave="this.style.background='rgba(139,92,246,0.15)'"
                                                @if($details['quantity'] >= $stock) title="Max stock reached" style="opacity:0.4; cursor:not-allowed;" @endif
                                        >+</button>
                                    </form>
                                </div>

                                <!-- Item Total -->
                                <div class="flex-shrink-0 text-right min-w-[80px]">
                                    <p class="font-extrabold text-white">${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                    <p class="text-xs text-gray-500">subtotal</p>
                                </div>

                                <!-- Remove -->
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-600
                                                                  hover:text-red-400 hover:bg-red-900/20 transition-all duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach

                        <!-- Continue Shopping -->
                        <a href="{{ route('products.index') }}" class="btn-secondary mt-2 inline-flex">
                            ← Continue Shopping
                        </a>
                    </div>

                    <!-- Order Summary -->
                    <div class="animate-fade-in-up" style="animation-delay:0.2s;">
                        <div class="glass p-6 sticky top-24">
                            <h2 class="font-bold text-lg text-gray-100 mb-5">Order Summary</h2>

                            <div class="space-y-3 mb-5">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Subtotal ({{ count($cart) }} {{ Str::plural('item', count($cart)) }})</span>
                                    <span class="text-gray-200 font-medium">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Shipping</span>
                                    <span class="text-green-400 font-medium">
                                        {{ $total >= 50 ? 'Free' : '$5.00' }}
                                    </span>
                                </div>
                                @if($total < 50)
                                    <p class="text-xs text-gray-500">Add ${{ number_format(50 - $total, 2) }} more for free shipping</p>
                                @endif
                            </div>

                            <div class="divider mb-5"></div>

                            <div class="flex justify-between items-end mb-6">
                                <span class="text-gray-300 font-semibold">Total</span>
                                <div class="text-right">
                                    <span class="text-3xl font-extrabold gradient-text">
                                        ${{ number_format($total >= 50 ? $total : $total + 5, 2) }}
                                    </span>
                                    <p class="text-xs text-gray-500">USD incl. taxes</p>
                                </div>
                            </div>

                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-success w-full justify-center py-3 text-base">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Checkout Securely
                                </button>
                            </form>

                            <p class="text-xs text-gray-600 text-center mt-4">🔒 SSL encrypted & secure</p>
                        </div>
                    </div>

                </div>
            @else
                <!-- Empty Cart -->
                <div class="glass text-center py-24 animate-fade-in">
                    <div class="text-8xl mb-5 opacity-20">🛒</div>
                    <h2 class="text-2xl font-bold text-gray-300 mb-3">Your cart is empty</h2>
                    <p class="text-gray-500 mb-8">Looks like you haven't added anything yet.</p>
                    <a href="{{ route('products.index') }}" class="btn-primary inline-flex">
                        Browse Products
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
