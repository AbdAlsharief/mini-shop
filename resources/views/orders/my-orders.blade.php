<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 animate-fade-in">
                <p class="section-label mb-1">Account</p>
                <h1 class="text-4xl font-extrabold gradient-text">My Orders</h1>
            </div>

            @forelse($orders as $order)
                @php
                    $statusColors = [
                        'pending'    => 'badge-warning',
                        'processing' => 'badge-info',
                        'shipped'    => 'badge-info',
                        'completed'  => 'badge-success',
                        'cancelled'  => 'badge-danger',
                    ];
                    $statusIcons = [
                        'pending'    => '⏳',
                        'processing' => '⚙️',
                        'shipped'    => '🚚',
                        'completed'  => '✓',
                        'cancelled'  => '✕',
                    ];
                    $statusClass = $statusColors[strtolower($order->status)] ?? 'badge-gray';
                    $statusIcon  = $statusIcons[strtolower($order->status)] ?? '●';
                @endphp

                <a href="{{ route('orders.show', $order->id) }}" class="block group" style="text-decoration:none;">
                    <div class="glass p-6 mb-4 animate-fade-in-up transition-all duration-200 hover:-translate-y-1"
                         style="border-color:rgba(139,92,246,0.18);"
                         onmouseenter="this.style.boxShadow='0 16px 40px rgba(139,92,246,0.2)'"
                         onmouseleave="this.style.boxShadow=''">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                            <!-- Left: Order Info -->
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                                     style="background:linear-gradient(135deg,rgba(139,92,246,0.2),rgba(99,102,241,0.1));">
                                    <span class="text-xl">📦</span>
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-100 text-lg group-hover:text-violet-300 transition-colors">
                                        Order <span class="gradient-text">#{{ $order->id }}</span>
                                    </h2>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $order->created_at->format('F j, Y') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Right: Status, Total, Arrow -->
                            <div class="flex items-center gap-4">
                                <span class="badge {{ $statusClass }}">
                                    {{ $statusIcon }} {{ ucfirst($order->status) }}
                                </span>
                                <div class="text-right">
                                    <p class="text-2xl font-extrabold text-white">${{ number_format($order->total, 2) }}</p>
                                    <p class="text-xs text-gray-500">Total</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-600 group-hover:text-violet-400 group-hover:translate-x-1 transition-all hidden sm:block"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

            @empty
                <!-- Empty State -->
                <div class="glass text-center py-24 animate-fade-in">
                    <div class="text-8xl mb-5 opacity-20">📦</div>
                    <h2 class="text-2xl font-bold text-gray-300 mb-3">No orders yet</h2>
                    <p class="text-gray-500 mb-8">Head to the shop and make your first purchase!</p>
                    <a href="{{ route('products.index') }}" class="btn-primary inline-flex">
                        Browse Products
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
