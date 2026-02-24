<nav x-data="{ open: false }" class="sticky top-0 z-50"
     style="background:rgba(15,15,20,0.85); backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px);
            border-bottom:1px solid rgba(139,92,246,0.15);">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="{{ route('products.index') }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white font-bold text-sm
                            transition-transform duration-200 group-hover:scale-110"
                     style="background:linear-gradient(135deg,#8b5cf6,#6366f1);
                            box-shadow:0 0 16px rgba(139,92,246,0.4);">
                    M
                </div>
                <span class="font-bold text-lg gradient-text">MiniShop</span>
            </a>

            <!-- Desktop Nav Links -->
            <div class="hidden sm:flex items-center gap-1">
                <a href="{{ route('products.index') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs('products.index') ? 'text-violet-300' : 'text-gray-400 hover:text-gray-100' }}"
                   style="{{ request()->routeIs('products.index') ? 'background:rgba(139,92,246,0.15);' : 'hover:background:rgba(255,255,255,0.05);' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Shop
                </a>

                @auth
                <a href="{{ route('my.orders') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs('my.orders') ? 'text-violet-300' : 'text-gray-400 hover:text-gray-100' }}"
                   style="{{ request()->routeIs('my.orders') ? 'background:rgba(139,92,246,0.15);' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    My Orders
                </a>

                @if(Auth::user()->isMerchant())
                <!-- Merchant Link -->
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs('admin.*') ? 'text-violet-300' : 'text-gray-400 hover:text-gray-100' }}"
                   style="{{ request()->routeIs('admin.*') ? 'background:rgba(139,92,246,0.15);' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
                    </svg>
                    Merchant
                </a>
                @endif

                @if(Auth::user()->isAdminRole())
                <!-- Admin Link -->
                <a href="{{ route('admin.merchants.index') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs('admin.merchants*') ? 'text-blue-300' : 'text-gray-400 hover:text-gray-100' }}"
                   style="{{ request()->routeIs('admin.merchants*') ? 'background:rgba(59,130,246,0.15);' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Admin
                </a>
                @endif

                @if(Auth::user()->isMasterAdmin())
                <!-- Master Admin Link -->
                <a href="{{ route('master.admins.index') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs('master.*') ? 'text-amber-300' : 'text-gray-400 hover:text-gray-100' }}"
                   style="{{ request()->routeIs('master.*') ? 'background:rgba(245,158,11,0.15);' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Master
                </a>
                @endif
                @endauth
            </div>

            <!-- Right side -->
            <div class="hidden sm:flex items-center gap-3">

                <!-- Cart -->
                <a href="{{ route('cart') }}" class="relative flex items-center justify-center w-10 h-10 rounded-xl
                           text-gray-400 hover:text-violet-300 transition-all duration-200"
                   style="background:rgba(255,255,255,0.05);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full text-white text-xs flex items-center justify-center font-bold"
                              style="background:#8b5cf6; font-size:10px;">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                           text-gray-300 hover:text-gray-100"
                                    style="background:rgba(139,92,246,0.1); border:1px solid rgba(139,92,246,0.2);">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold"
                                     style="background:linear-gradient(135deg,#8b5cf6,#6366f1);">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                ⚙️ &nbsp;Profile Settings
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    🚪 &nbsp;Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary text-sm">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm">Get Started</a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <button @click="open = !open" class="sm:hidden flex items-center justify-center w-10 h-10 rounded-xl
                            text-gray-400 hover:text-gray-100 transition-all duration-200"
                    style="background:rgba(255,255,255,0.05);">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden"
         style="border-top:1px solid rgba(139,92,246,0.1);">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('products.index') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-all"
               style="hover:background:rgba(139,92,246,0.1);">
                🛍️ Shop
            </a>
            <a href="{{ route('cart') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-all">
                🛒 Cart
                @if($cartCount > 0)
                    <span class="badge badge-info ml-auto">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                <a href="{{ route('my.orders') }}"
                   class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-all">
                    📦 My Orders
                </a>
                @if(Auth::user()->isMerchant())
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-all"
                   style="{{ request()->routeIs('admin.*') ? 'background:rgba(139,92,246,0.12); color:#c4b5fd;' : '' }}">
                    🛍️ Merchant
                </a>
                @endif
                @if(Auth::user()->isAdminRole())
                <a href="{{ route('admin.merchants.index') }}"
                   class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-all"
                   style="{{ request()->routeIs('admin.merchants*') ? 'background:rgba(59,130,246,0.12); color:#93c5fd;' : '' }}">
                    🛡️ Admin
                </a>
                @endif
                @if(Auth::user()->isMasterAdmin())
                <a href="{{ route('master.admins.index') }}"
                   class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-all"
                   style="{{ request()->routeIs('master.*') ? 'background:rgba(245,158,11,0.12); color:#fcd34d;' : '' }}">
                    🛡️ Master Admin
                </a>
                @endif
            @endauth
        </div>

        @auth
            <div class="px-4 py-3" style="border-top:1px solid rgba(139,92,246,0.1);">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold"
                         style="background:linear-gradient(135deg,#8b5cf6,#6366f1);">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-100">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-400 hover:text-gray-100">⚙️ Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-sm text-gray-400 hover:text-red-400 transition-colors">
                        🚪 Log Out
                    </button>
                </form>
            </div>
        @else
            <div class="px-4 py-3 flex gap-2" style="border-top:1px solid rgba(139,92,246,0.1);">
                <a href="{{ route('login') }}" class="btn-secondary flex-1 justify-center">Sign In</a>
                <a href="{{ route('register') }}" class="btn-primary flex-1 justify-center">Register</a>
            </div>
        @endauth
    </div>
</nav>
