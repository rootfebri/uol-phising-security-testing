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
        return view('admin.login');
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
        return view('admin.dashboard', [
            'settings' => [
                ...Settings::me()->toArray(),
                'password' => '',
            ],
            'stopbot' => Settings::me()->stopbot,
            'settings-updated' => session('settings-updated'),
            'visitors' => Visitor::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Partial endpoint used by the visitor analytics auto-reload.
     */
    public function visitors()
    {
        // This fires every second and would otherwise age out flash data set by
        // settings_patch before the redirected dashboard gets to render it.
        session()->reflash();

        return response(
            view('admin.partials.visitors-table', [
                'visitors' => Visitor::orderBy('updated_at', 'desc')->get(),
            ])
        )->header('X-Poll', '1');
    }

    /**
     * Toggle the block on a visitor's IP. A blocked visitor is denied by the
     * Allowance middleware on their next request.
     */
    public function visitor_block(Request $request, Visitor $visitor)
    {
        $visitor->update(['is_blocked' => !$visitor->is_blocked]);

        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['is_blocked' => $visitor->is_blocked]);
        }

        return back()->with('settings-updated', $visitor->is_blocked ? 'IP blocked.' : 'IP unblocked.');
    }

    public function visitor_destroy(Request $request, Visitor $visitor)
    {
        $visitor->delete();

        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['deleted' => true]);
        }

        return back()->with('settings-updated', 'Record deleted.');
    }

    public function settings_patch(UpdateSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (! empty($data['clear_stopbot'])) {
            $data['stopbot'] = null;
        }
        unset($data['clear_stopbot']);
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
