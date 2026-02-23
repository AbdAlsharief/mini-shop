<x-app-layout>
    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8 animate-fade-in">
                <a href="{{ route('products.index') }}" class="hover:text-violet-400 transition-colors">Shop</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-300 font-medium">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-fade-in-up">

                <!-- Image Panel -->
                <div class="glass flex items-center justify-center h-72 md:h-96 relative overflow-hidden"
                     style="background:linear-gradient(135deg, rgba(139,92,246,0.12) 0%, rgba(99,102,241,0.06) 100%);">
                    <div class="text-9xl select-none opacity-50">🛍️</div>
                    <!-- Decorative circles -->
                    <div class="absolute -bottom-8 -right-8 w-40 h-40 rounded-full opacity-10 blur-2xl"
                         style="background:#8b5cf6;"></div>
                    <div class="absolute -top-8 -left-8 w-32 h-32 rounded-full opacity-10 blur-2xl"
                         style="background:#6366f1;"></div>
                </div>

                <!-- Product Info -->
                <div class="flex flex-col justify-between">
                    <div>
                        <!-- Badge -->
                        <span class="badge badge-success mb-4">✓ In Stock</span>

                        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-100 mb-4">
                            {{ $product->name }}
                        </h1>

                        @if($product->description ?? false)
                            <p class="text-gray-400 mb-6 leading-relaxed">{{ $product->description }}</p>
                        @endif

                        <!-- Price -->
                        <div class="flex items-end gap-2 mb-8">
                            <span class="text-5xl font-extrabold gradient-text">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="text-gray-500 text-sm mb-1">USD</span>
                        </div>

                        <!-- Divider -->
                        <div class="divider mb-6"></div>

                        <!-- Features list (decorative) -->
                        <ul class="space-y-2 mb-8">
                            <li class="flex items-center gap-2 text-sm text-gray-400">
                                <span class="text-green-400">✓</span> Free shipping on orders over $50
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-400">
                                <span class="text-green-400">✓</span> 30-day hassle-free returns
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-400">
                                <span class="text-green-400">✓</span> Secure checkout
                            </li>
                        </ul>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Add to Cart
                            </button>
                        </form>

                        <a href="{{ route('products.index') }}" class="btn-secondary justify-center py-3 text-base">
                            ← Back to Shop
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
