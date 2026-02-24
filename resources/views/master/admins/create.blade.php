<x-app-layout>
    <div class="py-10">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 animate-fade-in-up">
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('master.admins.index') }}" class="hover:text-violet-400 transition-colors">Master Admin</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-300">New Account</span>
                </nav>
                <p class="section-label mb-1">Master Admin</p>
                <h1 class="text-3xl font-extrabold gradient-text">Create Account</h1>
                <p class="text-gray-500 mt-2 text-sm">Choose the role — Admin can register merchants, Master Admin has full control.</p>
            </div>

            <div class="glass p-8 animate-fade-in-up">
                <form action="{{ route('master.admins.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Role Selector -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-3">Role <span class="text-red-400">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach([
                                ['value' => 'admin',  'label' => 'Admin',        'icon' => '🛡️', 'desc' => 'Can register and manage merchants'],
                                ['value' => 'master', 'label' => 'Master Admin', 'icon' => '👑', 'desc' => 'Full control — can create admins & masters'],
                            ] as $opt)
                                <label class="cursor-pointer">
                                    <input type="radio" name="role" value="{{ $opt['value'] }}"
                                           {{ old('role', 'admin') === $opt['value'] ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="flex flex-col items-center gap-1 p-4 rounded-xl text-center transition-all duration-200 border
                                                peer-checked:border-violet-500 peer-checked:bg-violet-500/10 border-white/10 hover:border-violet-500/30"
                                         style="background:rgba(255,255,255,0.03);">
                                        <span class="text-2xl">{{ $opt['icon'] }}</span>
                                        <span class="text-sm font-semibold text-gray-200">{{ $opt['label'] }}</span>
                                        <span class="text-xs text-gray-500">{{ $opt['desc'] }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('role')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">Full Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                        @error('name')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">Email Address <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="user@example.com"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                        @error('email')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Min. 8 characters"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                        @error('password')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-300 mb-2">Confirm Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password"
                               class="w-full px-4 py-3 rounded-xl text-gray-100 placeholder-gray-600 outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.04); border:1px solid rgba(139,92,246,0.2);"
                               onfocus="this.style.borderColor='rgba(139,92,246,0.6)'; this.style.boxShadow='0 0 0 3px rgba(139,92,246,0.12)'"
                               onblur="this.style.borderColor='rgba(139,92,246,0.2)'; this.style.boxShadow='none'">
                    </div>

                    <div class="flex gap-3 pt-1">
                        <button type="submit" class="btn-primary flex-1 justify-center py-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Account
                        </button>
                        <a href="{{ route('master.admins.index') }}" class="btn-secondary justify-center py-3 px-6">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
