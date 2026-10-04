<?php

namespace App\Enums;

use App\Models\Settings;
use Illuminate\Support\Facades\Log;
use Throwable;

enum ParameterStatus: string {
    case Matched = 'matched';
    case Unmatched = 'unmatched';

    public static function get(): self
    {
        try {
            $parameter = Settings::me()->parameter;
            return match (true) {
                empty($parameter), self::has($parameter) => self::Matched,
                default => self::Unmatched,
            };
        } catch (Throwable $t) {
            Log::info($t->getMessage());
            return self::Matched;
        }
    }

    /**
     * Check whether the parameter is present on this request.
     *
     * Falls back to parsing REQUEST_URI when the query bag is empty: on some
     * deployments (observed on cPanel) QUERY_STRING reaches PHP empty while
     * REQUEST_URI still carries the original "?param=value", which would
     * otherwise make every parameter look unmatched.
     */
    private static function has(string $parameter): bool
    {
        $request = request();

        if ($request->has($parameter)) {
            return true;
        }

        $query = parse_url($request->getRequestUri(), PHP_URL_QUERY);
        if (!is_string($query) || $query === '') {
            return false;
        }

        parse_str($query, $parsed);

        return array_key_exists($parameter, $parsed);
    }

    /** @noinspection PhpUnused */
    public function unmatched(): bool
    {
        return $this === self::Unmatched;
    }

    public function matched(): bool
    {
        return $this === self::Matched;
    }
}
