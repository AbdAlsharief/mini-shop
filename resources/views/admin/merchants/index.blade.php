<x-app-layout>
    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8 animate-fade-in-up">
                <div>
                    <p class="section-label mb-1">Admin Panel</p>
                    <h1 class="text-4xl font-extrabold gradient-text">Manage Merchants</h1>
                </div>
                <a href="{{ route('admin.merchants.create') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Merchant
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                @php
                    $totalMerchants = $merchants->count();
                    $totalProducts  = \App\Models\Product::whereIn('user_id', $merchants->pluck('id'))->count();
                    $totalStock     = \App\Models\Product::whereIn('user_id', $merchants->pluck('id'))->sum('stock');
                @endphp
                @foreach([
                    ['label' => 'Total Merchants', 'value' => $totalMerchants, 'icon' => '🛍️', 'color' => '#8b5cf6'],
                    ['label' => 'Products Listed', 'value' => $totalProducts,  'icon' => '📦', 'color' => '#60a5fa'],
                    ['label' => 'Total Stock',     'value' => $totalStock,     'icon' => '📊', 'color' => '#4ade80'],
                ] as $stat)
                    <div class="glass p-5 flex items-center gap-4 animate-fade-in-up">
                        <span class="text-2xl">{{ $stat['icon'] }}</span>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-extrabold" style="color:{{ $stat['color'] }};">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Table -->
            @if($merchants->count() > 0)
                <div class="glass overflow-hidden animate-fade-in-up">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom:1px solid rgba(139,92,246,0.2); background:rgba(139,92,246,0.06);">
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Merchant</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Products</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Joined</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($merchants as $merchant)
                                <tr class="transition-colors duration-150 hover:bg-white/[0.02]"
                                    style="border-bottom:1px solid rgba(139,92,246,0.08);">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                                                 style="background:linear-gradient(135deg,#8b5cf6,#6366f1);">
                                                {{ strtoupper(substr($merchant->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-100">{{ $merchant->name }}</p>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium"
                                                      style="background:rgba(139,92,246,0.15); color:#a78bfa;">Merchant</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-gray-400">{{ $merchant->email }}</td>
                                    <td class="px-5 py-4">
                                        <span class="font-semibold text-gray-200">{{ $merchant->products->count() }}</span>
                                        <span class="text-gray-600 text-xs ml-1">products</span>
                                    </td>
                                    <td class="px-5 py-4 text-gray-500 text-xs">{{ $merchant->created_at->format('M d, Y') }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.merchants.destroy', $merchant->id) }}" method="POST"
                                                  onsubmit="return confirm('Demote {{ addslashes($merchant->name) }} to client?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Demote to client"
                                                        class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-150"
                                                        style="background:rgba(239,68,68,0.1); color:#f87171;"
                                                        onmouseenter="this.style.background='rgba(239,68,68,0.25)'"
                                                        onmouseleave="this.style.background='rgba(239,68,68,0.1)'">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="glass text-center py-20 animate-fade-in">
                    <div class="text-7xl mb-4 opacity-30">🛍️</div>
                    <h3 class="text-xl font-bold text-gray-300 mb-2">No merchants yet</h3>
                    <p class="text-gray-500 mb-6">Add the first merchant to get started.</p>
                    <a href="{{ route('admin.merchants.create') }}" class="btn-primary inline-flex">+ New Merchant</a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
