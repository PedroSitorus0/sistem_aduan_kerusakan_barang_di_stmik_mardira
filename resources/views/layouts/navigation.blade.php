<nav x-data="{ openMobile: false, openProfile: false }" class="bg-white fixed w-full z-50 top-0 border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <div class="flex items-center shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <x-application-logo></x-application-logo>
                    {{-- <span class="hidden sm:block text-lg font-bold text-gray-900 tracking-tight"></span> --}}
                </a>
            </div>

            <div class="hidden lg:flex lg:items-center lg:gap-1 xl:gap-2">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'text-white bg-[#E63912]' : 'text-gray-600 hover:bg-gray-100 hover:text-[#E63912]' }}">Dashboard</a>
                
                <a href="{{ route('complaints.index') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('complaints.index') ? 'text-white bg-[#E63912]' : 'text-gray-600 hover:bg-gray-100 hover:text-[#E63912]' }}">Lihat Pengaduan</a>
                
                <a href="{{ route('complaints.create') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('complaints.create') ? 'text-white bg-[#E63912]' : 'text-gray-600 hover:bg-gray-100 hover:text-[#E63912]' }}">Buat Pengaduan</a>

                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'dev')
                    <div class="w-px h-5 bg-gray-300 mx-1"></div>
                    
                    <a href="{{ route('locations.index') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('locations.index') ? 'text-[#E63912] bg-red-50' : 'text-gray-600 hover:bg-gray-100 hover:text-[#E63912]' }}">Lihat Daftar Lokasi</a>
                    
                    <a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('categories.index') ? 'text-[#E63912] bg-red-50' : 'text-gray-600 hover:bg-gray-100 hover:text-[#E63912]' }}">Data Kategori</a>

                    <a href="{{ route('categories.create') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('categories.create') ? 'text-[#E63912] bg-red-50' : 'text-gray-600 hover:bg-gray-100 hover:text-[#E63912]' }}">Buat Kategori</a>

                    <a href="{{ route('users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('users.*') ? 'text-[#E63912] bg-red-50' : 'text-gray-600 hover:bg-gray-100 hover:text-[#E63912]' }}">Pengguna</a>
                @endif

                @if(auth()->user()->role === 'dev')
                    <div class="w-px h-5 bg-gray-300 mx-1"></div>
                    <a href="{{ route('system-logs.index') }}" class="px-3 py-2 rounded-md text-sm font-bold transition-colors {{ request()->routeIs('system-logs.*') ? 'text-red-700 bg-red-100' : 'text-red-500 hover:bg-red-50 hover:text-red-600' }}">Log Sistem</a>
                @endif
            </div>

            <div class="flex items-center gap-3 shrink-0">
                
                <div class="relative">
                    <button @click="openProfile = !openProfile" @click.outside="openProfile = false" type="button" class="flex items-center focus:outline-none focus:ring-4 focus:ring-gray-100 rounded-full transition-all">
                        @if(Auth::user())
                            <div class="w-9 h-9 rounded-full bg-[#E63912] flex items-center justify-center text-white font-bold text-sm shadow-sm border border-red-200">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <div x-show="openProfile" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="transform opacity-100 scale-100" 
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 top-full mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-xl z-50" style="display: none;">
                        
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <div class="p-2 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#E63912] rounded-md transition-colors">Profil Akun</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>

                <button @click="openMobile = !openMobile" type="button" class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors">
                    <span class="sr-only">Buka menu utama</span>
                    <svg x-show="!openMobile" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="openMobile" class="w-6 h-6 hidden" :class="{'block': openMobile, 'hidden': !openMobile}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="openMobile" x-collapse class="lg:hidden border-t border-gray-100 bg-white" style="display: none;">
        <div class="px-4 pt-2 pb-4 space-y-1 max-h-[80vh] overflow-y-auto">
            
            <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 rounded-md text-base font-medium transition-colors {{ request()->routeIs('dashboard') ? 'text-[#E63912] bg-red-50' : 'text-gray-700 hover:bg-gray-50 hover:text-[#E63912]' }}">Dashboard</a>
            
            <a href="{{ route('complaints.create') }}" class="block px-3 py-2.5 rounded-md text-base font-medium transition-colors {{ request()->routeIs('complaints.create') ? 'text-[#E63912] bg-red-50' : 'text-gray-700 hover:bg-gray-50 hover:text-[#E63912]' }}">Buat Pengaduan</a>
            
            <a href="{{ route('complaints.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium transition-colors {{ request()->routeIs('complaints.index') ? 'text-[#E63912] bg-red-50' : 'text-gray-700 hover:bg-gray-50 hover:text-[#E63912]' }}">Daftar Pengaduan</a>

            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'dev')
                <div class="mt-4 mb-2">
                    <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Panel Admin</p>
                </div>
                
                <a href="{{ route('categories.create') }}" class="block px-3 py-2.5 rounded-md text-base font-medium transition-colors {{ request()->routeIs('categories.create') ? 'text-[#E63912] bg-red-50' : 'text-gray-700 hover:bg-gray-50 hover:text-[#E63912]' }}">Buat Kategori</a>
                
                <a href="{{ route('categories.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium transition-colors {{ request()->routeIs('categories.index') ? 'text-[#E63912] bg-red-50' : 'text-gray-700 hover:bg-gray-50 hover:text-[#E63912]' }}">Lihat Kategori</a>
                
                <a href="{{ route('locations.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium transition-colors {{ request()->routeIs('locations.index') ? 'text-[#E63912] bg-red-50' : 'text-gray-700 hover:bg-gray-50 hover:text-[#E63912]' }}">Data Lokasi</a>
                
                <a href="{{ route('users.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium transition-colors {{ request()->routeIs('users.*') ? 'text-[#E63912] bg-red-50' : 'text-gray-700 hover:bg-gray-50 hover:text-[#E63912]' }}">Pengguna</a>
            @endif

            @if(auth()->user()->role === 'dev')
                <div class="mt-4 mb-2">
                    <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Developer</p>
                </div>
                <a href="{{ route('system-logs.index') }}" class="block px-3 py-2.5 rounded-md text-base font-bold transition-colors {{ request()->routeIs('system-logs.*') ? 'text-red-700 bg-red-100' : 'text-red-500 hover:bg-red-50 hover:text-red-600' }}">Log Sistem</a>
            @endif
        </div>
    </div>
</nav>