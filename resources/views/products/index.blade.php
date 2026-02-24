<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Header -->
            <div class="mb-10 animate-fade-in-up">
                <p class="section-label mb-2">Discover</p>
                <h1 class="text-4xl sm:text-5xl font-extrabold gradient-text mb-3">Our Products</h1>
                <p class="text-gray-400 text-lg max-w-xl">
                    Hand-picked items, curated just for you. Find exactly what you're looking for.
                </p>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger">
                    @foreach($products as $product)
                        <a href="{{ route('products.show', $product->id) }}"
                           class="group block animate-fade-in-up" style="text-decoration:none;">
                            <div class="glass h-full flex flex-col overflow-hidden
                                        transition-all duration-300 group-hover:-translate-y-2"
                                 style="transition: transform 0.3s ease, box-shadow 0.3s ease;"
                                 onmouseenter="this.style.boxShadow='0 20px 60px rgba(139,92,246,0.25)'"
                                 onmouseleave="this.style.boxShadow=''">

                                <!-- Product Image Placeholder -->
                                <div class="relative h-44 flex items-center justify-center overflow-hidden"
                                     style="background:linear-gradient(135deg, rgba(139,92,246,0.15) 0%, rgba(99,102,241,0.08) 100%);
                                            border-bottom:1px solid rgba(139,92,246,0.12);">
                                    <div class="text-5xl select-none opacity-70 group-hover:scale-110 transition-transform duration-300">
                                        🛍️
                                    </div>
                                    <!-- Shine overlay -->
                                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                                         style="background:linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.05) 50%, transparent 60%);"></div>
                                </div>

                                <!-- Product Details -->
                                <div class="p-6 flex flex-col flex-1">
                                    <h2 class="text-lg font-bold text-gray-100 mb-2 group-hover:text-violet-300 transition-colors duration-200">
                                        {{ $product->name }}
                                    </h2>

                                    @if($product->description ?? false)
                                        <p class="text-sm text-gray-500 mb-4 line-clamp-2 flex-1">
                                            {{ $product->description }}
                                        </p>
                                    @else
                                        <div class="flex-1"></div>
                                    @endif

                                    <div class="flex items-center justify-between mt-4">
                                        <!-- Price -->
                                        <div>
                                            <span class="text-2xl font-extrabold text-white">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                        <!-- Stock Badge -->
                                        @if($product->stock > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                                  style="background:rgba(34,197,94,0.15); color:#4ade80; border:1px solid rgba(34,197,94,0.3);">
                                                ✓ {{ $product->stock }} left
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                                  style="background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.3);">
                                                ✗ Sold out
                                            </span>
                                        @endif
                                    </div>
                                    <!-- View CTA -->
                                    <div class="flex justify-end mt-3">
                                        <span class="flex items-center gap-1.5 text-sm font-semibold text-violet-400
                                                     group-hover:text-violet-300 transition-colors">
                                            View
                                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200"
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10 flex justify-center">
                    {{ $products->links() }}
                </div>

            @else
                <!-- Empty State -->
                <div class="glass text-center py-20 animate-fade-in">
                    <div class="text-7xl mb-4 opacity-30">🛒</div>
                    <h3 class="text-xl font-bold text-gray-300 mb-2">No products yet</h3>
                    <p class="text-gray-500">Check back soon — we're stocking up!</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
