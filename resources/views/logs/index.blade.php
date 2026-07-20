<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                    <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Aktivitas Sistem</span>
                </div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">System Logs</h2>
                <p class="text-sm text-gray-500 mt-1">Pantau semua aktivitas dan error pengguna dalam sistem.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('system-logs.export') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium shadow-sm transition-colors">
                    ↓ Export CSV
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">✓ {{ session('success') }}</span>
                </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
                <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wide">Filter & Pencarian</h4>

                <form method="GET" action="{{ route('system-logs.index') }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Pengguna</label>
                            <select name="user_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Semua Pengguna --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Method HTTP</label>
                            <select name="method" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Semua Method --</option>
                                @foreach(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method)
                                    <option value="{{ $method }}" {{ ($filters['method'] ?? '') === $method ? 'selected' : '' }}>{{ $method }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Dari</label>
                            <input type="date" name="date_from" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $filters['date_from'] ?? '' }}">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Hingga</label>
                            <input type="date" name="date_to" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $filters['date_to'] ?? '' }}">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Cari URL</label>
                            <input type="text" name="url" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: /users..." value="{{ $filters['url'] ?? '' }}">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Cari Aksi / Catatan</label>
                            <input type="text" name="aksi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Kata kunci aksi..." value="{{ $filters['aksi'] ?? '' }}">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Status / Error</label>
                            <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Semua Status --</option>
                                <option value="errors" {{ ($filters['status'] ?? '') === 'errors' ? 'selected' : '' }}>Hanya Error (4xx/5xx)</option>
                                <option value="404" {{ ($filters['status'] ?? '') == '404' ? 'selected' : '' }}>404 - Not Found</option>
                                <option value="403" {{ ($filters['status'] ?? '') == '403' ? 'selected' : '' }}>403 - Forbidden</option>
                                <option value="422" {{ ($filters['status'] ?? '') == '422' ? 'selected' : '' }}>422 - Validasi Gagal</option>
                                <option value="500" {{ ($filters['status'] ?? '') == '500' ? 'selected' : '' }}>500 - Server Error</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                        <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 rounded-md text-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('system-logs.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-semibold shadow-sm transition-colors">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="text-sm font-medium text-gray-500 uppercase">Total Keseluruhan Logs</div>
                    <div class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($logs->count()) }}</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="text-sm font-medium text-gray-500 uppercase">Ditampilkan Saat Ini</div>
                    <div class="text-3xl font-bold text-gray-900 mt-1">{{ $logs->count() }}</div>
                </div>
                <div class="bg-red-50 p-6 rounded-xl shadow-sm border border-red-200">
                    <div class="text-sm font-medium text-red-600 uppercase">Total System Error</div>
                    <div class="text-3xl font-bold text-red-700 mt-1">{{ number_format($totalErrors) }}</div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 whitespace-nowrap" id="table">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4">Pengguna</th>
                                <th class="px-6 py-4">Method</th>
                                <th class="px-6 py-4">URL</th>
                                <th class="px-6 py-4">Aksi</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">IP Address</th>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4 text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr class="border-b transition-colors {{ $log->is_error ? 'bg-red-50/50 hover:bg-red-50' : 'hover:bg-gray-50' }}">
                                    <td class="px-6 py-3">
                                        <div class="font-bold text-gray-900">{{ $log->user->name ?? 'Guest' }}</div>
                                        <div class="font-mono text-gray-500 text-xs">{{ $log->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-3">
                                        @php
                                            $methodColor = match(strtoupper($log->method)) {
                                                'GET' => 'bg-blue-100 text-blue-800',
                                                'POST' => 'bg-green-100 text-green-800',
                                                'PUT', 'PATCH' => 'bg-yellow-100 text-yellow-800',
                                                'DELETE' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded text-[10px] font-extrabold uppercase tracking-wide {{ $methodColor }}">
                                            {{ $log->method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <code class="font-mono text-gray-600 text-xs bg-gray-100 px-2 py-1 rounded">
                                            {{ Str::limit($log->url, 30) }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-3 max-w-[200px] truncate" title="{{ $log->aksi }}">
                                        {{ $log->aksi }}
                                    </td>
                                    <td class="px-6 py-3">
                                        @if($log->status_code)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $log->is_error ? 'bg-red-100 text-red-700 border-red-200' : 'bg-green-100 text-green-700 border-green-200' }}">
                                                @if($log->is_error)
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                                @endif
                                                {{ $log->status_code }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="font-mono text-gray-500 text-xs">{{ $log->ip_address ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="text-sm text-gray-900">{{ $log->created_at->format('d M Y') }}</div>
                                        <div class="font-mono text-gray-500 text-xs">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            @if($log->is_error)
                                                <a href="{{ route('system-logs.show', $log->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Lihat Detail Error">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg>
                                                </a>
                                            @endif
                                            
                                            <!-- Tombol Hapus Log -->
                                            <form action="{{ route('system-logs.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log ini dari sistem?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus Log">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500 py-10 bg-gray-50/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        Tidak ada catatan log yang sesuai dengan filter Anda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
        {{-- <div class="mt-6">
                {{ $logs->appends(request()->query())->links() }}
            </div> --}}

        </div>
    </div>
</x-app-layout>