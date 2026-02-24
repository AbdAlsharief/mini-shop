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
                    <span class="text-gray-300">New Product</span>
                </nav>
                <p class="section-label mb-1">Admin</p>
                <h1 class="text-3xl font-extrabold gradient-text">Create Product</h1>
            </div>

            <!-- Form -->
            <div class="glass p-8 animate-fade-in-up">
                <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">Product Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               placeholder="e.g. Premium Wireless Headphones"
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
                                  placeholder="Describe your product..."
                                  class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 transition-all duration-200 outline-none resize-none"
                                  style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                                  onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                                  onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">{{ old('description') }}</textarea>
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
                                <input type="number" id="price" name="price" value="{{ old('price') }}"
                                       step="0.01" min="0" placeholder="0.00"
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
                            <label for="stock" class="block text-sm font-semibold text-gray-300 mb-2">Stock <span class="text-red-400">*</span></label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}"
                                   min="0" placeholder="0"
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn-secondary justify-center py-3 px-6">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
