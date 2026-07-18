<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengaduan: ') }} <span class="text-blue-600">#{{ $complaint->id }}</span>
            </h2>
            <a href="{{ route('complaints.index') }}" 
   class="group inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 px-4 py-2.5 rounded-xl shadow-xs hover:shadow-sm hover:-translate-y-0.5 transition-all duration-200 ease-out tracking-wide">
    <!-- Ikon Panah Kembali yang bergeser ke kiri saat di-hover -->
    <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    <span>Kembali</span>
</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Detail Pengaduan -->
            <div class="md:col-span-2 space-y-6">
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                    <div class="flex justify-between items-start mb-4 border-b pb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $complaint->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Dilaporkan oleh: <span class="font-semibold text-gray-700">{{ $complaint->user->name }}</span> pada {{ $complaint->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-bold uppercase border">
                            {{ $complaint->status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Lokasi Ruangan</p>
                            <p class="text-gray-900">{{ $complaint->location->room_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Kategori Barang</p>
                            <p class="text-gray-900">{{ $complaint->category->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Kode Barang</p>
                            <p class="text-gray-900">{{ $complaint->kode_barang ?? 'Tidak disertakan' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Ditugaskan Kepada</p>
                            <p class="text-gray-900 font-medium text-blue-600">{{ $complaint->assignedTechnician->name ?? 'Belum ada teknisi' }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Deskripsi Kerusakan</p>
                        <div class="bg-gray-50 p-4 rounded text-gray-700 text-sm whitespace-pre-line border">
                            {{ $complaint->description }}
                        </div>
                    </div>

                    <!-- PERUBAHAN ADA DI BAGIAN INI -->
                    @if($complaint->photo_path && is_array($complaint->photo_path) && count($complaint->photo_path) > 0)
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Lampiran Foto</p>
                            <!-- Menggunakan grid agar rapi jika foto lebih dari 1 -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($complaint->photo_path as $photo)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Foto Aduan" class="w-full h-auto object-cover rounded border shadow-sm">
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-- AKHIR PERUBAHAN -->
                    
                </div>
            </div>

            <!-- Kolom Kanan: Riwayat Status (Logs) -->
            <div class="md:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Riwayat Tindakan</h3>
                    
                    <div class="space-y-6">
                        @forelse($complaint->logs as $log)
                            <div class="relative pl-4 border-l-2 {{ $loop->last ? 'border-blue-500' : 'border-gray-200' }}">
                                <div class="absolute w-3 h-3 bg-blue-500 rounded-full -left-[7px] top-1"></div>
                                <p class="text-xs text-gray-500">{{ $log->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $log->actor->name ?? 'Sistem' }}</p>
                                
                                @if($log->new_status)
                                    <p class="text-xs mt-1">Mengubah status ke: <span class="font-bold uppercase text-blue-600">{{ $log->new_status }}</span></p>
                                @endif
                                
                                <p class="text-sm text-gray-600 mt-2 bg-gray-50 p-2 rounded border">{{ $log->log_message }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">Belum ada riwayat tindakan.</p>
                        @endforelse
                    </div>

       @if(in_array(Auth::user()->role, ['admin', 'dev', 'teknisi']) && $complaint->status !== 'selesai')
    <div class="mt-6 pt-4 border-t border-gray-100">
        <a href="{{ route('complaints.edit', $complaint->id) }}" 
           class="group flex items-center justify-center gap-2 w-full text-center bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold py-3 px-4 rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 ease-out tracking-wide">
            <span>Proses / Update Status</span>
            
            <!-- Ikon Panah Interaktif yang bergerak ke kanan saat di-hover -->
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>
@endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>