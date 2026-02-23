<x-app-layout>
    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="glass p-8 mb-8 animate-fade-in-up relative overflow-hidden"
                 style="background:linear-gradient(135deg,rgba(139,92,246,0.15) 0%,rgba(99,102,241,0.08) 100%);">
                <!-- Decorative orb -->
                <div class="absolute -right-16 -top-16 w-48 h-48 rounded-full opacity-20 blur-3xl"
                     style="background:#8b5cf6;"></div>

                <div class="relative">
                    <p class="section-label mb-2">Dashboard</p>
                    <h1 class="text-3xl font-extrabold text-gray-100 mb-2">
                        Welcome back, <span class="gradient-text">{{ Auth::user()->name }}</span>! 👋
                    </h1>
                    <p class="text-gray-400">Ready to find something amazing today?</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 stagger">

                <!-- Browse Shop -->
                <a href="{{ route('products.index') }}"
                   class="glass p-6 flex flex-col items-center text-center gap-3 animate-fade-in-up
                          transition-all duration-300 hover:-translate-y-2 group"
                   onmouseenter="this.style.boxShadow='0 20px 40px rgba(139,92,246,0.2)'"
                   onmouseleave="this.style.boxShadow=''">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl
                                transition-transform duration-200 group-hover:scale-110"
                         style="background:linear-gradient(135deg,rgba(139,92,246,0.3),rgba(99,102,241,0.2));">
                        🛍️
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-100 group-hover:text-violet-300 transition-colors">Browse Shop</h3>
                        <p class="text-sm text-gray-500 mt-1">Explore all products</p>
                    </div>
                    <svg class="w-4 h-4 text-violet-500 group-hover:translate-x-1 transition-transform"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <!-- View Cart -->
                <a href="{{ route('cart') }}"
                   class="glass p-6 flex flex-col items-center text-center gap-3 animate-fade-in-up
                          transition-all duration-300 hover:-translate-y-2 group"
                   onmouseenter="this.style.boxShadow='0 20px 40px rgba(139,92,246,0.2)'"
                   onmouseleave="this.style.boxShadow=''">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl
                                relative transition-transform duration-200 group-hover:scale-110"
                         style="background:linear-gradient(135deg,rgba(139,92,246,0.3),rgba(99,102,241,0.2));">
                        🛒
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full text-white text-xs flex items-center justify-center font-bold"
                                  style="background:#8b5cf6; font-size:10px;">{{ $cartCount }}</span>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-100 group-hover:text-violet-300 transition-colors">Your Cart</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $cartCount > 0 ? $cartCount . ' ' . Str::plural('item', $cartCount) : 'Empty cart' }}
                        </p>
                    </div>
                    <svg class="w-4 h-4 text-violet-500 group-hover:translate-x-1 transition-transform"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <!-- My Orders -->
                <a href="{{ route('my.orders') }}"
                   class="glass p-6 flex flex-col items-center text-center gap-3 animate-fade-in-up
                          transition-all duration-300 hover:-translate-y-2 group"
                   onmouseenter="this.style.boxShadow='0 20px 40px rgba(139,92,246,0.2)'"
                   onmouseleave="this.style.boxShadow=''">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl
                                transition-transform duration-200 group-hover:scale-110"
                         style="background:linear-gradient(135deg,rgba(139,92,246,0.3),rgba(99,102,241,0.2));">
                        📦
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-100 group-hover:text-violet-300 transition-colors">My Orders</h3>
                        <p class="text-sm text-gray-500 mt-1">Track your orders</p>
                    </div>
                    <svg class="w-4 h-4 text-violet-500 group-hover:translate-x-1 transition-transform"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
