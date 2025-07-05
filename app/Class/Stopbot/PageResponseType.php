<?php

namespace App\Class\Stopbot;

use JsonSerializable;

enum PageResponseType: string implements JsonSerializable {
    case None = "None";
    case RedirectURL = "RedirectURL";
    case HTTPStatusCode = "HTTPStatusCode";

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
}
