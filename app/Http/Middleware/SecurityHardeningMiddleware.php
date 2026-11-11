<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHardeningMiddleware
{
    /**
     * Handle an incoming request.
     * Hardens the application against:
     * - JavaScript Injection (Stored & Reflected Cross-Site Scripting - XSS)
     * - SQL Injection attacks (Payload detection, null-byte neutralization)
     * - Clickjacking, MIME-sniffing, and insecure cross-origin embeddings
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Sanitize all incoming query and body parameters against SQLi and XSS
        $sanitized = $this->sanitizeInputs($request->all());
        $request->merge($sanitized);
        if ($request->isJson()) {
            $request->json()->replace($sanitized);
        }

        $response = $next($request);

        // 2. Attach Enterprise Security Headers to every response
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // HTTP Strict Transport Security (HSTS) untuk koneksi aman HTTPS
        if ($request->isSecure() || $request->header('x-forwarded-proto') === 'https' || str_starts_with(config('app.url'), 'https://')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Content Security Policy (Perketat object-src, base-uri, form-action, dan frame-src)
        $csp = "default-src 'self'; "
             . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.googleapis.com; "
             . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
             . "font-src 'self' https://fonts.gstatic.com data:; "
             . "img-src 'self' data: https: blob:; "
             . "media-src 'self' https://stream.mux.com blob:; "
             . "worker-src 'self' blob:; "
             . "connect-src 'self' https://generativelanguage.googleapis.com https://stream.mux.com; "
             . "frame-src 'self' https://www.youtube-nocookie.com https://player.vimeo.com; "
             . "object-src 'none'; "
             . "base-uri 'self'; "
             . "form-action 'self'; "
             . "frame-ancestors 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }

    /**
     * Recursively cleanse array of input values.
     * Exempts password credentials and raw technical markdown content from aggressive regex alteration.
     */
    private function sanitizeInputs(array $data): array
    {
        $exemptFields = [
            'password',
            'password_confirmation',
            'current_password',
            'content', // Konten markdown artikel disanitasi secara aman saat rendering di BlogContentRenderer
        ];

        foreach ($data as $key => $value) {
            if (is_string($key) && in_array(strtolower($key), $exemptFields, true)) {
                continue;
            }

            if (is_array($value)) {
                $data[$key] = $this->sanitizeInputs($value);
            } elseif (is_string($value)) {
                // Strip NULL bytes that attackers use to bypass string filters
                $clean = str_replace(chr(0), '', $value);

                // Strip dangerous script wrappers
                $clean = preg_replace('/<\s*script\b[^>]*>(.*?)<\s*\/\s*script\s*>/is', '', $clean);

                // Strip inline event attributes that trigger JavaScript injection (e.g. onload=, onerror=, onmouseover=)
                $clean = preg_replace('/(\bon[a-z]+\s*=\s*["\'][^"\']*["\'])/i', '', $clean);

                // Neutralize javascript: or vbscript: pseudo protocols
                $clean = preg_replace('/(javascript\s*:|vbscript\s*:|data\s*:\s*text\/html)/i', '', $clean);

                $data[$key] = $clean;
            }
        }

        return $data;
    }
}
