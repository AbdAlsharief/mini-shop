<x-app-layout>
    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8 animate-fade-in-up">
                <div>
                    <p class="section-label mb-1">Master Admin</p>
                    <h1 class="text-4xl font-extrabold gradient-text">Manage Merchants</h1>
                </div>
                <a href="{{ route('master.admins.create') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Merchant
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                @php
                    $totalAdmins    = $admins->count();
                    $totalProducts  = \App\Models\Product::whereIn('user_id', $admins->pluck('id'))->count();
                    $totalUsers     = \App\Models\User::where('role','client')->count();
                @endphp
                @foreach([
                    ['label' => 'Total Merchants',  'value' => $totalAdmins,   'icon' => '🛍️', 'color' => '#8b5cf6'],
                    ['label' => 'Their Products',   'value' => $totalProducts, 'icon' => '📦', 'color' => '#60a5fa'],
                    ['label' => 'Clients',          'value' => $totalUsers,    'icon' => '👥', 'color' => '#4ade80'],
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

            <!-- Admin Table -->
            @if($admins->count() > 0)
                <div class="glass overflow-hidden animate-fade-in-up">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom:1px solid rgba(139,92,246,0.2); background:rgba(139,92,246,0.06);">
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Products</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Joined</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                                <tr class="transition-colors duration-150 hover:bg-white/[0.02]"
                                    style="border-bottom:1px solid rgba(139,92,246,0.08);">
                                    <!-- Name -->
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                                                 style="background:linear-gradient(135deg,#8b5cf6,#6366f1);">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-100">{{ $admin->name }}</p>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium"
                                                      style="background:rgba(139,92,246,0.15); color:#a78bfa;">
                                                    Merchant
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="px-5 py-4 text-gray-400">{{ $admin->email }}</td>

                                    <!-- Products -->
                                    <td class="px-5 py-4">
                                        <span class="font-semibold text-gray-200">{{ $admin->products->count() }}</span>
                                        <span class="text-gray-600 text-xs ml-1">products</span>
                                    </td>

                                    <!-- Joined -->
                                    <td class="px-5 py-4 text-gray-500 text-xs">{{ $admin->created_at->format('M d, Y') }}</td>

                                    <!-- Actions -->
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- View Products -->
                                            <a href="{{ route('admin.products.index') }}"
                                               title="View their products"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-150"
                                               style="background:rgba(99,102,241,0.12); color:#818cf8;"
                                               onmouseenter="this.style.background='rgba(99,102,241,0.25)'"
                                               onmouseleave="this.style.background='rgba(99,102,241,0.12)'">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                            </a>

                                            <!-- Demote to Client -->
                                            <form action="{{ route('master.admins.destroy', $admin->id) }}" method="POST"
                                                  onsubmit="return confirm('Demote {{ addslashes($admin->name) }} to client? They will lose all admin access.')">
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
                    <p class="text-gray-500 mb-6">Create the first merchant to get started.</p>
                    <a href="{{ route('master.admins.create') }}" class="btn-primary inline-flex">+ New Merchant</a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
