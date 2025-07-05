<?php

namespace App\Class;

use App\Enums;
use Cache;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Log;
use Stringable;
use Throwable;

readonly class CardBin implements Arrayable, Stringable {
    public const CACHE_PREFIX = 'card.bin.';
    public const URL = 'https://data.handyapi.com/bin';
    public const UA_HEADERS = [
        'x-api-key' => 'HAS-0YV4mUBpLQJ7n5ycNKT6S',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36',
    ];

    public function __construct(
        public string         $Scheme = '-',
        public Enums\CardType $Type = Enums\CardType::Unknown,
        public string         $CardTier = '-',
        public string         $Issuer = '-',
    )
    {
    }

    public static function findOrNew(string $bin): static
    {
        $bin = Str::of($bin)
            ->replaceMatches('/[^0-9]/', '')
            ->prepend(self::CACHE_PREFIX)
            ->value();

        return cache()->rememberForever($bin, self::lookup($bin));
    }

    private static function lookup(string $bin): callable
    {
        return static function () use (&$bin) {
            try {
                $res = Http::withHeaders(self::UA_HEADERS)->get(self::URL . "/$bin");
            } catch (Throwable $th) {
                Log::alert($th->getMessage());
                return new self();
            }

            return new self(
                Scheme: $res->json('Scheme'),
                Type: Enums\CardType::tryFrom(strtoupper($res->json('Type') ?? '')) ?? Enums\CardType::Unknown,
                CardTier: $res->json('CardTier') ?? '-',
                Issuer: $res->json('Issuer') ?? '-',
            );
        };
    }

    public static function find(string $bin): ?static
    {
        $bin = Str::of($bin)
            ->trim(' ')
            ->trim()
            ->substr(0, 6)
            ->prepend(self::CACHE_PREFIX)
            ->value();

        return Cache::get($bin);
    }

    public function __toString()
    {
        return Str::of($this->Scheme)
            ->append(' ')
            ->append($this->Type->name)
            ->append(' - ')
            ->append($this->CardTier)
            ->append(' | ')
            ->append($this->Issuer)
            ->value();
    }

    public function toArray(): array
    {
        return [
            'brand' => $this->Scheme,
            'type' => $this->Type->name,
            'level' => $this->CardTier,
            'bank' => $this->Issuer,
        ];
    }
}
