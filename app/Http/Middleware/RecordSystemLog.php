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

        // jika request berawalan dari url system-logs maka akan diabaikan.
        if ($request->is('system-logs*') || $request->is('_debugbar*')) {
            return $response;
        }
        $exception = null;

        try {
            $statusCode = $response->getStatusCode();
            $exception = $response->exception ?? null;
        } catch (\Throwable $th) {
            $exception = $th;
            $statusCode = 500;
        }

        $aksi = $request->route() ? $request->route()->getName() : 'unknown_route';
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
            'is_error'        => $statusCode >= 400 || $exception !== null,
            'exception_class' => $exception ? get_class($exception) : null,
            'exception_message' => $exception ? $exception->getMessage() : null,
            'exception_trace' => $exception ? $exception->getTraceAsString() : null,
            // 3. Simpan sebagai JSON
            // Jika array context kosong, simpan null agar database lebih bersih
            'context'         => !empty($contextData) ? json_encode($contextData) : null,
        ]);

        if (isset($th)) {
            throw $th;
        }

        return $response;
    }
}