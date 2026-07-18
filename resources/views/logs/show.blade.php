<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    Detail Log Sistem 
                    <span class="px-2.5 py-0.5 text-sm rounded-md font-mono bg-white text-gray-600 border border-gray-300">#{{ $log->id }}</span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">Dicatat pada: {{ $log->created_at->format('l, d F Y - H:i:s') }}</p>
            </div>
            
            <a href="{{ route('system-logs.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium shadow-sm transition-colors">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- BAGIAN 1: INFORMASI DASAR (REQUEST INFO) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Informasi Request</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Pengguna (Aktor)</p>
                        @if($log->user)
                            <p class="font-bold text-gray-900">{{ $log->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $log->user->email }}</p>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Sistem / Guest / Unauthenticated
                            </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Aksi & Method</p>
                        <p class="font-bold text-gray-900">{{ $log->aksi ?? 'Tanpa Keterangan' }}</p>
                        @php
                            $methodColor = match(strtoupper($log->method)) {
                                'GET' => 'bg-blue-100 text-blue-800',
                                'POST' => 'bg-green-100 text-green-800',
                                'PUT', 'PATCH' => 'bg-yellow-100 text-yellow-800',
                                'DELETE' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wide {{ $methodColor }}">
                            {{ $log->method }}
                        </span>
                    </div>

                    <div class="lg:col-span-2">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">URL / Endpoint</p>
                        <div class="bg-gray-100 p-2 rounded border border-gray-200 font-mono text-sm text-gray-700 break-all">
                            {{ $log->url }}
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Status Code</p>
                        @if($log->status_code)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-bold border {{ $log->is_error ? 'bg-red-100 text-red-700 border-red-200' : 'bg-green-100 text-green-700 border-green-200' }}">
                                @if($log->is_error)
                                    <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                @endif
                                {{ $log->status_code }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">ID Request On table system_logs</p>
                        <p class="font-mono text-gray-800 bg-gray-50 px-2 py-1 rounded inline-block border">
                            {{ $log->id }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">IP Address</p>
                        <p class="font-mono text-gray-800 bg-gray-50 px-2 py-1 rounded inline-block border">
                            {{ $log->ip_address ?? 'Unknown' }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- BAGIAN 2: ERROR TRACE / PESAN MENTAH (Hanya Muncul Jika Ada Error) -->
            @if($log->is_error)
                <div class="bg-red-50 overflow-hidden shadow-sm sm:rounded-xl border border-red-200">
                    <div class="px-6 py-4 border-b border-red-200 bg-red-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <h3 class="text-sm font-bold text-red-800 uppercase tracking-wide">Detail Exception</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs font-bold text-red-800 mb-1">Exception Class:</p>
                            <code class="block bg-white text-red-600 p-2 rounded border border-red-200 font-mono text-sm shadow-sm">
                                {{ $log->exception_class ?? 'Tidak ada data class yang terekam' }}
                            </code>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-red-800 mb-1">Raw Exception Message:</p>
                            <!-- Menggunakan whitespace-pre-wrap agar stack trace panjang turun ke baris baru dengan rapi -->
                            <div class="bg-[#1e1e1e] text-red-400 p-4 rounded-lg font-mono text-sm whitespace-pre-wrap overflow-x-auto shadow-inner border border-gray-800">
                                {{ $log->exception_message ?? 'Tidak ada pesan error spesifik yang dicatat.' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- BAGIAN 3: DATA JSON (PAYLOAD & CONTEXT RESPONSE) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Request Payload (Input dari User) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Request Payload (Input)</h3>
                        <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded font-mono">JSON</span>
                    </div>
                    <div class="p-4 flex-grow bg-[#1e1e1e] rounded-b-xl rounded-t-none">
                        @php
                            // Decode string ke array, lalu encode kembali dengan PRETTY_PRINT agar rapi ke bawah
                            $contextArray = is_string($log->context) ? json_decode($log->context, true) : $log->context;
                            $payload = $contextArray['request_payload'] ?? null;
                            $prettyPayload = $payload ? json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
                        @endphp
                            {{-- $payload = is_string($log->request_payload) ? json_decode($log->request_payload, true) : $log->request_payload;
                            $prettyPayload = $payload ? json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
                        @endphp --}}
                        
                        <pre class="font-mono text-sm text-emerald-400 overflow-x-auto"><code>{{ $prettyPayload ?: 'No Payload Data (Atau request kosong)' }}</code></pre>
                    </div>
                </div>

                <!-- Context Data (Output / Response Array) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Context Data (Output/Header)</h3>
                        <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded font-mono">JSON</span>
                    </div>
                    <div class="p-4 flex-grow bg-[#1e1e1e] rounded-b-xl rounded-t-none">
                        @php
                            $context = is_string($log->context) ? json_decode($log->context, true) : $log->context;
                            $prettyContext = $context ? json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
                        @endphp

                        <pre class="font-mono text-sm text-sky-400 overflow-x-auto"><code>{{ $prettyContext ?: 'No Context Data' }}</code></pre>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</x-app-layout>