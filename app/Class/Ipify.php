<?php

namespace App\Class;

use App\Models\Settings;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

final readonly class Ipify {
    private const BASE_API = "https://geo.ipify.org";
    private const ENDPOINT = "/api/v2/country,city";
    private const DEFAULT_KEY = 'at_2LScdAp05zxjDxv9ikihKatHwEjRX';

    public function __construct(private string $apikey)
    {
    }

    /**
     * The key is admin-configurable via the Geo tab; the built-in default is
     * only used until one is saved (or if reading settings itself fails —
     * this runs inside a geo lookup and must never be the thing that throws).
     */
    public static function free(): self
    {
        $key = self::DEFAULT_KEY;

        try {
            $key = Settings::me()->ipify_key ?: $key;
        } catch (Throwable) {
            // Fall through to the built-in key.
        }

        return new self($key);
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
