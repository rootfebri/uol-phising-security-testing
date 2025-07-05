<?php

namespace App\Class\Stopbot;

use JsonSerializable;

class Status implements JsonSerializable {
    public function __construct(
        public bool   $Bot,
        public bool   $Block,
        public bool   $ThreatURL,
        public string $Desc,
    )
    {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'Bot' => $this->Bot,
            'Block' => $this->Block,
            'ThreatURL' => $this->ThreatURL,
            'Desc' => $this->Desc,
        ];
    }
}
