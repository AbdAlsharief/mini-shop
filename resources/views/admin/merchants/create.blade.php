<x-app-layout>
    <div class="py-10">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 animate-fade-in-up">
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('admin.merchants.index') }}" class="hover:text-violet-400 transition-colors">Admin Panel</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-300">New Merchant</span>
                </nav>
                <p class="section-label mb-1">Admin Panel</p>
                <h1 class="text-3xl font-extrabold gradient-text">Create Merchant Account</h1>
                <p class="text-gray-500 mt-2 text-sm">This merchant will manage their own products.</p>
            </div>

            <div class="glass p-8 animate-fade-in-up">
                <form action="{{ route('admin.merchants.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">Full Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Jane Doe"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                        @error('name')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">Email Address <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="merchant@example.com"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                        @error('email')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Min. 8 characters"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                        @error('password')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-300 mb-2">Confirm Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                    </div>

                    <div class="flex items-start gap-3 px-4 py-3 rounded-xl"
                         style="background:rgba(139,92,246,0.08); border:1px solid rgba(139,92,246,0.2);">
                        <span class="text-violet-400 mt-0.5 flex-shrink-0">🛍️</span>
                        <p class="text-xs text-gray-400">
                            This account will have <strong class="text-violet-300">merchant</strong> access — they can manage <strong class="text-violet-300">their own products only</strong>.
                        </p>
                    </div>

                    <div class="flex gap-3 pt-1">
                        <button type="submit" class="btn-primary flex-1 justify-center py-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Merchant
                        </button>
                        <a href="{{ route('admin.merchants.index') }}" class="btn-secondary justify-center py-3 px-6">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
