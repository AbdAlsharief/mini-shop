<x-app-layout>
    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 animate-fade-in-up">
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('admin.products.index') }}" class="hover:text-violet-400 transition-colors">Admin</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-300">Edit Product</span>
                </nav>
                <p class="section-label mb-1">Admin</p>
                <h1 class="text-3xl font-extrabold gradient-text">Edit Product</h1>
            </div>

            <!-- Info Strip -->
            <div class="glass p-4 mb-6 flex items-center gap-4 animate-fade-in">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,rgba(139,92,246,0.2),rgba(99,102,241,0.1));">
                    <span class="text-xl">🛍️</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-100 truncate">{{ $product->name }}</p>
                    <p class="text-xs text-gray-500">ID #{{ $product->id }} &middot; Created {{ $product->created_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('products.show', $product->id) }}"
                   class="text-xs text-violet-400 hover:text-violet-300 transition-colors flex-shrink-0">
                    View in shop →
                </a>
            </div>

            <!-- Form -->
            <div class="glass p-8 animate-fade-in-up">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">Product Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 transition-all duration-200 outline-none"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-300 mb-2">Description <span class="text-gray-600">optional</span></label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 transition-all duration-200 outline-none resize-none"
                                  style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                                  onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                                  onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price & Stock -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-300 mb-2">Price (USD) <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">$</span>
                                <input type="number" id="price" name="price"
                                       value="{{ old('price', $product->price) }}"
                                       step="0.01" min="0"
                                       class="w-full pl-8 pr-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 transition-all duration-200 outline-none"
                                       style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                                       onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                                       onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                            </div>
                            @error('price')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-300 mb-2">
                                Stock
                                @if($product->stock <= 0)
                                    <span class="ml-1 text-xs font-normal" style="color:#f87171;">⚠ Out of stock</span>
                                @elseif($product->stock <= 10)
                                    <span class="ml-1 text-xs font-normal" style="color:#fbbf24;">⚠ Low stock</span>
                                @endif
                                <span class="text-red-400">*</span>
                            </label>
                            <input type="number" id="stock" name="stock"
                                   value="{{ old('stock', $product->stock) }}"
                                   min="0"
                                   class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 transition-all duration-200 outline-none"
                                   style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                                   onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                                   onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                            @error('stock')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn-primary flex-1 justify-center py-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Changes
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn-secondary justify-center py-3 px-6">
                            Cancel
                        </a>
                    </div>
                </form>

                <!-- Danger Zone -->
                <div class="mt-8 pt-6" style="border-top:1px solid rgba(239,68,68,0.2);">
                    <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-3">Danger Zone</p>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                          onsubmit="return confirm('Delete \'{{ addslashes($product->name) }}\'? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-150"
                                style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);"
                                onmouseenter="this.style.background='rgba(239,68,68,0.2)'"
                                onmouseleave="this.style.background='rgba(239,68,68,0.1)'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete this product
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
