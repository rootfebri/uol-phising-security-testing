<?php
/** @noinspection PhpUnhandledExceptionInspection
 * @noinspection JsonEncodingApiUsageInspection
 */

namespace App\Class;

use App\Class\Stopbot\PageResponse;
use App\Class\Stopbot\PageResponseType;
use App\Class\Stopbot\Status;
use App\Class\Stopbot\StopbotError;
use App\Class\Stopbot\StopbotResponse;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use JsonException;
use Throwable;

final class Stopbot implements CastsAttributes {
    private const BASE_URL = "https://stopbot.net/api";
    private const BLOCKER_ENDPOINT = "/blocker";
    private const BLOCKER_V2_ENDPOINT = "/v2/blockerv2";
    private const VERIFY_ENDPOINT = "/account";
    public string $key;
    public string $confname;

    public function lookup(): StopbotResponse|StopbotError
    {
        try {
            $response = $this->request();
            $pageResponse = new PageResponse(
                Type: PageResponseType::None,
                Contents: null,
            );
            if ($response->json('status') === 'success') {
                if (!empty($response->json('IPStatus'))) {
                    $status = new Status(
                        Bot: $response->json('IPStatus.isBot') === 1,
                        Block: $response->json('IPStatus.BlockAccess') === 1,
                        ThreatURL: $response->json('IPStatus.ThreatURL') === 1,
                        Desc: $response->json('IPStatus.DetectActivity') ?? '',
                    );
                } else if (!empty($response->json('Status'))) {
                    $status = new Status(
                        Bot: $response->json('Status.Bot') === 1,
                        Block: $response->json('Status.Block') === 1,
                        ThreatURL: $response->json('Status.ThreatURL') === 1,
                        Desc: $response->json('Status.Desc') ?? '',
                    );
                    $pageResponse = new PageResponse(
                        Type: PageResponseType::tryFrom((string)$response->json('PageResponse.Type')) ?? PageResponseType::None,
                        Contents: $response->json('PageResponse.Contents'),
                    );
                } else {
                    return new StopbotError(
                        status: "error",
                        message: 'Unknown StopbotError',
                        timeResponse: '',
                    );
                }

                return StopbotResponse::new($status, $pageResponse);
            }

            return new StopbotError(
                status: "error",
                message: $response->json('message') ?? 'Unknown StopbotError',
                timeResponse: $response->json('timeResponse') ?? '',
            );
        } catch (ConnectionException|RequestException $e) {
            return new StopbotError(
                status: "error",
                message: $e->getMessage(),
                timeResponse: '',
            );
        }
    }

    /**
     * @throws RequestException|ConnectionException|JsonException
     */
    private function request(): PromiseInterface|Response
    {
        return Http::baseUrl(self::BASE_URL)
            ->withQueryParameters($this->buildParameters())
            ->get($this->blockerPath())
            ->throw();
    }

    /**
     * @inheritdoc
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?self
    {
        if (is_null($value)) {
            return null;
        }

        return unserialize($value, ['allowed_classes' => [self::class]]);
    }

    private function buildParameters(): array
    {
        $base = [
            'apikey' => $this->key,
            'ip' => request()->ip(),
            'ua' => urlencode(request()->userAgent()),
            'url' => request()->fullUrl(),
        ];
        return $this->version() === 1 ? $base : array_merge($base, [
            'confname' => $this->confname,
            'params' => json_encode(request()->query(), JSON_THROW_ON_ERROR),
            'headers' => json_encode(request()->headers->all(), JSON_THROW_ON_ERROR),
        ]);
    }

    public function version(): int
    {
        return $this->confname ? 2 : 1;
    }

    private function blockerPath(): string
    {
        return $this->version() === 2
            ? self::BLOCKER_V2_ENDPOINT
            : self::BLOCKER_ENDPOINT;
    }

    public static function new(string $key, string $confname): self
    {
        $instance = new self;
        $instance->key = $key;
        $instance->confname = $confname;

        return $instance;
    }

    /**
     * @inheritdoc
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return is_null($value) ? null : serialize($value);
    }

    public function verify(): StopbotError|null
    {
        try {
            $response = $this->client()->withQueryParameters(['apikey' => $this->key])->get(self::VERIFY_ENDPOINT);

            return StopbotError::tryFromArray($response->json());
        } catch (Throwable $e) {
            return new StopbotError(
                status: "error",
                message: $e->getMessage(),
                timeResponse: '',
            );
        }
    }

    public function client(): PendingRequest|Factory
    {
        return Http::baseUrl(self::BASE_URL);
    }
}
