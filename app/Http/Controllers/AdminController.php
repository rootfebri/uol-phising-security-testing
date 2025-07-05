<?php

namespace App\Http\Controllers;

use App\Class\Stopbot;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Settings;
use App\Models\Visitor;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller {
    public function login_index()
    {
        return inertia('admin-login');
    }

    public function login_post(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            '*' => 'Incorrect details!'
        ]);

        if (Auth::attempt($credentials, $request->input('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return back()->withErrors('Incorrect login!');
    }

    public function dashboard()
    {
        return inertia('dashboard', [
            'settings' => [
                ...Settings::me()->toArray(),
                'password' => '',
            ],
            'settings-updated' => session('settings-updated'),
            'visitors' => Visitor::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    public function settings_patch(UpdateSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        if (isset($data['stopbot'])) {
            $confname = $data['stopbot']['confname'] ?? '';
            $data['stopbot'] = Stopbot::new($data['stopbot']['key'], $confname);

            $error = $data['stopbot']->verify();
            match (true) {
                $error instanceof Stopbot\StopbotError => throw ValidationException::withMessages(['stopbot.key' => $error->message]),
                default => null,
            };
        }

        Settings::me()->update($data);

        return redirect()->back()->with('settings-updated', 'Settings updated successfully!');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
