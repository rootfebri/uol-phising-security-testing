<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SensitiveParameter;
use Throwable;

abstract class Controller {
    protected function redirect_if(Request $request, string $method, array|string $additionalKeys = []): void
    {
        try {
            $t = self::decrypt($request->get('t'));
            if (!isset($t['user'], $t['method']) || $t['method'] !== $method) {
                throw new HttpResponseException(redirect()->route('login.index'));
            }

            if (is_string($additionalKeys)) {
                $get = $request->get($additionalKeys);
                if (is_string($get)) {
                    self::decrypt($get);
                }
            } else {
                foreach ($additionalKeys as $key) {
                    $get = $request->get($key);
                    if (is_string($get)) {
                        self::decrypt($get);
                    }
                }
            }

        } catch (Throwable) {
            throw new HttpResponseException(redirect()->route('login.index'));
        }
    }

    public static function decrypt(string $enc): mixed
    {
        $data = base64_decode(strtr($enc, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($enc)) % 4));
        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        $decrypted = openssl_decrypt($ciphertext, 'AES-256-CBC', config('app.key'), OPENSSL_RAW_DATA, $iv);
        return unserialize(data: $decrypted, options: ['allowed_classes' => false]);
    }

    protected function redirect_to(string $route, string $method, array $additional = []): RedirectResponse
    {
        $user = Visitor::current()->user;
        return redirect()->route($route, ['t' => self::encrypt(compact('user', 'method')), ...$additional]);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public static function encrypt(#[SensitiveParameter] $v): string
    {
        $iv = random_bytes(16);
        $ciphertext = openssl_encrypt(serialize($v), 'AES-256-CBC', config('app.key'), OPENSSL_RAW_DATA, $iv);
        return rtrim(strtr(base64_encode($iv . $ciphertext), '+/', '-_'), '=');
    }
}
