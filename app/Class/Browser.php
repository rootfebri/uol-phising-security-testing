<?php

namespace App\Class;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Stringable;
use WhichBrowser\Parser;

class Browser extends Parser implements Stringable, CastsAttributes {
    public function get($model, string $key, $value, array $attributes): Parser
    {
        return unserialize($value, [Parser::class]);
    }

    public function set($model, string $key, $value, array $attributes): string
    {
        if (!$value instanceof Parser) {
            throw new InvalidArgumentException("The given value is not a Parser instance.");
        }

        return serialize($value);
    }

    public function safe(): bool
    {
        return !$this->unsafe();
    }

    public function unsafe(): bool
    {
        return $this->camouflage || $this->isType('bot') || ($this->isType('desktop') || $this->isType('mobile')) === false;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
