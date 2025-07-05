<?php

namespace App\Class\Stopbot;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Stringable;

class StopbotResponse implements CastsAttributes, Stringable {
    public Status $status;
    public PageResponse $pageResponse;

    public static function new(Status $status, PageResponse $pageResponse): static
    {
        $instance = new static;
        $instance->status = $status;
        $instance->pageResponse = $pageResponse;
        return $instance;
    }

    public function safe(): bool
    {
        return !$this->status->Block;
    }

    public function unsafe(): bool
    {
        return $this->status->Block;
    }

    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return is_null($value) ? null : unserialize($value, ['allowed_classes' => [__CLASS__]]);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return $value instanceof self ? serialize($value) : null;
    }

    public function __toString()
    {
        return $this->status->Desc;
    }
}
