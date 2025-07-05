<?php

namespace App\Class\Stopbot;

use Stringable;

class StopbotError implements Stringable {
    public function __construct(
        public string $status,
        public string $message,
        public string $timeResponse,
    )
    {
    }

    public static function tryFromArray(array $json): ?StopbotError
    {
        if (isset($json['status'], $json['message'])) {
            return new self(
                status: $json['status'],
                message: $json['message'],
                timeResponse: $json['timeResponse'] ?? '',
            );
        }

        return null;
    }

    public function __toString()
    {
        return "[$this->status] - $this->message - $this->timeResponse";
    }
}
