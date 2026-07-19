<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Content Security Policy (CSP) - Medium risk
        // Allows Google Maps iframe, reCAPTCHA, and Bootstrap CDN
        $cspParts = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google.com https://www.gstatic.com https://www.recaptcha.net https://cdn.jsdelivr.net https://cdnjs.cloudflare.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com",
            "img-src 'self' data: https:",
            "font-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.gstatic.com",
            "frame-src https://www.google.com https://www.recaptcha.net https://maps.google.com",
            "connect-src 'self' https://www.google.com https://www.recaptcha.net",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ];
        $response->headers->set('Content-Security-Policy', implode('; ', $cspParts));

        // X-Frame-Options - Medium risk (Anti-clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');

        // Strict-Transport-Security (HSTS) - Low risk
        // Only send on production (HTTPS) to avoid locking local dev into HTTPS
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // X-Content-Type-Options - Low risk
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection (legacy but still useful for older browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        return $response;
    }
}
