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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Pengaduan Saya</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $data['total_complaints'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-indigo-200">
                        <p class="text-sm font-medium text-indigo-500 uppercase">Pengaduan Aktif</p>
                        <p class="text-3xl font-bold text-indigo-900 mt-2">{{ $data['active_complaints'] }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Pengaduan Terbaru</h3>
                    <ul class="space-y-3">
                        @forelse($data['latest_complaints'] as $complaint)
                            <li class="flex justify-between items-center bg-gray-50 p-3 rounded border">
                                <span class="font-medium">{{ $complaint->title }}</span>
                                <span class="px-2 py-1 text-xs font-bold rounded uppercase bg-blue-100 text-blue-800">{{ $complaint->status }}</span>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500 italic">Anda belum membuat pengaduan.</p>
                        @endforelse
                    </ul>
                </div>
            @endif

            <!-- === TAMPILAN UNTUK TEKNISI === -->
            @if(Auth::user()->role === 'teknisi')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Tugas Masuk</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $data['total_assigned'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-green-200">
                        <p class="text-sm font-medium text-green-500 uppercase">Tugas Selesai</p>
                        <p class="text-3xl font-bold text-green-900 mt-2">{{ $data['completed'] }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Tugas yang Sedang Diproses</h3>
                    <ul class="space-y-3">
                        @forelse($data['latest_tasks'] as $task)
                            <li class="flex justify-between items-center bg-gray-50 p-3 rounded border">
                                <span class="font-medium">{{ $task->title }}</span>
                                <a href="{{ route('complaints.show', $task->id) }}" class="text-sm text-indigo-600 hover:underline">Lihat Detail</a>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500 italic">Tidak ada tugas aktif.</p>
                        @endforelse
                    </ul>
                </div>
            @endif

            <!-- === TAMPILAN UNTUK ADMIN & DEV === -->
            @if(in_array(Auth::user()->role, ['admin', 'dev']))
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                        <p class="text-xs font-medium text-gray-500 uppercase">Menunggu</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-2">{{ $data['menunggu'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                        <p class="text-xs font-medium text-gray-500 uppercase">Diproses</p>
                        <p class="text-2xl font-bold text-blue-600 mt-2">{{ $data['diproses'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                        <p class="text-xs font-medium text-gray-500 uppercase">Selesai</p>
                        <p class="text-2xl font-bold text-green-600 mt-2">{{ $data['selesai'] }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                        <p class="text-xs font-medium text-gray-500 uppercase">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600 mt-2">{{ $data['ditolak'] }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @if(Auth::user()->role === 'admin')
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-indigo-200">
                            <p class="text-sm font-medium text-indigo-600 uppercase">Total Teknisi Aktif</p>
                            <p class="text-3xl font-bold text-indigo-900 mt-2">{{ $data['total_technicians'] }}</p>
                        </div> 
                    @endif

                    @if(Auth::user()->role === 'dev')
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-red-200">
                            <p class="text-sm font-medium text-red-600 uppercase">System Error Logs</p>
                            <p class="text-3xl font-bold text-red-900 mt-2">{{ $data['total_errors'] }}</p>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">5 Pengaduan Terbaru</h3>
                    <ul class="space-y-3">
                        @forelse($data['latest_complaints'] as $complaint)
                            <li class="flex justify-between items-center bg-gray-50 p-3 rounded border">
                                <div>
                                    <span class="font-medium block">{{ $complaint->title }}</span>
                                    <span class="text-xs text-gray-500">Oleh: {{ $complaint->user->name }} | {{ $complaint->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="px-2 py-1 text-xs font-bold rounded uppercase 
                                    {{ $complaint->status == 'selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $complaint->status }}
                                </span>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500 italic">Belum ada pengaduan masuk.</p>
                        @endforelse
                    </ul>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>