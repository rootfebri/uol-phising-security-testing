<?php

namespace App\Enums;

use BadMethodCallException;
use Illuminate\Support\Str;
use Stringable;

/**
 * UserType enum represents different types of users in the system.
 *
 * This enum handles various user classifications and provides utilities
 * for type conversion, comparison, and string formatting.
 *
 * @method bool isCableDsl() Checks if the instance is a CableDsl user type
 * @method bool isResidential() Checks if the instance is a Residential user type
 * @method bool isBusiness() Checks if the instance is a Business user type
 * @method bool isCellular() Checks if the instance is a Cellular user type
 * @method bool isHosting() Checks if the instance is a Hosting user type
 * @method bool isUndetected() Checks if the instance is an Undetected user type
 * @method string fmtCase(string $string) Formats a string into a standardized case format
 * @method static string fmtCase(string $string) Formats a string into a standardized case format
 */
enum UserType {
    /**
     * Represents a Cable/DSL user
     * Used for users connected via traditional cable or DSL internet services
     */
    case CableDsl;
    /**
     * Represents a residential user
     * Used for users in residential/home environments
     */
    case Residential;
    /**
     * Represents a business user
     * Used for users in commercial or enterprise settings
     */
    case Business;
    /**
     * Represents a cellular user
     * Used for users connecting through mobile/cellular networks
     */
    case Cellular;
    /**
     * Represents a hosting user
     * Used for users associated with hosting services
     */
    case Hosting;
    /**
     * Represents an undetected user type
     * Used when the system cannot determine the user type
     */
    case Undetected;

    /**
     * Magic method to handle static method calls.
     * Supports direct static method calls, "is[Type]" comparison methods,
     * and methods with double underscore suffixes.
     *
     * @param string $name The static method name being called
     * @param array $arguments Arguments passed to the method
     * @return mixed The result of the called method
     * @throws BadMethodCallException When an invalid method is called
     */
    public static function __callStatic(string $name, array $arguments) {
        $method = Str::of($name);
        if (method_exists(self::class, $method->value())) {
            return self::{$method->value()}(...$arguments);
        }

        if (method_exists(self::class, $method->append('__')->value())) {
            return self::Undetected->{$method->append('__')->value()}(...$arguments);
        }

        throw new BadMethodCallException(sprintf("Bad method call: %s::%s()", self::class, $name));
    }

    /**
     * Magic method to handle dynamic instance method calls.
     * Supports direct method calls, "is[Type]" comparison methods,
     * and methods with double underscore suffixes.
     *
     * Example: $userType->isCellular() will return true if $userType is Cellular
     *
     * @param string $name The method name being called
     * @param array $arguments Arguments passed to the method
     * @return mixed The result of the called method
     * @throws BadMethodCallException When an invalid method is called
     */
    public function __call(string $name, array $arguments) {
        $method = Str::of($name);
        if (method_exists($this, $method->value())) {
            return $this->{$method->value()}(...$arguments);
        }

        if ($method->startsWith('is')) {
            return $this->is($method->substr(2)->value());
        }

        if (method_exists($this, $method->append('__')->value())) {
            return $this->{$method->append('__')->value()}(...$arguments);
        }

        throw new BadMethodCallException(sprintf("Bad method call: %s::%s()", self::class, $name));
    }

    private function is(string $case): bool {
        return $this === self::tryFrom($case);
    }

    /**
     * Attempts to convert a string value to a UserType enum value.
     *
     * This method iterates through all enum cases and compares their names
     * to the provided string value to find a match.
     *
     * @param Stringable|string $name The input string to format
     * @return self|null The corresponding UserType or null if no match is found
     */
    public static function tryFrom(Stringable|string $name): ?self {
        foreach (self::cases() as $case) {
            if ($case->name === self::fmtCase($name)) {
                return $case;
            }
        }

        return null;
    }

    /**
     * Formats a string into a standardized case format.
     * This is a private helper method used by the magic methods.
     * Double underscore suffix indicates an internal method.
     *
     * @param Stringable|string $string The input string to format
     * @return string The formatted string in pascal case
     */
    public function fmtCase__(Stringable|string $string): string {
        return Str::of($string)
            ->replace(['/', '\\', '-', '_', '.', ' '], '_')
            ->pascal();
    }
}
