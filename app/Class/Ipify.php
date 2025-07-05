<?php

namespace App\Class;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final readonly class Ipify {
    private const BASE_API = "https://geo.ipify.org";
    private const ENDPOINT = "/api/v2/country,city";

    public function __construct(private string $apikey)
    {
    }

    public static function free(): self
    {
        return new self('at_eK9V5DBu1qqWta0TtGyBA19TmTXSL');
    }

    /**
     * @throws ConnectionException
     */
    public function lookup(string $ipAddress): array
    {
        return cache()->rememberForever($ipAddress, function () use ($ipAddress) {
            return $this->request($ipAddress)->json();
        });
    }

    /**
     * @throws ConnectionException
     */
    private function request(string $ipAddress): PromiseInterface|Response
    {
        return Http::baseUrl(self::BASE_API)
            ->withQueryParameters(['apiKey' => $this->apikey, ...compact('ipAddress')])
            ->throw()
            ->get(self::ENDPOINT);
    }
}
