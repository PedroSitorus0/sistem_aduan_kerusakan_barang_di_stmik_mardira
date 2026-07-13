<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemLog;

class RecordSystemLog
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->is('system-logs*') || $request->is('_debugbar*')) {
            return $response;
        }

        $aksi = $request->route() ? $request->route()->getName() : 'unknown_route';
        $statusCode = $response->getStatusCode();

        // 1. Ambil semua data input (GET/POST payload)
        // Kita menggunakan except() agar password tidak ikut tersimpan di log (demi keamanan)
        $payload = $request->except(['password', 'password_confirmation', '_token']);

        // 2. Siapkan array context
        $contextData = [];
        
        // Jika payload tidak kosong, masukkan ke context
        if (!empty($payload)) {
            $contextData['request_payload'] = $payload;
        }

        SystemLog::create([
            'user_id'         => auth()->id(),
            'method'          => $request->method(),
            'url'             => $request->fullUrl(),
            'ip_address'      => $request->ip(),
            'user_agent'      => $request->userAgent(),
            'aksi'            => $aksi,
            'status_code'     => $statusCode,
            'is_error'        => $statusCode >= 400,
            
            // 3. Simpan sebagai JSON
            // Jika array context kosong, simpan null agar database lebih bersih
            'context'         => !empty($contextData) ? json_encode($contextData) : null,
        ]);

        return $response;
    }
}