{{-- Partial: products grid + result count + pagination (used by both full renders and AJAX swaps) --}}
@if($products->count() > 0)
    <p class="text-sm text-gray-500 mb-5" id="result-count">
        Showing <span class="text-gray-300 font-semibold">{{ $products->total() }}</span>
        product{{ $products->total() !== 1 ? 's' : '' }}
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger">
        @foreach($products as $product)
            <a href="{{ route('products.show', $product->id) }}"
               class="group block animate-fade-in-up" style="text-decoration:none;">
                <div class="glass h-full flex flex-col overflow-hidden
                            transition-all duration-300 group-hover:-translate-y-2"
                     style="transition: transform 0.3s ease, box-shadow 0.3s ease;"
                     onmouseenter="this.style.boxShadow='0 20px 60px rgba(139,92,246,0.25)'"
                     onmouseleave="this.style.boxShadow=''">

                    {{-- Image placeholder --}}
                    <div class="relative h-44 flex items-center justify-center overflow-hidden"
                         style="background:linear-gradient(135deg, rgba(139,92,246,0.15) 0%, rgba(99,102,241,0.08) 100%);
                                border-bottom:1px solid rgba(139,92,246,0.12);">
                        <div class="text-5xl select-none opacity-70 group-hover:scale-110 transition-transform duration-300">
                            🛍️
                        </div>
                        @if($product->category)
                            <span class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(139,92,246,0.2); color:#c4b5fd; border:1px solid rgba(139,92,246,0.3);">
                                {{ $product->category->name }}
                            </span>
                        @endif
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                             style="background:linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.05) 50%, transparent 60%);"></div>
                    </div>

                    {{-- Details --}}
                    <div class="p-6 flex flex-col flex-1">
                        <h2 class="text-lg font-bold text-gray-100 mb-1 group-hover:text-violet-300 transition-colors duration-200">
                            {{ $product->name }}
                        </h2>

                        @if($product->description ?? false)
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2 flex-1">
                                {{ $product->description }}
                            </p>
                        @else
                            <div class="flex-1"></div>
                        @endif

                        {{-- Tags --}}
                        @if($product->tags->isNotEmpty())
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                @foreach($product->tags as $tag)
                                    <span class="text-xs px-2 py-0.5 rounded-full"
                                          style="background:rgba(99,102,241,0.15); color:#a5b4fc; border:1px solid rgba(99,102,241,0.25);">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-auto pt-3" style="border-top:1px solid rgba(255,255,255,0.06);">
                            <span class="text-2xl font-extrabold text-white">${{ number_format($product->price, 2) }}</span>
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

    {{-- Pagination --}}
    <div class="mt-10 flex justify-center" id="pagination">
        {{ $products->links() }}
    </div>

@else
    <div class="glass text-center py-20 animate-fade-in">
        <div class="text-7xl mb-4 opacity-30">🔍</div>
        <h3 class="text-xl font-bold text-gray-300 mb-2">No products found</h3>
        <p class="text-gray-500 mb-6">Try adjusting your filters or search term.</p>
        <a href="{{ route('products.index') }}"
           class="inline-block px-6 py-2.5 rounded-lg text-sm font-semibold text-white transition"
           style="background:linear-gradient(135deg,#7c3aed,#6366f1);">
            Clear all filters
        </a>
    </div>
@endif
