<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8 animate-fade-in-up">
                <div>
                    <p class="section-label mb-1">Admin</p>
                    <h1 class="text-4xl font-extrabold gradient-text">Products</h1>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Product
                </a>
            </div>

            <!-- Stats Strip -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                @php
                    $myProducts = Auth::user()->products();
                    $total      = $products->total();
                    $inStock    = (clone $myProducts)->where('stock', '>', 0)->count();
                    $outOfStock = (clone $myProducts)->where('stock', 0)->count();
                    $totalStock = (clone $myProducts)->sum('stock');
                @endphp
                @foreach([
                    ['label' => 'Total Products', 'value' => $total,      'color' => '#8b5cf6'],
                    ['label' => 'In Stock',        'value' => $inStock,    'color' => '#4ade80'],
                    ['label' => 'Out of Stock',     'value' => $outOfStock, 'color' => '#f87171'],
                    ['label' => 'Total Units',      'value' => $totalStock, 'color' => '#60a5fa'],
                ] as $stat)
                    <div class="glass p-4 animate-fade-in-up">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-extrabold" style="color:{{ $stat['color'] }};">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Table -->
            @if($products->count() > 0)
                <div class="glass overflow-hidden animate-fade-in-up">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom:1px solid rgba(139,92,246,0.2); background:rgba(139,92,246,0.06);">
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Product</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Price</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Stock</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="--tw-divide-opacity:1; border-color:rgba(139,92,246,0.1);">
                            @foreach($products as $product)
                                <tr class="transition-colors duration-150 hover:bg-white/[0.02]">
                                    <!-- Product -->
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                                 style="background:linear-gradient(135deg,rgba(139,92,246,0.2),rgba(99,102,241,0.1));">
                                                <span class="text-base">🛍️</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-100">{{ $product->name }}</p>
                                                @if($product->description)
                                                    <p class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($product->description, 50) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Price -->
                                    <td class="px-5 py-4">
                                        <span class="font-bold text-white">${{ number_format($product->price, 2) }}</span>
                                    </td>

                                    <!-- Stock -->
                                    <td class="px-5 py-4">
                                        <span class="font-semibold {{ $product->stock > 0 ? 'text-gray-200' : 'text-red-400' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-5 py-4">
                                        @if($product->stock > 10)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                                  style="background:rgba(34,197,94,0.15); color:#4ade80; border:1px solid rgba(34,197,94,0.3);">
                                                ✓ In Stock
                                            </span>
                                        @elseif($product->stock > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                                  style="background:rgba(251,191,36,0.15); color:#fbbf24; border:1px solid rgba(251,191,36,0.3);">
                                                ⚠ Low Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                                  style="background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.3);">
                                                ✗ Out of Stock
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- View -->
                                            <a href="{{ route('products.show', $product->id) }}"
                                               title="View in shop"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-150"
                                               style="background:rgba(99,102,241,0.12); color:#818cf8;"
                                               onmouseenter="this.style.background='rgba(99,102,241,0.25)'"
                                               onmouseleave="this.style.background='rgba(99,102,241,0.12)'">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9.548 4.072A8.956 8.956 0 003 12c0-4.97 4.03-9 9-9s9 4.03 9 9-4.03 9-9 9a8.956 8.956 0 01-6.452-2.728"/>
                                                </svg>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                               title="Edit"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-150"
                                               style="background:rgba(139,92,246,0.12); color:#a78bfa;"
                                               onmouseenter="this.style.background='rgba(139,92,246,0.25)'"
                                               onmouseleave="this.style.background='rgba(139,92,246,0.12)'">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                                  onsubmit="return confirm('Delete \'{{ addslashes($product->name) }}\'? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Delete"
                                                        class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-150"
                                                        style="background:rgba(239,68,68,0.1); color:#f87171;"
                                                        onmouseenter="this.style.background='rgba(239,68,68,0.25)'"
                                                        onmouseleave="this.style.background='rgba(239,68,68,0.1)'">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="px-5 py-4" style="border-top:1px solid rgba(139,92,246,0.12);">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            @else
                <div class="glass text-center py-20 animate-fade-in">
                    <div class="text-7xl mb-4 opacity-30">📦</div>
                    <h3 class="text-xl font-bold text-gray-300 mb-2">No products yet</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first product.</p>
                    <a href="{{ route('admin.products.create') }}" class="btn-primary inline-flex">+ New Product</a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
