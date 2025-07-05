<?php

namespace App\Class\Stopbot;

use JsonSerializable;

class PageResponse implements JsonSerializable {
    public function __construct(
        public PageResponseType $Type,
        public int|null|string  $Contents,
    )
    {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'Type' => $this->Type->jsonSerialize(),
            'Contents' => $this->Contents,
        ];
    }
}
