<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - Selamat datang, {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- === TAMPILAN UNTUK USER === -->
@if(Auth::user()->role === 'user')
    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <!-- Total Pengaduan Saya -->
        <a href="{{ route('complaints.index') }}" 
           class="group block relative bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-gray-300">
            <div class="absolute inset-x-0 top-0 h-1 bg-gray-400 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider group-hover:text-gray-600 transition-colors duration-200">
                Total Pengaduan Saya
            </p>
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $data['total_complaints'] }}</p>
                <span class="text-xs font-medium text-gray-400 group-hover:text-gray-600 flex items-center gap-1 transition-colors duration-200">
                    Lihat Semua 
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>

        <!-- Pengaduan Aktif -->
        <a href="{{ route('complaints.index', ['status' => 'active']) }}" 
           class="group block relative bg-white p-6 rounded-xl border border-indigo-50 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-indigo-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-indigo-500 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <p class="text-xs font-semibold text-indigo-500 uppercase tracking-wider group-hover:text-indigo-600 transition-colors duration-200">
                Pengaduan Aktif
            </p>
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl font-extrabold text-indigo-900 tracking-tight">{{ $data['active_complaints'] }}</p>
                <span class="text-xs font-medium text-indigo-400 group-hover:text-indigo-600 flex items-center gap-1 transition-colors duration-200">
                    Lihat Aktif 
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>
    </div>

    <!-- Section Daftar Pengaduan Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800 tracking-tight flex items-center gap-2">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                Pengaduan Terbaru
            </h3>
            <span class="text-xs text-gray-400 font-medium">Menampilkan aduan terakhir</span>
        </div>
        
        <div class="p-6">
            <ul class="space-y-3">
                @forelse($data['latest_complaints'] as $complaint)
                    <li class="flex justify-between items-center bg-white p-4 rounded-lg border border-gray-100 shadow-sm transition-all duration-200 ease-in-out hover:bg-gray-50 hover:border-gray-200 hover:shadow-md hover:scale-[1.01]">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-100 rounded-md text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-700 tracking-tight">{{ $complaint->title }}</span>
                                <span class="text-xs text-gray-400">Oleh: {{ $complaint->user->name ?? 'Anonim' }} • {{ $complaint->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-md tracking-wider uppercase 
                                @if($complaint->status === 'selesai') bg-emerald-50 text-emerald-700 border border-emerald-200
                                @elseif($complaint->status === 'proses' || $complaint->status === 'diproses') bg-amber-50 text-amber-700 border border-amber-200
                                @else bg-blue-50 text-blue-700 border border-blue-200 @endif">
                                {{ $complaint->status }}
                            </span>

                            <a href="{{ route('complaints.show', $complaint->id) }}" 
                               class="text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors shadow-2xs font-semibold">
                                Lihat Detail
                            </a>
                        </div>
                    </li>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2m0-5a7 7 0 1114 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-400 italic">Anda belum membuat pengaduan saat ini.</p>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
@endif

<!-- === TAMPILAN UNTUK TEKNISI (SUDAH DISAMAKAN DENGAN USER) === -->
@if(Auth::user()->role === 'teknisi')
    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <!-- Card: Total Tugas Masuk -->
        <a href="{{ route('complaints.index', ['status' => 'assigned']) }}" 
           class="group block relative bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-gray-300">
            <div class="absolute inset-x-0 top-0 h-1 bg-gray-400 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider group-hover:text-gray-600 transition-colors duration-200">
                Total Tugas Masuk
            </p>
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $data['total_assigned'] }}</p>
                <span class="text-xs font-medium text-gray-400 group-hover:text-gray-600 flex items-center gap-1 transition-colors duration-200">
                    Lihat Semua 
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>

        <!-- Card: Tugas Selesai -->
        <a href="{{ route('complaints.index', ['status' => 'completed']) }}" 
           class="group block relative bg-white p-6 rounded-xl border border-green-50 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-green-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-emerald-500 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <p class="text-xs font-semibold text-emerald-500 uppercase tracking-wider group-hover:text-emerald-600 transition-colors duration-200">
                Tugas Selesai
            </p>
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl font-extrabold text-emerald-950 tracking-tight">{{ $data['completed'] }}</p>
                <span class="text-xs font-medium text-emerald-400 group-hover:text-emerald-600 flex items-center gap-1 transition-colors duration-200">
                    Lihat Selesai 
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>
    </div>

    <!-- Section Daftar Tugas Aktif -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800 tracking-tight flex items-center gap-2">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                Tugas yang Sedang Diproses
            </h3>
            <span class="text-xs text-gray-400 font-medium">Menampilkan tugas aktif Anda</span>
        </div>
        
        <div class="p-6">
            <ul class="space-y-3">
                @forelse($data['latest_tasks'] as $task)
                    <!-- List Item yang sama presisi dengan baris milik user -->
                    <li class="flex justify-between items-center bg-white p-4 rounded-lg border border-gray-100 shadow-sm transition-all duration-200 ease-in-out hover:bg-gray-50 hover:border-gray-200 hover:shadow-md hover:scale-[1.01]">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-50 text-indigo-500 rounded-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-700 tracking-tight">{{ $task->title }}</span>
                                <span class="text-xs text-gray-400">Ditugaskan pada aplikasi</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <!-- Tombol Detail yang seragam dengan tombol detail milik user -->
                            <a href="{{ route('complaints.show', $task->id) }}" 
                               class="text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors shadow-2xs font-semibold">
                                Lihat Detail
                            </a>
                        </div>
                    </li>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2m0-5a7 7 0 1114 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-400 italic">Tidak ada tugas aktif.</p>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
@endif

            <!-- === TAMPILAN UNTUK ADMIN & DEV === -->
@if(in_array(Auth::user()->role, ['admin', 'dev']))
    <!-- Status Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Menunggu Card -->
        <a href="{{ route('complaints.index', ['status' => 'menunggu']) }}" 
           class="group block relative bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-gray-300">
            <div class="absolute inset-x-0 top-0 h-1 bg-yellow-400 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider group-hover:text-gray-600 transition-colors duration-200">
                Menunggu
            </p>
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl font-extrabold text-yellow-600 tracking-tight">{{ $data['menunggu'] }}</p>
                <span class="text-xs font-medium text-yellow-500 group-hover:text-yellow-600 flex items-center gap-1 transition-colors duration-200">
                    Lihat Detail 
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>

        <!-- Diproses Card -->
        <a href="{{ route('complaints.index', ['status' => 'diproses']) }}" 
           class="group block relative bg-white p-6 rounded-xl border border-blue-50 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-blue-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-blue-500 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <p class="text-xs font-semibold text-blue-400 uppercase tracking-wider group-hover:text-blue-600 transition-colors duration-200">
                Diproses
            </p>
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl font-extrabold text-blue-600 tracking-tight">{{ $data['diproses'] }}</p>
                <span class="text-xs font-medium text-blue-400 group-hover:text-blue-600 flex items-center gap-1 transition-colors duration-200">
                    Pantau Proses 
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>

        <!-- Selesai Card -->
        <a href="{{ route('complaints.index', ['status' => 'selesai']) }}" 
           class="group block relative bg-white p-6 rounded-xl border border-green-50 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-green-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-emerald-500 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <p class="text-xs font-semibold text-green-400 uppercase tracking-wider group-hover:text-green-600 transition-colors duration-200">
                Selesai
            </p>
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl font-extrabold text-green-600 tracking-tight">{{ $data['selesai'] }}</p>
                <span class="text-xs font-medium text-green-400 group-hover:text-green-600 flex items-center gap-1 transition-colors duration-200">
                    Buka Arsip 
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>

        <!-- Ditolak Card -->
        <a href="{{ route('complaints.index', ['status' => 'ditolak']) }}" 
           class="group block relative bg-white p-6 rounded-xl border border-red-50 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-md hover:border-red-200">
            <div class="absolute inset-x-0 top-0 h-1 bg-red-500 rounded-t-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <p class="text-xs font-semibold text-red-400 uppercase tracking-wider group-hover:text-red-600 transition-colors duration-200">
                Ditolak
            </p>
            <div class="flex justify-between items-end mt-4">
                <p class="text-4xl font-extrabold text-red-600 tracking-tight">{{ $data['ditolak'] }}</p>
                <span class="text-xs font-medium text-red-400 group-hover:text-red-600 flex items-center gap-1 transition-colors duration-200">
                    Evaluasi 
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>
    </div>

    <!-- Role Specific Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        @if(Auth::user()->role === 'admin')
            <div class="bg-gradient-to-br from-indigo-50/50 to-white p-6 rounded-xl shadow-sm border border-indigo-100 flex justify-between items-center transition-all duration-300 hover:shadow-md">
                <div>
                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Total Teknisi Aktif</p>
                    <p class="text-4xl font-black text-indigo-900 mt-2 tracking-tight">{{ $data['total_technicians'] }}</p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div> 
        @endif

        @if(Auth::user()->role === 'dev')
            <div class="bg-gradient-to-br from-red-50/50 to-white p-6 rounded-xl shadow-sm border border-red-100 flex justify-between items-center transition-all duration-300 hover:shadow-md">
                <div>
                    <p class="text-xs font-bold text-red-600 uppercase tracking-wider">System Error Logs</p>
                    <p class="text-4xl font-black text-red-900 mt-2 tracking-tight">{{ $data['total_errors'] }}</p>
                </div>
                <a href="#" class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-md transition-colors shadow-2xs font-bold">
                    Periksa Logs
                </a>
            </div>
        @endif
    </div>

    <!-- Latest Complaints List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800 tracking-tight flex items-center gap-2">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                5 Pengaduan Terbaru
            </h3>
            <span class="text-xs text-gray-400 font-medium">Real-time</span>
        </div>
        
        <div class="p-6">
            <ul class="space-y-3">
                @forelse($data['latest_complaints'] as $complaint)
                    <li class="flex justify-between items-center bg-white p-4 rounded-lg border border-gray-100 shadow-sm transition-all duration-200 ease-in-out hover:bg-gray-50 hover:border-gray-200 hover:shadow-md hover:scale-[1.01]">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-100 rounded-md text-gray-500 flex items-center justify-center">
                                @if($complaint->status == 'selesai')
                                    <span class="flex h-2 w-2 rounded-full bg-green-500"></span>
                                @else
                                    <span class="flex h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-700 tracking-tight">{{ $complaint->title }}</span>
                                <span class="text-xs text-gray-400">Oleh: <strong class="text-gray-600 font-medium">{{ $complaint->user->name }}</strong> • {{ $complaint->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <!-- Badge Status Berwarna Dinamis -->
                            <span class="px-2.5 py-1 text-xs font-bold rounded-md tracking-wider uppercase 
                                {{ $complaint->status == 'selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                                {{ $complaint->status == 'diproses' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                {{ $complaint->status == 'menunggu' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : '' }}
                                {{ $complaint->status == 'ditolak' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                                {{ $complaint->status }}
                            </span>

                            <!-- Tombol Detail -->
                            <a href="{{ route('complaints.show', $complaint->id) }}" 
                               class="text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors shadow-2xs font-semibold">
                                Lihat Detail
                            </a>
                        </div>
                    </li>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2m0-5a7 7 0 1114 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-400 italic">Belum ada pengaduan masuk saat ini.</p>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
@endif

        </div>
    </div>
</x-app-layout>