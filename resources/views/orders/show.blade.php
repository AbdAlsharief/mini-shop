<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8 animate-fade-in">
                <a href="{{ route('my.orders') }}" class="hover:text-violet-400 transition-colors">My Orders</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-300 font-medium">Order #{{ $order->id }}</span>
            </nav>

            <!-- Order Header Card -->
            <div class="glass p-6 mb-6 animate-fade-in-up relative overflow-hidden"
                 style="background:linear-gradient(135deg,rgba(139,92,246,0.12) 0%,rgba(99,102,241,0.06) 100%);">
                <div class="absolute -right-12 -top-12 w-44 h-44 rounded-full blur-3xl opacity-15"
                     style="background:#8b5cf6;"></div>
                <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="section-label mb-1">Order Details</p>
                        <h1 class="text-3xl font-extrabold gradient-text">Order #{{ $order->id }}</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                        </p>
                    </div>

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

                    <span class="badge {{ $statusClass }} text-sm px-4 py-2">
                        {{ $statusIcon }} {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- ── Order Items ── -->
                <div class="lg:col-span-2 space-y-4">
                    <h2 class="text-xs font-semibold uppercase tracking-widest text-gray-500 mb-3">Items Ordered</h2>

                    @forelse($order->items as $item)
                        <div class="glass p-5 flex items-center gap-4 animate-fade-in-up
                                    transition-all duration-200 hover:-translate-y-1">

                            <!-- Icon -->
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0"
                                 style="background:linear-gradient(135deg,rgba(139,92,246,0.2),rgba(99,102,241,0.1));">
                                <span class="text-2xl">🛍️</span>
                            </div>

                            <!-- Name & unit price -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-100 truncate">
                                    {{ $item->product?->name ?? 'Product #' . $item->product_id }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    ${{ number_format($item->price, 2) }}
                                    <span class="mx-1 text-gray-700">×</span>
                                    {{ $item->quantity }}
                                    <span class="ml-2 text-gray-600">{{ Str::plural('unit', $item->quantity) }}</span>
                                </p>
                            </div>

                            <!-- Line total -->
                            <div class="flex-shrink-0 text-right">
                                <p class="font-extrabold text-white text-lg">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="glass p-10 text-center">
                            <p class="text-gray-500">No items found for this order.</p>
                        </div>
                    @endforelse
                </div>

                <!-- ── Sidebar ── -->
                <div class="space-y-4">

                    <!-- Order Summary -->
                    <div class="glass p-6 animate-fade-in-up" style="animation-delay:0.1s;">
                        <h2 class="text-xs font-semibold uppercase tracking-widest text-gray-500 mb-5">Summary</h2>

                        <div class="space-y-3 mb-5">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">
                                    Items ({{ $order->items->count() }})
                                </span>
                                <span class="text-gray-200">${{ number_format($order->total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Shipping</span>
                                <span class="{{ $order->total >= 50 ? 'text-green-400' : 'text-gray-200' }}">
                                    {{ $order->total >= 50 ? 'Free' : '$5.00' }}
                                </span>
                            </div>
                        </div>

                        <div class="divider mb-5"></div>

                        <div class="flex justify-between items-end">
                            <span class="text-gray-300 font-semibold">Total Paid</span>
                            <span class="text-3xl font-extrabold gradient-text">
                                ${{ number_format($order->total, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="glass p-6 animate-fade-in-up" style="animation-delay:0.15s;">
                        <h2 class="text-xs font-semibold uppercase tracking-widest text-gray-500 mb-5">Progress</h2>

                        @php
                            $steps = ['pending', 'processing', 'shipped', 'completed'];
                            $currentIdx = array_search(strtolower($order->status), $steps);
                        @endphp

                        <ol class="relative">
                            @foreach($steps as $i => $step)
                                @php
                                    $isDone    = $currentIdx !== false && $i <= $currentIdx;
                                    $isCurrent = $currentIdx !== false && $i === $currentIdx;
                                    $isLast    = $i === count($steps) - 1;
                                @endphp
                                <li class="flex gap-3 {{ !$isLast ? 'pb-5' : '' }} relative">
                                    <!-- Connector line -->
                                    @if(!$isLast)
                                        <div class="absolute left-[11px] top-6 w-0.5 h-full -z-0"
                                             style="{{ $isDone && $currentIdx > $i
                                                 ? 'background:linear-gradient(180deg,#8b5cf6,#6366f1);'
                                                 : 'background:rgba(255,255,255,0.07);' }}">
                                        </div>
                                    @endif

                                    <!-- Circle -->
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 z-10 text-xs font-bold"
                                         style="{{ $isDone
                                             ? 'background:linear-gradient(135deg,#8b5cf6,#6366f1); color:white; box-shadow:0 0 10px rgba(139,92,246,0.5);'
                                             : 'background:rgba(255,255,255,0.05); color:#4b5563; border:1px solid rgba(255,255,255,0.08);' }}">
                                        {{ $isDone ? '✓' : '' }}
                                    </div>

                                    <!-- Label -->
                                    <div class="pt-0.5">
                                        <p class="text-sm font-medium {{ $isDone ? 'text-gray-100' : 'text-gray-600' }}">
                                            {{ ucfirst($step) }}
                                        </p>
                                        @if($isCurrent)
                                            <p class="text-xs text-violet-400 mt-0.5">Current status</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Back -->
                    <a href="{{ route('my.orders') }}" class="btn-secondary w-full justify-center block text-center">
                        ← Back to My Orders
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
