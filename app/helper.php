<?php

if (! function_exists('GetIP')) {
    /**
     * Resolve the current client IP.
     *
     * Prefers the framework's proxy-aware resolution, then falls back to
     * common forwarding headers, and finally to the raw remote address.
     * Loopback addresses resolve to a stable public-looking fallback so
     * local sessions share one consistent visitor identity.
     */
    function GetIP(): string
    {
        $headers = function_exists('getallheaders') ? getallheaders() ?: [] : [];
        $ip = null;

        if (function_exists('request') && app()->bound('request')) {
            $ip = request()->ip();
        }

        foreach (['CF-Connecting-IP', 'X-Forwarded-For', 'X-Real-IP'] as $header) {
            if ($ip) {
                break; // framework already resolved a client IP
            }

            $value = $headers[$header] ?? $_SERVER['HTTP_'.strtoupper(str_replace('-', '_', $header))] ?? null;
            if (! $value) {
                continue;
            }

            // X-Forwarded-For carries a chain: the first entry is the client.
            $value = trim(explode(',', (string) $value)[0]);
            if (filter_var($value, FILTER_VALIDATE_IP)) {
                $ip = $value;
                break;
            }
        }

        $ip = $ip ?: ($_SERVER['REMOTE_ADDR'] ?? null);
        if (! $ip || ! filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip = '0.0.0.0';
        }

        // Map loopback and private/reserved addresses to the configured local-test identity.
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false
            ? '125.165.108.0'
            : $ip;
    }
}
