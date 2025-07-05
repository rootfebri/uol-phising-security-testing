<?php

namespace App\Enums;

use BadMethodCallException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static self Unknown
 * @method static self Disallowed
 * @method static self Allowed
 * @method static self try_from(UserType|string $value)
 */
enum AntibotStatus: string implements CastsAttributes {
    case Disallowed = 'disallowed';
    case Allowed = 'allowed';
    case Unknown = 'unknown';

    public static function __callStatic(string $name, array $arguments)
    {
        if (method_exists(self::class, $name)) {
            return self::$name(...$arguments);
        }

        if ($name === 'try_from') {
            if (!($arguments[0] ?? '') instanceof UserType) {
                throw new BadMethodCallException("Invalid argument type: " . gettype($arguments[0]) . " for $name");
            }

            return match ($arguments[0]) {
                UserType::Business, UserType::Cellular, UserType::Residential, UserType::CableDsl => self::Allowed,
                UserType::Undetected => self::Unknown,
                default => self::Disallowed,
            };
        }

        return match ($name) {
            'Disallowed' => self::Disallowed,
            'Allowed' => self::Allowed,
            'Unknown' => self::Unknown,
            default => throw new BadMethodCallException("Invalid method call: $name"),
        };
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): AntibotStatus
    {
        return match ($value) {
            'disallowed' => self::Disallowed,
            'allowed' => self::Allowed,
            'unknown' => self::Unknown,
            default => throw new BadMethodCallException("Invalid value: $value"),
        };
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof self) {
            return $value->value;
        }

        if (is_string($value)) {
            return self::try_from($value)->value;
        }

        throw new BadMethodCallException("Invalid value type: " . gettype($value));
    }
}
