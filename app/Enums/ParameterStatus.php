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
                empty($parameter), request()->has($parameter) => self::Matched,
                default => self::Unmatched,
            };
        } catch (Throwable $t) {
            Log::info($t->getMessage());
            return self::Matched;
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
