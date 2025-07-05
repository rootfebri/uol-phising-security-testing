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
            if (empty($parameter)) {
                return self::Matched;
            }

            return match (request()->has($parameter)) {
                true => self::Matched,
                default => self::Unmatched,
            };
        } catch (Throwable $t) {
            Log::info($t->getMessage());
            return self::Unmatched;
        }
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
